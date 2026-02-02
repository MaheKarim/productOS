<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class NotificationController extends Controller
{
    /**
     * Display a listing of notifications.
     */
    public function index(Request $request)
    {
        $query = Notification::query();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by target type
        if ($request->filled('target_type')) {
            $query->where('target_type', $request->target_type);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search by title or message
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            });
        }

        // Order by created_at desc
        $query->orderBy('created_at', 'desc');

        $notifications = $query->paginate(20);

        return view('admin.notifications.index', compact('notifications'));
    }

    /**
     * Show the form for creating a new notification.
     */
    public function create()
    {
        $users = User::where('is_active', true)->get();
        $roles = User::distinct()->pluck('role')->filter()->values();

        return view('admin.notifications.create', compact('users', 'roles'));
    }

    /**
     * Store a newly created notification.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:system,feature,promotional,alert,personal,credit',
            'priority' => 'required|in:low,medium,high,urgent',
            'action_text' => 'nullable|string|max:255',
            'action_url' => 'nullable|url',
            'target_type' => 'required|in:all,specific,role,custom',
            'target_users' => 'nullable|array',
            'target_users.*' => 'exists:users,id',
            'target_role' => 'nullable|string',
            'send_immediately' => 'required|boolean',
            'scheduled_at' => 'nullable|date|after:now',
            'expires_at' => 'nullable|date|after:now',
            'is_dismissible' => 'boolean',
            'is_persistent' => 'boolean',
            'show_as_popup' => 'boolean',
        ]);

        // Set default values
        $validated['is_dismissible'] = $request->has('is_dismissible');
        $validated['is_persistent'] = $request->has('is_persistent');
        $validated['show_as_popup'] = $request->has('show_as_popup');

        // Set icon and color based on type
        $validated['icon_class'] = Notification::getIconForType($validated['type']);
        $validated['color_code'] = Notification::getColorForType($validated['type']);

        // Set status
        if ($validated['send_immediately']) {
            $validated['status'] = Notification::STATUS_ACTIVE;
            $validated['sent_at'] = now();
        } else {
            $validated['status'] = Notification::STATUS_SCHEDULED;
        }

        // Validate target type specific fields
        if ($validated['target_type'] === 'specific' && empty($validated['target_users'])) {
            return back()->withErrors(['target_users' => 'Please select at least one user when targeting specific users.'])->withInput();
        }

        if ($validated['target_type'] === 'role' && empty($validated['target_role'])) {
            return back()->withErrors(['target_role' => 'Please select a role when targeting by role.'])->withInput();
        }

        DB::beginTransaction();
        try {
            $notification = Notification::create([
                'title' => $validated['title'],
                'message' => $validated['message'],
                'type' => $validated['type'],
                'priority' => $validated['priority'],
                'icon_class' => $validated['icon_class'],
                'color_code' => $validated['color_code'],
                'action_text' => $validated['action_text'],
                'action_url' => $validated['action_url'],
                'target_type' => $validated['target_type'],
                'target_users' => $validated['target_users'] ?? null,
                'target_role' => $validated['target_role'] ?? null,
                'status' => $validated['status'],
                'scheduled_at' => $validated['scheduled_at'] ?? null,
                'expires_at' => $validated['expires_at'] ?? null,
                'is_dismissible' => $validated['is_dismissible'],
                'is_persistent' => $validated['is_persistent'],
                'show_as_popup' => $validated['show_as_popup'],
                'created_by' => auth()->id(),
                'sent_at' => $validated['sent_at'] ?? null,
            ]);

            // If sending immediately, create user notifications
            if ($validated['send_immediately']) {
                $this->deliverNotification($notification);
            }

            DB::commit();

            return redirect()
                ->route('admin.notifications.index')
                ->with('success', 'Notification created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withErrors(['error' => 'Failed to create notification: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Display the specified notification.
     */
    public function show(Notification $notification)
    {
        $notification->load(['creator', 'userNotifications.user']);

        return view('admin.notifications.show', compact('notification'));
    }

    /**
     * Show the form for editing the specified notification.
     */
    public function edit(Notification $notification)
    {
        // Check if notification can be edited
        if ($notification->status === Notification::STATUS_EXPIRED) {
            return back()->withErrors(['error' => 'Expired notifications cannot be edited.']);
        }

        if ($notification->status === Notification::STATUS_ACTIVE && $notification->sent_at) {
            return back()->withErrors(['error' => 'Active notifications that have been sent cannot be edited.']);
        }

        $users = User::where('is_active', true)->get();
        $roles = User::distinct()->pluck('role')->filter()->values();

        return view('admin.notifications.edit', compact('notification', 'users', 'roles'));
    }

    /**
     * Update the specified notification.
     */
    public function update(Request $request, Notification $notification)
    {
        // Check if notification can be edited
        if ($notification->status === Notification::STATUS_EXPIRED) {
            return back()->withErrors(['error' => 'Expired notifications cannot be edited.']);
        }

        if ($notification->status === Notification::STATUS_ACTIVE && $notification->sent_at) {
            return back()->withErrors(['error' => 'Active notifications that have been sent cannot be edited.']);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:system,feature,promotional,alert,personal,credit',
            'priority' => 'required|in:low,medium,high,urgent',
            'action_text' => 'nullable|string|max:255',
            'action_url' => 'nullable|url',
            'target_type' => 'required|in:all,specific,role,custom',
            'target_users' => 'nullable|array',
            'target_users.*' => 'exists:users,id',
            'target_role' => 'nullable|string',
            'send_immediately' => 'required|boolean',
            'scheduled_at' => 'nullable|date|after:now',
            'expires_at' => 'nullable|date|after:now',
            'is_dismissible' => 'boolean',
            'is_persistent' => 'boolean',
            'show_as_popup' => 'boolean',
        ]);

        // Set default values
        $validated['is_dismissible'] = $request->has('is_dismissible');
        $validated['is_persistent'] = $request->has('is_persistent');
        $validated['show_as_popup'] = $request->has('show_as_popup');

        // Set icon and color based on type
        $validated['icon_class'] = Notification::getIconForType($validated['type']);
        $validated['color_code'] = Notification::getColorForType($validated['type']);

        // Validate target type specific fields
        if ($validated['target_type'] === 'specific' && empty($validated['target_users'])) {
            return back()->withErrors(['target_users' => 'Please select at least one user when targeting specific users.'])->withInput();
        }

        if ($validated['target_type'] === 'role' && empty($validated['target_role'])) {
            return back()->withErrors(['target_role' => 'Please select a role when targeting by role.'])->withInput();
        }

        DB::beginTransaction();
        try {
            // Update status based on send_immediately
            if ($validated['send_immediately'] && $notification->status === Notification::STATUS_DRAFT) {
                $validated['status'] = Notification::STATUS_ACTIVE;
                $validated['sent_at'] = now();
            } elseif (!$validated['send_immediately'] && $notification->status === Notification::STATUS_DRAFT) {
                $validated['status'] = Notification::STATUS_SCHEDULED;
            }

            $notification->update([
                'title' => $validated['title'],
                'message' => $validated['message'],
                'type' => $validated['type'],
                'priority' => $validated['priority'],
                'icon_class' => $validated['icon_class'],
                'color_code' => $validated['color_code'],
                'action_text' => $validated['action_text'],
                'action_url' => $validated['action_url'],
                'target_type' => $validated['target_type'],
                'target_users' => $validated['target_users'] ?? null,
                'target_role' => $validated['target_role'] ?? null,
                'status' => $validated['status'],
                'scheduled_at' => $validated['scheduled_at'] ?? null,
                'expires_at' => $validated['expires_at'] ?? null,
                'is_dismissible' => $validated['is_dismissible'],
                'is_persistent' => $validated['is_persistent'],
                'show_as_popup' => $validated['show_as_popup'],
            ]);

            // If sending immediately and not already sent, create user notifications
            if ($validated['send_immediately'] && !$notification->sent_at) {
                $this->deliverNotification($notification);
            }

            DB::commit();

            return redirect()
                ->route('admin.notifications.index')
                ->with('success', 'Notification updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withErrors(['error' => 'Failed to update notification: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Remove the specified notification.
     */
    public function destroy(Notification $notification)
    {
        // Check if notification can be deleted
        if ($notification->status === Notification::STATUS_ACTIVE) {
            return back()->withErrors(['error' => 'Active notifications cannot be deleted. Please expire them first.']);
        }

        DB::beginTransaction();
        try {
            // Delete user notifications
            $notification->userNotifications()->delete();

            // Soft delete notification
            $notification->delete();

            DB::commit();

            return redirect()
                ->route('admin.notifications.index')
                ->with('success', 'Notification deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withErrors(['error' => 'Failed to delete notification: ' . $e->getMessage()]);
        }
    }

    /**
     * Display notification analytics.
     */
    public function analytics(Notification $notification)
    {
        $notification->load(['userNotifications.user']);

        $analytics = [
            'total_recipients' => $notification->total_recipients,
            'read_count' => $notification->read_count,
            'unread_count' => $notification->unread_count,
            'read_rate' => $notification->read_rate,
            'action_click_rate' => $notification->action_click_rate,
            'dismiss_rate' => $notification->dismiss_rate,
        ];

        // Get detailed user engagement
        $userEngagement = $notification->userNotifications()
            ->with('user')
            ->orderBy('read_at', 'desc')
            ->paginate(50);

        return view('admin.notifications.analytics', compact('notification', 'analytics', 'userEngagement'));
    }

    /**
     * Duplicate a notification.
     */
    public function duplicate(Notification $notification)
    {
        $newNotification = $notification->replicate();
        $newNotification->title = $notification->title . ' (Copy)';
        $newNotification->status = Notification::STATUS_DRAFT;
        $newNotification->sent_at = null;
        $newNotification->created_by = auth()->id();
        $newNotification->save();

        return redirect()
            ->route('admin.notifications.edit', $newNotification)
            ->with('success', 'Notification duplicated successfully.');
    }

    /**
     * Resend notification to unread users.
     */
    public function resend(Notification $notification)
    {
        if ($notification->status !== Notification::STATUS_ACTIVE) {
            return back()->withErrors(['error' => 'Only active notifications can be resent.']);
        }

        // Get unread user notifications
        $unreadUserNotifications = $notification->userNotifications()->unread()->get();

        // Re-trigger notifications for unread users
        foreach ($unreadUserNotifications as $userNotification) {
            // You can add real-time notification trigger here
            // For example: $userNotification->user->notify(new DatabaseNotification(...));
        }

        return redirect()
            ->route('admin.notifications.show', $notification)
            ->with('success', "Notification resent to {$unreadUserNotifications->count()} unread users.");
    }

    /**
     * Deliver notification to target users.
     */
    protected function deliverNotification(Notification $notification): void
    {
        $targetUsers = $notification->getTargetUsers();

        foreach ($targetUsers as $user) {
            // Check user's notification preferences
            $preferences = $user->getNotificationPreferences();

            if (!$preferences->shouldReceiveType($notification->type)) {
                continue;
            }

            // Create user notification
            UserNotification::create([
                'notification_id' => $notification->id,
                'user_id' => $user->id,
                'is_read' => false,
                'is_dismissed' => false,
            ]);
        }
    }
}
