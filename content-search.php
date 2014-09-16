<?php
/**
 * The template part for displaying results in search pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Member Lite 2.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php		
		if(memberlite2_getPostThumbnailWidth($post->ID) > '740')
		{
			//get src of thumbnail
			$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'banner');			
			?>
			<div class="entry-banner" style="background-image: url('<?php echo esc_attr($thumbnail[0]);?>');">
			<?php
		}
		else
		{
			?>
			<?php the_post_thumbnail( 'thumbnail', array( 'class' => 'alignright' ) );
		}
	?>
		<header class="entry-header">
			<?php if ( 'post' == get_post_type() ) : ?>
				<?php $author_id = $post->post_author; ?>
				<div class="post_author_avatar"><?php echo get_avatar( $author_id, 80 ); ?></div>
			<?php endif; ?>
			<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
			<?php if ( 'post' == get_post_type() ) : ?>
			<div class="entry-meta">
				<?php memberlite2_posted_on(); ?>
			</div><!-- .entry-meta -->
			<?php endif; ?>
		</header><!-- .entry-header -->
	<?php		
		if(memberlite2_getPostThumbnailWidth($post->ID) > '740')
		{
			?>
			</div> <!-- .entry-banner -->
			<?php
		}
	?>

	<div class="entry-summary">
		<?php the_excerpt(); ?>
		<div class="clear"></div>
	</div><!-- .entry-summary -->

	<footer class="entry-footer">
		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( __( ', ', 'memberlite2' ) );
				if ( $categories_list && memberlite2_categorized_blog() ) :
			?>
			<span class="cat-links">
				<?php printf( __( 'Posted in %1$s.', 'memberlite2' ), $categories_list ); ?>
			</span>
			<?php endif; // End if categories ?>

			<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', __( ', ', 'memberlite2' ) );
				if ( $tags_list ) :
			?>
			<span class="tags-links">
				<?php printf( __( 'Tagged %1$s.', 'memberlite2' ), $tags_list ); ?>
			</span>
			<?php endif; // End if $tags_list ?>
		<?php endif; // End if 'post' == get_post_type() ?>

		<?php if ( 'post' == get_post_type() && ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
		<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment.', 'memberlite2' ), __( '1 Comment.', 'memberlite2' ), __( '% Comments.', 'memberlite2' ) ); ?></span>
		<?php endif; ?>

		<?php edit_post_link( __( 'Edit', 'memberlite2' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
