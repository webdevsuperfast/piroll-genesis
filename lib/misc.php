<?php
/**
 * Misc
 *
 * @package      Piroll Genesis
 * @since        0.0.1
 * @link         http://rotsenacob.com
 * @author       Rotsen Mark Acob <rotsenacob.com>
 * @copyright    Copyright (c) 2017, Rotsen Mark Acob
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
*/

// Custom Image Function
function pg_post_image() {
	global $post;
	$image = '';
	$image_id = get_post_thumbnail_id( $post->ID );
	$image = wp_get_attachment_image_src( $image_id, 'full' );
	$image = $image[0];
	if ( $image ) return $image;
	return pg_get_first_image();
}

// Get the First Image Attachment Function
function pg_get_first_image() {
	global $post, $posts;
	$first_img = '';
	ob_start();
	ob_end_clean();
	$output = preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches );
	$first_img = "";
	if ( isset( $matches[1][0] ) )
		$first_img = $matches[1][0];
	return $first_img;
}

//* This will occur when the comment is posted
function pg_comment_post( $incoming_comment ) {
    // convert everything in a comment to display literally
    $incoming_comment['comment_content'] = htmlspecialchars($incoming_comment['comment_content']);
    // the one exception is single quotes, which cannot be #039; because WordPress marks it as spam
    $incoming_comment['comment_content'] = str_replace( "'", '&apos;', $incoming_comment['comment_content'] );
    return( $incoming_comment );
}

//* This will occur before a comment is displayed
function pg_comment_display( $comment_to_display ) {
    // Put the single quotes back in
    $comment_to_display = str_replace( '&apos;', "'", $comment_to_display );
    return $comment_to_display;
}

//* Remove query string from static files
function pg_remove_cssjs_ver( $src ) {
    if( strpos( $src, '?ver=' ) )
    $src = remove_query_arg( 'ver', $src );
    return $src;
}

//* Remove default genesis header
remove_action( 'genesis_header', 'genesis_do_header' );

//* Move primary navigation inside header
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav' );

//* Page Header
add_action( 'genesis_header', 'pg_page_header' );
function pg_page_header() {
	do_action( 'pg_page_header' );
}

add_action( 'pg_page_header', 'pg_page_header_markup_open', 5 );
function pg_page_header_markup_open() {
	genesis_markup( array(
		'open' => '<div %s>',
		'context' => 'page-header'
	) );

	genesis_structural_wrap( 'page-header' );
}

add_action( 'pg_page_header', 'pg_page_header_markup_close', 15 );
function pg_page_header_markup_close() {
	genesis_structural_wrap( 'page-header', 'close' );
	genesis_markup( array(
		'close' => '</div>',
		'context' => 'page-header'
	) );
}

//* Dynamic Image Resizing
// @link https://gist.github.com/alpipego/7a60db952c4c4144c0f5d5c15fd86194#file-dynamic-img-loading-php
add_action( 'wp_ajax_resize_my_image', 'resizeImage' );
add_action( 'wp_ajax_nopriv_resize_my_image', 'resizeImage' );
function resizeImage() {
    // explicit declaration of variables
    $width = (int) $_GET['width'];
    $height = (int) $_GET['height'];
    $url = esc_url($_GET['source']);
    
    // call the resize script
    $img = aq_resize($url, $width, $height);
    
    // echo the response
    echo json_encode(['src' => $img]);
    wp_die();
}