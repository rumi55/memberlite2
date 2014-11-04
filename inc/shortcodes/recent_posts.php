<?php
/**
 * Shows the recent posts in a column layout.
 *
 * @param array $args Configuration arguments.
 */
function pmprot_recent_posts_shortcode_handler($atts, $content=null, $code="") {
	global $post;
	
	// $atts    ::= array of attributes
	// $content ::= text within enclosing form of shortcode element
	// $code    ::= the shortcode found, when == callback name
	// examples: [pmprot_recent_posts title="Recent Posts" show="none" category_id="2"]
	
	extract(shortcode_atts(array(
		'title' => NULL,
		'subtitle' => NULL,
		'show' => 'excerpt',
		'category_id' => NULL
	), $atts));
			
	// our return string
	$r = '<div class="pmprot_recent_posts">';
		
	// get posts
	if(!empty($category))
		query_posts(array("post_type"=>"post", "posts_per_page"=>"3", "ignore_sticky_posts"=>true, "cat"=>$category));
  	else
		query_posts(array("post_type"=>"post", "posts_per_page"=>"3", "ignore_sticky_posts"=>true,));
	
	if(!empty($title))
		$r .= '<h1>' . $title . '</h1>';
	if(!empty($subtitle))
		$r .= '<p class="subtitle">' . $subtitle . '</p>';
	
	$r .= '<div class="row">';
	
	$count = 0;
	
	// the Loop		
	if ( have_posts() ) : while ( have_posts() ) : the_post();	
		$count++;

		$r .= '<div class="medium-4 columns">';

		$r .= '<article id="post-' . get_the_ID() . '" class="' . implode(" ", get_post_class()) . '">';

		if ( has_post_thumbnail()) 
		{
			$r .= '<a class="widget_post_thumbnail" href="' . get_permalink() . '">' . get_the_post_thumbnail($post->ID, 'mini') . '</a>';
		}
		
		$r .= '<header class="entry-header">';
		$r .= '<h4 class="entry-title">';
		$r .= '<a href="' . get_permalink() . '" rel="permalink">';
		$r .= the_title('','',false);
		$r .= '</a>';
		$r .= '</h4>';
		$r .= '<span class="post-date">' . get_the_date() . '</span>';
		
		$r .= '</header>';		

		if($show == "excerpt")
			$r .= apply_filters('the_content', get_the_excerpt( '' ));
		else
			$r .= '';
		
		$r .= '<p><a class="more-link" href="' . get_permalink() . '" rel="permalink">';
		$r .= __('Continue Reading','memberlite');
		$r .= '</a></p>';
									
		$r .= '</article>';
		$r .= '</div>';
			
	endwhile; endif;
	
	$r .= '</div><!-- .row -->';
	$r .= '</div> <!-- .pmprot_recent_posts -->';
	
	//Reset Query
	wp_reset_query();

	return $r;
}

add_shortcode('pmprot_recent_posts', 'pmprot_recent_posts_shortcode_handler');