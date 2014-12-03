<?php
/**
Template Name: Interstitial Page
**/

get_header(); ?>

	<div id="primary" class="large-12 columns content-area">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content-interstitial', 'page' ); ?>
				
			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
