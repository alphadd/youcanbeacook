<?php

class PGL_Megamenu_Setting
{
    public function __construct(){
        add_action('admin_menu', array($this,'megamenu_create_menu'));
    }

    public function megamenu_create_menu() {

        //create new top-level menu
        add_menu_page('Opal Megamenu Plugin Settings', 'Megamenu Settings', 'administrator', __FILE__, array($this,'megamenu_settings_page') );

        //call register settings function
        add_action( 'admin_init', array($this,'register_mysettings') );
    }


    public function register_mysettings() {
        //register our settings
        register_setting( 'pgl-megamenu-settings-group', 'wpomegamenu-menu' );
        register_setting( 'pgl-megamenu-settings-group', 'wpomegamenu-animation' );
        register_setting( 'pgl-megamenu-settings-group', 'wpomegamenu-duration' );
        register_setting( 'pgl-megamenu-settings-group', 'wpomegamenu-effect' );
    }

    public function megamenu_settings_page() {
        $menus = wp_get_nav_menus( array( 'orderby' => 'name' ) );
    ?>
    <div class="wrap">
    <h2>Opal Megamenu Plugin</h2>

    <form method="post" action="options.php">
        <?php settings_fields( 'pgl-megamenu-settings-group' ); ?>
        <?php do_settings_sections( 'pgl-megamenu-settings-group' ); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">Select Menu:</th>
                <td>
                    <select name="wpomegamenu-menu">
                        <option value="">------ Select Menu ------</option>
                        <?php foreach ($menus as $menu) {
                            echo '<option value="'.$menu->term_id.'" '.selected($menu->term_id,get_option('wpomegamenu-menu')).'>'.$menu->name.'</option>';
                        } ?>
                    </select>
                    <p class="description">Select a menu to configure Megamenu for the menu items in the selected menu. <a href="<?php echo admin_url( 'themes.php?page=pgl_megamenu' ); ?>" class="button button-primary">Editor</a></p>
                </td>
            </tr>
        </table>

        <?php submit_button(); ?>

    </form>
    </div>
    <?php }
}