<?php
require_once('inc/wp_bootstrap_navwalker.php');
require_once('inc/template_functions.php');
require_once('inc/widgets.php');
class tailored_theme_class {
    public $option_name = 'theme_options';
	
    public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        add_action( 'init', array( $this, 'register_image_sizes' ) );
        add_action( 'init', array( $this, 'register_sidebars' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
        add_action( 'init', array( $this, 'register_menus' ) );
		add_action( 'admin_menu', array($this, 'admin_menu') );
		add_action( 'admin_post_tailored_theme_options_save', array($this, 'tailored_theme_options_save') );
		add_action( 'add_meta_boxes', array( $this, 'products_meta_box' ) );
		add_action( 'save_post', array( $this, 'save_products_meta' ), 10, 3 ) ;
		
		add_action( 'widgets_init', array( $this, 'register_widgets' ) );
		if ( ! isset( $content_width ) ) $content_width = 1070;
		
        add_theme_support( 'post-thumbnails' );
		add_theme_support( 'title-tag' );
		
		add_filter('post_link', array( $this, 'category_permalink' ), 1, 3);
		add_filter('post_type_link', array( $this, 'category_permalink' ), 1, 3);
		
		$this->option = get_option($this->option_name);
    }
	
	public function get_option() {
        return $this->option;
    }
	
    public function enqueue_scripts(){
		
		wp_enqueue_style( 'bootstrap', get_stylesheet_directory_uri() . '/css/bootstrap.min.css', '1.0');
		wp_enqueue_style( 'fontawesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css', '1.0');
		wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Open+Sans:400,300,700,400italic', '1.0');
		wp_enqueue_style( 'theme-style', get_stylesheet_uri(), array( 'bootstrap', 'fontawesome', 'google-fonts' ) );
		//wp_enqueue_style( 'animate', get_stylesheet_directory_uri() . '/css/animate.css', array() );
		
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'bootstrap-js', get_stylesheet_directory_uri() . '/js/bootstrap.js', array( 'jquery'), '1.0', true );
		wp_enqueue_script( 'matchHeight-js', get_stylesheet_directory_uri() . '/js/jquery.matchHeight-min.js', array( 'jquery' ), '1.0', true );
		wp_enqueue_script( 'custom-js', get_stylesheet_directory_uri() . '/js/front-end.js', array( 'jquery', 'bootstrap-js' ), '1.0', true );
		
	}
    
    public function register_image_sizes() {
        add_image_size( 'home-slide', 600, 350, false ); 
        add_image_size( 'custom-medium', 451, 347, true ); 
        add_image_size( 'custom-small', 65, 65, true ); 
        add_image_size( 'footer-image', 230, 160, true ); 
		add_image_size( 'blog-home-lg', 455, 228, true ); 
    }
    	
    public function register_menus() {
        register_nav_menus( array(
            'primary' => __( 'Primary Menu', 'sosen' ),
        ) );
		
		register_nav_menus( array(
            'social' => __( 'Social Menu', 'sosen' ),
        ) );
				
    }
    
	public function register_widgets (){
		//register_widget( 'tim_recent_posts' );
		//register_widget( 'tim_cats' );
	}
	
    public function register_sidebars() {
		
		register_sidebar( array(
			'name' => __( 'Contact Sidebar', 'seowned' ),
			'id' => 'contact_sidebar',
			'before_widget' => '<div class="panel panel-default"><div class="panel-body">',
			'after_widget' => "</div></div>",
			'before_title' => '<h3>',
			'after_title' => '</h3>',
		) );
		
		register_sidebar( array(
			'name' => __( 'Blog Sidebar', 'seowned' ),
			'id' => 'blog_sidebar',
			'before_widget' => '<div class="panel panel-default">',
			'after_widget' => "</div>",
			'before_title' => '<div class="panel-heading"><h3 class="panel-title">',
			'after_title' => '</h3></div>',
		) );
        
	}	
	
