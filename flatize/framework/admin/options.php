<?php

/**
  ReduxFramework Sample Config File
  For full documentation, please visit: https://docs.reduxframework.com
 * */

if (!class_exists('Redux_Framework_sample_config')) {

    class Redux_Framework_sample_config {

        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }

            // This is needed. Bah WordPress bugs.  ;)
            if (  true == Redux_Helpers::isTheme(__FILE__) ) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }

        }

        public function initSettings() {

            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            // If Redux is running as a plugin, this will remove the demo notice and links
            add_action( 'redux/loaded', array( $this, 'remove_demo' ) );
            
            // Function to test the compiler hook and demo CSS output.
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 3);
            
            // Change the arguments after they've been declared, but before the panel is created
            //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
            
            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
            
            // Dynamically add a section. Can be also used to modify sections/fields
            //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        /**

          This is a test function that will let you see when the compiler hook occurs.
          It only runs if a field   set with compiler=>true is changed.

         * */
        function compiler_action($options, $css, $changed_values) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r($changed_values); // Values that have changed since the last save
            echo "</pre>";
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )

            /*
              // Demo of how to use the dynamic CSS and write your own static CSS file
              $filename = dirname(__FILE__) . '/style' . '.css';
              global $wp_filesystem;
              if( empty( $wp_filesystem ) ) {
                require_once( ABSPATH .'/wp-admin/includes/file.php' );
              WP_Filesystem();
              }

              if( $wp_filesystem ) {
                $wp_filesystem->put_contents(
                    $filename,
                    $css,
                    FS_CHMOD_FILE // predefined mode settings for WP files
                );
              }
             */
        }

        /**

          Custom function for filtering the sections array. Good for child themes to override or add to the sections.
          Simply include this function in the child themes functions.php file.

          NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
          so you must use get_template_directory_uri() if you want to use any of the built in icons

         * */
        function dynamic_section($sections) {
            //$sections = array();
            $sections[] = array(
                'title' => __('Section via hook', 'redux-framework-demo'),
                'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'redux-framework-demo'),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }

        /**

          Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.

         * */
        function change_arguments($args) {
            //$args['dev_mode'] = true;

            return $args;
        }

        /**

          Filter hook for filtering the default value of any given field. Very useful in development mode.

         * */
        function change_defaults($defaults) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {

            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
            }
        }

        public function setSections() {

            /**
              Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $sample_patterns_path   = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url    = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns        = array();

            if (is_dir($sample_patterns_path)) :

                if ($sample_patterns_dir = opendir($sample_patterns_path)) :
                    $sample_patterns = array();

                    while (( $sample_patterns_file = readdir($sample_patterns_dir) ) !== false) {

                        if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                            $name = explode('.', $sample_patterns_file);
                            $name = str_replace('.' . end($name), '', $sample_patterns_file);
                            $sample_patterns[]  = array('alt' => $name, 'img' => $sample_patterns_url . $sample_patterns_file);
                        }
                    }
                endif;
            endif;

            ob_start();

            $ct             = wp_get_theme();
            $this->theme    = $ct;
            $item_name      = $this->theme->get('Name');
            $tags           = $this->theme->Tags;
            $screenshot     = $this->theme->get_screenshot();
            $class          = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'redux-framework-demo'), $this->theme->display('Name'));
            
            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                <?php endif; ?>

                <h4><?php echo $this->theme->display('Name'); ?></h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf(__('By %s', 'redux-framework-demo'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(__('Version %s', 'redux-framework-demo'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . __('Tags', 'redux-framework-demo') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>
            <?php
            if ($this->theme->parent()) {
                printf(' <p class="howto">' . __('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.') . '</p>', __('http://codex.wordpress.org/Child_Themes', 'redux-framework-demo'), $this->theme->parent()->display('Name'));
            }
            ?>

                </div>
            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();

            $sampleHTML = '';
            if (file_exists(dirname(__FILE__) . '/info-html.html')) {
                Redux_Functions::initWpFilesystem();
                
                global $wp_filesystem;

                $sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__) . '/info-html.html');
            }

            $imagepath = get_template_directory_uri().'/images/';

            // ACTUAL DECLARATION OF SECTIONS
            $this->sections[] = array(
                'title'     => __('General Settings', 'redux-framework-demo'),
                'desc'      => '',
                'icon'      => 'el-icon-home',
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields'    => array(
                    array(
                        'id'        => 'logo',
                        'type'      => 'media',
                        'url'       => true,
                        'title'     => __('Logo', 'redux-framework-demo'),
                        'compiler'  => 'true',
                        'default'   => array('url' => 'http://s.wordpress.org/style/images/codeispoetry.png')
                    ),
                    array(
                        'id'        => 'favicon',
                        'type'      => 'media',
                        'url'       => true,
                        'title'     => __('Favicon', 'redux-framework-demo'),
                        'compiler'  => 'true',
                        'default'   => array('url' => '')
                    ),
                    array(
                        'id' => 'logo_retina',
                        'type' => 'media',
                        'url' => true,
                        'title' => __('Logo Retina', 'redux-framework-demo'),
                        'compiler' => 'true',
                        //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                        'desc' => __('Upload your retina logo and please make name like this - logo@2x.png if your logo name : logo.png.', 'redux-framework-demo'),
                    ),
                    array(
                        'id' => 'apple_icon',
                        'type' => 'media',
                        'url' => true,
                        'title' => __('Apple Touch Icon', 'redux-framework-demo'),
                        'compiler' => 'true',
                        //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                        'desc' => __('Upload your Apple touch icon 57x57.', 'redux-framework-demo'),
                    ),
                    array(
                        'id' => 'apple_icon_57',
                        'type' => 'media',
                        'url' => true,
                        'title' => __('Apple Touch Icon 57x57', 'redux-framework-demo'),
                        'compiler' => 'true',
                        //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                        'desc' => __('Upload your Apple touch icon 57x57.', 'redux-framework-demo'),
                    ),
                    array(
                        'id' => 'apple_icon_72',
                        'type' => 'media',
                        'url' => true,
                        'title' => __('Apple Touch Icon 72x72', 'redux-framework-demo'),
                        'compiler' => 'true',
                        //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                        'desc' => __('Upload your Apple touch icon 72x72.', 'redux-framework-demo'),
                    ),
                    array(
                        'id' => 'apple_icon_114',
                        'type' => 'media',
                        'url' => true,
                        'title' => __('Apple Touch Icon 114x114', 'redux-framework-demo'),
                        'compiler' => 'true',
                        //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                        'desc' => __('Upload your Apple touch icon 114x114.', 'redux-framework-demo')                        ,
                    ),
                    array(
                        'id' => 'apple_icon_144',
                        'type' => 'media',
                        'url' => true,
                        'title' => __('Apple Touch Icon 144x144', 'redux-framework-demo'),
                        'compiler' => 'true',
                        //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                        'desc' => __('Upload your Apple touch icon 144x144.', 'redux-framework-demo')                        ,
                    ),
                    array(
                        'id'    => 'opt-divide',
                        'type'  => 'divide'
                    ),
                    array(
                        'id'        => '404_text',
                        'type'      => 'editor',
                        'required'  => array('is-404-page', '=', false),
                        'title'     => __('404 Text', 'redux-framework-demo'),
                        'subtitle'  => __('You can use the following shortcodes in your footer text: [wp-url] [site-url] [theme-url] [login-url] [logout-url] [site-title] [site-tagline] [current-year]', 'redux-framework-demo'),
                        'default'   => "This is Photoshop's version  of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum,",
                    ),
                    array(
                        'id'        => '404_page',
                        'type'      => 'select',
                        'data'      => 'pages',
                        'title'     => __('Page 404 Select Option', 'redux-framework-demo'),
                        'required'  => array('is-404-page', '=', true),
                    ),
                    array(
                        'id'    => 'opt-divide',
                        'type'  => 'divide'
                    ),
                    array(
                        'id'        => 'is-effect-scroll',
                        'type'      => 'switch',
                        'title'     => __('Enable Effect Scroll', 'redux-framework-demo'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'is-back-to-top',
                        'type'      => 'switch',
                        'title'     => __('Enable Back to Top button', 'redux-framework-demo'),
                        'default'   => true
                    ),
                ),
            );

            $path_image = PGL_FRAMEWORK_URI . 'admin/images/';



            $this->sections[] = array(
                'icon'      => 'el-icon-website',
                'title'     => __('Styling Options', 'redux-framework-demo'),
                'fields'    => array(
                    array(
                        'id'        => 'style_layout',
                        'type'      => 'button_set',
                        'title'     => __('Layout Style', 'redux-framework-demo'),
                        'desc'      => __('Choose Your Layout Style.', 'redux-framework-demo'),
                        'options'   => array(
                            'wide' => 'Wide', 
                            'boxed' => 'Boxed', 
                        ),
                        'default'   => 'wide'
                    ),
                    array(
                        'id'        => 'style_body_background',
                        'type'      => 'background',
                        'output'    => array('body'),
                        'required'  => array('style_layout', '=', 'boxed'),
                        'title'     => __('Body Background', 'redux-framework-demo'),
                        'default' => array(
                            'background-color'=>'#ddd'
                        ),
                    ),
                    array(
                        'id'        => 'style_main_color',
                        'type'      => 'image_select',
                        'compiler'  => true,
                        'title'     => __('Main Color', 'redux-framework-demo'),
                        'options'   => array(
                            '#1abc9c' => array( 'img' => $path_image . '01.jpg'),
                            '#3598db' => array( 'img' => $path_image . '02.jpg'),
                            '#c2a772' => array( 'img' => $path_image . '03.jpg'),
                            '#36c877' => array( 'img' => $path_image . '04.jpg'),
                            '#e99b1f' => array( 'img' => $path_image . '05.jpg'),
                            '#f64243' => array( 'img' => $path_image . '06.jpg'),
                            '#a57bcd' => array( 'img' => $path_image . '07.jpg'),
                            '#e9bf1d' => array( 'img' => $path_image . '08.jpg'),
                            'custom' => array( 'img' => $path_image . '09.jpg'),
                        ),
                        'default'   => '#1abc9c'
                    ),
                    array(
                        'id'       => 'style_main_custom',
                        'type'     => 'color',
                        'title'    => __('Main Color Custom', 'redux-framework-demo'), 
                        'default'  => '#FFFFFF',
                        'validate' => 'color',
                        'transparent' => false,
                        'required'  => array('style_main_color', '=', 'custom'),
                        'subtitle'  => __('Select your themes alternative color scheme.', 'redux-framework-demo'),
                    ),
                    array(
                        'id'        => 'style_topbar_background',
                        'type'      => 'background',
                        'output'    => array('#header-topbar'),
                        'title'     => __('Topbar Background Color', 'redux-framework-demo'),
                        'background-attachment' => false,
                        'background-image' => false,
                        'background-position' => false,
                        'background-repeat' => false,
                        'background-size' => false,
                        'default' => array(
                            'background-color'=>'#181818'
                        ),
                    ),
                    array(
                        'id'        => 'style_breadcrumb_background',
                        'type'      => 'background',
                        'output'    => array('.breadcrumb','.woocommerce-breadcrumb'),
                        'title'     => __('Breadcrumb Background', 'redux-framework-demo'),
                    ),
                    array(
                        'id'        => 'style_footer_background',
                        'type'      => 'background',
                        'output'    => array('#pgl-footer'),
                        'title'     => __('Footer Background', 'redux-framework-demo'),
                        'default' => array(
                            'background-color'=>'#181818'
                        ),
                    ),
                    array(
                        'id'    => 'opt-divide',
                        'type'  => 'divide'
                    ),
                    array(
                        'id'        => 'custom-css',
                        'type'      => 'ace_editor',
                        'title'     => __('CSS Code', 'redux-framework-demo'),
                        'subtitle'  => __('Paste your CSS code here.', 'redux-framework-demo'),
                        'mode'      => 'css',
                        'theme'     => 'monokai',
                        'desc'      => 'Possible modes can be found at <a href="http://ace.c9.io" target="_blank">http://ace.c9.io/</a>.',
                        'default'   => ""
                    ),
                    array(
                        'id'        => 'custom-js',
                        'type'      => 'ace_editor',
                        'title'     => __('JS Code', 'redux-framework-demo'),
                        'subtitle'  => __('Paste your JS code here.', 'redux-framework-demo'),
                        'mode'      => 'js',
                        'theme'     => 'monokai',
                        'desc'      => 'Possible modes can be found at <a href="http://ace.c9.io" target="_blank">http://ace.c9.io/</a>.',
                        'default'   => ""
                    ),
                )
            );
            
            $this->sections[] = array(
                'icon'      => 'el-icon-font',
                'title'     => __('Fonts Options', 'redux-framework-demo'),
                'subsection' => true,
                'fields'    => array(
                    array(
                        'id'          => 'font-main',
                        'type'        => 'typography', 
                        'title'       => __('Main Font', 'redux-framework-demo'),
                        'google'      => true, 
                        'font-backup' => false,
                        'font-style'  => false,
                        'text-align'  => false,
                        'line-height' => false,
                        'color'       => false,
                        'font-size'   => false,
                        'units'       => 'px',
                        'font_family_clear' => true
                    ),
                    array(
                        'id'          => 'font-heading',
                        'type'        => 'typography', 
                        'title'       => __('Heading Font', 'redux-framework-demo'),
                        'google'      => true, 
                        'font-backup' => false,
                        'font-style'  => false,
                        'text-align'  => false,
                        'line-height' => false,
                        'color'       => false,
                        'font-size'   => false,
                        'units'       => 'px',
                        'font_family_clear' => true
                    )
                )
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-qrcode',
                'title'     => __('Header Settings', 'redux-framework-demo'),
                'fields'    => array(
                    array(
                        'id'        => 'header',
                        'type'      => 'image_select',
                        'compiler'  => true,
                        'title'     => __('Header Layout', 'redux-framework-demo'),
                        'subtitle'  => __('Images for layout header.', 'redux-framework-demo'),
                        'options'   => array(
                            '' => array('alt' => 'Header Style 1',       'img' => $imagepath . 'header/header-2.jpg'),
                            'style2' => array('alt' => 'Header Style 2',  'img' => $imagepath . 'header/header-1.jpg'),
                            'style3' => array('alt' => 'Header Style 3',  'img' => $imagepath . 'header/header-3.jpg')
                        ),
                        'default'   => ''
                    ),
                    array(
                        'id'        => 'header_text',
                        'type'      => 'editor',
                        'title'     => __('Header Text', 'redux-framework-demo'),
                        'subtitle'  => __('You can use the following shortcodes in your footer text: [wp-url] [site-url] [theme-url] [login-url] [logout-url] [site-title] [site-tagline] [current-year]', 'redux-framework-demo'),
                        'default'   => "FREE SHIPPING ON ALL U.S ORDERS OVER $50",
                    ),
                    array(
                        'id'        => 'header-is-sticky',
                        'type'      => 'switch',
                        'title'     => __('Enable Sticky Header', 'redux-framework-demo'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'header-is-cart',
                        'type'      => 'switch',
                        'title'     => __('Enable Cart Header', 'redux-framework-demo'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'header-is-login',
                        'type'      => 'switch',
                        'title'     => __('Enable Login Header', 'redux-framework-demo'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'header-is-search',
                        'type'      => 'switch',
                        'title'     => __('Enable Search Header', 'redux-framework-demo'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'header_topbar_order',
                        'type'      => 'sorter',
                        'title'     => 'Topbar Widget Enable',
                        'compiler'  => 'true',
                        'options'   => array(
                            'enabled'  => array(
                                'text'       => 'Widget Text',
                                'menu'        => 'Menu',
                            ),
                            'disabled'   => array(

                            ),
                        ),
                    ),
                    array(
                        'id'        => 'header_topbar_text',
                        'type'      => 'editor',
                        'title'     => __('Topbar Widget Text', 'redux-framework-demo'),
                        'subtitle'  => __('You can use the following shortcodes in your footer text: [wp-url] [site-url] [theme-url] [login-url] [logout-url] [site-title] [site-tagline] [current-year]', 'redux-framework-demo'),
                        'default'   => "",
                    ),
                    array(
                        'id'        => 'header_topbar_menu_heading',
                        'type'      => 'text',
                        'title'     => __('Topbar Menu Heading', 'redux-framework-demo'),
                        'default'   => 'Menu',
                    ),
                    array(
                        'id'        => 'header_topbar_menu',
                        'type'      => 'select',
                        'title'     => __('Topbar Menu select', 'redux-framework-demo'),
                        'data'      => 'menu',
                    ),
                )
            );
            
            $this->sections[] = array(
                'icon'      => 'el-icon-list-alt',
                'title'     => __('Footer Settings', 'redux-framework-demo'),
                'fields'    => array(
                    array(
                        'id'        => 'footer_layout',
                        'type'      => 'image_select',
                        'compiler'  => true,
                        'title'     => __('Footer Layout', 'redux-framework-demo'),
                        'subtitle'  => __('Images for layout footer.', 'redux-framework-demo'),
                        'options'   => array(
                            'style1' => array('alt' => 'Footer Style 1',       'img' => $imagepath . 'footer/footer-1.jpg'),
                            'style2' => array('alt' => 'Footer Style 2',  'img' => $imagepath . 'footer/footer-2.jpg'),
                        ),
                        'default'   => 'style1'
                    ),
                    array(
                        'id'        => 'footer_menu',
                        'type'      => 'select',
                        'title'     => __('Footer Menu select', 'redux-framework-demo'),
                        'data'      => 'menu',
                    ),
                    array(
                        'id'        => 'copyright_text',
                        'type'      => 'editor',
                        'title'     => __('Copyright Text', 'redux-framework-demo'),
                        'subtitle'  => __('You can use the following shortcodes in your footer text: [wp-url] [site-url] [theme-url] [login-url] [logout-url] [site-title] [site-tagline] [current-year]', 'redux-framework-demo'),
                        'default'   => ' Copyright © 2013 Flatize. Designed by <a href="#">PixelGeekLab</a> <br>All rights reserved.',
                    ),
                    array(
                        'id'        => 'fa-facebook',
                        'type'      => 'text',
                        'title'     => __('Facebook', 'redux-framework-demo'),
                        'subtitle'  => __('This must be a URL.', 'redux-framework-demo'),
                        'validate'  => 'url',
                    ),
                    array(
                        'id'        => 'fa-twitter',
                        'type'      => 'text',
                        'title'     => __('Twitter', 'redux-framework-demo'),
                        'subtitle'  => __('This must be a URL.', 'redux-framework-demo'),
                        'validate'  => 'url',
                    ),
                    array(
                        'id'        => 'fa-linkedin',
                        'type'      => 'text',
                        'title'     => __('LinkedIn', 'redux-framework-demo'),
                        'subtitle'  => __('This must be a URL.', 'redux-framework-demo'),
                        'validate'  => 'url',
                    ),
                    array(
                        'id'        => 'fa-tumblr',
                        'type'      => 'text',
                        'title'     => __('Tumblr', 'redux-framework-demo'),
                        'subtitle'  => __('This must be a URL.', 'redux-framework-demo'),
                        'validate'  => 'url',
                    ),
                    array(
                        'id'        => 'fa-google-plus',
                        'type'      => 'text',
                        'title'     => __('Google +', 'redux-framework-demo'),
                        'subtitle'  => __('This must be a URL.', 'redux-framework-demo'),
                        'validate'  => 'url',
                    ),
                    array(
                        'id'        => 'fa-pinterest',
                        'type'      => 'text',
                        'title'     => __('Pinterest', 'redux-framework-demo'),
                        'subtitle'  => __('This must be a URL.', 'redux-framework-demo'),
                        'validate'  => 'url',
                    ),
                    array(
                        'id'        => 'fa-instagram',
                        'type'      => 'text',
                        'title'     => __('Instagram', 'redux-framework-demo'),
                        'subtitle'  => __('This must be a URL.', 'redux-framework-demo'),
                        'validate'  => 'url',
                    ),
                    array(
                        'id'        => 'social_order',
                        'type'      => 'sorter',
                        'title'     => 'Social Enable',
                        'compiler'  => 'true',
                        'options'   => array(
                            'enabled'  => array(
                                'fa-facebook'       => 'Facebook',
                                'fa-twitter'        => 'Twitter',
                                'fa-linkedin'       => 'LinkedIn',
                                'fa-tumblr'         => 'Tumblr',
                                'fa-google-plus'    => 'Google +',
                                'fa-pinterest'      => 'Pinterest',
                                'fa-instagram'      => 'Instagram',
                            ),
                            'disabled'   => array(

                            ),
                        ),
                    ),
                )
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-bold',
                'title'     => __('Blog Setting', 'redux-framework-demo'),
                'fields'    => array(
                    array(
                        'id'        => 'blog-layout',
                        'type'      => 'image_select',
                        'title'     => __('Images Option for Layout', 'redux-framework-demo'),
                        'subtitle'  => __('No validation can be done on this field type', 'redux-framework-demo'),
                        'desc'      => __('This uses some of the built in images, you can use them for layout options.', 'redux-framework-demo'),
                        
                        //Must provide key => value(array:title|img) pairs for radio options
                        'options'   => array(
                            '1' => array('alt' => '1 Column',        'img' => ReduxFramework::$_url . 'assets/img/1col.png'),
                            '2' => array('alt' => '2 Column Left',   'img' => ReduxFramework::$_url . 'assets/img/2cl.png'),
                            '3' => array('alt' => '2 Column Right',  'img' => ReduxFramework::$_url . 'assets/img/2cr.png'),
                            '4' => array('alt' => '3 Column Middle', 'img' => ReduxFramework::$_url . 'assets/img/3cm.png'),
                            '5' => array('alt' => '3 Column Left',   'img' => ReduxFramework::$_url . 'assets/img/3cl.png'),
                            '6' => array('alt' => '3 Column Right',  'img' => ReduxFramework::$_url . 'assets/img/3cr.png')
                        ), 
                        'default' => '2'
                    ),
                    array(
                        'id'        => 'blog-left-sidebar',
                        'type'      => 'select',
                        'title'     => __('Sidebar Left', 'redux-framework-demo'),
                        'data'      => 'sidebars',
                        'default'   => 'sidebar-left'
                    ),
                    array(
                        'id'        => 'blog-right-sidebar',
                        'type'      => 'select',
                        'title'     => __('Sidebar Right', 'redux-framework-demo'),
                        'data'      => 'sidebars',
                        'default'   => 'sidebar-right'
                    ),
                )
            );

            $this->sections[] = array(
                'icon'      => ' el-icon-rss',
                'title'     => __('SEO Settings', 'redux-framework-demo'),
                'fields'    => array(
                    array(
                        'id'        => 'is-seo',
                        'type'      => 'switch',
                        'title'     => __('Enable SEO options', 'redux-framework-demo'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'seo-keywords',
                        'type'      => 'textarea',
                        'required'  => array('is-seo', '=', '1'),
                        'title'     => __('SEO Keywords', 'redux-framework-demo'),
                        'desc'      => 'Paste your SEO Keywords. This will be added into the meta tag keywords in header.',
                        'default'   => ''
                    ),
                    array(
                        'id'        => 'seo-description',
                        'type'      => 'textarea',
                        'required'  => array('is-seo', '=', '1'),
                        'title'     => __('SEO Description', 'redux-framework-demo'),
                        'desc'      => 'Paste your SEO Description. This will be added into the meta tag description in header.',
                        'default'   => ''
                    ),
                )
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-shopping-cart',
                'title'     => __('Woocommerce Settings', 'redux-framework-demo'),
                'fields'    => array(
                    array(
                        'id'        => 'woo-shop-number',
                        'type'      => 'text',
                        'title'     => __('Shop show products', 'redux-framework-demo'),
                        'desc'      => __('To Change number of products displayed per page.', 'redux-framework-demo'),
                        'validate'  => 'numeric',
                        'default'   => '10',
                    ),
                    array(
                        'id'        => 'woo-shop-column',
                        'type'      => 'select',
                        'title'     => __('Shop Columns', 'redux-framework-demo'),
                        'options'   => array(
                            '1' => '1 Column', 
                            '2' => '2 Columns', 
                            '3' => '3 Columns',
                            '4' => '4 Columns', 
                            '6' => '6 Columns',
                        ),
                        'default'   => '4'
                    ),
                    array(
                        'id'        => 'woo-related-number',
                        'type'      => 'text',
                        'title'     => __('Related show products', 'redux-framework-demo'),
                        'desc'      => __('To Change number of products displayed related.', 'redux-framework-demo'),
                        'validate'  => 'numeric',
                        'default'   => '4',
                    ),
                    array(
                        'id'        => 'woo-related-column',
                        'type'      => 'select',
                        'title'     => __('Related Columns', 'redux-framework-demo'),
                        'options'   => array(
                            '1' => '1 Column', 
                            '2' => '2 Columns', 
                            '3' => '3 Columns',
                            '4' => '4 Columns', 
                            '6' => '6 Columns',
                        ),
                        'default'   => '4'
                    ),
                    array(
                        'id'        => 'woo-upsells-number',
                        'type'      => 'text',
                        'title'     => __('Upsells show products', 'redux-framework-demo'),
                        'desc'      => __('To Change number of products displayed up-sell.', 'redux-framework-demo'),
                        'validate'  => 'numeric',
                        'default'   => '4',
                    ),
                    array(
                        'id'        => 'woo-upsells-column',
                        'type'      => 'select',
                        'title'     => __('Upsells Columns', 'redux-framework-demo'),
                        'options'   => array(
                            '1' => '1 Column', 
                            '2' => '2 Columns', 
                            '3' => '3 Columns',
                            '4' => '4 Columns', 
                            '6' => '6 Columns',
                        ),
                        'default'   => '4'
                    ),
                    array(
                        'id'        => 'woo-cross-sells-number',
                        'type'      => 'text',
                        'title'     => __('Cross Sells show products', 'redux-framework-demo'),
                        'desc'      => __('To Change number of products displayed cross sells.', 'redux-framework-demo'),
                        'validate'  => 'numeric',
                        'default'   => '4',
                    ),
                    array(
                        'id'        => 'woo-cross-sells-column',
                        'type'      => 'select',
                        'title'     => __('Cross Sells Columns', 'redux-framework-demo'),
                        'options'   => array(
                            '1' => '1 Column', 
                            '2' => '2 Columns', 
                            '3' => '3 Columns',
                            '4' => '4 Columns', 
                            '6' => '6 Columns',
                        ),
                        'default'   => '4'
                    ),
                    array(
                        'id'        => 'woo-shop-layout',
                        'type'      => 'image_select',
                        'compiler'  => true,
                        'title'     => __('Shop Layout', 'redux-framework-demo'),
                        'subtitle'  => __('Select main content and sidebar alignment. Choose between 1, 2 or 3 column layout.', 'redux-framework-demo'),
                        'options'   => array(
                            '1' => array('alt' => '1 Column',       'img' => ReduxFramework::$_url . 'assets/img/1col.png'),
                            '2' => array('alt' => '2 Column Left',  'img' => ReduxFramework::$_url . 'assets/img/2cl.png'),
                            '3' => array('alt' => '2 Column Right', 'img' => ReduxFramework::$_url . 'assets/img/2cr.png'),
                        ),
                        'default'   => '2'
                    ),
                    array(
                        'id'        => 'woo-shop-sidebar',
                        'type'      => 'select',
                        'title'     => __('Shop Left Sidebar', 'redux-framework-demo'),
                        'data'      => 'sidebars',
                        'default'   => 'sidebar-left'
                    ),
                    array(
                        'id'        => 'woo-single-layout',
                        'type'      => 'image_select',
                        'compiler'  => true,
                        'title'     => __('Single Layout', 'redux-framework-demo'),
                        'subtitle'  => __('Select main content and sidebar alignment. Choose between 1, 2 or 3 column layout.', 'redux-framework-demo'),
                        'options'   => array(
                            '1' => array('alt' => '1 Column',       'img' => ReduxFramework::$_url . 'assets/img/1col.png'),
                            '2' => array('alt' => '2 Column Left',  'img' => ReduxFramework::$_url . 'assets/img/2cl.png'),
                            '3' => array('alt' => '2 Column Right', 'img' => ReduxFramework::$_url . 'assets/img/2cr.png'),
                        ),
                        'default'   => '2'
                    ),
                    array(
                        'id'        => 'woo-single-sidebar',
                        'type'      => 'select',
                        'title'     => __('Single Sidebar', 'redux-framework-demo'),
                        'data'      => 'sidebars',
                        'default'   => 'sidebar-left'
                    ),
                    array(
                        'id'        => 'woo-is-quickview',
                        'type'      => 'switch',
                        'title'     => __('Enable QuickView', 'redux-framework-demo'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'woo-is-effect-thumbnail',
                        'type'      => 'switch',
                        'title'     => __('Enable Effect Image', 'redux-framework-demo'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'woo-is-effect-add-cart',
                        'type'      => 'switch',
                        'title'     => __('Enable Effect Fly Add to Cart', 'redux-framework-demo'),
                        'default'   => true
                    ),
                ),
            );

             $this->sections[] = array(
                'icon'      => 'el-icon-lines',
                'title'     => __('Megamenu Settings', 'redux-framework-demo'),
                'fields'    => array(
                    array(
                        'id'        => 'megamenu-menu',
                        'type'      => 'select',
                        'title'     => __('Mega Menu', 'redux-framework-demo'),
                        'data'      => 'menu',
                        'desc'      => 'Select a menu to configure Megamenu for the menu items in the selected menu.'
                    ),
                    array(
                        'id'        => 'megamenu-animation',
                        'type'      => 'select',
                        'title'     => __('Animation', 'redux-framework-demo'),
                        'options'   => array(
                                'effect-none'   => 'None',
                                'bottom-to-top'         => 'Bottom to top',
                            ),
                        'desc'      => 'Select animation for Megamenu.',
                        'default' => 'effect-none',
                    ),
                    array(
                        'id'        => 'megamenu-duration',
                        'type'      => 'text',
                        'title'     => __('Duration', 'redux-framework-demo'),
                        'desc'      => __('Animation effect duration for dropdown of Megamenu (in miliseconds).', 'redux-framework-demo'),
                        'validate'  => 'numeric',
                        'default'   => '400',
                    ),
                ),
            );

            $this->sections[] = array(
                'type' => 'divide',
            );

             $this->sections[] = array(
                'title'     => __('Import / Export', 'redux-framework-demo'),
                'desc'      => __('Import and Export your Redux Framework settings from file, text or URL.', 'redux-framework-demo'),
                'icon'      => 'el-icon-refresh',
                'fields'    => array(
                    array(
                        'id'            => 'opt-import-export',
                        'type'          => 'import_export',
                        'title'         => 'Import Export',
                        'subtitle'      => 'Save and restore your Redux options',
                        'full_width'    => false,
                    ),
                ),
            );

            if (file_exists(trailingslashit(dirname(__FILE__)) . 'README.html')) {
                $tabs['docs'] = array(
                    'icon'      => 'el-icon-book',
                    'title'     => __('Documentation', 'redux-framework-demo'),
                    'content'   => nl2br(file_get_contents(trailingslashit(dirname(__FILE__)) . 'README.html'))
                );
            }
        }

        public function setHelpTabs() {

            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-1',
                'title'     => __('Theme Information 1', 'redux-framework-demo'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo')
            );

            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-2',
                'title'     => __('Theme Information 2', 'redux-framework-demo'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo')
            );

            // Set the help sidebar
            $this->args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'redux-framework-demo');
        }

        /**

          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name'          => 'theme_option',            // This is where your data is stored in the database and also becomes your global variable name.
                'display_name'      => $theme->get('Name'),     // Name that appears at the top of your panel
                'display_version'   => $theme->get('Version'),  // Version that appears at the top of your panel
                'menu_type'         => 'menu',                  //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu'    => true,                    // Show the sections below the admin menu item or not
                'menu_title'        => __('Theme Options', 'redux-framework-demo'),
                'page_title'        => __('Theme Options', 'redux-framework-demo'),
                
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => '', // Must be defined to add google fonts to the typography module
                
                'async_typography'  => false,                    // Use a asynchronous font on the front end or font string
                'admin_bar'         => true,                    // Show the panel pages on the admin bar
                'global_variable'   => '',                      // Set a different name for your global variable other than the opt_name
                'dev_mode'          => true,                    // Show the time the page took to load, etc
                'customizer'        => true,                    // Enable basic customizer support
                //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

                // OPTIONAL -> Give you extra features
                'page_priority'     => null,                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent'       => 'themes.php',            // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions'  => 'manage_options',        // Permissions needed to access the options panel.
                'menu_icon'         => '',                      // Specify a custom URL to an icon
                'last_tab'          => '',                      // Force your panel to always open to a specific tab (by id)
                'page_icon'         => 'icon-themes',           // Icon displayed in the admin panel next to your menu_title
                'page_slug'         => '_options',              // Page slug used to denote the panel
                'save_defaults'     => true,                    // On load save the defaults to DB before user clicks save or not
                'default_show'      => false,                   // If true, shows the default value next to each field that is not the default value.
                'default_mark'      => '',                      // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export' => true,                   // Shows the Import/Export panel when not used as a field.
                
                // CAREFUL -> These options are for advanced use only
                'transient_time'    => 60 * MINUTE_IN_SECONDS,
                'output'            => true,                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag'        => true,                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.
                
                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database'              => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info'           => false, // REMOVE

                // HINTS
                'hints' => array(
                    'icon'          => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color'    => 'lightgray',
                    'icon_size'     => 'normal',
                    'tip_style'     => array(
                        'color'         => 'light',
                        'shadow'        => true,
                        'rounded'       => false,
                        'style'         => '',
                    ),
                    'tip_position'  => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect'    => array(
                        'show'          => array(
                            'effect'        => 'slide',
                            'duration'      => '500',
                            'event'         => 'mouseover',
                        ),
                        'hide'      => array(
                            'effect'    => 'slide',
                            'duration'  => '500',
                            'event'     => 'click mouseleave',
                        ),
                    ),
                )
            );

            // Panel Intro text -> before the form
            if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
                if (!empty($this->args['global_variable'])) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace('-', '_', $this->args['opt_name']);
                }
                $this->args['intro_text'] = sprintf(__('<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'redux-framework-demo'), $v);
            } else {
                $this->args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'redux-framework-demo');
            }

            // Add content after the form.
            $this->args['footer_text'] = __('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'redux-framework-demo');
        }

    }
    
    global $reduxConfig;
    $reduxConfig = new Redux_Framework_sample_config();
    
}