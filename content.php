<?php
/**
 * The default template for displaying content
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<?php if ( is_sticky() ) { ?>
				<hgroup>
					<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyeleven' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
					<h3 class="entry-format"><?php _e( 'Featured', 'twentyeleven' ); ?></h3>
				</hgroup>
			<?php } else {?>
			<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyeleven' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
			<div class="entry-meta clearfix">
				<?php $show_sep = false; ?>
				<?php 
				// Hide category and tag text for pages on Search
				if ( 'post' == get_post_type() ) 
				{
					/* translators: used between list items, there is a space after the comma */
					$categories_list = get_the_category_list( __( ', ', 'nhcoa' ) );
					if ( $categories_list )
					{
					?>
						<span class="meta-sec cats">
							<?php printf( __( '<span class="%1$s">Posted in</span> %2$s', 'nhcoa' ), 'entry-utility-prep entry-utility-prep-cat-links', $categories_list );
							$show_sep = true; ?>
						</span>
					<?php 
					} // End if categories
					/* translators: used between list items, there is a space after the comma */
				}?>
				<span class="sep"> | </span>
				<span class="meta-sec pub-date"><?php the_time('F j, Y');?></span>
			</div>
			<?php } ?>

		</header><!-- .entry-header -->

		<?php if ( is_search() ) : // Only display Excerpts for Search ?>
		<div class="entry-summary clearfix">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="entry-content clearfix">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentyeleven' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'twentyeleven' ) . '</span>', 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->
		<?php endif; ?>
		<div class="meta-tags">
			<?php
			$tags_list = get_the_tag_list( '', __( '', 'nhcoa' ) );
			if ( $tags_list )
			{
			?>
				<span class="tags">
					<?php printf( __( '<b><span class="%1$s">Tags:</span></b> %2$s', 'nhcoa' ), 'entry-utility-prep tagitem entry-utility-prep-tag-links', $tags_list );  ?>
				</span>
			<?php
			}
			?>
		</div>
		<footer class="entry-meta-share">
			<?php if (function_exists('sharethis_button')) { sharethis_button(); } ?>
		</footer><!-- #entry-meta -->
	</article>