	public function register_post_types() {
		$slideslabels = array(
			'name'               => _x( 'Slides', 'post type general name', 'your-plugin-textdomain' ),
			'singular_name'      => _x( 'Slide', 'post type singular name', 'your-plugin-textdomain' ),
			'menu_name'          => _x( 'Slides', 'admin menu', 'your-plugin-textdomain' ),
			'name_admin_bar'     => _x( 'Slide', 'add new on admin bar', 'your-plugin-textdomain' ),
			'add_new'            => _x( 'Add New', 'slides', 'your-plugin-textdomain' ),
			'add_new_item'       => __( 'Add New Slide', 'your-plugin-textdomain' ),
			'new_item'           => __( 'New Slide', 'your-plugin-textdomain' ),
			'edit_item'          => __( 'Edit Slide', 'your-plugin-textdomain' ),
			'view_item'          => __( 'View Slide', 'your-plugin-textdomain' ),
			'all_items'          => __( 'All Slides', 'your-plugin-textdomain' ),
			'search_items'       => __( 'Search Slides', 'your-plugin-textdomain' ),
			'parent_item_colon'  => __( 'Parent Slides:', 'your-plugin-textdomain' ),
			'not_found'          => __( 'No slides found.', 'your-plugin-textdomain' ),
			'not_found_in_trash' => __( 'No slides found in Trash.', 'your-plugin-textdomain' )
		);
	
		$slidesargs = array(
			'labels'             => $slideslabels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => false,
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'supports'           => array( 'title', 'editor', 'thumbnail' )
		);
		
		$productimagelabels = array(
			'name'               => _x( 'Footer Images', 'post type general name', 'your-plugin-textdomain' ),
			'singular_name'      => _x( 'Footer Image', 'post type singular name', 'your-plugin-textdomain' ),
			'menu_name'          => _x( 'Footer Images', 'admin menu', 'your-plugin-textdomain' ),
			'name_admin_bar'     => _x( 'Footer Image', 'add new on admin bar', 'your-plugin-textdomain' ),
			'add_new'            => _x( 'Add New', 'slides', 'your-plugin-textdomain' ),
			'add_new_item'       => __( 'Add New Footer Image', 'your-plugin-textdomain' ),
			'new_item'           => __( 'New Footer Image', 'your-plugin-textdomain' ),
			'edit_item'          => __( 'Edit Footer Image', 'your-plugin-textdomain' ),
			'view_item'          => __( 'View Footer Image', 'your-plugin-textdomain' ),
			'all_items'          => __( 'All Footer Images', 'your-plugin-textdomain' ),
			'search_items'       => __( 'Search Footer Images', 'your-plugin-textdomain' ),
			'parent_item_colon'  => __( 'Parent Footer Images:', 'your-plugin-textdomain' ),
			'not_found'          => __( 'No footer images found.', 'your-plugin-textdomain' ),
			'not_found_in_trash' => __( 'No footer images found in Trash.', 'your-plugin-textdomain' )
		);
	
		$productimageargs = array(
			'labels'             => $productimagelabels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => false,
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'supports'           => array( 'title', 'thumbnail' )
		);
		
		$logolabels = array(
			'name'               => _x( 'Footer Logos', 'post type general name', 'your-plugin-textdomain' ),
			'singular_name'      => _x( 'Footer Logo', 'post type singular name', 'your-plugin-textdomain' ),
			'menu_name'          => _x( 'Footer Logos', 'admin menu', 'your-plugin-textdomain' ),
			'name_admin_bar'     => _x( 'Footer Logo', 'add new on admin bar', 'your-plugin-textdomain' ),
			'add_new'            => _x( 'Add New', 'slides', 'your-plugin-textdomain' ),
			'add_new_item'       => __( 'Add New Footer Logo', 'your-plugin-textdomain' ),
			'new_item'           => __( 'New Footer Logo', 'your-plugin-textdomain' ),
			'edit_item'          => __( 'Edit Footer Logo', 'your-plugin-textdomain' ),
			'view_item'          => __( 'View Footer Logo', 'your-plugin-textdomain' ),
			'all_items'          => __( 'All Footer Logos', 'your-plugin-textdomain' ),
			'search_items'       => __( 'Search Footer Logos', 'your-plugin-textdomain' ),
			'parent_item_colon'  => __( 'Parent Footer Logos:', 'your-plugin-textdomain' ),
			'not_found'          => __( 'No footer logos found.', 'your-plugin-textdomain' ),
			'not_found_in_trash' => __( 'No footer logos found in Trash.', 'your-plugin-textdomain' )
		);
	
		$logoargs = array(
			'labels'             => $logolabels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => false,
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'supports'           => array( 'title', 'thumbnail' )
		);
		
		$productslabels = array(
			'name'               => _x( 'Products', 'post type general name', 'your-plugin-textdomain' ),
			'singular_name'      => _x( 'Product', 'post type singular name', 'your-plugin-textdomain' ),
			'menu_name'          => _x( 'Products', 'admin menu', 'your-plugin-textdomain' ),
			'name_admin_bar'     => _x( 'Product', 'add new on admin bar', 'your-plugin-textdomain' ),
			'add_new'            => _x( 'Add New', 'product', 'your-plugin-textdomain' ),
			'add_new_item'       => __( 'Add New Products', 'your-plugin-textdomain' ),
			'new_item'           => __( 'New Product', 'your-plugin-textdomain' ),
			'edit_item'          => __( 'Edit Product', 'your-plugin-textdomain' ),
			'view_item'          => __( 'View Product', 'your-plugin-textdomain' ),
			'all_items'          => __( 'All Products', 'your-plugin-textdomain' ),
			'search_items'       => __( 'Search Products', 'your-plugin-textdomain' ),
			'parent_item_colon'  => __( 'Parent Products:', 'your-plugin-textdomain' ),
			'not_found'          => __( 'No products found.', 'your-plugin-textdomain' ),
			'not_found_in_trash' => __( 'No products found in Trash.', 'your-plugin-textdomain' )
		);
	
		$productsargs = array(
			'labels'             => $productslabels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'with_front' => false, 'slug' => 'products/%category%' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => true,
			'supports'           => array( 'title', 'editor', 'thumbnail' )
		);
	
		register_post_type( 'slides', $slidesargs );
		register_post_type( 'products', $productsargs );
		register_post_type( 'footer-images', $productimageargs );
		register_post_type( 'logos', $logoargs );		
	}
	
