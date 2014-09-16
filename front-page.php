<?php
/**
 * The template for the home page.
 *
 * @package Member Lite 2.0
 */

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>
	
	<header class="masthead">
		<div class="container12">
			<div class="row">
				<div class="column12">
					<?php
						global $more;
						$more = 0;
						the_content('');
						//echo apply_filters('the_content',get_the_content());
					?>
				</div>
			</div><!-- .row -->
		</div>
	</header><!-- .masthead -->
	<div class="container12">
		<div class="row">
			<div id="primary" class="column12 content-area">
				<main id="main" class="site-main" role="main">
		
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>	
							<div class="entry-content">
								<?php 
									global $more;    // Declare global $more (before the loop).
									$more = 1;       // Set (inside the loop) to display content above the more tag.				
									echo get_the_content_after_more();
								?>
								
								<?php
									wp_link_pages( array(
										'before' => '<div class="page-links">' . __( 'Pages:', 'memberlite2' ),
										'after'  => '</div>',
									) );
								?>
							</div><!-- .entry-content -->
							<footer class="entry-footer">
								<?php edit_post_link( __( 'Edit', 'memberlite2' ), '<span class="edit-link">', '</span>' ); ?>
							</footer><!-- .entry-footer -->
						</article><!-- #post-## -->
		
				</main><!-- #main -->
			</div><!-- #primary -->
		</div>
	</div>
	
	<?php endwhile; // end of the loop. ?>
	
<?php get_footer(); ?>
