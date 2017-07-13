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
			<div id="mainContent" class="clearfix pageTemplate">
			
				<div id="contentArea" class="span12 pull-left">
					<div id="primary">
						<div id="content" role="main">
							<?php while ( have_posts() ) : the_post(); ?>

								<?php get_template_part( 'content', 'page' ); ?>

								<?php 					
									//comments_template( '', true ); 					
								?>

							<?php endwhile; // end of the loop. ?>

						</div><!-- #content -->
					</div><!-- #primary -->
				</div>
			</div>
		</div>
		
		<div id="mainBottom" class="row">
			<?php get_sidebar('gbottom'); ?>
		</div>
		
	</div><!-- #main -->
<?php get_footer(); ?>