<?php
/**
 * Plugin Name: YooTheme Access Control
 * Plugin URI: https://prasina-scholeia.gr
 * Description: Restricts YooTheme Builder access to administrators only. Blocks all other user roles from accessing YooTheme functionality.
 * Version: 1.0.0
 * Author: Prasina Scholeia
 * License: GPL v2 or later
 * Text Domain: yootheme-access-control
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('YOOTHEME_ACCESS_CONTROL_VERSION', '1.0.0');
define('YOOTHEME_ACCESS_CONTROL_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('YOOTHEME_ACCESS_CONTROL_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Main plugin class
 */
class YooThemeAccessControl {
    
    public function __construct() {
        // Hide YooTheme Builder for non-admin roles - load early to prevent flash
        add_action('admin_enqueue_scripts', array($this, 'hide_yootheme_builder_for_non_admins'), 1);
        
        // Block YooTheme Builder access for non-admin roles
        add_action('init', array($this, 'block_yootheme_builder_access'));
        
        // Show admin notice when access is blocked
        add_action('admin_notices', array($this, 'show_blocked_notice'));
    }
    
    /**
     * Hide YooTheme Builder for non-admin roles
     */
    public function hide_yootheme_builder_for_non_admins() {
        // Check if current user is NOT an administrator
        if (!current_user_can('administrator')) {
            // Add CSS inline to load immediately
            wp_add_inline_style('wp-admin', '
                /* Hide YooTheme Builder button for non-admins - load immediately */
                .wp-media-buttons a[href*="customizer"][href*="builder"],
                .wp-media-buttons a[href*="action=kernel"][href*="section=builder"] {
                    display: none !important;
                }
                
                /* Also hide by text content using attribute selector */
                .wp-media-buttons a[href*="customizer"]:has-text("YOOtheme Builder") {
                    display: none !important;
                }
            ');
            
            // Add JavaScript as backup (but CSS should handle it)
            wp_add_inline_script('jquery', '
                jQuery(document).ready(function($) {
                    // Hide YooTheme Builder button as backup
                    $(".wp-media-buttons a").each(function() {
                        if ($(this).text().includes("YOOtheme Builder") || 
                            ($(this).attr("href") && $(this).attr("href").includes("customizer") && $(this).attr("href").includes("builder"))) {
                            $(this).hide();
                        }
                    });
                });
            ');
        }
    }
    
    /**
     * Block YooTheme Builder access for non-admin roles
     */
    public function block_yootheme_builder_access() {
        // Check if current user is NOT an administrator
        if (!current_user_can('administrator')) {
            // Get current URL
            $current_url = $_SERVER['REQUEST_URI'] ?? '';
            $current_url_lower = strtolower($current_url);
            
            // Don't block our own redirect destination page
            if (strpos($current_url_lower, 'yootheme_blocked=1') !== false) {
                return;
            }
            
            // Only block if this is actually a YooTheme URL, not our redirect destination
            $is_yootheme_url = false;
            
            // Check if this is a YooTheme Builder request
            if (strpos($current_url_lower, 'admin-ajax.php') !== false && 
                strpos($current_url_lower, 'action=kernel') !== false &&
                strpos($current_url_lower, 'section=builder') !== false) {
                $is_yootheme_url = true;
            }
            
            // Block YooTheme menu URLs (admin-ajax.php with kernel action)
            if (strpos($current_url_lower, 'admin-ajax.php') !== false && 
                strpos($current_url_lower, 'action=kernel') !== false &&
                strpos($current_url_lower, 'p=customizer') !== false) {
                $is_yootheme_url = true;
            }
            
            // Also check for customizer URLs that might be YooTheme Builder
            if (strpos($current_url_lower, 'customizer') !== false && 
                strpos($current_url_lower, 'builder') !== false) {
                $is_yootheme_url = true;
            }
            
            // Block YooTheme menu URLs (left admin menu)
            if (strpos($current_url_lower, 'admin.php') !== false && 
                strpos($current_url_lower, 'page=yootheme') !== false) {
                $is_yootheme_url = true;
            }
            
            // Block any other YooTheme related URLs
            if (strpos($current_url_lower, 'yootheme') !== false && 
                (strpos($current_url_lower, 'admin') !== false || strpos($current_url_lower, 'wp-admin') !== false)) {
                $is_yootheme_url = true;
            }
            
            // Only redirect if this is actually a YooTheme URL
            if ($is_yootheme_url) {
                // Block access and redirect to admin with error message
                wp_redirect(admin_url('edit.php?post_type=post&yootheme_blocked=1'));
                exit;
            }
        }
    }
    
    /**
     * Show admin notice when access is blocked
     */
    public function show_blocked_notice() {
        // Check if current user is NOT an administrator
        if (!current_user_can('administrator')) {
            // Check if we're on the blocked page
            if (isset($_GET['yootheme_blocked']) && $_GET['yootheme_blocked'] == '1') {
                echo '<div class="notice notice-error"><p><strong>Access Denied:</strong> YooTheme Builder access is restricted to administrators only.</p></div>';
            }
        }
    }
}

// Initialize the plugin
new YooThemeAccessControl(); 