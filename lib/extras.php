<?php
/**
 * Extras
 *
 * @package      Piroll Genesis
 * @since        0.0.1
 * @link         http://rotsenacob.com
 * @author       Rotsen Mark Acob <rotsenacob.com>
 * @copyright    Copyright (c) 2017, Rotsen Mark Acob
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
*/

add_filter( 'wp_nav_menu', function( $html, $args ) {
    if ( 'primary' !== $args->theme_location ) return $html;

    $output = apply_filters( 'pg_nav_brand', pg_nav_brand_markup() );
    $output .= $html;

    return $output;
}, 10, 2 );

function pg_nav_brand_markup() {
    $output = '<a class="logo" title="'.esc_attr( get_bloginfo( 'description' ) ).'" href="'.esc_url( home_url( '/' ) ).'">'.get_bloginfo( 'name' ).'</a>';

	return $output;
}