# Custom URL Field - Usage Guide

## Overview
The `custom_url` field has been added to the `tools` table to support tools with custom routes (like PM Career Compass).

## When to Use Custom URL

Use the `custom_url` field when a tool needs to:
- Have a different URL structure than the standard `/tools/{category}/{tool}` pattern
- Point to a standalone page or external resource
- Have complex routing that doesn't fit the standard tool pattern

## Examples

### PM Career Compass
- **Custom URL:** `/tools/career-compass`
- **Standard URL would be:** `/tools/validation-research/pm-career-compass`
- **Reason:** Career Compass has its own dedicated route structure with multiple pages

### Standard Tools (No Custom URL)
- **URL:** `/tools/{category}/{tool}` (e.g., `/tools/saas-metrics/cac`)
- **Reason:** Standard calculator tools follow this pattern

## How to Add Custom URL

### Via Admin Panel
1. Navigate to **Admin → Tools Management**
2. Click **"Add New Tool"** or edit an existing tool
3. In the **Basic Information** section, find the **"Custom URL"** field
4. Enter the custom URL path (e.g., `/tools/career-compass`)
5. Leave the field **empty** for standard tools
6. Save the tool

### Via Database Seeder
When adding tools programmatically (e.g., in seeder):
```php
Tool::create([
    'name' => 'PM Career Compass',
    'slug' => 'pm-career-compass',
    'custom_url' => '/tools/career-compass', // Add this line
    // ... other fields
]);
```

## Frontend Behavior

### Tools Index Page
- Tools with `custom_url` will link directly to that URL
- Tools without `custom_url` will use the standard route pattern
- The custom URL is displayed in the admin tools table for reference

### Search Functionality
- Search results will use the custom URL if available
- Falls back to standard URL pattern if no custom URL

## Important Notes

1. **No Leading Slash Required:** The custom URL can be with or without leading slash
   - `/tools/career-compass` ✓
   - `tools/career-compass` ✓

2. **URL Validation:** Ensure the custom URL points to an existing route
   - Test the URL after adding it
   - The URL will be used as-is in the `href` attribute

3. **Route Priority:** Custom URLs take precedence over standard routing
   - If `custom_url` is set, it will be used
   - If `custom_url` is null/empty, standard routing applies

## Admin Panel Display

In the tools management table, tools with custom URLs will display:
- Tool name
- Time estimate
- **Custom URL (if set)** - shown in indigo color with arrow icon

This makes it easy to identify which tools have custom routing.
