<?php 
	get_header(); 
	$meta = get_post_meta( $post->ID, '_product_meta', true );
?>
<div id="breadcrumbs" class="container-fluid">
	<div id="breadcrumbsinner" class="container">
		<?php if ( function_exists('yoast_breadcrumb') ) {
            $breadcrumbs = yoast_breadcrumb( '<ol class="breadcrumb"><li>', '</li></ul>', false );
            echo str_replace( array( '|', '/%category%' ), array( '</li><li>', '' ), $breadcrumbs );
        } ?>
	</div>
</div>
<section id="product" class="container-fluid">
	<div class="container" id="productinner">
		<div class="row">
			<div class="col-md-24">
				<h1><?php the_title(); ?></h1>
			</div>
			<div class="col-md-7">
				<div class="thumbnail">
					<?php 
						if ( has_post_thumbnail(  ) ) { // check if the post has a Post Thumbnail assigned to it.
							echo the_post_thumbnail( 'full' );
						} 
					?>
				</div>
			</div>
			<div class="col-md-8 col-md-offset-1">
				<?php 
					if( isset( $meta['product_features'] ) ) {
						echo '<h2>Product Features</h2>';
						echo wpautop( $meta['product_features'] ); 
					}
				?>
			</div>
			<div class="col-md-6 col-md-offset-2">
				<h2>Request a Quote</h2>
				<?php echo do_shortcode( '[contact-form-7 id="32" title="Request Quote"]' ); ?>
			</div>
		</div>
	</div>
</section>
<section id="content" class="container-fluid">
	<div class="container" id="content-inner">
		<div class="row">
			<div class="col-md-24">
				<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>
					<h2>Product Information</h2>
					<?php the_content(); ?>
				<?php endwhile; endif; ?>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>