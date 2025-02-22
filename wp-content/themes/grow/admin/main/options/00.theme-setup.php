<?php
/**
 * Theme setup functions.
 *
 * @package ThinkUpThemes
 */


//----------------------------------------------------------------------------------
//	ADD CUSTOM HOOKS
//----------------------------------------------------------------------------------

// Used at top of header.php
function thinkup_hook_header() { 
	do_action('thinkup_hook_header');
}

// Used at top if header.php within the body tag
function thinkup_bodystyle() { 
	do_action('thinkup_bodystyle');
}

// Used after <body> tag in header.php
function thinkup_hook_bodyhtml() { 
	do_action('thinkup_hook_bodyhtml');
}


//----------------------------------------------------------------------------------
//	CORRECT Z-INDEX OF OEMBED OBJECTS
//----------------------------------------------------------------------------------
function thinkup_fix_oembed( $embed ) {
	if ( strpos( $embed, '<param' ) !== false ) {
   		$embed = str_replace( '<embed', '<embed wmode="transparent" ', $embed );
   		$embed = preg_replace( '/param>/', 'param><param name="wmode" value="transparent" />', $embed, 1);
	}
	return $embed;
}
add_filter( 'embed_oembed_html', 'thinkup_fix_oembed', 1 );


//----------------------------------------------------------------------------------
//	ADD PAGE TITLE
//----------------------------------------------------------------------------------

function thinkup_title_select() {
	global $post;

	if ( is_page() ) {
		printf( '<span>' . __( '%s', 'grow' ) . '</span>', get_the_title() );
	} elseif ( is_attachment() ) {
		printf( '<span>' . __( 'Blog Post Image: ', 'grow' ) . '</span>' . '%s', esc_attr( get_the_title( $post->post_parent ) ) );
	} else if ( is_single() ) {
		printf( '<span>' . __( '%s', 'grow' ) . '</span>', get_the_title() );
	} else if ( is_search() ) {
		printf( '<span>' . __( 'Search Results: ', 'grow' ) . '</span>' . '%s', get_search_query() );
	} else if ( is_404() ) {
		printf( '<span>' . __( 'Page Not Found', 'grow' ) . '</span>' );
	} elseif ( is_archive() ) {
		echo get_the_archive_title();
	} elseif ( thinkup_check_isblog() ) {
		printf( '<span>' . __( 'Blog', 'grow' ) . '</span>' );
	} else {
		printf( '<span>' . __( '%s', 'grow' ) . '</span>', get_the_title() );
	}
}


//----------------------------------------------------------------------------------
//	ADD BREADCRUMBS FUNCTIONALITY
//----------------------------------------------------------------------------------

function thinkup_input_breadcrumb() {
global $thinkup_general_breadcrumbdelimeter;

	$output           = NULL;
	$count_loop       = NULL;
	$count_categories = NULL;

	if ( empty( $thinkup_general_breadcrumbdelimeter ) ) {
		$delimiter = '<span class="delimiter">/</span>';
	} else if ( ! empty( $thinkup_general_breadcrumbdelimeter ) ) {
		$delimiter = '<span class="delimiter"> ' . esc_html( $thinkup_general_breadcrumbdelimeter ) . ' </span>';
	}

	$delimiter_inner   =   '<span class="delimiter_core"> &bull; </span>';
	$main              =   __( 'Home', 'grow' );
	$maxLength         =   30;

	/* Archive variables */
	$arc_year       =   get_the_time('Y');
	$arc_month      =   get_the_time('F');
	$arc_day        =   get_the_time('d');
	$arc_day_full   =   get_the_time('l');  

	/* URL variables */
	$url_year    =   get_year_link($arc_year);
	$url_month   =   get_month_link($arc_year,$arc_month);

	/* Display breadcumbs if NOT the home page */
	if ( ! is_front_page() ) {
		$output .= '<div id="breadcrumbs"><div id="breadcrumbs-core">';
		global $post, $cat;
		$homeLink = home_url( '/' );
		$output .= '<a href="' . esc_url( $homeLink ) . '">' . esc_html( $main ) . '</a>' . $delimiter;    

		/* Display breadcrumbs for single post */
		if ( is_single() ) {
			$category = get_the_category();
			$num_cat = count($category);
			if ($num_cat <=1) {
				$output .= ' ' . get_the_title();
			} else {

				// Count Total categories
				foreach( get_the_category() as $category) {
					$count_categories++;
				}
				
				// Output Categories
				foreach( get_the_category() as $category) {
					$count_loop++;

					if ( $count_loop < $count_categories ) {
						$output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->cat_name ) . '</a>' . $delimiter_inner; 
					} else {
						$output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->cat_name ) . '</a>'; 
					}
				}
				
				if (strlen(get_the_title()) >= $maxLength) {
					$output .=  ' ' . $delimiter . trim(substr(get_the_title(), 0, $maxLength)) . ' ...';
				} else {
					$output .=  ' ' . $delimiter . get_the_title();
				}
			}
		} elseif ( is_search() ) {
			$output .= __( 'Search Results for: ', 'grow' ) . get_search_query() . '"';
		} elseif ( is_page() && !$post->post_parent ) {
			$output .=  get_the_title();
		} elseif ( is_page() && $post->post_parent ) {
			$post_array = get_post_ancestors( $post );
			krsort( $post_array ); 
			foreach( $post_array as $key=>$postid ){
				$post_ids = get_post( $postid );
				$title = $post_ids->post_title;
				$output  .= '<a href="' . esc_url( get_permalink( $post_ids ) ) . '">' . esc_html( $title ) . '</a>' . $delimiter;
			}
			$output .= get_the_title();
		} elseif ( is_404() ) {
			$output .= __( 'Error 404 - Not Found.', 'grow' );
		} elseif ( is_archive() ) {
			$output .= get_the_archive_title();
		} elseif ( thinkup_check_isblog() ) {
			$output .= __( 'Blog', 'grow' );
		} else {
			$output .= get_the_title();
		}
		$output .=  '</div></div>';

		return $output;
	}
}


