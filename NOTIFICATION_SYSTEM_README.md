# Web-Based Notification Management System

A comprehensive notification system for web applications with admin control for managing notifications and user interface for reading them.

## Features

### Admin Panel - Notification Management

#### 1. Create Notification
- **Notification Types:**
  - System Notification (general announcements, updates)
  - Feature Notification (new features, feature updates)
  - Promotional Notification (offers, discounts)
  - Alert/Warning (important alerts, maintenance notices)
  - Personal Message (targeted individual messages)
  - Credit/Billing (credit updates, payment reminders)

- **Creation Form Fields:**
  - Basic Information: Title, Message, Type, Priority
  - Targeting Options: All Users, Specific User, User Role, Custom
  - Scheduling: Send Immediately, Schedule for Later, Auto-expire After
  - Display Settings: Dismissible, Persistent, Show as Popup
  - Action Button: Button Text, Action URL

#### 2. View Notifications (Admin Dashboard)
- Notification List Table with columns: ID, Title, Type, Target Audience, Status, Sent Date, Read Rate, Actions
- Filtering & Search: Filter by type, status, date range, target audience
- Detailed View: Full notification preview, recipient list, engagement details

#### 3. Update/Edit Notification
- Edit Rules:
  - Draft Notifications: Fully editable
  - Scheduled Notifications: Editable until send time
  - Active Notifications: Can update expiration, cannot change content
  - Expired Notifications: Cannot edit, can duplicate

#### 4. Delete Notification
- Delete Options: Soft Delete, Permanent Delete, Bulk Delete
- Delete Behavior: Different rules based on notification status
- Confirmation: Required with warning for active notifications

#### 5. Notification Analytics
- Performance Metrics Dashboard: Total sent, active, scheduled, delivery success rate, read rate
- Individual Notification Stats: Recipients, read count, unread count, action clicks, dismiss rate
- Visual Analytics: Charts for engagement over time, read vs unread comparison, type distribution

### User Panel - Notification Interface

#### 1. Notification Bell Icon
- Bell Icon with badge counter
- Unread Count Badge: Red circle with number, shows "99+" for 100+ unread
- Auto-update badge count in real-time (polling every 30 seconds)
- Animated pulse/shake on new notification arrival

#### 2. Notification Dropdown Panel
- Panel Design: Opens below bell icon, shows recent 15 notifications
- Panel Header: "Notifications" heading, "Mark all as read" button
- Notification Grouping: Today, Yesterday, This Week, Older
- Panel Footer: "View All Notifications" link

#### 3. Notification Card Design
- Type Icon/Color: Different icons and colors for each notification type
- Title and Message Preview: Truncated in dropdown, full in notification center
- Timestamp: Relative time (Just now, 5 minutes ago, etc.)
- Read/Unread Indicator: Blue dot for unread, normal for read
- Action Button: Appears at bottom if configured by admin

#### 4. Notification Center (Full Page)
- Page Layout: Dedicated route `/notifications`
- Tab Navigation: All, Unread, System, Features, Alerts, Archived
- Filter & Search: Search bar, date range filter, type filter, sort options
- Notification List: Paginated, full message content, quick actions
- Bulk Actions: Select multiple, mark as read, delete/archive

#### 5. Read/Unread Management
- Auto Mark as Read: When user clicks notification, visible for 3+ seconds, action button clicked
- Manual Actions: Mark as read/unread, mark all as read
- Read Status Indicators: Visual differences between read and unread

#### 6. Notification Actions
- User Actions: Read/Open, Dismiss/Archive, Delete, Mark Unread, Click Action Button
- Notification Persistence: Persistent notifications cannot be dismissed
- Expired Notifications: Auto-remove when expiration date passes

#### 7. User Notification Preferences
- Settings Page Section: Located in user profile/settings
- Preference Options:
  - Global toggle to enable/disable all notifications
  - Individual toggles for each notification type
  - Display preferences (show popups, auto-mark read, group by date)
  - Cleanup preferences (auto-archive, auto-delete)

#### 8. Notification Popup/Modal (Optional)
- On Login/Page Load: Shows modal for urgent/high-priority unread notifications
- Modal Design: Title, message content, priority indicator, action button, dismiss button

## Technical Implementation

### Database Tables

#### notifications table
```php
id, title, message, type, priority, icon_class, color_code,
action_text, action_url, target_type, target_users, target_role,
status, scheduled_at, expires_at, is_dismissible, is_persistent,
show_as_popup, created_by, created_at, updated_at, deleted_at
```

