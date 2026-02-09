## Plan to Update "Resume Builder" to "Resume Analyzer"

### Files to Update:

1. **User Dashboard** (`/Users/mahekarim/Workspace/portfolio/resources/views/user/dashboard.blade.php`)
   - Line 94: Change "Resume Builder" to "Resume Analyzer"

2. **Feature Seeder** (`/Users/mahekarim/Workspace/portfolio/database/seeders/FeatureSeeder.php`)
   - Line 28: Update feature name from "Resume Builder" to "Resume Analyzer"

### Changes Required:

**File 1: User Dashboard**
```php
// Current:
<h3 class="font-bold text-slate-900 mb-1">Resume Builder</h3>

// Change to:
<h3 class="font-bold text-slate-900 mb-1">Resume Analyzer</h3>
```

**File 2: Feature Seeder**
```php
// Current:
'name' => 'Resume Builder',

// Change to:
'name' => 'Resume Analyzer',
```

### Notes:
- The route names and feature keys will remain unchanged to maintain system compatibility
- Only the display text will be updated for user-facing content
- This is a simple text replacement that won't affect functionality