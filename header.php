<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Checathlon
 */

$body_classes = get_body_class();

$html_class = ' class="no-js"';
$body_class = ' class="' . implode( ' ', $body_classes ) . '"';
if ( checathlon_is_amp() ) {
	$html_class .= sprintf( ' [class]="%s"', esc_attr( "'no-js' + ( navMenuToggledOn ? ' disable-scroll' : ''" ) ) );
	$body_class .= ' [class]="\'' . implode( ' ', $body_classes ) . '\' + ( navMenuToggledOn ? \' main-navigation-open\' : \'\' )"';
}

?><!DOCTYPE html>
<html <?php language_attributes(); echo $html_class; ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php echo $body_class; ?>>
<?php unset( $body_classes, $html_class, $body_class ); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'checathlon' ); ?></a>

	<div class="site-header-wrap">
		<header id="masthead" class="site-header main-padding" role="banner">
			<div class="wrapper main-width">

				<?php
					// Custom logo.
					checathlon_the_custom_logo();

					do_action( 'checathlon_after_the_custom_logo' );
				?>

				<div class="site-branding">
					<?php
					// Site title.
					if ( is_front_page() && is_home() ) : ?>
						<h1 class="site-title title-font no-margin-bottom"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php else : ?>
						<p class="site-title title-font no-margin-bottom"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php
						endif;
					?>
				</div><!-- .site-branding -->

				<?php
					get_template_part( 'menus/menu', 'primary' ); // Loads the menus/menu-primary.php template.
				?>

			</div><!-- .wrapper -->
			<?php do_action( 'checathlon_inside_header' ); ?>
		</header><!-- .site-header -->
	</div><!-- .site-header-wrap -->

	<?php do_action( 'checathlon_after_header' ); ?>

	<div id="content" class="site-content">
