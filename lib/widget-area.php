<?php
/**
 * Widget Areas
 *
 * @package      Piroll Genesis
 * @since        0.0.1
 * @link         http://rotsenacob.com
 * @author       Rotsen Mark Acob <rotsenacob.com>
 * @copyright    Copyright (c) 2017, Rotsen Mark Acob
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
*/

add_action( 'init', function() {
    $sidebars = array(
        'home-featured' => __( 'Home Featured Area', 'piroll-genesis' ),
        'portfolio-area' => __( 'Portfolio Area', 'piroll-genesis' )
    );

    if ( is_array( $sidebars ) || ! is_wp_error( $sidebars ) ) {
        foreach( $sidebars as $key => $value ) {
            genesis_register_sidebar( array(
                'id' => $key,
                'name' => $value
            ) );
        }
    }
} );