	public function register_taxonomies() {
		$productcats = array(
			'name'              => _x( 'Categories', 'taxonomy general name' ),
			'singular_name'     => _x( 'Category', 'taxonomy singular name' ),
			'search_items'      => __( 'Search Categories' ),
			'all_items'         => __( 'All Categories' ),
			'parent_item'       => __( 'Parent Category' ),
			'parent_item_colon' => __( 'Parent Category:' ),
			'edit_item'         => __( 'Edit Category' ),
			'update_item'       => __( 'Update Category' ),
			'add_new_item'      => __( 'Add New Category' ),
			'new_item_name'     => __( 'New Category Name' ),
			'menu_name'         => __( 'Category' ),
		);
	
		$productcatargs = array(
			'hierarchical'      => true,
			'labels'            => $productcats,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'product-category', 'with_front' => false ),
		);	
		
		register_taxonomy( 'prod-cat', array( 'products' ), $productcatargs );
	}

	public function category_permalink($permalink, $post_id, $leavename) {
		//con %category% catturo il rewrite del Custom Post Type
		if (strpos($permalink, '%category%') === FALSE) return $permalink;
			// Get post
			$post = get_post($post_id);
			if (!$post) return $permalink;
	
			// Get taxonomy terms
			$terms = wp_get_object_terms($post->ID, 'prod-cat');
			if (!is_wp_error($terms) && !empty($terms) && is_object($terms[0]))
				$taxonomy_slug = $terms[0]->slug;
			else $taxonomy_slug = 'no-category';
	
		return str_replace('%category%', $taxonomy_slug, $permalink);
	}
	
	function products_meta_box() {
		add_meta_box(
			'products_meta',
			__( 'Product Details', 'myplugin_textdomain' ),
			array( $this, 'products_meta_callback' ),
			'products'
		);
	}
	
	function products_meta_callback( $post ) {
		$value = get_post_meta( $post->ID, '_product_meta', true );
		
		if( isset( $value['product_features'] ) ) {
			$features = $value['product_features'];
		} else {
			$features = '';	
		}
		wp_nonce_field( 'products_meta_data', 'products_meta_data_nonce' );
		wp_editor( $features, 'product_features' );
	}
	
	public function save_products_meta( $post_id ) {
	
		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['products_meta_data_nonce'] ) )
			return $post_id;

		$nonce = $_POST['products_meta_data_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'products_meta_data' ) )
			return $post_id;

		// If this is an autosave, our form has not been submitted,
                //     so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		// Check the user's permissions.
		if ( 'products' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
	
		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}

		/* OK, its safe for us to save the data now. */

		// Sanitize the user input.
		$mydata = array(
			'product_features' => ( isset( $_POST['product_features'] ) ? $_POST['product_features'] : '' ),
		);
				
		// Update the meta field.
		update_post_meta( $post_id, '_product_meta', $mydata );
	}
	
	public function admin_menu() {
		add_object_page('Theme Options', 'Theme Options', 'manage_options', 'theme-options', array($this, 'theme_options'), $this->admin_icon);	
		add_submenu_page('theme-options', 'Theme Options', 'Contact Details', 'manage_options', 'theme-options/tab1', array($this, 'theme_options'));
		add_submenu_page('theme-options', 'Theme Options', 'Analytics', 'manage_options', 'theme-options/tab2', array($this, 'theme_options'));
		add_submenu_page('theme-options', 'Theme Options', 'Advanced', 'manage_options', 'theme-options/tab3', array($this, 'theme_options'));
	}
	
	public function theme_options() { 
		$option = $this->get_option();
		$tab = explode( '/', urldecode( $_REQUEST['page'] ) );
		$tab = $tab[1];
		$tab = str_replace( 'tab', '', $tab );
		wp_enqueue_media();
	?>
    	<div class="wrap">
            <h2>Settings</h2>

            <h2 class="nav-tab-wrapper">
                <a class="nav-tab <?php echo( !isset($tab) || $tab == '' || $tab == 1 ? 'nav-tab-active' : ''); ?>"
                   href="<?php echo admin_url('admin.php?page=theme-options/tab1'); ?>">Contact Details</a>
                <a class="nav-tab <?php echo(isset($tab) && $tab == 2 ? 'nav-tab-active' : ''); ?>"
                   href="<?php echo admin_url('admin.php?page=theme-options/tab2'); ?>">Analytics</a>
                <a class="nav-tab <?php echo(isset($tab) && $tab == 3 ? 'nav-tab-active' : ''); ?>"
                   href="<?php echo admin_url('admin.php?page=theme-options/tab3'); ?>">Advanced</a>
            </h2>
            <form method="POST" action="<?php echo admin_url('admin-post.php'); ?>">
            <?php if ( !isset( $tab ) || $tab == '' || $tab == 1 ) { ?>
            	<h3>Contact Details</h3>
            	<table class="form-table">
                    <tr>
                        <th>Company Name</th>
                        <td>
                        	<input class="regular-text" type="text" name="<?php echo $this->option_name . '[theme_options][address][company]'; ?>" value="<?php echo (isset($option['theme_options']['address']['company']) ? $option['theme_options']['address']['company'] : ''); ?>">
                        </td>
                    </tr>
					<tr>
                        <th>Street Address</th>
                        <td>
                        	<input class="regular-text" type="text" name="<?php echo $this->option_name . '[theme_options][address][street]'; ?>" value="<?php echo (isset($option['theme_options']['address']['street']) ? $option['theme_options']['address']['street'] : ''); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th>Address 2</th>
                        <td>
                        	<input class="regular-text" type="text" name="<?php echo $this->option_name . '[theme_options][address][address_2]'; ?>" value="<?php echo (isset($option['theme_options']['address']['address_2']) ? $option['theme_options']['address']['address_2'] : ''); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th>Town</th>
                        <td>
                        	<input class="regular-text" type="text" name="<?php echo $this->option_name . '[theme_options][address][town]'; ?>" value="<?php echo (isset($option['theme_options']['address']['town']) ? $option['theme_options']['address']['town'] : ''); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th>County</th>
                        <td>
                        	<input class="regular-text" type="text" name="<?php echo $this->option_name . '[theme_options][address][county]'; ?>" value="<?php echo (isset($option['theme_options']['address']['county']) ? $option['theme_options']['address']['county'] : ''); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th>Postcode</th>
                        <td>
                        	<input class="regular-text" type="text" name="<?php echo $this->option_name . '[theme_options][address][postcode]'; ?>" value="<?php echo (isset($option['theme_options']['address']['postcode']) ? $option['theme_options']['address']['postcode'] : ''); ?>">
                        </td>
                    </tr>
                    <tr><td colspan="2"><hr></td></tr>
                    <tr>
                        <th>Phone Number</th>
                        <td>
                        	<input class="regular-text" type="text" name="<?php echo $this->option_name . '[theme_options][address][phone]'; ?>" value="<?php echo (isset($option['theme_options']['address']['phone']) ? $option['theme_options']['address']['phone'] : ''); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th>Email Address</th>
                        <td>
                        	<input class="regular-text" type="text" name="<?php echo $this->option_name . '[theme_options][address][email]'; ?>" value="<?php echo (isset($option['theme_options']['address']['email']) ? $option['theme_options']['address']['email'] : ''); ?>">
                        </td>
                    </tr>
                    <tr><td colspan="2"><hr></td></tr>
                    <tr>
                        <th>Facebook</th>
                        <td>
                        	<input class="regular-text" type="url" name="<?php echo $this->option_name . '[theme_options][address][facebook]'; ?>" value="<?php echo (isset($option['theme_options']['address']['facebook']) ? $option['theme_options']['address']['facebook'] : ''); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th>Twitter</th>
                        <td>
                        	<input class="regular-text" type="url" name="<?php echo $this->option_name . '[theme_options][address][twitter]'; ?>" value="<?php echo (isset($option['theme_options']['address']['twitter']) ? $option['theme_options']['address']['twitter'] : ''); ?>">
                        </td>
                    </tr>
					<tr>
                        <th>LinkedIN</th>
                        <td>
                        	<input class="regular-text" type="url" name="<?php echo $this->option_name . '[theme_options][address][linkedin]'; ?>" value="<?php echo (isset($option['theme_options']['address']['linkedin']) ? $option['theme_options']['address']['linkedin'] : ''); ?>">
                        </td>
                    </tr>
					<tr>
                        <th>Google+</th>
                        <td>
                        	<input class="regular-text" type="url" name="<?php echo $this->option_name . '[theme_options][address][google]'; ?>" value="<?php echo (isset($option['theme_options']['address']['google']) ? $option['theme_options']['address']['google'] : ''); ?>">
                        </td>
                    </tr>
					<tr><td colspan="2"><hr></td></tr>
					<tr>
                        <th>Opening Hours</th>
                        <td>
							<?php
								wp_editor( $option['theme_options']['address']['opening'], $this->option_name . '[theme_options][address][opening]', array( 'media_buttons' => false, 'textarea_rows' => 3 ) ); 
							?> 
                        </td>
                    </tr>
                </table>            
            <?php } elseif( isset( $tab ) && $tab == 2 ) { ?>
            	<h3>Contact Details</h3>
            	<table class="form-table">
                    <tr>
                        <th>Tracking Code</th>
                        <td>
                        	<textarea width="60%" class="large-text code" name="<?php echo $this->option_name . '[theme_options][analytics][code]'; ?>" rows="10"><?php echo (isset($option['theme_options']['analytics']['code']) ? stripslashes( $option['theme_options']['analytics']['code'])  : ''); ?></textarea>
                        </td>
                    </tr>
                </table>
            <?php } elseif( isset( $tab ) && $tab == 3 ) { ?>
            	<h3>Advanced</h3>
            	<table class="form-table">
                    <tr>
                        <th>Custom &lt;head&gt; code</th>
                        <td>
                        	<textarea width="60%" class="large-text code" name="<?php echo $this->option_name . '[theme_options][advanced][head]'; ?>" rows="10"><?php echo (isset($option['theme_options']['advanced']['head']) ? stripslashes(  $option['theme_options']['advanced']['head'] ) : ''); ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>Custom CSS</th>
                        <td>
                        	<textarea width="60%" class="large-text code" name="<?php echo $this->option_name . '[theme_options][advanced][css]'; ?>" rows="10"><?php echo (isset($option['theme_options']['advanced']['css']) ? stripslashes( $option['theme_options']['advanced']['css'] ) : ''); ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>Custom JS</th>
                        <td>
                        	<textarea width="60%" class="large-text code" name="<?php echo $this->option_name . '[theme_options][advanced][js]'; ?>" rows="10"><?php echo (isset($option['theme_options']['advanced']['js']) ? stripslashes( $option['theme_options']['advanced']['js'] ) : ''); ?></textarea>
                        </td>
                    </tr>
                </table>
            <?php } ?>
            	<input type="hidden" value="tailored_theme_options_save" name="action"/>
                <?php wp_nonce_field('tailored_theme_options_save', $this->option_name . '_nonce', TRUE); ?>
                <?php submit_button( 'Update Settings', 'primary', 'save_settings', false ); ?>
            </form>
        </div>
    <?php } 
	
	public function tailored_theme_options_save() {
		if (!wp_verify_nonce($_POST[$this->option_name . '_nonce'], 'tailored_theme_options_save'))
            die('Invalid nonce.' . var_export($_POST, true));
        
		
		if (isset ($_POST[$this->option_name])) {
			$array = $this->get_option();
            foreach ($_POST[$this->option_name] AS $key => $value) {
				foreach ( $value AS $k => $v) { 
                	$array[$key][$k] = $v;
				}
            }
			update_option($this->option_name, $array);
            
        } 
        if (!isset ($_POST['_wp_http_referer']))
            die('Missing target.');

        $url = urldecode($_POST['_wp_http_referer']);

        wp_safe_redirect($url);
        exit;
	}
	
}
$tailored_theme = new tailored_theme_class();