<?php
/**
 * Shortcodes
 *
 * @package      Piroll Genesis
 * @since        0.0.1
 * @link         http://rotsenacob.com
 * @author       Rotsen Mark Acob <rotsenacob.com>
 * @copyright    Copyright (c) 2017, Rotsen Mark Acob
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
*/

add_shortcode( 'portfolio', function( $atts, $content = null ) {
    static $instance = 0;
    $instance++;

    $defaults = array(
        'class' => '',
        'numpost' => 12,
        'order' => 'DESC',
        'orderby' => 'date'
    );

    $atts = shortcode_atts( $defaults, $atts, 'portfolio' );

    ob_start();

    $classes = array();

    if ( $atts['class'] ) $classes[] = $atts['class'];
    $classes[] = 'piroll-portfolio';
    $classes[] = 'piroll-portfolio-' . $instance;

    $attrs = array(
        'class' => esc_attr( implode( ' ', $classes ) ),
        'id' => 'piroll-portfolio-' . $instance,
        'data-instance' => $instance,
    );

    $args = array(
        'post_type' => 'portfolio',
        'posts_per_page' => (int) $atts['numpost'],
        'order' => $atts['order'],
        'orderby' => $atts['orderby']
    );

    $loop = new WP_Query( $args );

    if ( $loop->have_posts() ) :
        echo '<div '; foreach( $attrs as $attr => $value ) echo $attr . '="' . $value .'" '; echo '>';
        while ( $loop->have_posts() ) : $loop->the_post();
            echo '<figure '; post_class(); echo '>';
                echo '<img class="portfolio-image" src="'.get_stylesheet_directory_uri() . '/images/spacer.gif' . '" alt="'.get_the_title().'" data-src="'.get_the_post_thumbnail_url( get_the_ID(), 'full' ).'" />';
                echo '<a href="'.get_permalink().'"></a>';
            echo '</figure>';
        endwhile;
        echo '</div>';
        wp_reset_query();
    endif;

    return ob_get_clean();
} );