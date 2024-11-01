<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Sptable
 * @subpackage Sptable/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Sptable
 * @subpackage Sptable/admin
 * @author     Bluegamediversion <bluegamediversion@gmail.com>
 */
class Sptable_Admin {

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

	const CELLS_DATA = array(
		''                => '',
		'add_to_cart_btn' => 'Add to cart',
		'prod_name'       => 'Product Name',
		'prod_thumb'      => 'Thumbnail',
		'prod_price'      => 'Price',
		'prod_qty'        => 'Quantity',
	);

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		$my_current_screen = get_current_screen();
		if ( false !== strpos( $my_current_screen->id, SPTABLE_CPT_PROD_TABLE ) || false !== strpos( $my_current_screen->id, SPTABLE_CPT_PROD_LIST ) ) {
			wp_enqueue_style( $this->plugin_name . 'select2', plugin_dir_url( __FILE__ ) . 'css/select-css/select2.css', array(), $this->version, 'all' );
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/sptable-admin.css', array(), $this->version, 'all' );
		}
	}

	/**
	 * Register the JavaScript for the admin area.
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

		$my_current_screen = get_current_screen();
		if ( false !== strpos( $my_current_screen->id, SPTABLE_CPT_PROD_TABLE ) || false !== strpos( $my_current_screen->id, SPTABLE_CPT_PROD_LIST ) ) {
			wp_enqueue_script( $this->plugin_name . 'select2', plugin_dir_url( __FILE__ ) . 'js/select-js/select2.full.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/sptable-admin.js', array( 'jquery' ), $this->version, false );

			$data = array(
				'sptables_cells_data' => $this::CELLS_DATA,
			);
			wp_localize_script( $this->plugin_name, 'sptable_vars', $data );
		}

	}

	/**
	 * Registers the list custom post type
	 */
	public static function register_cpt_product_list() {

		$labels = array(
			'name'               => __( 'List', 'sptable' ),
			'singular_name'      => __( 'List', 'sptable' ),
			'add_new'            => __( 'New list', 'sptable' ),
			'add_new_item'       => __( 'New list', 'sptable' ),
			'edit_item'          => __( 'Edit list', 'sptable' ),
			'new_item'           => __( 'New list', 'sptable' ),
			'view_item'          => __( 'View list', 'sptable' ),
			'not_found'          => __( 'No product list found', 'sptable' ),
			'not_found_in_trash' => __( 'No list in the trash', 'sptable' ),
			'menu_name'          => __( 'Lists', 'sptable' ),
		);

		$args = array(
			'labels'              => $labels,
			'hierarchical'        => false,
			'description'         => 'Lists',
			'supports'            => array( 'title' ),
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => false,
			'show_in_nav_menus'   => false,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'has_archive'         => false,
			'query_var'           => false,
			'can_export'          => true,
		);

		register_post_type( SPTABLE_CPT_PROD_LIST, $args );
	}
	/**
	 * Registers the list custom post type
	 */
	public static function register_cpt_product_table() {
		$labels = array(
			'name'                  => _x( 'Simple Product Table', 'Post Type General Name', 'sptable' ),
			'singular_name'         => _x( 'Simple Product Table', 'Post Type Singular Name', 'sptable' ),
			'menu_name'             => __( 'Simple Product Table', 'sptable' ),
			'name_admin_bar'        => __( 'Simple Product Table', 'sptable' ),
			'archives'              => __( 'Our', 'sptable' ),
			'attributes'            => __( 'Attributes', 'sptable' ),
			'parent_item_colon'     => __( 'Parent :', 'sptable' ),
			'all_items'             => __( 'Product Tables', 'sptable' ),
			'add_new_item'          => __( 'Add New Table', 'sptable' ),
			'add_new'               => __( 'Add New', 'sptable' ),
			'new_item'              => __( 'New', 'sptable' ),
			'edit_item'             => __( 'Edit', 'sptable' ),
			'update_item'           => __( 'Update', 'sptable' ),
			'view_item'             => __( 'View ', 'sptable' ),
			'view_items'            => __( 'View', 'sptable' ),
			'search_items'          => __( 'Search', 'sptable' ),
			'not_found'             => __( 'Not found', 'sptable' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'sptable' ),
			'featured_image'        => __( ' Sketch', 'sptable' ),
			'set_featured_image'    => __( 'Set sketch', 'sptable' ),
			'remove_featured_image' => __( 'Remove sketch', 'sptable' ),
			'use_featured_image'    => __( 'Use as sketch', 'sptable' ),
			'insert_into_item'      => __( 'Insert into sheet', 'sptable' ),
			'uploaded_to_this_item' => __( 'Uploaded to this sheet', 'sptable' ),
			'items_list'            => __( 'list', 'sptable' ),
			'items_list_navigation' => __( 'list navigation', 'sptable' ),
			'filter_items_list'     => __( 'Filter  list', 'sptable' ),
		);

		$args = array(
			'label'                 => __( 'Simple Product Table', 'sptable' ),
			'description'           => __( 'Create product table', 'sptable' ),
			'labels'                => $labels,
			'supports'              => array( 'title' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'menu_icon'             => 'dashicons-editor-table',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'post',
			'show_in_rest'          => true,
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		);

		register_post_type( SPTABLE_CPT_PROD_TABLE, $args );
	}

	/**
	 * Create menu and submenus
	 */
	public static function add_sptable_menu() {
		$parent_slug = 'edit.php?post_type=' . SPTABLE_CPT_PROD_TABLE;
		add_submenu_page( $parent_slug, __( 'Products Lists', 'sptable' ), __( 'Products Lists', 'sptable' ), 'manage_product_terms', 'edit.php?post_type=' . SPTABLE_CPT_PROD_LIST, false );
	}

	/**
	 * Add meta box to configuration ctp with options page.
	 *
	 * @return void
	 */
	public function get_main_options_metabox() {
		$screen = array( SPTABLE_CPT_PROD_TABLE );
		add_meta_box(
			'sptable-options-box',
			__( 'Product Table Configuration', 'sptable' ),
			array( $this, 'get_sptable_columns_metabox' ),
			$screen
		);
		$screen_product_list = array( SPTABLE_CPT_PROD_LIST );
		add_meta_box(
			'sptable-product-list-option',
			__( 'Product List', 'sptable' ),
			array( $this, 'get_sptable_new_product_list_metabox' ),
			$screen_product_list
		);
	}
	public function get_sptable_columns_metabox() {
		$post_id                   = get_the_ID();
		$current_meta_table_config = is_array( get_post_meta( $post_id, SPTABLE_TABLE_CONFIG, true ) ) ? get_post_meta( $post_id, SPTABLE_TABLE_CONFIG, true ) : array();

		$args               = array(
			'post_type' => array( SPTABLE_CPT_PROD_LIST ),
			'nopaging'  => true,
		);
		$product_lists      = get_posts( $args );
		$product_lists      = is_array( $product_lists ) ? $product_lists : array();
		$prod_list_selected = isset( $current_meta_table_config['prod_list'] ) ? $current_meta_table_config['prod_list'] : null;
		if ( isset( $current_meta_table_config['prod_list'] ) ) {
			$prod_list_selected = $current_meta_table_config['prod_list'];
		}
		?>
		<form method="POST" >
			<div>
				<tr>
					<td>
						<label>
							<strong><?php echo esc_attr__( 'Shortcode : ', 'sptable' ); ?></strong>
						</label>
					</td>
					<td>
						<label>
							<?php echo wp_kses_post( '[sptable id="' . $post_id . '"] ', 'sptable' ); ?><br />
						</label>
					</td>
				</tr>
				<tr>
					<td>
						<label>
							<?php echo esc_attr__( 'Choose product list : ' ); ?>
						</label>
					</td>
					<td>
						<select name="spt_table_config[prod_list]" require>
							<?php
							foreach ( $product_lists as $prod_list ) :
								$prod_list_id = $prod_list->ID;
								?>
								<option value="<?php echo esc_attr( $prod_list_id ); ?>" <?php echo ( (string) $prod_list_id === $prod_list_selected ) ? 'selected' : ''; ?>>
								<?php echo esc_attr( $prod_list->post_title ); ?>
								</option>
							<?php endforeach; ?>
						</select>
					</td>
				</tr>
			</div>
			<table id="stptable-form-table">
				<thead>
					<tr>
						<th>
							<input type="checkbox" class="spt_table_all_ckbx"/>
						</th>
						<th>
							<strong>
								<?php esc_html_e( 'columns', 'sptable' ); ?>
							</strong>
						</th>
						<th>
							<strong>
								<?php esc_html_e( 'heading', 'sptable' ); ?>
							</strong>
						</th>
						<th>
							<strong>
								<?php esc_html_e( 'cells', 'sptable' ); ?>
							</strong>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$current_meta_table_config['table_data'] = ( isset( $current_meta_table_config['table_data'] ) && is_array( $current_meta_table_config['table_data'] ) ) ? $current_meta_table_config['table_data'] : array();
					foreach ( $current_meta_table_config['table_data'] as $key => $conf ) {
						$cells_datas = $conf['cells'];
						?>
							<tr data-key="<?php echo esc_attr( $key ); ?>">
								<td><input type="checkbox" class="spt_table_record" name="check1"/></td>
								<td><input type="text" class="td_full_input" name="spt_table_config[table_data][<?php echo esc_attr( $key ); ?>][columns]" value="<?php echo esc_attr( $conf['columns'] ); ?>" /></td>
								<td><input type="text" class="td_full_input"  name="spt_table_config[table_data][<?php echo esc_attr( $key ); ?>][heading]" value="<?php echo esc_attr( $conf['heading'] ); ?>" /></td>
								<td>
									<select class="td_full_input" name="spt_table_config[table_data][<?php echo esc_attr( $key ); ?>][cells]" required>
									<?php foreach ( $this::CELLS_DATA as $cell_key => $cell_val ) : ?>
											<option value="<?php echo esc_attr( $cell_key ); ?>" <?php echo ( $cell_key === $cells_datas ) ? 'selected' : ''; ?>>
												<?php echo esc_attr( $cell_val ); ?>
											</option>
										<?php endforeach; ?>
									</select>
								</td>
							</tr>
							<?php
					}
					?>
				</tbody>
			</table>
		</form>
		<div style="margin-top: 2%;">
			<button type="button" class="sptable_button sptable_btn_delete delete-row"><?php esc_attr_e( 'Delete Row', 'sptable' ); ?></button>
			<button type="button" class="sptable_button sptable_btn_add add-row"><?php esc_attr_e( 'Add Row', 'sptable' ); ?></button>
		</div>
		<input type="hidden" name="securite_nonce" value="<?php echo esc_html( wp_create_nonce( 'securite-nonce-sptable' ) ); ?>"/>
		<?php
	}

	public function get_sptable_new_product_list_metabox() {
		$args     = array(
			'post_type' => array( 'product', 'product_variation' ),
			'nopaging'  => true,
		);
		$products = get_posts( $args );

		$post_id           = get_the_ID();
		$prod_ids_for_list = is_array( get_post_meta( $post_id, 'sptable_prod_list', true ) ) ? get_post_meta( $post_id, 'sptable_prod_list', true ) : array();
		?>
		<form method="POST" >
			<table>
				<tr>
					<td><label><?php esc_attr_e( 'Product List', 'sptable' ); ?></label></td>
					<td>
						<select multiple id="sptable_select_prod_list" name="sptable_prod_list[]" required>
							<?php
							foreach ( $products as $prod ) :
								$prod_id = $prod->ID;
								?>
								<option value="<?php echo esc_attr( $prod_id ); ?>" <?php echo ( in_array( (string) $prod_id, $prod_ids_for_list, true ) ) ? 'selected' : ''; ?>>
									<?php echo esc_attr( $prod->post_title ); ?>
								</option>
							<?php endforeach; ?>
						</select>
					</td>
				</tr>
			</table>
		</form>
		<input type="hidden" name="securite_nonce" value="<?php echo esc_html( wp_create_nonce( 'securite-nonce-product-list-sptable' ) ); ?>"/>
		<?php
	}

	public function save_table_config_cpt( $post_id, $post, $update ) {
		if ( isset( $_POST['securite_nonce'] ) && wp_verify_nonce( sanitize_key( $_POST['securite_nonce'] ), 'securite-nonce-sptable' ) ) {
			$to_save = isset( $_POST[ SPTABLE_TABLE_CONFIG ] ) ? sptable_sanitize_text_field_array_of_array( wp_unslash( $_POST[ SPTABLE_TABLE_CONFIG ] ) ) : array();
			update_post_meta( $post_id, SPTABLE_TABLE_CONFIG, $to_save );
		}
	}

	public function save_product_list_cpt( $post_id ) {
		if ( isset( $_POST['securite_nonce'] ) && wp_verify_nonce( sanitize_key( $_POST['securite_nonce'] ), 'securite-nonce-product-list-sptable' ) ) {
			$to_save = isset( $_POST['sptable_prod_list'] ) ? sptable_sanitize_text_field_array_of_array( wp_unslash( $_POST['sptable_prod_list'] ) ) : array();
			update_post_meta( $post_id, 'sptable_prod_list', $to_save );
		}
	}
}
