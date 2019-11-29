=== Plugin Name ===
Contributors: abhijitrakas
Tags: contributors, post, post contributors, contributors post, contributor, post contributor
Requires at least: 3.8
Tested up to: 5.1.1
Stable tag: 1.1.6
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
= 1.1.4 [September 23, 2019] =

= 1.1.3 [September 23, 2019] =

= 1.1.2 [April 9, 2019] =

= 1.1.1 [April 8, 2019] =

= 1.1.0 [April 8, 2019] =

= 1.0.9 [April 1, 2019] =

= 1.0.8 [March 19, 2019] =

= 1.0.7 [March 18, 2019] =

= 1.0.6 [March 18, 2019] =

= 1.0.5 [March 18, 2019] =
* Update return message

= 1.0.4 [March 06, 2019] =
* Updated

= 1.0.3 [March 05, 2019] =
* Updated

 * Style of plugin settings.

= 1.0.1 [February 20, 2019] =

* FIXED

 * Fix PHP Notices on Post Edit Page.

== Upgrade Notice ==
v1.1.4 with message changes.

== Arbitrary section ==

== A brief Markdown Example ==

