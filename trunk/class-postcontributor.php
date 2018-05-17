<?php
/**
 * Main plugin file.
 *
 * @package post-contributor
 */

defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

/*
Plugin Name: Post Contributor
Plugin URI:  http://coffeecupweb.com/post-contributors
Description: Very handy plugin to show author contribution in particular post
Version:     1.0
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

/**
 * Class to bootstarp plugin.
 */
class PostContributor {

	/**
	 * Function to load all required methods on class object created.
	 *
	 * @return void
	 */
	public function __construct() {
		add_shortcode( 'post-authors', [ $this, 'add_post_authors' ] );
		add_shortcode( 'contributor', [ $this, 'show_post_authors' ] );
		spl_autoload_register( [ $this, 'required_class_loader' ] );
		if ( is_admin() ) {
			new PostClass();
			new FetchClass();
			new OptionClass();
		}
	}

	/**
	 * Function to display post authors list.
	 *
	 * @access public
	 * @param  array $atts Attributes list.
	 * @return void
	 */
	public function add_post_authors( $atts ) {
		// get all shorcode attributes.
		$atts = shortcode_atts(
			array(
				'class' => '',
				'id'    => '',
			), $atts
		);
		// get post meta using ID.
		$userposts = get_post_meta( get_the_ID(), 'contributedUsers' );
		$userposts = explode( ',', $userposts[0]['postauthors'] );
		printf( '<ul id="%s">', esc_attr( $atts['id'] ) );
		foreach ( $userposts as $userpost ) {
			$userdata = get_userdata( $userpost );
			printf( '<li class="%s">%s</li>', esc_attr( $atts['class'] ), esc_attr( $userdata->display_name ) );
		}
		echo '</ul>';
	}

	/**
	 * Function to display post authors list.
	 *
	 * @access public
	 * @param  array $atts Attributes list.
	 * @return void
	 */
	public function show_post_authors( $atts ) {
		// get all shorcode attributes.
		$atts = shortcode_atts(
			array(
				'class' => '',
				'id'    => '',
			), $atts
		);
		// get post meta using ID.
		$userposts = get_post_meta( get_the_ID(), 'contributedUsers' );
		$userposts = explode( ',', $userposts[0]['postauthors'] );
		printf( '<div id=%s>', esc_attr( $atts['id'] ) );
		foreach ( $userposts as $userpost ) {
			$userdata = get_userdata( $userpost );
			printf( '<div class="%s">%s</div>', esc_attr( $atts['class'] ), esc_attr( $userdata->display_name ) );
		}
		echo '</div>';
	}

	/**
	 * Load all classes
	 *
	 * @access public
	 * @param  string $class Class name.
	 * @return void
	 */
	public function required_class_loader( $class ) {
		if ( is_readable( plugin_dir_path( dirname( __FILE__ ) ) . 'post-contributor/classes/' . $class . '.php' ) ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'post-contributor/classes/' . $class . '.php';
		}
	}
}

new PostContributor();
