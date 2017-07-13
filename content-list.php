<?php
/**
 * The default template for displaying page content
 */
?>

	<article id="post-<?php the_ID(); ?>" class="entry-list">
		<div class="entry-thumb pull-left thumbnail">
			<?php if(has_post_thumbnail()){ ?>				
				<?php the_post_thumbnail('entry-thumb'); ?>
			<?php } ?>
		</div>
		<header class="entry-header">
			<?php if ( is_sticky() ) { ?>
				<hgroup>
					<h2 class="entry-title"><a href="<?php the_permalink();?>" title="<?php printf( esc_attr__( '%s haberini göster', 'daka' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
					<h3 class="entry-format"><?php _e( 'Featured', 'daka' ); ?></h3>
				</hgroup>
			<?php } else{?>
			<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( '%s  haberini göster', 'daka' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
			<?php }?>			
		</header><!-- .entry-header -->
		
		<div class="entry-content clearfix">
			<?php the_excerpt( __( '<span class="meta-nav">Devami Oku &rarr;</span>', 'gkd' ) ); ?>
			<a class="readmore pull-right" href="<?php the_permalink();?>" title="Devami okumak için tiklayiniz"><span class="badge">Devam &rarr;</span></a>
		</div>		
	</article>