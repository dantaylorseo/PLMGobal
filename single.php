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
		if( have_posts() ) : while( have_posts() ): the_post() 
	?>
	<div class="article container-fluid <?php echo( $i == 1 ? 'alt' : '' ); ?>">
		<div class="container">
			<article class="media">
				<?php if ( has_post_thumbnail() ) { ?>
				<div class="media-left"> 
					<?php the_post_thumbnail( 'thumbnail', array( 'class' => 'media-object' ) ); ?>
				</div>
				<?php } ?>
				<div class="media-body">
					<h1 class="media-heading"><?php the_title(); ?></h1>
					<?php tailored_post_meta(); ?>
					<?php the_content(); ?>
					<?php comments_template(); ?>
				</div>
			</article>
		</div>
	</div>
	<?php 
		endwhile; endif; 
	?>
</section>
<?php get_footer(); ?>
