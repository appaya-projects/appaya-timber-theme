<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Site extends TimberSite {
	public $logo;
	public $menus;

	function __construct() {
		parent::__construct();

		$id = get_theme_mod( 'custom_logo' );
		$this->logo = new Timber\Image($id);

		$this->menus = (object) array();

		$menus = get_registered_nav_menus();
		foreach($menus as $location => $desc) {
			$this->menus->$location = new TimberMenu($location);
		}
	}

	public function get_posts() {
		$args = array(
			'post_type' 	=> 'post',
			'orderby'		=> 'meta_value_num',
			'order'			=> 'DESC',
			'posts_per_page' => -1,
		);

		return new Timber\PostQuery($args);
	}
	
	public function image($file_dir) {
		$directory = get_template_directory_uri() .'/assets/images/'. $file_dir;

		return new Timber\Image($directory);
	}


}
?>