<?php
/**
 * Icon (SVG) related functions and filters.
 *
 * @package Karvi16
 */
 
/**
 * Add SVG definitions to the footer.
 *
 * @since 1.0.0
 */
function checathlon_include_svg_icons() {
	
	// Define SVG sprite file.
	$svg_icons = get_template_directory() . '/assets/images/svg-icons.svg';
	
	// If it exists, include it.
	if ( file_exists( $svg_icons ) ) {
		require_once( $svg_icons );
	}

}
add_action( 'wp_footer', 'checathlon_include_svg_icons', 9999 );
 
/**
 * Return SVG markup.
 *
 * @param  array  $args {
 *     Parameters needed to display an SVG.
 *
 *     @param string $icon Required. Use the icon filename, e.g. "facebook-square".
 *     @param string $title Optional. SVG title, e.g. "Facebook".
 *     @param string $desc Optional. SVG description, e.g. "Share this post on Facebook".
 * }
 * @return string SVG markup.
 */
function checathlon_get_svg( $args = array() ) {

	// Make sure $args are an array.
	if ( empty( $args ) ) {
		return esc_html__( 'Please define default parameters in the form of an array.', 'checathlon' );
	}
	
	// Define an icon.
	if ( false === array_key_exists( 'icon', $args ) ) {
		return esc_html__( 'Please define an SVG icon filename.', 'checathlon' );
	}
	
	// Set defaults.
	$defaults = array(
		'icon'        => '',
		'title'       => '',
		'desc'        => '',
		'aria_hidden' => true, // Hide from screen readers.
	);
	
	// Parse args.
	$args = wp_parse_args( $args, $defaults );
	
	// Set aria hidden.
	if ( true === $args['aria_hidden'] ) {
		$aria_hidden = ' aria-hidden="true"';
	} else {
		$aria_hidden = '';
	}
	
	// Set ARIA.
	if ( $args['title'] && $args['desc'] ) {
		$aria_labelledby = ' aria-labelledby="title desc"';
	} else {
		$aria_labelledby = '';
	}
	
	// Begin SVG markup
	$svg = '<svg class="icon icon-' . esc_html( $args['icon'] ) . '"' . $aria_hidden . $aria_labelledby . ' role="img">';
		// If there is a title, display it.
		if ( $args['title'] ) {
			$svg .= '<title>' . esc_html( $args['title'] ) . '</title>';
		}
		// If there is a description, display it.
		if ( $args['desc'] ) {
			$svg .= '<desc>' . esc_html( $args['desc'] ) . '</desc>';
		}
	if ( is_customize_preview() ) {
		$svg .= '<use xlink:href="' . get_template_directory_uri() . '/assets/images/svg-icons.svg' . '#icon-' . esc_html( $args['icon'] ) . '"></use>';
	} else {
		$svg .= '<use xlink:href="#icon-' . esc_html( $args['icon'] ) . '"></use>';
	}
	$svg .= '</svg>';
	return $svg;
}

/**
 * Display an SVG.
 *
 * @param  array  $args  Parameters needed to display an SVG.
 */
function checathlon_do_svg( $args = array() ) {
	echo checathlon_get_svg( $args );
}

/**
 * Display SVG icons in social navigation.
 *
 * @since 1.0.0
 *
 * @param string  $item_output The menu item output.
 * @param WP_Post $item        Menu item object.
 * @param int     $depth       Depth of the menu.
 * @param array   $args        wp_nav_menu() arguments.
 * @return string Menu item with possible description.
 */
