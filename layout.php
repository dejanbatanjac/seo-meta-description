<?php
/**
 * The main class responsible for all.
 */

if ( ! class_exists( 'WP_SEO_Meta_Description_Layout' ) ) :
final class WP_SEO_Meta_Description_Layout {

  function init() {
    // Init actions.
    add_action( 'add_meta_boxes', array( &$this, 'init_menu') );
    add_action( 'wp_head' ,       array( &$this, 'add_meta_description') );
    add_action( 'save_post',      array( &$this, 'save_postdata') );
  }

  /**
   * We create admin area meta boxes.
   */
  function init_menu() {

    // Add meta box to all posts.
    add_meta_box(
        'wp_seo_meta_description_box',
        __( 'Meta Description', 'seo_textdomain' ),
        array( &$this, 'draw_custom_meta_box'),
        'post'
    );

    // Add meta box to all pages.
    add_meta_box(
        'wp_seo_meta_description_box',
        __( 'Meta Description', 'seo_textdomain' ),
        array( &$this, 'draw_custom_meta_box' ),
        'page'
    );

    /**
     * Get list of custom post types that are not page, post, attachment.
     * https://codex.wordpress.org/Function_Reference/get_post_types
     */
    $args = array(
        'public'   => true,
        '_builtin' => false,
    );

    $output = 'names'; // names or objects, note names is the default
    $operator = 'and'; // 'and' or 'or'

    $cpts[] = array();

    $post_types = get_post_types( $args, $output, $operator );

    foreach ( $post_types  as $post_type ) {

        // Add meta box to all custom posts.
        add_meta_box(
            'wp_seo_meta_description_box',
            __( 'Meta Description', 'seo_textdomain' ),
            array( &$this, 'draw_custom_meta_box' ),
            $post_type
        );
    }

  } // End function().


  /**
   * We echo to the page content.
   */
  function add_meta_description() {
    global $post;

    if ( ! empty( $post->post_type ) ) {
      $description = get_post_meta( $post->ID, 'seometadescription', true );
      $description = strip_tags( stripslashes( $description ) );

      // echo only if not empty
      if ( ! empty( $description ) ) {
        echo '<meta name="description" content="' . esc_attr( $description ) . '" />';
      }
    }
  } // End function().


  /**
   * Admin area custom meta box textarea.
   */
  function draw_custom_meta_box() {
    global $post;

    // get the existing meta description
    $meta_box_value = get_post_meta( $post->ID, 'seometadescription', true );

    // The actual fields for data entry
    echo '<label for="seometadescriptoin">';
    _e( 'Meta Description', 'seo-meta-description' );
    echo '</label>';
    echo '<textarea id="seometadescription" style="width: 100%;" name="seometadescription">';
    echo $meta_box_value;
    echo '</textarea>';
    _e( 'only 139 chars visible on Google results', 'seo-meta-description' );

    wp_nonce_field( WP_SEO_META_DESCRIPTION_BASENAME, 'seo_meta_description_box_nonce' );
  }

  /**
   * Returns 0 in error, elese return 1 and updates metadata.
   */
  function save_postdata( $post_id ) {

    // If not admin user, we are not on the right page.
    if ( ! is_admin() ) {
      return 0;
    }

    // Always check nonce as the first step.
    if ( isset( $_POST['seo_meta_description_box_nonce'] )
    && ! wp_verify_nonce( $_POST['seo_meta_description_box_nonce'],
    WP_SEO_META_DESCRIPTION_BASENAME ) ) {
      return 0;
    }

    // Only if user can If this is either post or page (not working with custom post types)
    if ( isset( $_POST )  && isset( $_POST['post_type'] ) ) {

        // Only if we have data.
      if ( isset( $_POST['seometadescription'] ) ) {

        // Tags will be stripped.
        $data = wp_strip_all_tags( $_POST['seometadescription'] );
        // Extra white space will be trimmed to single white space.
        $data = preg_replace( '/\s\s+/', ' ', $data );

        // Post meta update.
        update_post_meta( $post_id, 'seometadescription', $data );
        return 1;
      }
    }
    return 0;
  }// End function().

}// End class{}.
endif;
