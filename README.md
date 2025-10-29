# YooTheme Access Control Plugin

This plugin restricts YooTheme Builder access to administrators only, blocking all other user roles from accessing YooTheme functionality.

## Features

- **Role-based access control** - Only administrators can access YooTheme Builder
- **UI hiding** - YooTheme buttons are hidden from non-admin users (no flash)
- **Server-side security** - Direct URL access is blocked at the server level
- **Clean error messages** - Users see clear messages when access is denied
- **No redirect loops** - Properly handles redirects to prevent browser errors

## What it blocks

- YooTheme Builder button in post/page editors
- Direct YooTheme Builder URLs (admin-ajax.php)
- YooTheme menu in left admin sidebar
- Any YooTheme admin pages
- All YooTheme-related functionality

## User Roles Affected

**Blocked (cannot access YooTheme):**
- Editors
- Authors
- Contributors
- Subscribers
- Shop Managers (WooCommerce)
- Any custom roles

**Allowed (full access):**
- Administrators

## Installation

1. Upload the plugin to `/wp-content/plugins/yootheme-access-control/`
2. Activate the plugin through the 'Plugins' menu in WordPress
3. No configuration needed - works immediately

## Security

- **Server-side blocking** prevents direct URL access
- **CSS hiding** prevents UI elements from showing
- **JavaScript backup** ensures complete hiding
- **Proper redirect handling** prevents browser errors

## Requirements

- WordPress 5.0+
- YooTheme Pro
- PHP 7.4+

## Automatic Updates

This plugin supports automatic updates directly from GitHub. WordPress will check for new versions and notify you when updates are available.

### How Updates Work

- Plugin checks GitHub repository for new releases
- Updates are shown in WordPress admin (Plugins page)
- Click "Update Now" to install the latest version
- No need to manually download and upload files

### Creating a New Release (for developers)

To release a new version:

1. Update the version number in `yootheme-access-control.php` header (line 6)
2. Update `YOOTHEME_ACCESS_CONTROL_VERSION` constant (line 18)
3. Commit and push changes to the main branch
4. Create a new release on GitHub:
   - Go to: https://github.com/pduke7/YooTheme-Access-Control-/releases/new
   - Tag version: Use semantic versioning (e.g., `v1.0.1`, `v1.1.0`, `v2.0.0`)
   - Release title: Same as tag (e.g., `v1.0.1`)
   - Description: List changes in the release
   - Click "Publish release"
5. WordPress will detect the new version within 12 hours

**Note**: The tag must match the version in the plugin header for updates to work correctly.

## Support

For support, please contact the plugin author or open an issue on GitHub.

## License

GPL v2 or later 