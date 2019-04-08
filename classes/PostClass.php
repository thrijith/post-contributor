<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class PostClass {
	/*
	*
	* Load All Hook On Class Object Created
	*
	*/
	public function __construct() {
		add_action( 'add_meta_boxes', [ $this, 'contributor_add_meta_box' ] );
		add_action( 'save_post', [ $this, 'contributor_save_meta_box' ] );
	}

	/**
	 * Adds a box to the main column on the Post and Page edit screens.
	 */
	public function contributor_add_meta_box() {
		if ( get_option( 'all_posts_type' ) ):
			$types = explode( ',', get_option( 'all_posts_type' ) );
			foreach ( $types as $screen ) {
				add_meta_box(
					'contributorID',
					__( 'Post Contributor', 'contributor_textdomain' ),
					[ $this, 'contributor_meta_box_callback' ],
					$screen
				);
			}
		endif;
	}


	/**
	 * Prints the box content.
	 *
	 * @param WP_Post $post The object for the current post/page.
	 */
	public function contributor_meta_box_callback( $post ) {

		// Add a nonce field so we can check for it later.
		wp_nonce_field( 'contributor_save_meta_box', 'contributor_nonce' );

		/*
		 * Use get_post_meta() to retrieve an existing value
		 * from the database and use the value for the form.
		 */

		$allUser = get_post_meta( $post->ID, 'contributedUsers', true );
		if ( ! is_array( $allUser ) ) {
			$allUser = [];
		} else {
			$allUser = explode( ',', $allUser['postauthors'] );
		}

		/*
		*
		* Admin User Fetch Here
		*
		*/
		$adminuser = $this->find_user_list( 'Administrator' );

		echo '<div class="displayflex">';
		echo '<div class="col4"><div class="paddLabel"><label for="contributorArrayAdmin">';
		_e( 'Admin Users', 'contributor_textdomain' );
		echo '</label></div>';
		if ( is_array( $adminuser ) ) {
			foreach ( $adminuser as $admin ) {
				if ( in_array( $admin['id'], $allUser ) ) {
					echo '<div class="gapCheck"><input type="checkbox" checked="checked" id="contributorArrayAdmin" name="contributorArrayAdmin[]" value="' . esc_attr( $admin['id'] ) . '" /> ' . $admin['uname'] . '</div>';
				} else {
					echo '<div class="gapCheck"><input type="checkbox" id="contributorArrayAdmin" name="contributorArrayAdmin[]" value="' . esc_attr( $admin['id'] ) . '" /> ' . $admin['uname'] . '</div>';
				}
			}
		}
		echo '</div>';

		/*
		*
		* Author User Fetch Here
		*
		*/
		$authors = $this->find_user_list( 'Author' );

		echo '<div class="col4"><div class="paddLabel"><label for="contributorArrayAuthor">';
		_e( 'Author Users', 'contributor_textdomain' );
		echo '</label></div>';
		if ( is_array( $authors ) ) {
			foreach ( $authors as $userauthor ) {
				if ( in_array( $userauthor['id'], $allUser ) ) {
					echo '<div class="gapCheck"><input type="checkbox" id="contributorArrayAuthor" checked="checked" name="contributorArrayAuthor[]" value="' . esc_attr( $userauthor['id'] ) . '" /> ' . $userauthor['uname'] . '</div>';
				} else {
					echo '<div class="gapCheck"><input type="checkbox" id="contributorArrayAuthor" name="contributorArrayAuthor[]" value="' . esc_attr( $userauthor['id'] ) . '" /> ' . $userauthor['uname'] . '</div>';
				}
			}
		}
		echo '</div>';

		/*
		*
		* Editor User Fetch Here
		*
		*/
		$editoruser = $this->find_user_list( 'Editor' );
		echo '<div class="col4"><div class="paddLabel"><label for="contributorArrayEditor">';
		_e( 'Editor Users', 'contributor_textdomain' );
		echo '</label></div>';
		if ( is_array( $editoruser ) ) {
			foreach ( $editoruser as $usereditors ) {
				if ( in_array( $usereditors['id'], $allUser ) ) {
					echo '<div class="gapCheck"><input type="checkbox" id="contributorArrayEditor" checked="checked" name="contributorArrayEditor[]" value="' . esc_attr( $usereditors['id'] ) . '"  /> ' . $usereditors['uname'] . '</div>';
				} else {
					echo '<div class="gapCheck"><input type="checkbox" id="contributorArrayEditor" name="contributorArrayEditor[]" value="' . esc_attr( $usereditors['id'] ) . '"  /> ' . $usereditors['uname'] . '</div>';
				}
			}
		}
		echo '</div></div>';
	}

	/**
	 *
	 * Saving our custom data!
	 *
	 */
	public function contributor_save_meta_box( $post_id ) {

		// Check if our nonce is set.
		if ( ! isset( $_POST['contributor_nonce'] ) ) {
			return;
		}

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST['contributor_nonce'], 'contributor_save_meta_box' ) ) {
			return;
		}

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Check the user's permissions.
		if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}

		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}

		// Make sure that it is set.
		if ( ! is_array( $_POST['contributorArrayAdmin'] ) AND ! is_array( $_POST['contributorArrayAuthor'] ) AND ! is_array( $_POST['contributorArrayEditor'] ) ) {
			return;
		}


		/*
		* Field Check For Admin
		*/
		if ( is_array( $_POST['contributorArrayAdmin'] ) ) {
			$selectedUser['postauthors'] = implode( ',', $_POST['contributorArrayAdmin'] );
		}


		/*
		* Field Check For Author
		*/
		if ( is_array( $_POST['contributorArrayAuthor'] ) ) {
			if ( $selectedUser['postauthors'] ) {
				$selectedUser['postauthors'] .= ',' . implode( ',', $_POST['contributorArrayAuthor'] );
			} else {
				$selectedUser['postauthors'] .= implode( ',', $_POST['contributorArrayAuthor'] );
			}
		}

		/*
		* Field Check For Editor
		*/
		if ( ! empty( $_POST['contributorArrayEditor'] ) && is_array( $_POST['contributorArrayEditor'] ) ) {
			if ( $selectedUser['postauthors'] ) {
				$selectedUser['postauthors'] .= ',' . implode( ',', $_POST['contributorArrayEditor'] );
			} else {
				$selectedUser['postauthors'] .= implode( ',', $_POST['contributorArrayEditor'] );
			}
		}

		// Update the meta field in the database.
		update_post_meta( $post_id, 'contributedUsers', $selectedUser );
	}

	/*
	*
	* Load All User Of Particular Role
	*
	*/
	public function find_user_list( $role ) {
		$args       = array( 'role' => $role );
		$user_query = new WP_User_Query( $args );
		// User Loop
		if ( ! empty( $user_query->results ) ) {
			foreach ( $user_query->results as $user ) {
				$users['id']    = $user->ID;
				$users['uname'] = ucfirst( $user->display_name );
				$authrUser[]    = $users;
			}

			return $authrUser;
		}

		return 'No Author User Found!';
	}
}

