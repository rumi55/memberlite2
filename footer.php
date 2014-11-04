<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Member Lite 2.0
 */
?>
		<?php if(!is_front_page() || !is_page_template('templates/fluid-width.php')) { ?></div><!-- .row --><?php } ?>
	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="footer-widgets">
 			<div class="row">
					<?php dynamic_sidebar('sidebar-4');	?>
			</div><!-- .row -->
		</div><!-- .footer-widgets -->
		<nav id="footer-navigation">
			<?php 
				$footer_defaults = array(
					'theme_location' => 'footer',
					'container' => 'div',
					'container_class' => 'footer-navigation row',
					'menu_class' => 'menu large-12 columns',
					'fallback_cb' => false,					
				);				
				wp_nav_menu($footer_defaults); 				
			?>
		</nav><!-- #footer-navigation -->
		<div class="row site-info">
			<div class="large-12 columns">				
				<?php 
					$copyright_textbox = get_theme_mod( 'copyright_textbox' ); 
					if ( ! empty( $copyright_textbox ) ) 
					{
						echo wpautop($copyright_textbox); 
					}				
				?>
			</div><!-- .columns -->
		</div><!-- .row, .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
