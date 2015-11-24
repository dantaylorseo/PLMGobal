<?php
	global $tailored_theme;
	$options = $tailored_theme->get_option();
	$address = $options['theme_options']['address'];
?>
<section id="gallery" class="container-fluid">
	<div class="container" id="gallery-inner">
		<div class="row">
			<div class="col-md-16">
				<div class="row">
				<?php
					$imageargs = array(
						'post_type' => 'footer-images',
						'posts_per_page' => 6,
						'orderby'	=> 'rand',
					);
					$images = get_posts( $imageargs );
					foreach( $images as $image ) {
						setup_postdata( $image );
				?>
					<div class="col-md-8">
						<div class="thumbnail">
							<?php 
								if ( has_post_thumbnail( $image->ID ) ) { // check if the post has a Post Thumbnail assigned to it.
									echo get_the_post_thumbnail( $image->ID, 'footer-image' );
								} 
							?>
						</div>
					</div>
				<?php 
				}
				wp_reset_postdata(); 
				?>
				</div>
			</div>
			<div class="col-md-7 col-md-offset-1">
				<div class="row logos">
					<?php
					$logoargs = array(
						'post_type' => 'logos',
						'posts_per_page' => 6,
						'orderby'	=> 'rand',
					);
					$logos = get_posts( $logoargs );
					foreach( $logos as $logo ) {
						setup_postdata( $logo );
				?>
					<div class="col-md-12">
						<div class="thumbnail">
							<?php 
								if ( has_post_thumbnail( $logo->ID ) ) { // check if the post has a Post Thumbnail assigned to it.
									echo get_the_post_thumbnail( $logo->ID, 'full' );
								} 
							?>
						</div>
					</div>
				<?php 
				}
				wp_reset_postdata(); 
				?>
					
				</div>
			</div>
		</div>
	</div>
</section>
<footer id="footer" class="container-fluid">
	<div class="container" id="footer-inner">
		<div class="row">
			<div class="col-md-12">
				<?php if( isset( $address['opening'] ) && $address['opening'] != '' ) { ?>
				<h4>Opening Hours</h4>
				<?php echo wpautop( $address['opening'] ); ?>
				<?php } ?>
				<h4 id="followustitle">Follow Us</h4>
				<p>
					<?php if( isset( $address['facebook'] ) && $address['facebook'] != '' ) { ?>
					<a href="<?php echo $address['facebook']; ?>">
						<span class="fa-stack fa-lg">
						  <i class="fa fa-circle fa-stack-2x"></i>
						  <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
						</span>
					</a>
					<?php
					}
					if( isset( $address['twitter'] ) && $address['twitter'] != '' ) { ?>
					<a href="<?php echo $address['twitter']; ?>">
						<span class="fa-stack fa-lg">
						  <i class="fa fa-circle fa-stack-2x"></i>
						  <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
						</span>
					</a>
					<?php
					}
					if( isset( $address['linkedin'] ) && $address['linkedin'] != '' ) { ?>
					<a href="<?php echo $address['linkedin']; ?>">
						<span class="fa-stack fa-lg">
						  <i class="fa fa-circle fa-stack-2x"></i>
						  <i class="fa fa-linkedin fa-stack-1x fa-inverse"></i>
						</span>
					</a>
					<?php
					}
					if( isset( $address['google'] ) && $address['google'] != '' ) { ?>
					<a href="<?php echo $address['google']; ?>">
						<span class="fa-stack fa-lg">
						  <i class="fa fa-circle fa-stack-2x"></i>
						  <i class="fa fa-google-plus fa-stack-1x fa-inverse"></i>
						</span>
					</a>
					<?php 
					}
					?>
				</p>

			</div>
			<div class="col-md-12 text-right">
				
				<h4>Information</h4>
				<address><?php echo ( isset( $address['company'] ) ? $address['company'].',<br>' : '' ); ?>
				<?php echo ( isset( $address['street'] ) ? $address['street'].',<br>' : '' ); ?>
				<?php echo ( isset( $address['address2'] ) ? $address['address2'].',<br>' : '' ); ?>
				<?php echo ( isset( $address['town'] ) ? $address['town'].',<br>' : '' ); ?>
				<?php echo ( isset( $address['county'] ) ? $address['county'].',<br>' : '' ); ?>
				<?php echo ( isset( $address['postcode'] ) ? $address['postcode'] : '' ); ?></address>
				<?php echo ( isset( $address['phone'] ) ? '<p>Tel: '.$address['phone'].'</p>' : '' ); ?>
			</div>
			<div class="col-md-24 text-center"><p><?php if( isset( $address['company'] ) ) { ?> &copy Copyright <?php echo $address['company']; ?> 2015</p><?php } ?></div>			
		</div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>