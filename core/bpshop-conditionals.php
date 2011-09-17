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
 * Conditional to check what page the user is on
 *
 * @since 	1.0
 */
function bpshop_is_page( $page )
{
	if( bp_is_current_component( 'shop' ) && bp_is_current_action( $page ) )
		return true;
	
	return false;
}

/**
 * Conditional to check what page the user is on
 *
 * @since 	1.0
 */
function bpshop_is_subpage( $sub )
{
	if( bp_is_current_component( 'shop' ) && bp_is_action_variable( $sub, 0 ) )
		return true;
	
	return false;
}
?>