<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Member Lite 2.0
 */

/*
if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
*/
?>

<div id="secondary" class="column4 widget-area" role="complementary">
<?php 
	if (is_404() || is_home() || is_search() || is_single() || is_category() || is_author() || is_archive() || is_day() || is_month() || is_year() ) 
	{
		//Sidebar for Posts and Archives
		dynamic_sidebar('sidebar-2');	
	}
	
	if(is_page())
	{
		global $post, $hidechildren;
		if(!$hidechildren)
		{
			if($post->post_parent) 
			{
				$exclude = get_post_meta($post->ID,'exclude',true);
				$pagemenuid = end($post->ancestors);
				$children = wp_list_pages('title_li=&child_of=' . $pagemenuid . '&exclude=' . $exclude . '&echo=0&sort_column=menu_order');
				$titlenamer = get_the_title($pagemenuid);
				$titlelink = get_permalink($pagemenuid);
			}
			else 
			{
				$exclude = "";
				$children = wp_list_pages('title_li=&child_of=' . $post->ID . '&exclude=' . $exclude . '&echo=0&sort_column=menu_order');
				$titlenamer = get_the_title($post->ID);
				$titlelink = get_permalink($post->ID);
			}
			if($children) 
			{ ?>
				<aside id="nav_menu-submenu" class="widget widget_nav_menu">
					<h3 class="widget-title"><a<?php if(is_page($pagemenuid)) { ?> class="active"<?php } ?> href="<?php echo $titlelink?>"><?php echo $titlenamer?></a></h3>
					<ul class="menu">
						<?php echo $children; ?>
					</ul>
				</aside> <!-- end widget -->
			<?php
			}						
		}

		//Sidebar for Non-template Pages
		dynamic_sidebar('sidebar-1');
	}
?>
</div><!-- #secondary -->
