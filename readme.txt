=== Genesis Title Toggle ===
Contributors: billerickson
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=EDYM76U6BTE5L
Tags: genesis, genesiswp, title, 
Requires at least: 3.0
Tested up to: 3.5.1
Stable tag: 1.5

Turn on/off page titles on a per page basis, and set sitewide defaults from Theme Settings. Must be using the Genesis theme.

== Description ==

This plugin lets you easily remove the page title from specific pages. Don't want "Home" at the top of your homepage? Activate, then edit the homepage and check "Hide".

You can also set sitewide defaults. If you don't want page titles on any pages, go to Genesis > Theme Settings > Title Toggle and check the appropriate box. Once a post type has the default set to remove, when editing a page you can selectively turn on that page's title.

Finally, if you're comfortable with code you can use the `be_title_toggle_post_types` filter to change the post types this applies to (it only applies to pages by default). 

[Support Forum](https://github.com/billerickson/Genesis-Title-Toggle/issues)


== Installation ==

1. Upload the `genesis-title-toggle` folder to your `/wp-content/plugins/` directory

2. Activate the "Genesis Title Toggle" plugin in your WordPress administration interface

3. When editing a page, go down to the Title Toggle metabox and check "hide" to hide that page's title.

4. (Optional) Go to Genesis > Theme Settings > Title Toggle to remove titles on all pages by default.


== Screenshots ==

1. The metabox that shows up on the Edit screen.

2. The metabox that shows up on Genesis > Theme Settings.

3. If you check "hide" on Theme Settings, this metabox is displayed on the Edit screen.

== Changelog ==

= 1.5 = 
* Add HTML5 Support for Genesis 2.0

= 1.4 = 
* Updated to work with all StudioPress themes with post formats

= 1.3 =
* Updated the metabox library to latest version

= 1.2.3 = 
* The fix in 1.2.2 didn't make it for some reason, so re-patching it.

= 1.2.2 =
* Minor modification to the way it detects Genesis. Upgrading is only necessary if you're using Premise

= 1.2.1 = 
* Typo in 1.2 caused the plugin to crash. I'm so sorry!

= 1.2 =
* Fixed an issue where if you weren't running Genesis, site breaks (ex: WP Touch changes themes when on mobile device)

= 1.1 = 
* Added support for localization and a German language pack. Thanks David Decker.

= 1.0 = 
* Initial release