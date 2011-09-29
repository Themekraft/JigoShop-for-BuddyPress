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

class BPSHOP_Downloads
{
	/**
	 * Initiate the downloads
	 * 
	 * @since 	1.0
	 * @access 	public
	 */
	public function init()
	{
		add_action( 'additional_downloadable_product_type_options', array( __CLASS__, 'add_time_option'  ) 	  );
		add_action( 'save_post', 									array( __CLASS__, 'save_time_option' ), 1 );
	}
	
	/**
	 * Add the time-based option to product pages
	 * 
	 * @since 	1.0
	 * @access 	private
	 */
	public function add_time_option()
	{
		global $post;
		
		$restriction = get_post_meta( $post->ID, 'time_limit', true );
		?>
		<p class="form-field">
			<label for="time-limit"><?php _e( 'Time Restriction', 'bpshop' ) ?></label>
			<input type="text" class="short" name="time_limit" id="time-limit" value="<?php echo esc_attr( $restriction ) ?>" />
			<span class="description"><?php _e( 'Enter number of months a customer can download a product. Leave blank to disable.', 'bpshop' ) ?></span>
		</p>
		<?php
	}
	
	/**
	 * Save the time-based option
	 * 
	 * @since 	1.0
	 * @access 	private
	 */
	function save_time_option( $post_id )
	{	
		if( isset( $_POST['time_limit'] ) && absint( $_POST['time_limit'] ) > 0 )
			update_post_meta( $post_id, 'time_limit', absint( $_POST['time_limit'] ) );
	}
	
	/**
	 * Get a list of downloadable products
	 * 
	 * Based on jigoshop_customer::get_downloadable_products()
	 * Should really be done via a filter and should probably be its own plugin
	 * 
	 * @since 	1.0
	 * @access 	private
	 * @todo	Pull request for Jigoshop team
	 */
	public function get_downloadable_products()
	{
		global $wpdb;
		
		$downloads = array();
		
		$jigoshop_orders = &new jigoshop_orders();
		$jigoshop_orders->get_customer_orders( get_current_user_id() );
		
		if( $jigoshop_orders->orders ) :
			foreach( $jigoshop_orders->orders as $order ) :
				if( $order->status == 'completed' ) :
				
					$results = $wpdb->get_results( $wpdb->prepare( "
						SELECT *
						FROM {$wpdb->prefix}jigoshop_downloadable_product_permissions
						WHERE order_key = %s
						AND user_id = %d
						", $order->order_key, get_current_user_id() )
					);
					
					$user_info = get_userdata( get_current_user_id() );

					if( $results ) :
						foreach( $results as $result ) :
							$_product = &new jigoshop_product( $result->product_id );
							
							// we check for an existing time limit here and maybe prevent
							// the product from being added to the available products
							if( $time_limit = get_post_meta( $_product->id, 'time_limit', true ) ) :								
								$downloadable_until = strtotime( '+'. $time_limit .' months', strtotime( $order->order_date ) );
								
								if( $downloadable_until < strtotime( 'now' ) )
									continue;
							endif;

							if ($_product->exists) :
								$download_name = $_product->get_title();
							else :
								$download_name = '#' . $result->product_id;
							endif;
							
							$downloads[] = array(
								'download_url' 		  => add_query_arg('download_file', $result->product_id, add_query_arg( 'order', $result->order_key, add_query_arg( 'email', $user_info->user_email, home_url() ) ) ),
								'product_id' 		  => $result->product_id,
								'download_name' 	  => $download_name,
								'order_key' 		  => $result->order_key,
								'downloads_remaining' => $result->downloads_remaining
							);
						endforeach;
					endif;						
				endif;					
			endforeach;				
		endif;			

		return $downloads;
	}
}
BPSHOP_Downloads::init();
?>