<?php
/**
 * The default template for displaying page content
 */
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="pg-header">
			<h1 class="pg-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'daka' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
		</header><!-- .entry-header -->
		<div class="pg-content">
			<?php the_content( __( 'Devamı Oku <span class="meta-nav">&rarr;</span>', 'daka' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Sayfalar:', 'daka' ) . '</span>', 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->	
		<footer class="pg-foot">
			<?php if (function_exists('sharethis_button')) { sharethis_button(); } ?>
		</footer><!-- #entry-meta -->
	</article>