<?php
/**
 * @package		WordPress
 * @subpackage	BuddyPress,Jigoshop
 * @author		Boris Glumpler
 * @copyright	2011, Themekraft
 * @link		https://github.com/Themekraft/BP-Shop-Integration
 * @license		http://www.opensource.org/licenses/gpl-2.0.php GPL License
 */
?>
<h3><?php _e( 'Purchase History', 'bpshop' ); ?></h3>

<?php
jigoshop::show_messages();
	 	
$jigoshop_orders = &new jigoshop_orders();
$jigoshop_orders->get_customer_orders( bp_displayed_user_id(), 5 );
if ($jigoshop_orders->orders) :
?>
<table class="shop_table my_account_orders">
	<thead>
		<tr>
			<th><span class="nobr"><?php _e('#', 'jigoshop'); ?></span></th>
			<th><span class="nobr"><?php _e('Date', 'jigoshop'); ?></span></th>
			<th><span class="nobr"><?php _e('Ship to', 'jigoshop'); ?></span></th>
			<th><span class="nobr"><?php _e('Total', 'jigoshop'); ?></span></th>
			<th colspan="2"><span class="nobr"><?php _e('Status', 'jigoshop'); ?></span></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($jigoshop_orders->orders as $order) : ?>
		<tr class="order">
			<td><?php echo $order->id; ?></td>
			<td><time title="<?php echo date_i18n(get_option('date_format').' '. get_option('time_format'), strtotime($order->order_date)); ?>"><?php echo date_i18n(get_option('date_format').' '.get_option('time_format'), strtotime($order->order_date)); ?></time></td>
			<td><address><?php if ($order->formatted_shipping_address) echo $order->formatted_shipping_address; else echo '&ndash;'; ?></address></td>
			<td><?php echo jigoshop_price($order->order_total); ?></td>
			<td><?php echo $order->status; ?></td>
			<td style="text-align:right; white-space:nowrap;">
				<?php if ($order->status=='pending') : ?>
					<a href="<?php echo $order->get_checkout_payment_url(); ?>" class="button pay"><?php _e('Pay', 'jigoshop'); ?></a>
					<a href="<?php echo $order->get_cancel_order_url(); ?>" class="button cancel"><?php _e('Cancel', 'jigoshop'); ?></a>
				<?php endif; ?>
				<a href="<?php echo add_query_arg('order', $order->id, get_permalink(get_option('jigoshop_view_order_page_id'))); ?>" class="button"><?php _e('View', 'jigoshop'); ?></a>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php else : ?>
	<p><?php _e( 'No recent purchases available.', 'bpshop' ); ?></p>
<?php endif; ?>

<?php if ($downloads = jigoshop_customer::get_downloadable_products()) : ?>
<h3><?php _e('Available downloads', 'jigoshop'); ?></h3>
<ul class="digital-downloads">
	<?php foreach ($downloads as $download) : ?>
		<li><?php if (is_numeric($download['downloads_remaining'])) : ?><span class="count"><?php echo $download['downloads_remaining'] . _n(' download Remaining', ' downloads Remaining', $download['downloads_remaining'], 'jigoshop'); ?></span><?php endif; ?> <a href="<?php echo $download['download_url']; ?>"><?php echo $download['download_name']; ?></a></li>
	<?php endforeach; ?>
</ul>
<?php endif; ?>