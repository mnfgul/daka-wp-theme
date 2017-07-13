<?php
/**
 * The main template file.
 */

get_header(); ?>
	
	<div id="banner" class="container ds5">
		<div id="bannerInnerShadow">
			<div id="topBanner" class="carousel">
				<!-- Carousel items -->
				<div class="carousel-inner">
					<?php
						$args = array( 'post_type' => 'page', 'post_parent' => '78', 'order_by' => 'menu_order', 'order' => 'ASC');
						$loop = new WP_Query( $args );
						$i = 1;
						while ( $loop->have_posts() ) : $loop->the_post();
						?>
						<div class="<?php if($i==1) echo 'active'?> item">
							<?php the_post_thumbnail( 'banner-full');?>
							<div class="carousel-caption">
								<h4 class="bannerTitle"><?php the_title();?></h4>
								<div class="bannerText"><?php echo get_the_content();?></div>
							</div>
						</div>
					<?php
							$i++;
						endwhile;								
					?>					
				</div>
				<!-- Carousel nav -->
				<a class="carousel-control left" href="#topBanner" data-slide="prev">&lsaquo;</a>
				<a class="carousel-control right" href="#topBanner" data-slide="next">&rsaquo;</a>
			</div>		
			
			<div id="bannerBtns" class="clearfix visible-desktop">
				<span id="bannerBtnTxt"></span>
				<a href="#" class="bannerBtn" id="btn1"></a>
				<a href="#" class="bannerBtn" id="btn2"></a>
				<a href="#" class="bannerBtn" id="btn3"></a>
				<a href="#" class="bannerBtn" id="btn4"></a>
				<a href="#" class="bannerBtn" id="btn5"></a>
				<a href="#" class="bannerBtn" id="btn6"></a>
				<a href="#" class="bannerBtn" id="btn7"></a>
			</div>					
		</div>
	</div>
	<div id="bannerShadow" class="container"></div>	
	
	<div id="main" class="container">
		<div id="mainContent" class="row">
			<div id="leftSec" class="span8 mainBox">
				<div class="boxHeader">
					<h2>Haberler/Duyurular</h2>
				</div>				
				<div class="boxContent">
					<?php 
						$args = array(
						'cat' => '3',
						'orderby' => 'date',
						'posts_per_page' => 5,
						'order' => 'DESC'
						);
						query_posts($args);
						
						while ( have_posts() ) : 
							the_post();
							get_template_part( 'content', 'list');					
						endwhile;
						
						// Reset Query
						wp_reset_query();
					?>
				</div>
				<div class="boxFoot">
				
				</div>
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