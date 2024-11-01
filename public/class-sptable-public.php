<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Sptable
 * @subpackage Sptable/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Sptable
 * @subpackage Sptable/public
 * @author     Bluegamediversion <bluegamediversion@gmail.com>
 */
class Sptable_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Sptable_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sptable_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/sptable-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name . '-dataTables-min', plugin_dir_url( __FILE__ ) . 'css/datatables.min.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Sptable_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sptable_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name . '-datatables-min', plugin_dir_url( __FILE__ ) . 'js/datatables.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/sptable-public.js', array( 'jquery' ), $this->version, false );

		$data = array(
			'sptables_ajaxurl' => admin_url( 'admin-ajax.php' ),
		);
		wp_localize_script( $this->plugin_name, 'sptable_public_vars', $data );

	}
	public static function register_shortcodes() {
		if ( ! is_admin() ) {
			add_shortcode( 'sptable', array( 'Sptable_Public', 'get_product_datatable' ) );
		}
	}

	public static function get_product_datatable( $atts ) {
		$atts_array             = shortcode_atts(
			array(
				'id' => null,
			),
			$atts
		);
		$sptable_config_post_id = $atts_array['id'];
		if ( ! $sptable_config_post_id ) {
			return;
		}
		$table_to_display_cpt_configs = is_array( get_post_meta( $sptable_config_post_id, SPTABLE_TABLE_CONFIG, true ) ) ? get_post_meta( 939, SPTABLE_TABLE_CONFIG, true ) : array();
		if ( ! isset( $table_to_display_cpt_configs['table_data'] ) ) {
			return;
		}
		if ( isset( $table_to_display_cpt_configs['prod_list'] ) ) {
			$prod_list_id = $table_to_display_cpt_configs['prod_list'];
		}
		$products_ids                               = is_array( get_post_meta( $prod_list_id, 'sptable_prod_list', true ) ) ? get_post_meta( $prod_list_id, 'sptable_prod_list', true ) : array();
		$table_to_display_cpt_configs['table_data'] = is_array( $table_to_display_cpt_configs['table_data'] ) ? $table_to_display_cpt_configs['table_data'] : array();
		?>
		<div class="row">
			<table id="sptable_datatable" cellspacing="5">
				<thead>
					<tr>
						<?php foreach ( $table_to_display_cpt_configs['table_data'] as $key => $config ) : ?>
							<th><?php echo esc_attr( $config['heading'] ); ?></th>
						<?php endforeach; ?>
					</tr>
				</thead>
				<tbody>
						<?php
						foreach ( $products_ids as $key => $prod_id ) {
							$product = wc_get_product( $prod_id );

							if ( $product && $product->exists() ) {
								$product_permalink = $product->is_visible() ? $product->get_permalink() : '';
								?>
								<tr >
									<?php foreach ( $table_to_display_cpt_configs['table_data'] as $key => $config ) : ?>
										<?php if ( 'prod_name' === $config['cells'] ) : ?>
											<td class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
												<?php
												if ( ! $product_permalink ) {
													echo wp_kses_post( $product->get_name() );
												} else {
													echo wp_kses_post( sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $product->get_name() ) );
												}
												?>
											</td>
										<?php elseif ( 'add_to_cart_btn' === $config['cells'] ) : ?>
											<td>
												<a href="?add-to-cart=<?php echo esc_attr( $prod_id ); ?>" data-quantity = "1"
													class="button sptable-add-to-cart sptable-add-to-cart-<?php echo esc_attr( $prod_id ); ?>"
													data-product_id="<?php echo esc_attr( $prod_id ); ?>"> <?php esc_html_e( 'Add to cart', 'woocommerce' ); ?>
												</a>
											</td>
										<?php elseif ( 'prod_thumb' === $config['cells'] ) : ?>
											<td class="product-thumbnail">
												<?php

												$thumbnail = $product->get_image();

												if ( ! $product_permalink ) {
													echo $thumbnail; // phpcs:ignore Standard.Category.SniffName.ErrorCode.
												} else {
													printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // phpcs:ignore Standard.Category.SniffName.ErrorCode.
												}
												?>
											</td>
										<?php elseif ( 'prod_price' === $config['cells'] ) : ?>
											<td class="product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
												<?php
													echo esc_attr( $product->get_price() );
												?>
											</td>
										<?php elseif ( 'prod_qty' === $config['cells'] ) : ?>
											<td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
												<?php
												if ( $product->is_sold_individually() ) {
													$product_quantity = sprintf( '1 <input type="hidden" class="sptable_quantity" name="sptable-quantity" value="1" />' );
												} else {
													$product_quantity = woocommerce_quantity_input(
														array(
															'input_name'   => 'sptable-quantity',
															'classes'   => 'sptable_quantity',
															'placeholder'   => $prod_id,
														),
														$product
													);
												}
												echo esc_attr( $product_quantity );
												?>
											</td>
										<?php endif; ?>
									<?php endforeach; ?>
								</tr>
								<?php
							}
						}
						?>
					</tr>
				</tbody>
			</table>
		</div>
		<?php
	}

	public static function add_product_to_cart() {
		$product_id  = filter_input( INPUT_POST, 'product_id' );
		$product_qty = filter_input( INPUT_POST, 'product_qty' );
		WC()->cart->add_to_cart( $product_id, $product_qty );
	}
}
