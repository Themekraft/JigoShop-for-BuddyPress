<?php
/**
 * @package		WordPress
 * @subpackage	BuddyPress,Jigoshop
 * @author		Boris Glumpler
 * @copyright	2011, Themekraft
 * @link		https://github.com/Themekraft/BP-Shop-Integration
 * @license		http://www.opensource.org/licenses/gpl-2.0.php GPL License
 */

// No direct access is allowed
if( ! defined( 'ABSPATH' ) ) exit;

class BPSHOP_Redirect
{
	/**
	 * Initialize the redirects
	 * 
	 * Attached to the <code>page_link</code> filter hook
	 *
	 * @todo	Collaborate with the Jigoshop team to reduce the many db calls on
	 * 			every page load (bp_get_option/get_blog_option does caching, though)
	 * @since 	1.0
	 * @uses	add_filter()
	 * @uses	is_user_logged_in()
	 */
	public function init()
	{
		if( is_user_logged_in() )
			add_filter( 'page_link', array( __CLASS__, 'router' ), 10, 2 );
	}
	
	/**
	 * Link router function
	 *
	 * @since 	1.0
	 * @uses	bp_get_option()
	 * @uses	is_page()
	 * @uses	bp_loggedin_user_domain()
	 */
	public static function router( $link, $id )
	{
		global $bp;
		
		$cart_page_id 		= bp_get_option( 'jigoshop_cart_page_id' 			);
		$checkout_page_id 	= bp_get_option( 'jigoshop_checkout_page_id' 		);
		$view_page_id 		= bp_get_option( 'jigoshop_view_order_page_id' 		);
		$address_page_id 	= bp_get_option( 'jigoshop_edit_address_page_id' 	);
		$account_page_id 	= bp_get_option( 'jigoshop_myaccount_page_id' 		);
		$password_page_id 	= bp_get_option( 'jigoshop_change_password_page_id' );
		$thanks_page_id 	= bp_get_option( 'jigoshop_thanks_page_id' 			);
		$pay_page_id 		= bp_get_option( 'jigoshop_pay_page_id' 			);
		$track_page_id 		= bpshop_get_tracking_page_id();
				
		switch( $id )
		{
			case $cart_page_id:
				$link = bp_loggedin_user_domain() .'shop/cart/';
				break;
				
			case $checkout_page_id:
				$link = bp_loggedin_user_domain() .'shop/cart/checkout/';
				break;
				
			case $thanks_page_id:
				$link = bp_loggedin_user_domain() .'shop/cart/checkout/thanks/';
				break;
				
			case $pay_page_id:
				$link = bp_loggedin_user_domain() .'shop/cart/checkout/pay/';
				break;

			case $track_page_id:
				$link = bp_loggedin_user_domain() .'shop/track/';
				break;

			case $account_page_id:
				$link = bp_loggedin_user_domain() .'shop/history/';
				break;
				
			case $view_page_id:
				$link = bp_loggedin_user_domain() .'shop/history/view/';
				break;
				
			case $address_page_id:
				$type = ( isset( $_GET['address'] ) ) ? $_GET['address'] : 'billing';
				 
				switch( $type )
				{
					case 'shipping' :
						$ids = bp_get_option( 'bpshop_shipping_address_ids' );
						$url = bp_loggedin_user_domain(). $bp->profile->slug .'/edit/group/'. $ids['group_id'];
						break;
						
					case 'billing' :
						$ids = bp_get_option( 'bpshop_billing_address_ids' );
						$url = bp_loggedin_user_domain(). $bp->profile->slug .'/edit/group/'. $ids['group_id'];
						break;
				}
				break;

			case $password_page_id:
				$link = bp_loggedin_user_domain() . $bp->settings->slug .'/';
				break;
		}

		return $link;
	}
}
BPSHOP_Redirect::init();
?>