<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class FetchClass {

	/*
	*
	* Loading css for backend
	*
	*/
	public function __construct() {
		add_action( 'admin_head', [ $this, 'add_style_in_footer' ] );
	}

	public function add_style_in_footer() {
		?>
		<style>
			.textcenter {
				text-align: center;
			}

			@media (min-width: 781px) {
				.col4 {
					width: 33%;
				}

				.displayflex {
					display: flex;
				}
			}

			@media (max-width: 780px) {
				.col4 {
					width: 100%;
				}

				.displayflex {
					display: block;
				}
			}

			.paddLabel {
				padding: 10px 0px;
			}

			.gapCheck {
				padding: 5px 0px 5px 0px;
			}

			div.checkboxDist {
				text-transform: capitalize;
			}

			div.checkboxDist input {
				margin: 5px;
			}
		</style>
		<?php
	}
}

