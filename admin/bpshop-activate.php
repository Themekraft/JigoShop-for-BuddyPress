<?php
/**
 * @package		WordPress
 * @subpackage	BuddyPress,Jigoshop
 * @author		Boris Glumpler
 * @copyright	2010, ShabuShabu Webdesign
 * @link		http://shabushabu.eu
 * @license		http://www.opensource.org/licenses/gpl-2.0.php GPL License
 */

// No direct access is allowed
if( ! defined( 'ABSPATH' ) ) exit;

/**
 * Activation routine
 * 
 * Remove all created Jigoshop pages as these will be moved into
 * a members profile area. Trashes all pages, but does not delete them
 *
 * @todo	Keep an eye on an option for the order-tracking page
 * 			to use instead of querying directly
 * @since 	1.0
 */
function bpshop_activate()
{
	global $wpdb;
	
	$ids['cart_id']		= get_option( 'jigoshop_cart_page_id' );
	$ids['checkout_id'] = get_option( 'jigoshop_checkout_page_id' );
	$ids['account_id']	= get_option( 'jigoshop_myaccount_page_id' );
	$ids['track_id'] 	= $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM {$wpdb->posts} WHERE post_name = 'order-tracking' LIMIT 1" ) );
	$ids['address_id']	= get_option( 'jigoshop_edit_address_page_id' );
	$ids['order_id']	= get_option( 'jigoshop_view_order_page_id' );
	$ids['password_id']	= get_option( 'jigoshop_change_password_page_id' );
	$ids['pay_id']		= get_option( 'jigoshop_pay_page_id' );
	$ids['thanks']		= get_option('jigoshop_thanks_page_id' );
	
	foreach( $ids as $post_id )
		wp_delete_post( $post_id );
}
?>