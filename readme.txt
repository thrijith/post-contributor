=== Plugin Name ===
Contributors: abhijitrakas
Tags: contributors, post, post contributors, contributors post, contributor, post contributor
Requires at least: 3.8
Tested up to: 5.0.3
Stable tag: 1.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin very usefull to show post contributors.

== Description ==
This plugin is show list of post contributor on frontend. At backend there is option to select particular contributor for post. Output in two different format.


== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/post-contributor` directory, or install the plugin through the WordPress plugins screen directly.

2. Activate the plugin through the 'Plugins' screen in WordPress.

3. Use the Settings->Post Contributor screen to configure the plugin.


For list format paste following code in template

`<?php do_shortcode('[post-authors id="authorList" class="authorName"]'); ?>`

Both 'class' and 'id' parameter are optional.


Result in div format

`<?php do_shortcode('[contributor id="authorList" class="authorName"]'); ?>`


== Frequently Asked Questions ==

= Is it work only for three role =
Yes, currently it working only for three user i.e. Administrator, Author and Editor.

== Screenshots ==

1. Post Contributor Setting Page

2. Select where to show contributor option

3. Post Contributor Option

4. Select post contributors

== Changelog ==

= 1.0.1 [February 20, 2019] =

* FIXED

 * Fix PHP Notices on Post Edit Page.

== Upgrade Notice ==
v1.0.1 with fixes for PHP Notice in Post Edit Page.

== Arbitrary section ==

== A brief Markdown Example ==

