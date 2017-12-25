<?php
/**
 * Front Page
 *
 * @package      Piroll Genesis
 * @since        0.0.1
 * @link         http://rotsenacob.com
 * @author       Rotsen Mark Acob <rotsenacob.com>
 * @copyright    Copyright (c) 2017, Rotsen Mark Acob
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
*/

// Remove Markup
add_filter( 'genesis_markup_site-inner', '__return_null' );
add_filter( 'genesis_markup_content-sidebar-wrap_output', '__return_false' );
add_filter( 'genesis_markup_content', '__return_null' );
add_filter( 'genesis_markup_content-sidebar-wrap', '__return_null' );
add_filter( 'genesis_markup_entry', '__return_null' );
add_filter( 'genesis_markup_sidebar-primary', '__return_null' );

//* Remove Loop
remove_action( 'genesis_loop', 'genesis_do_loop' );

//* Home Featured Area
add_action( 'pg_page_header', function() {
    if ( ! is_active_sidebar( 'home-featured' ) ) return;

    genesis_widget_area( 'home-featured', array(
        'before' => '',
        'after' => ''
    ) );
} );

add_action( 'genesis_after_header', function() {
    if ( ! is_active_sidebar( 'portfolio-area' ) ) return;

    genesis_markup( array(
        'open' => '<div %s>',
        'context' => 'portfolio-area'
    ) );

    genesis_widget_area( 'portfolio-area', array(
        'before' => '',
        'after' => ''
    ) );

    genesis_markup( array(
        'close' => '</div>',
        'context' => 'portfolio-area'
    ) );
} );

genesis();