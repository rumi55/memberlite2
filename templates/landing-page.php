<?php
/**
Template Name: Landing Page
**/
$landing_page_level = get_post_meta($post->ID,'landing_page_level',true);
$landing_page_upsell = get_post_meta($post->ID,'landing_page_upsell',true);
$checkout_button = get_post_meta($post->ID,'landing_page_checkout_button',true);
$before_sidebar = get_post_meta($post->ID,'before_sidebar',true);

if(empty($checkout_button))
	$checkout_button = 'Select';	
get_header(); ?>

	<div id="primary" class="column8 content-area">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content-landing', 'page' ); ?>
			
			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<div id="secondary" class="column4 widget-area" role="complementary">
		<?php
			if(!empty($before_sidebar)) 
			{ 
				echo apply_filters('the_content',$before_sidebar); 
			}
			else
			{
				echo do_shortcode('[pmprot_signup level="' . $landing_page_level . '" short="true" title="Sign Up Now"]'); 
			}
		?>
	</div>
	
	<?php if(!empty($landing_page_upsell)) { ?>
				
		<hr />
				
		<div class="column12">			
			<?php 
				if(is_numeric($landing_page_upsell))
					echo do_shortcode('[pmprot_levels levels="' . intval($landing_page_upsell) . '"]');
				else
					echo apply_filters('the_content', $landing_page_upsell);
			?>
		</div>
	<?php } ?>
	
<?php get_footer(); ?>
