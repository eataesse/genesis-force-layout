<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://rdejong.nl
 * @since      1.0.0
 *
 * @package    Genesis_Force_Layout
 * @subpackage Genesis_Force_Layout/admin/partials
 */
?>


<div class="wrap">

    <h2><?php echo esc_html(get_admin_page_title()); ?></h2>
    
    <!-- This file should primarily consist of HTML with a little bit of PHP. -->
    
    <p>
    This plugin will force layouts when a sidebar is empty on a page.<br />
    For exampe, with the layout content-sidebar, the sidebar being empty, the plugin will force the full-width-content layout on that page.
    </p>
    
    <form method="post" name="genesis_force_layout_options" action="options.php">
    
        <?php
        //Grab all options
        $options = get_option($this->plugin_name);

        // Cleanup
        $force_layout = $options['force-layout'];
        
        settings_fields($this->plugin_name);
        do_settings_sections($this->plugin_name);
        ?>
        <?php if( isset($_GET['settings-updated']) ) { ?>
    <div id="message" class="updated">
        <p><strong><?php _e('Settings saved.') ?></strong></p>
    </div>
<?php } ?>
        <table class="form-table">
            <tr valign="top">
        		<th scope="row"><label for="<?php echo $this->plugin_name; ?>-force-layout"><?php esc_attr_e( 'Enable the plugin', 'wp_admin_style' ); ?></label></th>
        		<td><input name="<?php echo $this->plugin_name; ?>[force-layout]" type="checkbox" id="<?php echo $this->plugin_name; ?>-force-layout" value="1" <?php checked($force_layout,1); ?> /></td>
        	</tr>
        </table>
    
        <?php submit_button('Save all changes', 'primary','submit', TRUE); ?>
    
    </form>
    
</div>
