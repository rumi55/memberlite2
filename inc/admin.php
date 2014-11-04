<?php
/**
 * Custom admin theme pages
 *
 * @package Member Lite 2.0
 */

/**
 * Adds Theme Support submenu page to "Appearance" menu.
 *
 */
 
function memberlite_plugin_menu() {
	add_theme_page('MemberLite Documentation and Support', 'MemberLite', 'edit_theme_options', 'memberlite-support', 'memberlite_support');
}
add_action('admin_menu', 'memberlite_plugin_menu');

function memberlite_support() {
	if(isset($_REQUEST['tab']))
		$view = $_REQUEST['tab'];
	else
		$view = "";
	?>
	<div id="wpbody-content" aria-label="Main content" tabindex="0">	
		<div class="wrap">
			<h2>MemberLite Theme Documentation and Support</h2>
			<h2 class="nav-tab-wrapper">
				<a href="admin.php?page=memberlite-support&tab=overview" class="nav-tab<?php if( ($view == 'overview') || (empty($view)) ) { ?> nav-tab-active<?php } ?>"><?php _e('Settings', 'memberlite');?></a>
				<a href="admin.php?page=memberlite-support&tab=docs" class="nav-tab<?php if($view == 'docs') { ?> nav-tab-active<?php } ?>"><?php _e('Documentation', 'memberlite');?></a>
			</h2>
			<!-- /manage-menus -->
			<?php if( ($view == 'overview') || (empty($view)) ) { ?>
				<div id="memberlite-overview">
					<h3>Overview</h3>
				</div>		
			<?php } ?>
			<?php if($view == 'docs') { ?>
				<div id="memberlite-shortcodes">
					<h3>Adding Your Logo</h3>
					<p>Use the Appearance Header Screen to add a Custom Header logo (formatted for retina display) and to toggle the display of header text and text color.</p>
					<p><a href="<?php admin_url( 'themes.php?page=custom-header'); ?>">Edit Your Custom Header &raquo</a> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; <a href="http://demo.paidmembershipspro.com/memberlite/" target="_blank">Explore Documentation on Custom Headers in MemberLite &raquo;</a></p>
					<hr />
					<h3>Customize the Theme</h3>
					<p>Use the Customize Screen to modify theme layout, logo, fonts, colors, copyright message and more.</p>
					<p><a href="<?php admin_url( 'customize.php'); ?>">Customize Your Theme &raquo;</a> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; <a href="http://demo.paidmembershipspro.com/memberlite/" target="_blank">Explore Documentation on Customizing MemberLite &raquo;</a></p>
					<hr />
					<h3>Using Child Themes</h3>
					<p>If you need to customize the theme beyond the settings in "Customize", use a child theme.</p>
					<p><a href="#" target="_blank">Download a Blank Child Theme &raquo;</a> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; <a href="http://codex.wordpress.org/Child_Themes" target="_blank">About Child Themes (WordPress Codex)  &raquo; </a></p>
					<hr />
					<h3>Shortcodes</h3>
					<p>MemberLite shortcodes enhance the appearance of your site content and can be used to  customize the display of Paid Memberships Pro-generated pages. Shortcodes are included for:</p>
					<ul class="ul-disc">
						<li>[row] and [column] for formatting text in responsive columns. <a href="http://demo.paidmembershipspro.com/memberlite/shortcodes/column-shortcodes" target="_blank">docs</a></li>
						<li>[pmprot_subpagelist] to show a list of a given pages' subpages in the order you define. <a href="http://demo.paidmembershipspro.com/memberlite/shortcodes" target="_blank">docs</a></li>
						<li>[pmprot_signup] to display a block with signup fields for a specific membership level. <a href="http://demo.paidmembershipspro.com/memberlite/shortcodes" target="_blank">docs</a></li>
						<li>[pmprot_levels] to display a block with details and a registration link for the specified membership levels. <a href="http://demo.paidmembershipspro.com/memberlite/shortcodes" target="_blank">docs</a></li>
					</ul>
					<p><a href="http://demo.paidmembershipspro.com/memberlite/shortcodes" target="_blank">View Shortcode Documentation &raquo;</a></p>
					<hr />
					<h3>Integrated Plugins</h3>
					<p>MemberLite includes formatting for use with:</p>
					<ul class="ul-disc">
						<li><strong><a href="http://www.paidmembershipspro.com" target="_blank">Paid Memberships Pro</a></strong><br /><a href="<?php admin_url( 'plugin-install.php?tab=search&s=paid+memberships+pro'); ?>">Install Plugin &raquo;</a></li>
						<li><strong><a href="http://www.woothemes.com/woocommerce/" target="_blank">WooCommerce</a></strong><br /><a href="<?php admin_url( 'plugin-install.php?tab=search&s=woocommerce'); ?>">Install Plugin &raquo;</a> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; <a href="<?php admin_url( 'plugin-install.php?tab=search&type=term&s=pmpro+woocommerce'); ?>">Install PMPro WooCommerce Addon &raquo;</a></li>						
						<li><strong><a href="http://www.bbpress.org" target="_blank">bbPress</a></strong><br /><a href="<?php admin_url( 'plugin-install.php?tab=search&s=bbpress'); ?>">Install Plugin</a> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; <a href="<?php admin_url( 'plugin-install.php?tab=search&type=term&s=pmpro+bbpress'); ?>">Install PMPro bbPress Addon &raquo;</a></li>
						<li><strong><a href="http://wp-events-plugin.com" target="_blank">Events Manager</a></strong><br /><a href="<?php admin_url( 'plugin-install.php?tab=search&s=events+manager'); ?>">Install Plugin &raquo;</a> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; <a href="<?php admin_url( 'plugin-install.php?tab=search&type=term&s=pmpro+woocommerce'); ?>">Install PMPro Addon &raquo;</a></li>						
				</div>		
			<?php } ?>
	</div><!-- /.wrap-->
<div class="clear"></div></div>
	<?php	
}