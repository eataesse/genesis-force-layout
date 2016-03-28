<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://rdejong.nl
 * @since      1.0.0
 *
 * @package    Genesis_Force_Layout
 * @subpackage Genesis_Force_Layout/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Genesis_Force_Layout
 * @subpackage Genesis_Force_Layout/public
 * @author     Richard de Jong <info@rdejong.nl>
 */
class Genesis_Force_Layout_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
        $this->genesis_force_layout_options = get_option($this->plugin_name);

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
		 * defined in Genesis_Force_Layout_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Genesis_Force_Layout_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/genesis-force-layout-public.css', array(), $this->version, 'all' );

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
		 * defined in Genesis_Force_Layout_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Genesis_Force_Layout_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/genesis-force-layout-public.js', array( 'jquery' ), $this->version, false );

	}
    
    //add_filter( 'genesis_pre_get_option_site_layout', 'force_layout' );

    /**
     * Force layout if primary sidebar is inactive
     *
     * @author Richard de Jong
     * @since 1.0.0
     */
    public function force_layout( $opt ) {
        
        //check if force layout is enabled
        if( $this->genesis_force_layout_options['force-layout'] ){
                    
            global $post;
            
            //get current post id
            $page_id = $post->ID;
            
            //retrieve if the current page has a custom chosen layout
            $page_meta_array = get_post_meta( $page_id, '_genesis_layout');
            $page_meta = $page_meta_array[0];
            
            //if not, get the default layout
            if(empty($page_meta)) {
                $page_meta = genesis_site_layout();
            }
            
            //define all the genesis layouts
            $cs = 'content-sidebar';
            $sc = 'sidebar-content';
            $css = 'content-sidebar-sidebar';
            $ssc = 'sidebar-sidebar-content';
            $scs = 'sidebar-content-sidebar';
            
            //define if the primary sidebar should be replaced with the secondary sidebar
            $replace_primary_with_secondary = false;
            //define if the secondary sidebar should be replaced with the primary sidebar
            $replace_secondary_with_primary = false;
            
            //check if current page layout is content-sidebar or sidebar-content
            if( $page_meta == $cs || $page_meta == $sc ) {
                if( !is_active_sidebar( 'sidebar' )) {
                    $layout = 'full_width_content';
                }
            }
            
            //check if current page layout is content-sidebar-sidebar
            if( $page_meta == $css || $page_meta == $ssc ) {
                //check if the primary or secondary sidebar is inactive, but not both
                if( !is_active_sidebar( 'sidebar' ) xor !is_active_sidebar( 'sidebar-alt') ) {
                    $layout = ( $page_meta == $css ) ? 'content_sidebar' : 'sidebar_content';
                    
                    // Check if Primary Sidebar is not active
                    if( !is_active_sidebar( 'sidebar' ) ) {
                        // Remove the Primary Sidebar from the Primary Sidebar area.
                        remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
                        
                        // Place the Secondary Sidebar into the Primary Sidebar area.
                        add_action( 'genesis_sidebar', 'genesis_do_sidebar_alt' );
                    } elseif( !is_active_sidebar( 'sidebar-alt' ) ) {
                        // Remove the Secondary Sidebar from the Secondary Sidebar area.
                        remove_action( 'genesis_sidebar_alt', 'genesis_do_sidebar_alt' );
                        
                        // Place the Primary Sidebar into the Secondary Sidebar area.
                        add_action( 'genesis_sidebar_alt', 'genesis_do_sidebar' );
                    }
                    //if only secondary, remove primary and set secondary in place of primary
                } elseif( !is_active_sidebar( 'sidebar' ) && !is_active_sidebar( 'sidebar-alt') ) {
                    $layout = 'full_width_content';
                }
            }
            
            //check if current page layout is sidebar-content-sidebar
            if( $page_meta == $scs ) {
                if( !is_active_sidebar( 'sidebar' ) && !is_active_sidebar( 'sidebar-alt') ) {
                    $layout = 'full_width_content';
                } elseif( !is_active_sidebar( 'sidebar' ) ) {
                    $layout = 'sidebar_content';
                } elseif( !is_active_sidebar( 'sidebar-alt') ) {
                    $layout = 'content_sidebar';
                }
                
            }
            
            if($layout) {
                add_filter( 'genesis_site_layout', '__genesis_return_' . $layout . '' );
            }
    
        } else {
            //plugin is disabled
            return false;
        }
        
    }
    
    
    
    


}
