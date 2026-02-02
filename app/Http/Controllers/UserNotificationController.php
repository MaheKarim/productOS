<?php

namespace App\Http\Controllers;

use App\Models\UserNotification;
use App\Models\Notification;
use App\Models\NotificationPreference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserNotificationController extends Controller
{
    /**
     * Display user's notifications.
     */
    public function index(Request $request)
    {
        $query = Auth::user()->userNotifications()->notExpired()->active();

        // Filter by status (read/unread)
        if ($request->filled('status')) {
            if ($request->status === 'unread') {
                $query->unread();
            } elseif ($request->status === 'read') {
                $query->read();
            }
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->ofType($request->type);
        }

        // Filter by priority
        if ($request->filled('priority')) {
            $query->ofPriority($request->priority);
        }

        // Search by title or message
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('notification', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            });
        }

        // Order by created_at desc
        $query->orderBy('created_at', 'desc');

        $notifications = $query->paginate(20);

        // Get unread count
        $unreadCount = Auth::user()->unread_notifications_count;

        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    /**
     * Get unread count for badge.
     */
    public function unreadCount()
    {
        $count = Auth::user()->unread_notifications_count;

        return response()->json([
            'count' => $count,
            'display' => $count > 99 ? '99+' : $count,
        ]);
    }

    /**
     * Get recent notifications for dropdown.
     */
    public function recent()
    {
        $notifications = Auth::user()
            ->unreadNotifications()
            ->with('notification')
            ->orderBy('created_at', 'desc')
            ->limit(15)
            ->get();

        return response()->json([
            'notifications' => $notifications,
            'count' => $notifications->count(),
        ]);
    }

    /**
     * Get all notifications for dropdown (including read).
     */
    public function dropdown()
    {
        $notifications = Auth::user()
            ->userNotifications()
            ->notExpired()
            ->active()
            ->with('notification')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => Auth::user()->unread_notifications_count,
        ]);
    }

    /**
     * Mark a notification as read.
     */
    public function markAsRead(UserNotification $userNotification)
    {
        // Ensure user owns the notification
        if ($userNotification->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $userNotification->markAsRead();

        return response()->json([
            'success' => true,
            'unread_count' => Auth::user()->unread_notifications_count,
        ]);
    }

    /**
     * Mark a notification as unread.
     */
    public function markAsUnread(UserNotification $userNotification)
    {
        // Ensure user owns the notification
        if ($userNotification->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $userNotification->markAsUnread();

        return response()->json([
            'success' => true,
            'unread_count' => Auth::user()->unread_notifications_count,
        ]);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        Auth::user()
            ->unreadNotifications()
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return response()->json([
            'success' => true,
            'unread_count' => 0,
        ]);
    }

    /**
     * Dismiss a notification.
     */
    public function dismiss(UserNotification $userNotification)
    {
        // Ensure user owns the notification
        if ($userNotification->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Check if notification can be dismissed
        if (!$userNotification->canBeDismissed()) {
            return response()->json(['error' => 'This notification cannot be dismissed'], 403);
        }

        $userNotification->dismiss();

        return response()->json([
            'success' => true,
            'unread_count' => Auth::user()->unread_notifications_count,
        ]);
    }

    /**
     * Restore a dismissed notification.
     */
    public function restore(UserNotification $userNotification)
    {
        // Ensure user owns the notification
        if ($userNotification->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $userNotification->restore();

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * Delete a notification permanently.
     */
    public function destroy(UserNotification $userNotification)
    {
        // Ensure user owns the notification
        if ($userNotification->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $userNotification->delete();

        return response()->json([
            'success' => true,
            'unread_count' => Auth::user()->unread_notifications_count,
        ]);
    }

    /**
     * Bulk mark notifications as read.
     */
    public function bulkMarkAsRead(Request $request)
    {
        $validated = $request->validate([
            'notification_ids' => 'required|array',
            'notification_ids.*' => 'exists:user_notifications,id',
        ]);

        $count = Auth::user()
            ->userNotifications()
            ->whereIn('id', $validated['notification_ids'])
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return response()->json([
            'success' => true,
            'count' => $count,
            'unread_count' => Auth::user()->unread_notifications_count,
        ]);
    }

    /**
     * Bulk dismiss notifications.
     */
    public function bulkDismiss(Request $request)
    {
        $validated = $request->validate([
            'notification_ids' => 'required|array',
            'notification_ids.*' => 'exists:user_notifications,id',
        ]);

        $count = Auth::user()
            ->userNotifications()
            ->whereIn('id', $validated['notification_ids'])
            ->update([
                'is_dismissed' => true,
                'dismissed_at' => now(),
            ]);

        return response()->json([
            'success' => true,
            'count' => $count,
            'unread_count' => Auth::user()->unread_notifications_count,
        ]);
    }

    /**
     * Bulk delete notifications.
     */
    public function bulkDestroy(Request $request)
    {
        $validated = $request->validate([
            'notification_ids' => 'required|array',
            'notification_ids.*' => 'exists:user_notifications,id',
        ]);

        $count = Auth::user()
            ->userNotifications()
            ->whereIn('id', $validated['notification_ids'])
            ->delete();

        return response()->json([
            'success' => true,
            'count' => $count,
            'unread_count' => Auth::user()->unread_notifications_count,
        ]);
    }

    /**
     * Get notification preferences.
     */
    public function preferences()
    {
        $preferences = Auth::user()->getNotificationPreferences();

        return response()->json([
            'preferences' => $preferences,
        ]);
    }

    /**
     * Update notification preferences.
     */
    public function updatePreferences(Request $request)
    {
        $validated = $request->validate([
            'enable_notifications' => 'boolean',
            'receive_system' => 'boolean',
            'receive_features' => 'boolean',
            'receive_promotional' => 'boolean',
            'receive_alerts' => 'boolean',
            'receive_personal' => 'boolean',
            'receive_credit' => 'boolean',
            'show_popups' => 'boolean',
            'auto_mark_read' => 'boolean',
            'group_by_date' => 'boolean',
            'auto_archive_after_days' => 'nullable|integer|min:0',
            'auto_delete_after_days' => 'nullable|integer|min:0',
        ]);

        $preferences = Auth::user()->getNotificationPreferences();
        $preferences->update($validated);

        return response()->json([
            'success' => true,
            'preferences' => $preferences,
        ]);
    }

    /**
     * Record action click on notification.
     */
    public function recordActionClick(UserNotification $userNotification)
    {
        // Ensure user owns the notification
        if ($userNotification->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $userNotification->recordActionClick();
        $userNotification->markAsRead();

        return response()->json([
            'success' => true,
            'action_url' => $userNotification->notification->action_url,
            'unread_count' => Auth::user()->unread_notifications_count,
        ]);
    }

    /**
     * Get notifications grouped by date.
     */
    public function grouped(Request $request)
    {
        $query = Auth::user()->userNotifications()->notExpired()->active();

        // Filter by status (read/unread)
        if ($request->filled('status')) {
            if ($request->status === 'unread') {
                $query->unread();
            } elseif ($request->status === 'read') {
                $query->read();
            }
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->ofType($request->type);
        }

        $notifications = $query->with('notification')
            ->orderBy('created_at', 'desc')
            ->get();

        // Group by date
        $grouped = $notifications->groupBy(function ($item) {
            $date = $item->created_at;
            if ($date->isToday()) {
                return 'Today';
            } elseif ($date->isYesterday()) {
                return 'Yesterday';
            } elseif ($date->diffInDays(now()) <= 7) {
                return 'This Week';
            } else {
                return $date->format('F j, Y');
            }
        });

        return response()->json([
            'grouped' => $grouped,
            'unread_count' => Auth::user()->unread_notifications_count,
        ]);
    }
}
