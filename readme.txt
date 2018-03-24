=== Genesis Title Toggle ===
Contributors: billerickson
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=EDYM76U6BTE5L
Tags: genesis, genesiswp, title,
Requires at least: 3.0
Tested up to: 4.9
Stable tag: 1.8.0

This plugin ONLY works with the Genesis theme. Do not install if you are not using Genesis.

Turn on/off page titles on a per page basis, and set sitewide defaults from Theme Settings. Must be using the Genesis theme.

== Description ==

This plugin ONLY works with the Genesis theme. Do not install if you are not using Genesis.

This plugin lets you easily remove the page title from specific pages. Don't want "Home" at the top of your homepage? Activate, then edit the homepage and check "Hide".

You can also set sitewide defaults. If you don't want page titles on any pages, go to Genesis > Theme Settings > Title Toggle and check the appropriate box. Once a post type has the default set to remove, when editing a page you can selectively turn on that page's title.

See [the wiki](https://github.com/billerickson/genesis-title-toggle/wiki) for information on extending the plugin:
- [Use on Posts or Custom Post Types](https://github.com/billerickson/genesis-title-toggle/wiki#use-on-posts-or-custom-post-types)
- [Integrate with Custom Theme](https://github.com/billerickson/Genesis-Title-Toggle/wiki#integrating-with-a-custom-theme)


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

= 1.8.0 =
* Added support for all StudioPress child themes
* Added `be_title_toggle_remove` action for custom theme integration

= 1.7.1 =
* Properly sanitize the metabox key before saving.

= 1.7.0 =
* Added option to make site title an h1 when editing homepage. More information: http://www.billerickson.net/genesis-h1-front-page/

= 1.6.2 =
* Fix issue when you have all titles disabled by default

= 1.6.1 =
* Fix issue with HTML5 themes using post formats

= 1.6 =
* Updated the metabox code to prevent conflicts with other plugins
* General refresh of the code to make it cleaner and easier to read

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
