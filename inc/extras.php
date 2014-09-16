<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Member Lite 2.0
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @param array $args Configuration arguments.
 * @return array
 */
function memberlite2_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'memberlite2_page_menu_args' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function memberlite2_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	global $post;
	$classes[] = get_theme_mod('sidebar_location');
	$classes[] = get_theme_mod('sidebar_location_blog');
	if ( is_page_template( 'templates/sidebar-content.php' ) )
		$classes[] = 'sidebar-content';
	if ( is_page_template( 'templates/content-sidebar.php' ) )
		$classes[] = 'content-sidebar';
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}
	return $classes;
}
add_filter( 'body_class', 'memberlite2_body_classes' );

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function memberlite2_wp_title( $title, $sep ) {
	if ( is_feed() ) {
		return $title;
	}

	global $page, $paged;

	// Add the blog name
	$title .= get_bloginfo( 'name', 'display' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " $sep $site_description";
	}

	// Add a page number if necessary:
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
		$title .= " $sep " . sprintf( __( 'Page %s', 'memberlite2' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'memberlite2_wp_title', 10, 2 );

/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function memberlite2_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}
add_action( 'wp', 'memberlite2_setup_author' );

/**
 * Get the width of a thumbnail.
 *
 */
function memberlite2_getPostThumbnailWidth($post_id = NULL)
{
	//get thumbnail from post_id
	$attachment_id = get_post_thumbnail_id($post_id);	
	if(empty($attachment_id))
		return false;	//no thumbnail
		
	//get attachment src, width, and height
	$attachment = wp_get_attachment_image_src($attachment_id, "full");
	
	//make sure width is there
	if(is_array($attachment) && !empty($attachment[1]))
		return $attachment[1];
	else
		return false;	
}


/**
 * The Read More link
 *
 *
 */
function new_excerpt_more( $more ) {
	return '...';
}
add_filter( 'excerpt_more', 'new_excerpt_more' );

/**
 * Some content filters for excerpts on pages - used in Theme Templates
 *
 *
 */
function get_the_content_after_more($content = NULL)
{
	if($content === NULL)
		$content = get_the_content();
	$moretag = preg_match("/\<span id=\"more-[0-9]*\"\>\<\/span\>/", $content, $matches);
	if(!$moretag)
		$moretag = preg_match("/(\<\!\-\-more\-\-\>)/", $content, $matches);
	if($moretag)
	{
		$morespan = $matches[0];
		$morespan_pos = strpos($content, $morespan);
		$newcontent = substr($content, $morespan_pos + strlen($morespan), strlen($content) - strlen($morespan));
		$newcontent = apply_filters('the_content', $newcontent);
		return $newcontent;
	}
	else
		return "";
}

function get_the_content_before_more($content = NULL)
{
	if($content === NULL)
		$content = get_the_content();
			
	$moretag = preg_match("/\<span id=\"more-[0-9]*\"\>\<\/span\>/", $content, $matches);
	if(!$moretag)
		$moretag = preg_match("/(\<\!\-\-more\-\-\>)/", $content, $matches);
	if($moretag)
	{				
		$morespan = $matches[0];
		$morespan_pos = strpos($content, $morespan);
		$newcontent = substr($content, 0, $morespan_pos);
		$newcontent = apply_filters('the_content', $newcontent);
		return $newcontent;
	}
	else
		return $content;
}

function memberlite2_page_title() {
	global $post; 
	if(is_woocommerce())
	{
		woocommerce_breadcrumb();
		?>
		<h1 class="page-title">
		<?php
			if(is_archive())
				single_cat_title(); 
			else
				the_title();
		?>
		</h1>
			<?php
			// Show an optional term description.
			$term_description = woocommerce_product_archive_description();
			if ( ! empty( $term_description ) ) :
				printf( '<div class="taxonomy-description">%s</div>', $term_description );
			endif;	
			woocommerce_taxonomy_archive_description();
	}
	elseif(is_author() || is_tag() || is_archive())
	{
		?>
			<h1 class="page-title">
			<?php
				if ( is_category() ) :
					single_cat_title();
	
				elseif ( is_tag() ) :
					$current_tag = single_tag_title("", false);
					printf( __( 'Posts Tagged: %s', 'memberlite2' ), '<span>' . $current_tag . '</span>' );
	
				elseif ( is_author() ) :
					printf( __( 'Author: %s', 'memberlite2' ), '<span class="vcard">' . get_the_author() . '</span>' );
	
				elseif ( is_day() ) :
					printf( __( 'Day: %s', 'memberlite2' ), '<span>' . get_the_date() . '</span>' );
	
				elseif ( is_month() ) :
					printf( __( 'Month: %s', 'memberlite2' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'memberlite2' ) ) . '</span>' );
	
				elseif ( is_year() ) :
					printf( __( 'Year: %s', 'memberlite2' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'memberlite2' ) ) . '</span>' );
	
				elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
					_e( 'Asides', 'memberlite2' );
	
				elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
					_e( 'Galleries', 'memberlite2' );
	
				elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
					_e( 'Images', 'memberlite2' );
	
				elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
					_e( 'Videos', 'memberlite2' );
	
				elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
					_e( 'Quotes', 'memberlite2' );
	
				elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
					_e( 'Links', 'memberlite2' );
	
				elseif ( is_tax( 'post_format', 'post-format-status' ) ) :
					_e( 'Statuses', 'memberlite2' );
	
				elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
					_e( 'Audios', 'memberlite2' );
	
				elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :
					_e( 'Chats', 'memberlite2' );
	
				else :
					_e( 'Archives', 'memberlite2' );
	
				endif;
			?>
		</h1>
		<?php
			// Show an optional term description.
			$term_description = term_description();
			if ( ! empty( $term_description ) ) :
				printf( '<div class="taxonomy-description">%s</div>', $term_description );
			endif;			
	}
	elseif(is_search())
	{
		?>
		<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'memberlite2' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
		<?php
	}
	elseif(is_singular('post'))
	{
		$author_id = $post->post_author;
		?>
		<div class="masthead-post-byline">
			<div class="post_author_avatar"><?php echo get_avatar( $author_id, 80 ); ?></div>
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			<p class="entry-meta">
				<?php memberlite2_posted_on($post); ?>
			</p><!-- .entry-meta -->
		</div>
		<?php
	}
	elseif(is_home())
	{
		?>
		<h1 class="page-title"><?php echo get_the_title(get_option('page_for_posts')); ?></h1>
		<?php
	}
	elseif(is_page_template('templates/landing-page.php'))
	{
		global $landing_page_level, $checkout_button;
		$level = pmpro_getLevel($landing_page_level);
		the_post_thumbnail( 'medium', array( 'class' => 'alignleft' ) );
		the_title( '<h1 class="entry-title">', '</h1>' );
		echo '<p class="pmpro_level-price">' . pmprot_getLevelCost($level, true, true) . '</p>';
		echo wpautop($level->description);
		?>
		<a class="pmpro_btn pmpro_btn-select" href="<?php echo pmpro_url("checkout", "?level=" . $level->id, "https")?>"><?php echo $checkout_button; ?></a>
		<?php
	}
	else
	{
		the_title( '<h1 class="entry-title">', '</h1>' );
	}
}

remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description' );
remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description' );
add_filter('woocommerce_show_page_title',false);

function pmprot_getLevelCost(&$level, $tags = true, $short = false)
{
	global $pmpro_currency_symbol;
	//initial payment
	if(empty($short))
		$r = sprintf(__('The price for membership is <strong>%s</strong> now', 'pmpro'), $pmpro_currency_symbol . number_format($level->initial_payment, 2));
	elseif(pmpro_isLevelFree($level))
		$r = sprintf(__('<strong>FREE</strong>', 'pmpro'));
	else
		$r = sprintf(__('<strong>%s</strong>', 'pmpro'), $pmpro_currency_symbol . number_format($level->initial_payment, 2));
			
	//recurring part
	if($level->billing_amount != '0.00')
	{
		if($level->billing_limit > 1)
		{			
			if($level->cycle_number == '1')
			{
				$r .= sprintf(__(' and then <strong>%s per %s for %d more %s</strong>.', 'pmpro'), $pmpro_currency_symbol . $level->billing_amount, pmpro_translate_billing_period($level->cycle_period), $level->billing_limit, pmpro_translate_billing_period($level->cycle_period, $level->billing_limit));
			}				
			else
			{ 
				$r .= sprintf(__(' and then <strong>%s every %d %s for %d more %s</strong>.', 'pmpro'), $pmpro_currency_symbol . $level->billing_amount, $level->cycle_number, pmpro_translate_billing_period($level->cycle_period, $level->cycle_number), $level->billing_limit, pmpro_translate_billing_period($level->cycle_period, $level->billing_limit));
			}
		}
		elseif($level->billing_limit == 1)
		{
			$r .= sprintf(__(' and then <strong>%s after %d %s</strong>.', 'pmpro'), $pmpro_currency_symbol . $level->billing_amount, $level->cycle_number, pmpro_translate_billing_period($level->cycle_period, $level->cycle_number));
		}
		else
		{
			if( $level->billing_amount === $level->initial_payment ) {
				if($level->cycle_number == '1')
				{
					if(empty($short))
					{
						$r = sprintf(__('The price for membership is <strong>%s per %s</strong>.', 'pmpro'), $pmpro_currency_symbol . number_format($level->initial_payment, 2), pmpro_translate_billing_period($level->cycle_period) );
					}
					else
					{
						$r = sprintf(__('<strong>%s/%s</strong>', 'pmpro'), $pmpro_currency_symbol . number_format($level->initial_payment, 2), pmpro_translate_billing_period($level->cycle_period) );
					}
				}
				else
				{
					if(empty($short))
					{
						$r = sprintf(__('The price for membership is <strong>%s every %d %s</strong>.', 'pmpro'), $pmpro_currency_symbol . number_format($level->initial_payment, 2), $level->cycle_number, pmpro_translate_billing_period($level->cycle_period, $level->cycle_number) );
					}
					else
					{
						$r = sprintf(__('<strong>%s every %d %s</strong>.', 'pmpro'), $pmpro_currency_symbol . number_format($level->initial_payment, 2), $level->cycle_number, pmpro_translate_billing_period($level->cycle_period, $level->cycle_number) );
					}
				}
			} else {
				$r .= '<span class="pmpro_level-subprice">';
				if($level->cycle_number == '1')
				{
					if(empty($short))
					{
						$r .= sprintf(__(' and then <strong>%s per %s</strong>.', 'pmpro'), $pmpro_currency_symbol . $level->billing_amount, pmpro_translate_billing_period($level->cycle_period));
					}
					else
					{
						$r .= sprintf(__('then <strong>%s/%s</strong>', 'pmpro'), $pmpro_currency_symbol . $level->billing_amount, pmpro_translate_billing_period($level->cycle_period));
					}
				}
				else
				{
					$r .= sprintf(__(' and then <strong>%s every %d %s</strong>.', 'pmpro'), $pmpro_currency_symbol . $level->billing_amount, $level->cycle_number, pmpro_translate_billing_period($level->cycle_period, $level->cycle_number));
				}
				$r .= '</span>';
			}
		}
	}

	//add a space
	$r .= ' ';
	
	//trial part
	if($level->trial_limit)
	{
		if($level->trial_amount == '0.00')
		{
			if($level->trial_limit == '1')
			{
				$r .= ' ' . __('After your initial payment, your first payment is Free.', 'pmpro');
			}
			else
			{
				$r .= ' ' . sprintf(__('After your initial payment, your first %d payments are Free.', 'pmpro'), $level->trial_limit);
			}
		}
		else
		{
			if($level->trial_limit == '1')
			{
				$r .= ' ' . sprintf(__('After your initial payment, your first payment will cost %s.', 'pmpro'), $pmpro_currency_symbol . $level->trial_amount);
			}
			else
			{
				$r .= ' ' . sprintf(__('After your initial payment, your first %d payments will cost %s.', 'pmpro'), $level->trial_limit, $pmpro_currency_symbol . $level->trial_amount);
			}
		}
	}
				
	//taxes part
	$tax_state = pmpro_getOption("tax_state");
	$tax_rate = pmpro_getOption("tax_rate");
	
	if($tax_state && $tax_rate && !pmpro_isLevelFree($level))
	{
		$r .= sprintf(__('Customers in %s will be charged %s%% tax.', 'pmpro'), $tax_state, round($tax_rate * 100, 2));			
	}
	
	if(!$tags)
		$r = strip_tags($r);
	
	$r = apply_filters("pmpro_level_cost_text", $r, $level);		
	return $r;
}

function pmprot_getLevelLandingPage($level_id) {
	if(is_object($level_id))
		$level_id = $level_id->id;
	
	$args = array(
		'post_type' => apply_filters('pmprot_level_landing_page_post_types', array('page', 'post')),
		'meta_query' => array(
			array(
				'key' => 'landing_page_level',
				'value' => $level_id,
			)
		)
	);
	
	$posts = get_posts($args);
	
	if(empty($posts))
		return false;
	else
		return $posts[0];
}