<?php
/**
 * The template for displaying all pages.
 */

get_header(); ?>
	<div id="main" class="container ds5">
		<div id="bcContainer">
		<?php 
			the_breadcrumb(); 
		?>
		</div>
		<div class="row clearfix">			
			
			<div id="mainContent" class="clearfix generalTemplate">
				<?php get_sidebar('gleft'); ?>
			
				<div id="rightSec" class="span6 pull-left">
					<section id="primary">
						
						<div id="content" role="main">

						<?php if ( have_posts() ) : ?>

							<header class="page-header">
								<h1 class="page-title"><?php
									printf( __( 'Category Archives: %s', 'nhcoa' ), '<span>' . single_cat_title( '', false ) . '</span>' );
								?></h1>

								<?php
									$category_description = category_description();
									if ( ! empty( $category_description ) )
										echo apply_filters( 'category_archive_meta', '<div class="category-archive-meta">' . $category_description . '</div>' );
								?>
							</header>

							<?php /* Start the Loop */ ?>
							<?php while ( have_posts() ) : the_post(); ?>

								<?php
									/* Include the Post-Format-specific template for the content.
									 * If you want to overload this in a child theme then include a file
									 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
									 */
									get_template_part( 'content', 'compact');
								?>

							<?php endwhile; ?>
							<div id="footPagi" class="pagination pagination-centered">
							<?php paginate();?>
							</div>

						<?php else : ?>

							<article id="post-0" class="post no-results not-found">
								<header class="entry-header">
									<h1 class="entry-title"><?php _e( 'Nothing Found', 'nhcoa' ); ?></h1>
								</header><!-- .entry-header -->

								<div class="entry-content">
									<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'nhcoa' ); ?></p>
									<?php get_search_form(); ?>
								</div><!-- .entry-content -->
							</article><!-- #post-0 -->

						<?php endif; ?>

						</div><!-- #content -->
					</section><!-- #primary -->			
				</div>
				<?php get_sidebar('gright'); ?>
				
			</div>
			
			
		</div>
		
		<div id="mainBottom" class="row">
			<?php get_sidebar('gbottom'); ?>
		</div>
		
	</div><!-- #main -->
<?php get_footer(); ?>