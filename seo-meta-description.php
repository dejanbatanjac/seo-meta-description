<?php
/**
 * Plugin Name: SEO Meta Description
 * Plugin URI: http://programming-review.com/seo-meta-description
 * Description: Creates meta descriptions for posts, pages and custom post types.
 * Version: 2.0.0
 * Author: Dejan Batanjac
 * Author URI: https://programming-review.com
 * Text Domain: seo-meta-description
 * Domain Path: languages
 * License: GPL2

 * SEO Meta Description is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * SEO Meta Description is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with SEO Meta Description. If not, see <http://www.gnu.org/licenses/>.
 *
 * TODO: Separate seo-meta-description.php for admin and frontend.
 * TODO: Improve internalization support.
 * TODO: Add the screenshot image for the wordpress.org web site.
 * TODO: Add automated tests woith different Description strings.
 * TODO: Transform echo into pritnf.
 * TODO: Improve the excape functions after internalization.
 * TODO: Add the @doctype support.
 * TODO: Add WordPress version checker.
 * TODO: Add new line character after meta description.
 * TODO: Get meta description from other concurent plugins wordpress-seo, all-in-one-seo-pack.
 * TODO: Move meta description to the top of meta information.
 * NOTE: Moving meta description to the top may have some SEO impact.
 */

define( 'WP_SEO_META_DESCRIPTION_VERSION', '2.0.0' );
define( 'WP_SEO_META_DESCRIPTION_URL', plugin_dir_url( __FILE__ ) );
define( 'WP_SEO_META_DESCRIPTION_PATH', plugin_dir_path( __FILE__ ) );
define( 'WP_SEO_META_DESCRIPTION_BASENAME', plugin_basename( __FILE__ ) );

require WP_SEO_META_DESCRIPTION_PATH . 'layout.php';

if ( class_exists( 'WP_SEO_Meta_Description_Layout' ) ) :
  $layout = new WP_SEO_Meta_Description_Layout();
endif;

if ( isset( $layout ) ) {
  // Initialize the layout.
  $layout->init();
}
