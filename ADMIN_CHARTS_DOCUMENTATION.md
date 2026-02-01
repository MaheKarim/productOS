# Admin Dashboard Charts & Analytics Documentation

## Overview

The admin dashboard now includes interactive charts and graphs to visualize key metrics and trends for your ProductOS application. This implementation provides real-time data visualization for user growth and credit consumption patterns.

## Features Implemented

### 1. Monthly User Registration Trend Chart

**Chart Type:** Line Chart with dual datasets

**Data Display:**
- X-axis: Months (Jan, Feb, Mar, etc.)
- Y-axis: Number of users registered
- Shows current year data with solid line
- Shows previous year data with dashed line for comparison
- Displays cumulative user count over time

**Additional Features:**
- Total registrations for each month
- Highlights peak registration months automatically
- Year-over-year comparison
- Filter by year (current year, previous years)
- Cumulative user count tracking

**API Endpoint:** `GET /admin/analytics/user-registrations`

**Query Parameters:**
- `year` (optional): Year to display (default: current year)

### 2. Feature-Wise Credit Consumption

**Chart Types:**
- Pie/Doughnut Chart: Visual distribution of credits by feature
- Bar Chart: Detailed breakdown with dual Y-axes (credits & users)

**Data Display:**
- Credits consumed per feature (Interview Prep, Resume Builder, Strategic Roadmap, etc.)
- Percentage distribution of each feature
- Number of users per feature
- Average credits per user per feature

**Filter Options:**
- All Time: Complete historical data
- This Month: Current month data
- This Week: Current week data
- Today: Today's data only

**API Endpoint:** `GET /admin/analytics/credit-consumption`

**Query Parameters:**
- `period` (optional): Time period filter (default: "all")
  - Options: "all", "month", "week", "today"
- `start_date` (optional): Custom start date (YYYY-MM-DD)
- `end_date` (optional): Custom end date (YYYY-MM-DD)

### 3. Dashboard Summary Metrics

**Metrics Displayed:**
- Active users vs inactive users
- Total credits in circulation
- Average credits per user
- Feature activation status indicators
- Credit consumption per feature

**API Endpoint:** `GET /admin/analytics/metrics`

## Export Functionality

### Export Options
- **PNG Export**: Download chart as high-resolution PNG image
- **CSV Export**: Download chart data as CSV file for further analysis

### How to Export
1. Click download icon (↓) to export CSV data
2. Click image icon (🖼️) to export chart as PNG
3. Files are automatically named with chart type and date

## Technical Implementation

### Libraries Used
- **Chart.js v4.4.1**: Main charting library
- **Chart.js Data Labels Plugin**: For displaying labels on charts
- **Chart.js Date Adapter**: For date-based charts
- **Tailwind CSS**: Styling and responsive design
- **Lucide Icons**: Iconography

### Database Models Used
- `User`: User registration data
- `FeatureUsage`: Credit consumption tracking
- `Feature`: Feature configuration and status

## Usage Examples

### Viewing Different Years
```javascript
// Load 2025 data
loadUserRegistrationChart(2025);

// Load 2024 data
loadUserRegistrationChart(2024);
```

### Filtering by Period
```javascript
// Load this month's data
changePeriod('month');

// Load this week's data
changePeriod('week');

// Load today's data
changePeriod('today');
```

## Troubleshooting

### Common Issues

**Charts not loading:**
- Check browser console for JavaScript errors
- Verify API endpoints are accessible
- Ensure user has admin privileges

**Incorrect data:**
- Verify database migrations are run
- Check `feature_usages` table has records
- Ensure `created_at` timestamps are correct

## Changelog

### Version 1.0.0 (2026-02-01)
- Initial implementation of user registration trend chart
- Added feature-wise credit consumption charts
- Implemented dashboard summary metrics
- Added export functionality (PNG, CSV)
- Implemented period filtering
- Added year-over-year comparison
- Responsive design implementation
