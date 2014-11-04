<?php
/**
 * The template for displaying forum pages.
 *
 * @package Member Lite 2.0
 */

get_header(); ?>

	<div id="primary" class="<?php if(bbp_is_single_user()) { ?>medium-12<?php } else { ?>medium-8<?php } ?> columns content-area">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>
				
			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php if(!bbp_is_single_user()) { ?><?php get_sidebar(); ?><?php } ?>
<?php get_footer(); ?>