function checathlon_nav_social_icons( $item_output, $item, $depth, $args ) {
	
	// Supported social icons.
	$social_icons = apply_filters( 'checathlon_nav_social_icons', array(
		'codepen.io'      => 'codepen',
		'digg.com'        => 'digg',
		'dribbble.com'    => 'dribbble',
		'dropbox.com'     => 'dropbox',
		'facebook.com'    => 'facebook',
		'flickr.com'      => 'flickr',
		'foursquare.com'  => 'foursquare',
		'plus.google.com' => 'googleplus',
		'github.com'      => 'github',
		'instagram.com'   => 'instagram',
		'linkedin.com'    => 'linkedin-alt',
		'mailto:'         => 'mail',
		'pinterest.com'   => 'pinterest-alt',
		'getpocket.com'   => 'pocket',
		'polldaddy.com'   => 'polldaddy',
		'reddit.com'      => 'reddit',
		'skype.com'       => 'skype',
		'skype:'          => 'skype',
		'soundcloud.com'  => 'cloud',
		'spotify.com'     => 'spotify',
		'stumbleupon.com' => 'stumbleupon',
		'tumblr.com'      => 'tumblr',
		'twitch.tv'       => 'twitch',
		'twitter.com'     => 'twitter',
		'vimeo.com'       => 'vimeo',
		'wordpress.org'   => 'wordpress',
		'wordpress.com'   => 'wordpress',
		'youtube.com'     => 'youtube',
	) );
	
	// Change SVG icon inside social links menu if there is supported URL.
	if ( 'social' == $args->theme_location ) {
		foreach ( $social_icons as $attr => $value ) {
			if ( false !== strpos( $item_output, $attr ) ) {
				$item_output = str_replace( $args->link_after, '</span>' . checathlon_get_svg( array( 'icon' => esc_attr( $value ) ) ), $item_output );
			}
		}
	}

	return $item_output;
	
}
add_filter( 'walker_nav_menu_start_el', 'checathlon_nav_social_icons', 10, 4 );

function checathlon_dropdown_icon_to_menu_link( $title, $item, $args, $depth ) {
	
	if ( 'primary' == $args->theme_location ) {
	
		foreach ( $item->classes as $value ) {
			if ( $value == 'menu-item-has-children' ) {
				$title =  $title . checathlon_get_svg( array( 'icon' => 'expand' ) );
			}
		}
		
	}
	
	return $title;
	
}
add_filter( 'nav_menu_item_title', 'checathlon_dropdown_icon_to_menu_link', 10, 4 );

/**
 * Returns an array of SVG icons names.
 *
 * @since  1.0.0
 *
 * @return array
 */
function checathlon_get_svg_icons() {

	$icons = array(
		'rating-full'    => 'rating-full',
		'checkmark'      => 'checkmark',
		'collapse'       => 'collapse',
		'edit'           => 'edit',
		'expand'         => 'expand',
		'month'          => 'month',
		'phone'          => 'phone',
		'search'         => 'search',
		'info'           => 'info',
		'location'       => 'location',
		'feed2'          => 'feed2',
		'folder-open'    => 'folder-open',
		'tag'            => 'tag',
		'comment'        => 'comment',
		'bolt'           => 'bolt',
		'heart'          => 'heart',
		'user'           => 'user',
		'film'           => 'film',
		'signal'         => 'signal',
		'cog'            => 'cog',
		'road'           => 'road',
		'lock'           => 'lock',
		'flag'           => 'flag',
		'volume-up'      => 'volume-up',
		'camera'         => 'camera',
		'check-square-o' => 'check-square-o',
		'leaf'           => 'leaf',
		'plane'          => 'plane',
		'thumbs-o-up'    => 'thumbs-o-up',
		'external-link'  => 'external-link',
		'upload'         => 'upload',
		'unlock'         => 'unlock',
		'credit-card'    => 'credit-card',
		'gavel'          => 'gavel',
		'umbrella'       => 'umbrella',
		'user-md'        => 'user-md',
		'coffee'         => 'coffee',
		'cutlery'        => 'cutlery',
		'microphone'     => 'microphone',
		'shield'         => 'shield',
		'html5'          => 'html5',
		'female'         => 'female',
		'male'           => 'male',
		'space-shuttle'  => 'space-shuttle',
		'share-alt'      => 'share-alt',
		'paint-brush'    => 'paint-brush',
		'category'       => 'category',
		'tag2'           => 'tag2',
		'rocket'         => 'rocket',
		'diamond'        => 'diamond',
		'shopping-cart'  => 'shopping-cart',
	);

	return apply_filters( 'checathlon_svg_icons', $icons );
	
}