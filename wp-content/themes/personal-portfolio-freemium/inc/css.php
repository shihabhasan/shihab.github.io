<?php
/**
 * Hooks the Custom Internal CSS to head section
 * Eventually, some of the functionality here could be replaced by core features.
 * @package Personal Portfolio
 */

function dinozoom_load_all_fonts_admin () {
	if ( !is_customize_preview() ) return false;	
	$fonts = personalportfolio_font_list(1);
	$gfonts = array();
	foreach ( $fonts as $key => $font ) {
		if ( preg_match( "/_g_/", $key ) ) $gfonts [] = $font[0];
	}
	$gfonts = str_replace(' ','+',implode('|', array_unique( $gfonts ) ) );
	wp_enqueue_style( 'personalportfolio-google-fonts', "//fonts.googleapis.com/css?family=$gfonts&subset=latin,latin-ext", array(), '1.0.0' );
}
add_action( 'wp', 'dinozoom_load_all_fonts_admin' );

function dinozoom_font_family ( $option, $font ) {
	$font_slug = get_theme_mod( $option, '_g_opensans' );
	$fonts = personalportfolio_font_list(1);
	
	if ( ! $font_slug ) return false;
	
	// Font Family
	if ( preg_match( "/_g_/", $font_slug ) ):
		$name = $fonts [$font_slug][0];
		$type = $fonts [$font_slug][1];
		$font["css"] = "font-family: '$name', $type; font-weight: 400;";
		$font["fonts"][] = $name;
	else:
		$generic = $fonts [$font_slug][1];
		$font["css"] = "font-family: $generic;";
	endif;
	return $font;
}
function personalportfolio_custom_css() {
	$css = '';
	// Fonts & Family CSS
	$font = array();
		// Site:
		$font = dinozoom_font_family ( 'site_fonts', $font );
		if ( isset($font["css"]) ) $css .= "body,button,input,select,textarea {". $font["css"] ."}";
		// Main Menu
		$font = dinozoom_font_family ( 'menu_font', $font );
		if ( isset($font["css"]) ) $css .= "#primary-menu > li > a {". $font["css"] ."}";
		// Content
		$font = dinozoom_font_family ( 'content_font', $font );
		if ( isset($font["css"]) ) $css .= "article .entry-content, article .entry-summary {". $font["css"] ."}";
	
	
	// Link Google Fonts
	if ( @count ($font["fonts"]) ) {
		$locale = get_locale();
		$subset = "latin";
		if ( ! preg_match( "/(en_US|en_AU|en_CA|en_ZA|en_GB)/",$locale) ) $subset .= ",latin-ext";
		$gfonts = str_replace(' ','+',implode('|',array_unique($font["fonts"])));
		//echo "<link href='//fonts.googleapis.com/css?family=$gfonts&subset=$subset' rel='stylesheet' type='text/css'>";
		wp_enqueue_style( 'personalportfolio-google-fonts', "//fonts.googleapis.com/css?family=$gfonts&subset=$subset", array(), '1.0.0' );
	}
		
	// Font Sizes CSS
	if( get_theme_mod( 'site_font_sizes', "14" ) != "14" )
		$css .= "body,button,input,select,textarea { font-size:". get_theme_mod('site_font_sizes') ."px;}";
	if( get_theme_mod( 'menu_font_size', "15" ) != "15" )
		$css .= "#primary-menu > li > a { font-size:". get_theme_mod('menu_font_size') ."px;}";
	if( get_theme_mod( 'content_font_size', "14" ) != "14" )
		$css .= "article .entry-content, article .entry-summary { font-size:". get_theme_mod('content_font_size') ."px;}";
	
	// Services
		// Services intro text color
		if( get_theme_mod( 'services_intro_text_color' ) )
			$css .= '#service_section h1, #service_section p {color:'.get_theme_mod( 'services_intro_text_color' ).';}';
		// Projects intro text color
		if( get_theme_mod( 'projects_intro_text_color' ) )
			$css .= '#project-section .hc_service_title h1, #project-section .hc_service_title p {color:'.get_theme_mod( 'projects_intro_text_color' ).';}';	
		// Testimonials intro text color
		if( get_theme_mod( 'testimonial_intro_text_color' ) )
			$css .= '#testimonials-section .hc_service_title h1, #testimonials-section .hc_service_title p {color:'.get_theme_mod( 'testimonial_intro_text_color' ).';}';
		// Customers intro text color
		if( get_theme_mod( 'customers_intro_text_color' ) )
			$css .= '#customers-section .hc_service_title h1, #customers-section .hc_service_title p {color:'.get_theme_mod( 'customers_intro_text_color' ).';}';	
			
		
	// Other CSS
	// Custom CSS texarea
	$css .= esc_html(get_theme_mod('custom_css'));
	// Other CSS
	$primary_color = esc_attr( get_theme_mod( 'primary_color', '#ff8800' ) );	
	if( $primary_color != '#ff8800' ) {
		$css .= '
		.widget-area .widget{box-shadow: 0px -5px 0px 0px '.$primary_color.';}
		blockquote{border-left:2px solid '.$primary_color.';}
		.page-content ul li:before,
		.entry-content ul li:before,
		.entry-summary ul li:before,
		.page-content h1:before,
		.entry-content h1:before,
		.page-content h2:before,
		.entry-content h2:before,
		.page-content h3:before,
		.entry-content h3:before
		{color:'.$primary_color.';}
		pre{border-left:2px solid '.$primary_color.';}
		button,input[type="button"],input[type="reset"],input[type="submit"]{background:'.$primary_color.';}
		a:hover,a:focus,a:active{color:'.$primary_color.';}
		.pagination .nav-links a:hover{color:'.$primary_color.';}
		.pagination .current{color:'.$primary_color.';}
		.entry-content a{color:'.$primary_color.';}
		.wp-pagenavi span.current{color:'.$primary_color.';}
		.entry-title, .entry-title a, .widget-area .widget-title{color:'.$primary_color.';}
		#next-slide,#prev-slide{color:'.$primary_color.';}
		#controllers a:hover, #controllers a.active{color:'.$primary_color.';}
		#controllers a:hover, #controllers a.active{background-color:'.$primary_color.';}
		#slider-title a{background:'.$primary_color.';}
		.comments-title, .comment-reply-title {color:'.$primary_color.';}
		.content-box .featured-image {border-color:'.$primary_color.';}
		.content-box .readmore i {color:'.$primary_color.';}
		';
	}
	// WooCommerce Colors
		$css .= '
		.woocommerce a.button, .woocommerce button.button,
		.woocommerce input.button, .woocommerce #respond input#submit.alt,
		.woocommerce a.button, .woocommerce button.button,
		.woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt,
		.woocommerce #respond input#submit
		{
			background-color:'.$primary_color.';border-color:'.$primary_color.';
		}';
	// Contact details color
	if( get_theme_mod( 'contact_color' ) )
		$css .= '.site-description,.site-description a{color:'.get_theme_mod( 'contact_color' ).';}';
	if( get_theme_mod( 'contact_color_hover' ) )
		$css .= '.site-description span:hover {
				color:'.get_theme_mod( 'contact_color_hover' ).';
				border-color:'.get_theme_mod( 'contact_color_hover' ).';}
				.header-search .search-field:hover {border-color:'.get_theme_mod( 'contact_color_hover' ).';}';
				
				
				
	// Header Image
	$header_image = get_header_image();
	if( $header_image == '' or $header_image === false ) $css .= 'header.site-header{background-image:none;}';
		else $css .= 'header.site-header{background-image:url('.$header_image.');}';
		
	// Posts
	if( get_theme_mod( 'post_text_color' ) )
		$css .= '.page-content, .entry-content{color:'.get_theme_mod( 'post_text_color' ).';}';
	if( get_theme_mod( 'post_meta_color' ) )
		$css .= '.entry-meta, .entry-meta span a,
				 .entry-footer, .entry-footer span a {color:'.get_theme_mod( 'post_meta_color' ).';}';
	// Main Menu styke
	if( get_theme_mod( 'menu_bg' ) )
		$css .= '.main-navigation{background-image:url('.get_theme_mod( 'menu_bg' ).');}';
	if( get_theme_mod( 'menu_color' ) )
		$css .= '.main-navigation li a{color:'.get_theme_mod( 'menu_color' ).';}';
	if( get_theme_mod( 'menu_color_hover' ) )
		$css .= '.main-navigation li a:hover{
			color:'.get_theme_mod( 'menu_color_hover' ).';
			border-color:'.get_theme_mod( 'menu_color_hover' ).';}';
	// CTA
	if( get_theme_mod( 'enable_cta', 1 ) ):
		if( get_theme_mod( 'cta_bg', get_template_directory_uri() . "/images/beach.jpg" ) ) $css .= '#cta{background-image:url('. get_theme_mod( 'cta_bg', get_template_directory_uri() . "/images/beach.jpg" ) .');}';
		if( get_theme_mod( 'cta_text_color' ) ) $css .= '#cta .text{color:'.get_theme_mod( 'cta_text_color' ).';}';
		if( get_theme_mod( 'cta_button_bg' ) ) $css .= '#cta .button a{background-color:'. get_theme_mod('cta_button_bg') .';}';
	endif;
	// Print css
	if( !empty( $css ) ) {
		?>
		<style type="text/css"><?php echo $css; ?></style>
		<?php
	}
}
add_action('wp_head', 'personalportfolio_custom_css');

?>