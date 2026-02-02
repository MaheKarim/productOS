<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificationPreference extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'enable_notifications',
        'receive_system',
        'receive_features',
        'receive_promotional',
        'receive_alerts',
        'receive_personal',
        'receive_credit',
        'show_popups',
        'auto_mark_read',
        'group_by_date',
        'auto_archive_after_days',
        'auto_delete_after_days',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
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
        'auto_archive_after_days' => 'integer',
        'auto_delete_after_days' => 'integer',
    ];

    /**
     * Get the user that owns the notification preferences.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the user should receive notifications of a specific type.
     */
    public function shouldReceiveType(string $type): bool
    {
        if (!$this->enable_notifications) {
            return false;
        }

        return match ($type) {
            Notification::TYPE_SYSTEM => $this->receive_system,
            Notification::TYPE_FEATURE => $this->receive_features,
            Notification::TYPE_PROMOTIONAL => $this->receive_promotional,
            Notification::TYPE_ALERT => $this->receive_alerts,
            Notification::TYPE_PERSONAL => $this->receive_personal,
            Notification::TYPE_CREDIT => $this->receive_credit,
            default => true,
        };
    }

    /**
     * Get default preferences for a new user.
     */
    public static function getDefaultPreferences(): array
    {
        return [
            'enable_notifications' => true,
            'receive_system' => true,
            'receive_features' => true,
            'receive_promotional' => true,
            'receive_alerts' => true,
            'receive_personal' => true,
            'receive_credit' => true,
            'show_popups' => true,
            'auto_mark_read' => true,
            'group_by_date' => true,
            'auto_archive_after_days' => 30,
            'auto_delete_after_days' => 90,
        ];
    }

    /**
     * Get or create preferences for a user.
     */
    public static function getForUser(int $userId): self
    {
        return self::firstOrCreate(
            ['user_id' => $userId],
            self::getDefaultPreferences()
        );
    }
}
