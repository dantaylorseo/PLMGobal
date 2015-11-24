<?php get_header(); ?>
<div id="breadcrumbs" class="container-fluid">
	<div id="breadcrumbsinner" class="container">
		<?php if ( function_exists('yoast_breadcrumb') ) {
            $breadcrumbs = yoast_breadcrumb( '<ol class="breadcrumb"><li>', '</li></ul>', false );
            echo str_replace( array( '|', '/%category%' ), array( '</li><li>', '' ), $breadcrumbs );
        } ?>
	</div>
</div>
<section id="content" class="container-fluid">
	
	<?php
		$i = 0; 
		if( have_posts() ) : while( have_posts() ): the_post() 
	?>
	<div class="article container-fluid <?php echo( $i == 1 ? 'alt' : '' ); ?>">
		<div class="container">
			<article class="media">
				<?php if ( has_post_thumbnail() ) { ?>
				<div class="media-left"> 
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'thumbnail', array( 'class' => 'media-object' ) ); ?></a>
				</div>
				<?php } ?>
				<div class="media-body">
					<h2 class="media-heading"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<?php tailored_post_meta(); ?>
					<?php the_excerpt(); ?>
				</div>
			</article>
		</div>
	</div>
	<?php 
		if( $i == 0 ) {
			$i ++;
		} else {
			$i =0;
		}
		endwhile; endif; 
	?>
	<div class="container">
		<?php wp_pagenavi(); ?>
	</div>
</section>
<?php get_footer(); ?>
