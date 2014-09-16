<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Member Lite 2.0
 */
?>
		<?php if(!is_front_page() || !is_page_template('templates/fluid-width.php')) { ?></div></div><!-- .row, .container12 --><?php } ?>
	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="footer-widgets">
			<div class="container12">
				<div class="row">
					<div class="footer-widgets">
						<?php dynamic_sidebar('sidebar-4');	?>
					</div>
				</div><!-- .row -->
			</div><!-- .container12 -->
		</div><!-- .footer-widgets -->
		<div class="container12">
			<div class="row">
				<div class="column12 site-info">
					<?php 
						$copyright_textbox = get_theme_mod( 'copyright_textbox' ); 
						if ( ! empty( $copyright_textbox ) ) 
						{
							echo wpautop($copyright_textbox); 
						}				
					?>
				</div><!-- .site-info -->
			</div><!-- .row -->
		</div><!-- .container12 -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
