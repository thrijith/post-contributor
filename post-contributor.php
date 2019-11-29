<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
/*
Plugin Name: Post Contributor
Plugin URI:  http://coffeecupweb.com/post-contributors
Description: Very handy plugin to show author contribution in particular post
Version:     1.1.6
Author:      Abhijit Rakas
Author URI:  http://coffeecupweb.com/post-contributors
License:     GPL2

Post Contributor is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Post Contributor is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Post Contributor. If not, see http://www.gnu.org/licenses/gpl-2.0.html.
*/

define( 'POST_CONTRIBUTOR_ASSETS', plugins_url(  '/', __FILE__ ) . 'built_assets/' );

class ExecutableClass
{

	public function __construct()
	{
		add_shortcode('post-authors',[$this,'add_post_authors']);
		add_shortcode('contributor',[$this,'show_post_authors']);
		spl_autoload_register([$this,'requiredClassLoader']);
		if( is_admin() )
		{
			new PostClass();
			new FetchClass();
			new OptionClass();
		}
	}

	public function add_post_authors($atts)
	{
		$atts = shortcode_atts( array(
			'class' => '',
			'id' => '',
		), $atts );
		$userposts = get_post_meta(get_the_ID(),'contributedUsers');
		$userposts = explode(',',$userposts[0]['postauthors']);
		printf('<ul id="%s">',$atts['id']);
		foreach($userposts as $userpost){
			$userdata = get_userdata($userpost);
			printf('<li class="%s">%s</li>',$atts['class'],$userdata->display_name);
		}
		echo '</ul>';
	}

	public function show_post_authors($atts)
	{
		$atts = shortcode_atts( array(
			'class' => '',
			'id' => '',
		), $atts );
		$userposts = get_post_meta(get_the_ID(),'contributedUsers');
		$userposts = explode(',',$userposts[0]['postauthors']);
		printf('<div id=%s>',$atts['id']);
		foreach($userposts as $userpost){
			$userdata = get_userdata($userpost);
			printf('<div class="%s">%s</div>',$atts['class'],$userdata->display_name);
		}
		echo '</div>';
	}

	/*
	* Load all classes
	*
	*/
	public function requiredClassLoader($class)
	{
		if ( is_readable( plugin_dir_path( dirname( __FILE__ ) ) . 'post-contributor/classes/' . $class . '.php' ) ){
			require_once( plugin_dir_path( dirname( __FILE__ ) ) . 'post-contributor/classes/' . $class . '.php' );
		}
	}
}

new ExecutableClass();