#### user_notifications table (pivot/junction)
```php
id, notification_id, user_id, is_read, read_at,
is_dismissed, dismissed_at, action_clicked, clicked_at, created_at
```

#### notification_preferences table
```php
id, user_id, enable_notifications, receive_system, receive_features,
receive_promotional, receive_alerts, receive_personal, receive_credit,
show_popups, auto_mark_read, group_by_date,
auto_archive_after_days, auto_delete_after_days
```

### Models

#### Notification Model
- Relationships: creator, userNotifications
- Scopes: active, scheduled, draft, expired, urgent, highPriority, ofType, ofTargetType
- Methods: getTotalRecipients, getReadCount, getUnreadCount, getReadRate, getActionClickRate, getDismissRate
- Static Methods: getIconForType, getColorForType, getIconForPriority

#### UserNotification Model
- Relationships: notification, user
- Scopes: unread, read, dismissed, active, ofType, ofPriority, ofNotificationStatus, notExpired, showAsPopup
- Methods: markAsRead, markAsUnread, dismiss, restore, recordActionClick, canBeDismissed, isVisible

#### NotificationPreference Model
- Relationships: user
- Methods: shouldReceiveType, getDefaultPreferences, getForUser

### Controllers

#### Admin/NotificationController
- Methods: index, create, store, show, edit, update, destroy, analytics, duplicate, resend
- Features: Filtering, pagination, validation, delivery logic, bulk operations

#### UserNotificationController
- Methods: index, unreadCount, recent, dropdown, markAsRead, markAsUnread, markAllAsRead, dismiss, restore, destroy, bulkMarkAsRead, bulkDismiss, bulkDestroy, preferences, updatePreferences, recordActionClick, grouped
- Features: Real-time updates, grouped notifications, preference management

### Routes

#### Admin Routes
```
/admin/notifications - List all notifications
/admin/notifications/create - Create notification form
/admin/notifications/{id} - View notification details
/admin/notifications/{id}/edit - Edit notification
/admin/notifications/{id}/analytics - View analytics
/admin/notifications/{id}/duplicate - Duplicate notification
/admin/notifications/{id}/resend - Resend to unread users
```

#### User Routes
```
/notifications - Notification center
/notifications/preferences - Preferences page
/notifications/unread-count - Get unread count
/notifications/recent - Get recent notifications
/notifications/dropdown - Get dropdown notifications
/notifications/{id}/read - Mark as read
/notifications/{id}/unread - Mark as unread
/notifications/mark-all-read - Mark all as read
/notifications/{id}/dismiss - Dismiss notification
/notifications/{id}/restore - Restore notification
/notifications/{id} - Delete notification
/notifications/bulk/mark-read - Bulk mark as read
/notifications/bulk/dismiss - Bulk dismiss
/notifications/bulk/destroy - Bulk delete
/notifications/{id}/action-click - Record action click
/notifications/grouped - Get grouped notifications
```

### Jobs

#### SendScheduledNotifications
- Runs every minute (via cron)
- Sends scheduled notifications when scheduled_at <= current_time
- Creates user_notification records for target users
- Checks user preferences before sending

#### ExpireNotifications
- Runs daily (via cron)
- Expires notifications when expires_at <= current_time
- Updates status to 'expired'

#### ScheduleNotifications Command
- Console command to process notifications
- Can be run manually or via cron
- Dispatches both SendScheduledNotifications and ExpireNotifications jobs

### Real-Time Updates

- **Polling:** Check for new notifications every 30 seconds
- **Features:**
  - Badge count auto-updates
  - New notification appears in dropdown without refresh
  - Toast/snackbar notification on new arrival
  - Visual indication (bell icon animation)

### Performance Optimization

- **Pagination:** Load 20-30 notifications per page
- **Lazy Loading:** Load more as user scrolls
- **Caching:** Cache unread count queries
- **Database Indexing:** Optimize queries with proper indexes
- **Query Optimization:** Use eager loading to prevent N+1 queries
- **Batch Operations:** Process bulk actions efficiently
- **Asynchronous Processing:** Use queues for sending to large user bases

### Security Considerations

- **Authorization:** Users can only view their own notifications
- **Input Validation:** Sanitize all admin inputs (prevent XSS)
- **SQL Injection Prevention:** Use parameterized queries
- **Rate Limiting:** Prevent spam creation from admin panel
- **Audit Logging:** Track all admin actions
- **Role-Based Access:** Only authorized admins can create notifications

