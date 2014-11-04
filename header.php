<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Member Lite 2.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<nav id="mobile-navigation" class="mobile-navigation" role="navigation">
		<?php dynamic_sidebar('sidebar-5'); ?>	
	</nav>
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'memberlite' ); ?></a>
    <header id="masthead" class="site-header" role="banner">
		<div class="row">
			<div class="medium-4 columns site-branding">
				<button class="menu-toggle"><i class="fa fa-bars"></i></button>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<span class="site-description"><?php bloginfo( 'description' ); ?></span>
			</div><!-- .column4 -->
			<div class="medium-8 columns header-right">
				<div id="meta-member">
					<aside class="widget">
					<?php 
						global $current_user, $pmpro_pages;
						if($user_ID)
						{ 
							?>				
							<span class="user">Welcome, <?php echo preg_replace("/\@.*/", "", $current_user->display_name)?></span>
							<?php
								if(!empty($pmpro_pages))
								{
									$account_page = get_post($pmpro_pages['account']);
									?>
									<a href="<?php echo pmpro_url("account"); ?>"><?php echo $account_page->post_title; ?></a>
									<?php
								}
								else
								{
									?>
									<a href="<?php echo admin_url("profile.php"); ?>"><?php _e( 'Profile', 'memberlite' ); ?></a>
									<?php
								}
							?>
							<a href="<?php echo wp_logout_url( ); ?>"><?php _e( 'Log Out', 'memberlite' ); ?></a>
							<?php 
						} 
						else 
						{ 
							?>
							<a href="<?php echo wp_login_url(); ?>"><?php _e( 'Log In', 'memberlite' ); ?></a>
							<a href="<?php echo wp_registration_url(); ?>"><?php _e( 'Register', 'memberlite' ); ?></a>
							<?php
						} 
					?>
					</aside>
				</div><!-- #meta-member -->
				<?php 	
					$meta_defaults = array(
						'theme_location' => 'meta',
						'container' => 'nav',
						'container_id' => 'meta-navigation',
						'container_class' => 'meta-navigation',
						'fallback_cb' => false
					);					
					wp_nav_menu( $meta_defaults ); 
				?>
				<?php dynamic_sidebar('sidebar-3'); ?>
			</div><!-- .column8 -->
		</div><!-- .row -->
	</header><!-- #masthead -->
	<nav id="site-navigation">
	<?php 
		$primary_defaults = array(
			'theme_location' => 'primary',
			'container' => 'div',
			'container_class' => 'main-navigation row',
			'menu_class' => 'menu large-12 columns',
			'fallback_cb' => false,					
		);				
		wp_nav_menu($primary_defaults); 				
	?>
	</nav><!-- #site-navigation -->
	<div id="content" class="site-content">
		<?php if(!is_front_page()) { ?>
            <?php		
                global $post;
                if((is_singular('post') || (is_page()) && !is_page_template( 'templates/landing-page.php' )) && memberlite_getPostThumbnailWidth($post->ID) > '740')
                {
                    //get src of thumbnail
                    $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');			
                    ?>
                    <div class="masthead-banner" style="background-image: url('<?php echo esc_attr($thumbnail[0]);?>');">
                    <?php
                }
            ?>
            <header class="masthead">
				<div class="row">
					<div class="large-12 columns">
						<?php memberlite_page_title(); ?>
					</div>
				</div><!-- .row -->
			</header><!-- .masthead -->
            <?php
                if((is_singular('post') || (is_page()) && !is_page_template( 'templates/landing-page.php' )) && memberlite_getPostThumbnailWidth($post->ID) > '740')
                {
                    ?>
                    </div> <!-- .masthead-banner -->
                    <?php
                }
            ?>
			<?php if(!is_page_template( 'templates/fluid-width.php' )) { ?>
				<div class="row">
			<?php } ?>
		<?php } ?>
	