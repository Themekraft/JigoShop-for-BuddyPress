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
 * Screen function to display the shopping cart
 *
 * @since 	1.0
 */
function bpshop_screen_shopping_cart()
{
	bp_core_load_template( apply_filters( 'bpshop_template_member_home', 'shop/member/home' ) );
}

/**
 * Screen function to display the checkout page
 *
 * @since 	1.0
 */
function bpshop_screen_checkout()
{
	bp_core_load_template( apply_filters( 'bpshop_template_member_checkout', 'shop/member/home' ) );
}

/**
 * Screen function to display the purchase history
 *
 * @since 	1.0
 */
function bpshop_screen_history()
{
	bp_core_load_template( apply_filters( 'bpshop_template_member_history', 'shop/member/home' ) );
}

/**
 * Screen function for tracking an order
 *
 * @since 	1.0
 */
function bpshop_screen_track_order()
{
	bp_core_load_template( apply_filters( 'bpshop_template_member_track_order', 'shop/member/home' ) );
}
?>