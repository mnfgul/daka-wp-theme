<?php
/**
 * The template for displaying all pages.
 */

get_header(); ?>
	
	<div id="main" class="container">
		<div id="mainContent" class="row">
			<div id="leftSec" class="span8 mainBox">
			
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
			
            <div id="rightSec" class="span4">
                <div class="mainBox">
                    <div class="boxHeader">
                        <h2>Etkinlik Takvimi</h2>
                    </div>
                    <div class="boxContent">
                        <?php get_sidebar(); ?>
                    </div>                    
                </div>
                <div class="boxFoot"></div>
                
                <div class="mainBox">
                    <div class="boxHeader">
                        <h2>Foto Galeri</h2>
                    </div>
                    <div class="boxContent">
                        <?php
                        $args = array( 'post_type' => 'page', 'page_id' => 257);
                        $loop = new WP_Query( $args );
                        while ( $loop->have_posts() )
                        {
                            $loop->the_post();
                            echo the_content();
                        }
                        ?> 
                    </div>
                </div>                
                <div class="boxFoot"></div>
            </div>
			
		</div>		
	</div><!-- #main -->
<?php get_footer(); ?>