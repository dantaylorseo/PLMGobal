<?php get_header(); ?>
<div id="breadcrumbs" class="container-fluid">
	<div id="breadcrumbsinner" class="container">
		<?php if ( function_exists('yoast_breadcrumb') ) {
            $breadcrumbs = yoast_breadcrumb( '<ol class="breadcrumb"><li>', '</li></ul>', false );
            echo str_replace( '|', '</li><li>', $breadcrumbs );
        } ?>
	</div>
</div>
<section id="content" class="container-fluid">
	<div class="container" id="content-inner">
		<div class="row">
			<div class="col-md-24">
				<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>
					<h1><?php the_title(); ?></h1>
					<?php the_content(); ?>
				<?php endwhile; endif; ?>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>