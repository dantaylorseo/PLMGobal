<?php get_header(); ?>
<section id="masthead" class="container-fluid">
	<div class="container" id="masthead-inner">
		<div id="carousel" class="carousel slide" data-ride="carousel"> 
			<!-- Indicators -->
			<ol class="carousel-indicators">
			<?php
				$i = 0;
				$gpargs = array(
					'post_type' => 'slides',
					'posts_per_page' => -1,
					'orderby'	=> 'menu_order',
					'order' => 'ASC'
				);
				$slides = get_posts( $gpargs );
				for( $n = 0; $n<count($slides); $n++ ) {
			?>
				<li data-target="#carousel" data-slide-to="<?php echo $n; ?>" class="<?php echo ( $n == 0 ? 'active' : '' ); ?>"></li>
			<?php } ?>
			</ol>
			<!-- Wrapper for slides -->
			<div class="carousel-inner" role="listbox">
				<?php
					foreach( $slides as $slide ) {
						setup_postdata( $slide );
				?>
					<div class="item row <?php echo ( $i == 0 ? 'active' : '' ); ?>">
						<div class="col-md-12">
							<?php the_content(); ?>
							<a href="#" class="btn btn-primary">Contact Us</a>
						</div>
						<div class="col-md-12">
							<?php 
								if ( has_post_thumbnail( $slide->ID ) ) { // check if the post has a Post Thumbnail assigned to it.
									echo get_the_post_thumbnail( $slide->ID, 'home-slide', array( 'class' => 'img-responsive' ) );
								} 
							?>
						</div>
					</div>
				<?php 
				$i++;
					} 
					wp_reset_postdata();
				?>
			</div>
		</div>
	</div>
</section>
<section id="content" class="container-fluid">
	<div class="container" id="content-inner">
		<div class="row">
			<div class="col-md-18 match">
				<?php the_content(); ?>
			</div>
			<div class="col-md-4 col-md-offset-2 centerblock match">
				<div class="verticalcenter"><a href="#" class="btn btn-block btn-primary">Request a callback</a></div>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>