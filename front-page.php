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