/* ----------------------------------------------------------------------------------
	ADD MENU DESCRIPTION FEATURE
---------------------------------------------------------------------------------- */

class thinkup_menudescription extends Walker_Nav_Menu {

	function start_el(&$output, $item, $depth=0, $args=array(), $id = 0) {
		global $wp_query;
		
		$item_output = NULL;
		
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
 
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';
 
		$output .= $indent . '<li id="menu-item-'. esc_attr( $item->ID ) . '"' . $value . $class_names .'>';

		$attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) .'"' : '';
		$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) .'"' : '';
		$attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) .'"' : ' href="' . esc_url( get_permalink( $item->ID ) ) . '"';

        // Insert title for top level
		if ( has_nav_menu( 'header_menu' ) ) {
			$title = ( $depth == 0 )
				? '<span>' . esc_html( apply_filters( 'the_title', $item->title, $item->ID ) ) . '</span>' : esc_html( apply_filters( 'the_title', $item->title, $item->ID ) );
		} else {
			$title = ( $depth == 0 )
				? '<span>' . esc_html( apply_filters( 'the_title', get_the_title($item->ID), $item->ID ) ) . '</span>' : esc_html( apply_filters( 'the_title', get_the_title($item->ID), $item->ID ) );
		}

        // Structure of output
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $title;
		$item_output .= '</a>';

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}


//----------------------------------------------------------------------------------
//	ADD CUSTOM FEATURED IMAGE SIZES
//----------------------------------------------------------------------------------

function thinkup_input_addimagesizes() {

	// Image size for testimonial shortcode
	add_image_size( 'sc-testimonial', 80, 80, true );

	/* 1 Column Layout */
	add_image_size( 'column1-1/2', 1140, 570, true );
	add_image_size( 'column1-1/3', 1140, 380, true );
	add_image_size( 'column1-1/4', 1140, 285, true );
	add_image_size( 'column1-2/5', 1140, 456, true );

	/* 2 Column Layout */
	add_image_size( 'column2-1/1', 570, 570, true );
	add_image_size( 'column2-1/4', 570, 142, true );
	add_image_size( 'column2-1/2', 570, 285, true );
	add_image_size( 'column2-2/3', 570, 380, true );
	add_image_size( 'column2-3/5', 570, 342, true );

	/* 3 Column Layout */
	add_image_size( 'column3-1/1', 380, 380, true );
	add_image_size( 'column3-1/3', 380, 107, true );
	add_image_size( 'column3-2/5', 380, 152, true );	
	add_image_size( 'column3-2/3', 380, 254, true );
	add_image_size( 'column3-3/4', 380, 285, true );

	/* 4 Column Layout */
	add_image_size( 'column4-1/1', 285, 285, true );
	add_image_size( 'column4-2/3', 285, 190, true );
	add_image_size( 'column4-3/4', 285, 214, true );
}
add_action( 'init', 'thinkup_input_addimagesizes' );
 
function thinkup_input_showimagesizes($sizes) {

	// 1 Column Layout
	$sizes['column1-1/2'] = 'Full - 1:2';
	$sizes['column1-1/3'] = 'Full - 1:3';
	$sizes['column1-1/4'] = 'Full - 1:4';
	$sizes['column1-2/5'] = 'Full - 2:5';

	// 2 Column Layout
	$sizes['column2-1/1'] = 'Half - 1:1';
	$sizes['column2-1/2'] = 'Half - 1:2';
	$sizes['column2-2/3'] = 'Half - 2:3';
	$sizes['column2-3/5'] = 'Half - 3:5';

	// 3 Column Layout
	$sizes['column3-1/1'] = 'Third - 1:1';
	$sizes['column3-2/5'] = 'Third - 2:5';
	$sizes['column3-2/3'] = 'Third - 2:3';
	$sizes['column3-3/4'] = 'Third - 3:4';

	// 4 Column Layout
	$sizes['column4-1/1'] = 'Quarter - 1:1';
	$sizes['column4-2/3'] = 'Quarter - 2:3';
	$sizes['column4-3/4'] = 'Quarter - 3:4';

	return $sizes;
}
add_filter('image_size_names_choose', 'thinkup_input_showimagesizes');


