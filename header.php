<?php
	global $tailored_theme;
	$options = $tailored_theme->get_option();
	$address = $options['theme_options']['address'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<?php wp_head(); ?>
<?php
	if( isset( $options['theme_options']['advanced']['head'] ) ) {
?>
	<?php echo stripslashes( $options['theme_options']['advanced']['head'] ); ?>

<?php } ?>
<?php
	if( isset( $options['theme_options']['advanced']['js'] ) ) {
?>
	<script>
		<?php echo stripslashes( $options['theme_options']['advanced']['js'] ); ?>
	</script>
<?php } ?>
<?php
	if( isset( $options['theme_options']['advanced']['css'] ) ) {
?>
	<style>
		<?php echo stripslashes( $options['theme_options']['advanced']['css'] ); ?>
	</style>
<?php } ?>
<?php echo ( isset( $options['theme_options']['analytics']['code'] ) ? stripslashes( $options['theme_options']['analytics']['code'] ) : '' ); ?>

</head>
<body <?php body_class(); ?>>
<header id="header" class="container">
	<div class="row">
		<div class="col-md-4" id="logo"> <img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/images/logo.png" width="157" height="129" class="img-responsive" alt="PLM Global"/> </div>
		<div class="col-md-20" id="menu">
			<nav class="navbar navbar-default">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
					</div>
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<?php if ( function_exists('wp_nav_menu') ) { wp_nav_menu( array(
								'menu'              => 'primary',
								'theme_location'    => 'primary',
								'container'         => '',
								'menu_class'        => 'nav navbar-nav',
								'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
								'walker'            => new wp_bootstrap_navwalker()
								)
							
							); } 
						?>
						<p class="navbar-text">
						  <i class="fa fa-phone"></i> <?php echo ( isset( $address['phone'] ) ? $address['phone'] : '' ); ?>
						</p>
					</div>
				</div>
			</nav>
		</div>
	</div>
</header>