### Responsive Design

- **Desktop (>768px):** Dropdown panel from bell icon, notification center full page with sidebar
- **Tablet (768px - 1024px):** Adjusted dropdown width, notification center full-width
- **Mobile (<768px):** Full-screen notification panel (slide from right), bottom sheet for dropdown

### Accessibility (A11Y)

- **ARIA Labels:** Proper labels for screen readers
- **Keyboard Navigation:** Support for Tab, Enter, Escape
- **Focus Management:** Auto-focus on dropdown open
- **Color Contrast:** WCAG AA compliance
- **Screen Reader Announcements:** For new notifications
- **Alt Text:** For icons and images

## Installation & Setup

### 1. Run Migrations
```bash
php artisan migrate
```

### 2. Set Up Cron Jobs
Add to your crontab:
```
* * * * * php /path/to/your/project/artisan notifications:process >> /dev/null 2>&1
```

Or use Laravel's scheduler in `app/Console/Kernel.php`:
```php
$schedule->command('notifications:process')->everyMinute();
```

### 3. Add Notification Link to Navigation
The notification bell is already integrated into the main navigation bar in `resources/views/components/nav.blade.php`.

### 4. Add Admin Link to Sidebar
Add notification management link to admin sidebar in `resources/views/admin/layout.blade.php`:
```blade
<a href="{{ route('admin.notifications.index') }}"
   class="menu-item group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-soft {{ request()->routeIs('admin.notifications.*') ? 'sidebar-item-active' : 'hover:bg-slate-800/50 hover:text-white' }}"
   data-menu-name="notifications">
    <i data-lucide="bell" class="mr-3 w-5 h-5 {{ request()->routeIs('admin.notifications.*') ? 'text-indigo-400' : 'text-slate-500 group-hover:text-indigo-400' }}"></i>
    Notifications
    <span class="ml-auto px-2 py-0.5 text-[10px] rounded-full bg-indigo-500/20 text-indigo-400 font-bold">
        {{ \App\Models\Notification::count() }}
    </span>
</a>
```

## Usage Examples

### Creating a Notification (Admin)
1. Navigate to `/admin/notifications/create`
2. Fill in the form:
   - Title: "New Feature Released"
   - Message: "We've just released a new feature that allows you to..."
   - Type: "feature"
   - Priority: "medium"
   - Target: "All Users"
   - Send Immediately: Yes
3. Click "Create Notification"

### Viewing Notifications (User)
1. Click the bell icon in the navigation bar
2. View recent notifications in dropdown
3. Click "View All Notifications" for full list
4. Click on any notification to mark as read

### Managing Preferences (User)
1. Navigate to `/notifications/preferences`
2. Toggle notification types on/off
3. Configure display settings
4. Set cleanup preferences
5. Click "Save Preferences"

## File Structure

```
app/
├── Http/Controllers/
│   ├── Admin/
│   │   └── NotificationController.php
│   └── UserNotificationController.php
├── Models/
│   ├── Notification.php
│   ├── UserNotification.php
│   └── NotificationPreference.php
├── Jobs/
│   ├── SendScheduledNotifications.php
│   └── ExpireNotifications.php
└── Console/Commands/
    └── ScheduleNotifications.php

database/migrations/
├── 2026_02_02_190000_create_notifications_table.php
├── 2026_02_02_190001_create_user_notifications_table.php
└── 2026_02_02_190002_create_notification_preferences_table.php

resources/views/
├── admin/
│   └── notifications/
│       ├── index.blade.php
│       ├── create.blade.php
│       ├── edit.blade.php
│       ├── show.blade.php
│       └── analytics.blade.php
├── notifications/
│   ├── index.blade.php
│   └── preferences.blade.php
└── components/
    └── nav.blade.php (updated with notification bell)

routes/web.php (updated with notification routes)
```

## Future Enhancements

- [ ] Implement WebSockets for true real-time updates
- [ ] Add email notification option for users
- [ ] Implement push notifications for mobile devices
- [ ] Add notification templates for quick creation
- [ ] Implement A/B testing for notifications
- [ ] Add notification categories/tags
- [ ] Implement notification scheduling with recurring options
- [ ] Add notification preview before sending
- [ ] Implement notification export/import functionality
- [ ] Add notification analytics dashboard with more metrics
- [ ] Implement notification localization/multi-language support

## Support

For issues or questions, please refer to the Laravel documentation or contact the development team.
