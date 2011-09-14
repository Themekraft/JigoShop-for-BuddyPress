<?php
/**
 * @package		WordPress
 * @subpackage	BuddyPress,Jigoshop
 * @author		Boris Glumpler
 * @copyright	2010, ShabuShabu Webdesign
 * @link		http://shabushabu.eu
 * @license		http://www.opensource.org/licenses/gpl-2.0.php GPL License
 */
?>
<div id="item-body" role="main">

	<?php do_action( 'bpshop_before_member_body' ); ?>

	<div class="item-list-tabs no-ajax" id="subnav">
		<ul>
			<?php bp_get_options_nav(); ?>
			<?php do_action( 'bpshop_member_options_nav' ); ?>
		</ul>
	</div><!-- .item-list-tabs -->

	<h3><?php _e( 'Shopping Cart', 'bpshop' ); ?></h3>

	<?php echo do_shortcode( '[jigoshop_cart]' ); ?>

	<?php do_action( 'bpshop_after_member_body' ); ?>

</div><!-- #item-body -->