//----------------------------------------------------------------------------------
//	ADD HOME: HOME TO CUSTOM MENU PAGE LIST
//----------------------------------------------------------------------------------

function thinkup_menu_homelink( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'thinkup_menu_homelink' );


//----------------------------------------------------------------------------------
//	ADD FUNCTION TO GET CURRENT PAGE URL
//----------------------------------------------------------------------------------

function thinkup_check_ishome() {
	$pageURL = 'http';
	if( isset($_SERVER["HTTPS"]) ) {
		if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
//		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]; // Monitor how this works for users on https sites.
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	$pageURL = rtrim($pageURL, '/') . '/';

	$pageURL = str_replace( "www.", "", $pageURL );
	$siteURL = str_replace( "www.", "", site_url( '/' ) );

	if ( $pageURL == $siteURL ) {
		return true;
	} else {
		return false;
	}
}


//----------------------------------------------------------------------------------
//	CHANGE FALLBACK WP_PAGE_MENU CLASSES TO MATCH WP_NAV_MENU CLASSES
//----------------------------------------------------------------------------------

function thinkup_input_menuclass( $ulclass ) {

	$ulclass = preg_replace( '/<ul>/', '<ul class="menu">', $ulclass, 1 );
	$ulclass = str_replace( 'children', 'sub-menu', $ulclass );

	return preg_replace('/<div (.*)>(.*)<\/div>/iU', '$2', $ulclass );
}
add_filter( 'wp_page_menu', 'thinkup_input_menuclass' );


//----------------------------------------------------------------------------------
//	DETERMINE IF THE PAGE IS A BLOG - USEFUL FOR HOMEPAGE BLOG.
//----------------------------------------------------------------------------------

// Credit to: http://www.poseidonwebstudios.com/web-development/wordpress-is_blog-function/
function thinkup_check_isblog() {
 
    global $post;
 
    //Post type must be 'post'.
    $post_type = get_post_type($post);
 
    //Check all blog-related conditional tags, as well as the current post type,
    //to determine if we're viewing a blog page.
    return (
        ( is_home() || is_archive() )
        && ($post_type == 'post')
    ) ? true : false ;
 
}


//----------------------------------------------------------------------------------
//	ADD FEATURED IMAGE THUMBNAIL.
//----------------------------------------------------------------------------------

// Add featured images to posts
add_filter('manage_pages_columns', 'thinkup_posts_columns', 5);
add_filter('manage_posts_columns', 'thinkup_posts_columns', 5);
add_action('manage_posts_custom_column', 'thinkup_posts_custom_columns', 5, 2);
add_action('manage_pages_custom_column', 'thinkup_posts_custom_columns', 5, 2);
function thinkup_posts_columns($defaults){
    $defaults['riv_post_thumbs'] = __( 'Thumbs', 'lan-thinkupthemes' );
    return $defaults;
}
function thinkup_posts_custom_columns($column_name, $id){
        if($column_name === 'riv_post_thumbs'){
        echo the_post_thumbnail( 'thumbnail' );
    }
}


//----------------------------------------------------------------------------------
//	ADD MORE BUTTONS TO VISUAL EDITOR.
//----------------------------------------------------------------------------------

function thinkup_visualeditor_morebuttons($buttons) {
	$buttons[] = 'hr';
	$buttons[] = 'del';
	$buttons[] = 'sub';
	$buttons[] = 'sup';
	$buttons[] = 'fontselect';
	$buttons[] = 'fontsizeselect';
	$buttons[] = 'cleanup';
	$buttons[] = 'styleselect';

	return $buttons;
}
add_filter( 'mce_buttons_3', 'thinkup_visualeditor_morebuttons' );


//----------------------------------------------------------------------------------
//	ADD GOOGLE FONT - RALEWAY. (http://themeshaper.com/2014/08/13/how-to-add-google-fonts-to-wordpress-themes/)
//----------------------------------------------------------------------------------

function thinkup_googlefonts_url() {
    $fonts_url = '';

    // Translators: Translate this to 'off' if there are characters in your language that are not supported by Open Sans
    $font_translate = _x( 'on', 'Raleway font: on or off', 'grow' );
 
    if ( 'off' !== $font_translate ) {
        $font_families = array();
  
        if ( 'off' !== $font_translate ) {
            $font_families[] = 'Raleway:300,400,600,700';
        }
 
        $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,latin-ext' ),
        );
 
        $fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
    }
 
    return $fonts_url;
}

function thinkup_googlefonts_scripts() {
   wp_enqueue_style( 'thinkup-google-fonts', thinkup_googlefonts_url(), array(), null );
}
add_action( 'wp_enqueue_scripts', 'thinkup_googlefonts_scripts' );


//----------------------------------------------------------------------------------
//	ADD THEMEBUTTON2 CLASS TO COMMENT CANCEL REPLY BUTTON
//----------------------------------------------------------------------------------

function thinkup_input_cancelreplyclass($class){
    $class = str_replace( 'id="cancel-comment-reply-link"', 'id="cancel-comment-reply-link" class="themebutton2"', $class);
    return $class;
}
add_filter('cancel_comment_reply_link', 'thinkup_input_cancelreplyclass');
	
	
?>