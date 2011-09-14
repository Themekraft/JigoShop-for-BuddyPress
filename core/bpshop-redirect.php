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

class BPSHOP_Redirect
{
	/**
	 * Initialize the redirects
	 *
	 * @since 	1.0
	 */
	public function init()
	{
		add_action( 'wp', array( __CLASS__, 'cart_url' 		), 0 );
		add_action( 'wp', array( __CLASS__, 'checkout_url' 	), 0 );
		add_action( 'wp', array( __CLASS__, 'remove_url' 	), 0 );
		add_action( 'wp', array( __CLASS__, 'track_order' 	), 0 );
	}
	
	/**
	 * Redirect to the profile cart
	 *
	 * @since 	1.0
	 */
	public function cart_url()
	{		
		$cart_page_id = get_option( 'jigoshop_cart_page_id' );
		
		if( is_page( $cart_page_id ) )
		{
			bp_core_redirect( bp_loggedin_user_domain() .'shop/cart/' );
		}
	}
	
	/**
	 * Redirect to the profile checkout page
	 *
	 * @since 	1.0
	 */
	public function checkout_url()
	{
		$checkout_page_id = get_option( 'jigoshop_checkout_page_id' );
		
		if( is_page( $checkout_page_id ) )
		{
			bp_core_redirect( bp_loggedin_user_domain() .'shop/checkout/' );
		}
	}
	
	/**
	 * Redirect to the profile cart to remove item
	 *
	 * @since 	1.0
	 */
	public function remove_url()
	{
		$cart_page_id = get_option( 'jigoshop_cart_page_id' );
		
		if( is_page( $cart_page_id ) && isset( $_GET['remove_item'] ) )
		{
			bp_core_redirect( bp_loggedin_user_domain() .'shop/cart/?remove_item='. $_GET['remove_item'] );
		}
	}

	/**
	 * Redirect to the profile track order page
	 *
	 * @todo	Direct DB querying not really save, as the pagename (order-tracking)
	 * 			might change
	 * @since 	1.0
	 */
	public function track_order()
	{
		global $wpdb;
		
		$track_page_id = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM {$wpdb->posts} WHERE post_name = 'order-tracking' LIMIT 1" ) );
		
		if( is_page( $track_page_id ) )
		{
			bp_core_redirect( bp_loggedin_user_domain() .'shop/track/' );
		}
	}
}
BPSHOP_Redirect::init();
?>