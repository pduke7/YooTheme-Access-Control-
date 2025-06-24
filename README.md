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

## Support

For support, please contact the plugin author.

## License

GPL v2 or later 