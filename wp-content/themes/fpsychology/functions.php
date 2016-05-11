<?php
/**
 * fPsychology functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @subpackage fPsychology
 * @author tishonator
 * @since fPsychology 1.0.0
 *
 */

if ( ! function_exists( 'fpsychology_setup' ) ) :
/**
 * fPsychology setup.
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support post thumbnails.
 *
 */
function fpsychology_setup() {

	load_theme_textdomain( 'fpsychology', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );

	add_theme_support( "title-tag" );

	// add custom header
	add_theme_support( 'custom-header', array (
					   'default-image'          => '',
					   'random-default'         => '',
					   'width'                  => 180,
					   'height'                 => 36,
					   'flex-height'            => '',
					   'flex-width'             => '',
					   'default-text-color'     => '',
					   'header-text'            => '',
					   'uploads'                => true,
					   'wp-head-callback'       => '',
					   'admin-head-callback'    => '',
					   'admin-preview-callback' => '',
					) );

	// add the visual editor to resemble the theme style
	add_editor_style( array( 'css/editor-style.css' ) );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary'   => __( 'primary menu', 'fpsychology' ),
	) );

	

	// add Custom background				 
	add_theme_support( 'custom-background', 
				   array ('default-color'  => '#FFFFFF')
				 );

	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1200, 0, true );

	if ( ! isset( $content_width ) )
		$content_width = 900;

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form', 'comment-list',
	) );
}
endif; // fpsychology_setup
add_action( 'after_setup_theme', 'fpsychology_setup' );

/**
 * the main function to load scripts in the fPsychology theme
 * if you add a new load of script, style, etc. you can use that function
 * instead of adding a new wp_enqueue_scripts action for it.
 */
function fpsychology_load_scripts() {

	// load main stylesheet.
	wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/css/font-awesome.min.css', array( ) );
	wp_enqueue_style( 'fpsychology-style', get_stylesheet_uri(), array( ) );
	
	wp_enqueue_style( 'fpsychology-fonts', fpsychology_fonts_url(), array(), null );
	
	// Load thread comments reply script
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
	
	// Load Utilities JS Script
	wp_enqueue_script( 'fpsychology-js', get_template_directory_uri() . '/js/utilities.js', array( 'jquery' ) );

	wp_enqueue_script( 'mobile.customized', get_template_directory_uri() . '/js/jquery.mobile.customized.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'jquery.easing.1.3', get_template_directory_uri() . '/js/jquery.easing.1.3.js', array( 'jquery' ) );
	wp_enqueue_script( 'camera', get_template_directory_uri() . '/js/camera.min.js', array( 'jquery' ) );
}

add_action( 'wp_enqueue_scripts', 'fpsychology_load_scripts' );

/**
 *	Load google font url used in the fPsychology theme
 */
function fpsychology_fonts_url() {

    $fonts_url = '';
 
    /* Translators: If there are characters in your language that are not
    * supported by PT Sans, translate this to 'off'. Do not translate
    * into your own language.
    */
    $opensansfont = _x( 'on', 'Open Sans font: on or off', 'fpsychology' );

    if ( 'off' !== $opensansfont ) {
        $font_families = array();
 
        $font_families[] = 'Open Sans';
 
        $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,cyrillic-ext,cyrillic,latin-ext' ),
        );
 
        $fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
    }
 
    return $fonts_url;
}

/**
 * Display html code of all social sites
 */
function fpsychology_display_social_sites() {

	echo '<ul class="header-social-widget">';

	$socialURL = get_theme_mod('fpsychology_social_facebook', '#');
	if ( !empty($socialURL) ) {

		echo '<li><a href="' . esc_url( $socialURL ) . '" title="' . __('Follow us on Facebook', 'fpsychology') . '" class="facebook16"></a>';
	}

	$socialURL = get_theme_mod('fpsychology_social_google', '#');
	if ( !empty($socialURL) ) {

		echo '<li><a href="' . esc_url( $socialURL ) . '" title="' . __('Follow us on Google+', 'fpsychology') . '" class="google16"></a>';
	}

	$socialURL = get_theme_mod('fpsychology_social_twitter', '#');
	if ( !empty($socialURL) ) {

		echo '<li><a href="' . esc_url( $socialURL ) . '" title="' . __('Follow us on Twitter', 'fpsychology') . '" class="twitter16"></a>';
	}

	$socialURL = get_theme_mod('fpsychology_social_linkedin', '#');
	if ( !empty($socialURL) ) {

		echo '<li><a href="' . esc_url( $socialURL ) . '" title="' . __('Follow us on LinkeIn', 'fpsychology') . '" class="linkedin16"></a>';
	}

	$socialURL = get_theme_mod('fpsychology_social_instagram', '#');
	if ( !empty($socialURL) ) {

		echo '<li><a href="' . esc_url( $socialURL ) . '" title="' . __('Follow us on Instagram', 'fpsychology') . '" class="instagram16"></a>';
	}

	$socialURL = get_theme_mod('fpsychology_social_rss', get_bloginfo( 'rss2_url' ));
	if ( !empty($socialURL) ) {

		echo '<li><a href="' . esc_url( $socialURL ) . '" title="' . __('Follow our RSS Feeds', 'fpsychology') . '" class="rss16"></a>';
	}

	$socialURL = get_theme_mod('fpsychology_social_tumblr', '#');
	if ( !empty($socialURL) ) {

		echo '<li><a href="' . esc_url( $socialURL ) . '" title="' . __('Follow us on Tumblr', 'fpsychology') . '" class="tumblr16"></a>';
	}

	$socialURL = get_theme_mod('fpsychology_social_youtube', '#');
	if ( !empty($socialURL) ) {

		echo '<li><a href="' . esc_url( $socialURL ) . '" title="' . __('Follow us on Youtube', 'fpsychology') . '" class="youtube16"></a>';
	}

	$socialURL = get_theme_mod('fpsychology_social_pinterest', '#');
	if ( !empty($socialURL) ) {

		echo '<li><a href="' . esc_url( $socialURL ) . '" title="' . __('Follow us on Pinterest', 'fpsychology') . '" class="pinterest16"></a>';
	}

	$socialURL = get_theme_mod('fpsychology_social_vk', '#');
	if ( !empty($socialURL) ) {

		echo '<li><a href="' . esc_url( $socialURL ) . '" title="' . __('Follow us on VK', 'fpsychology') . '" class="vk16"></a>';
	}

	$socialURL = get_theme_mod('fpsychology_social_flickr', '#');
	if ( !empty($socialURL) ) {

		echo '<li><a href="' . esc_url( $socialURL ) . '" title="' . __('Follow us on Flickr', 'fpsychology') . '" class="flickr16"></a>';
	}

	$socialURL = get_theme_mod('fpsychology_social_vine', '#');
	if ( !empty($socialURL) ) {

		echo '<li><a href="' . esc_url( $socialURL ) . '" title="' . __('Follow us on Vine', 'fpsychology') . '" class="vine16"></a>';
	}

	echo '</ul>';
}

/**
 *	Used to load the content for posts and pages.
 */
function fpsychology_the_content() {

	// Display Thumbnails if thumbnail is set for the post
	if ( has_post_thumbnail() ) {
?>

		<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title_attribute(); ?>">
			<?php the_post_thumbnail(); ?>
		</a>
								
<?php
	}
	the_content( __( 'Read More', 'fpsychology') );
}

/**
 * Display website's logo image
 */
function fpsychology_show_website_logo_image_or_title() {

	if ( get_header_image() != '' ) {
	
		// Check if the user selected a header Image in the Customizer or the Header Menu
		$logoImgPath = get_header_image();
		$siteTitle = get_bloginfo( 'name' );
		$imageWidth = get_custom_header()->width;
		$imageHeight = get_custom_header()->height;
		
		echo '<a href="' . esc_url( home_url('/') ) . '" title="' . esc_attr( get_bloginfo('name') ) . '">';
		
		echo '<img src="' . esc_url( $logoImgPath ) . '" alt="' . esc_attr( $siteTitle ) . '" title="' . esc_attr( $siteTitle ) . '" width="' . esc_attr( $imageWidth ) . '" height="' . esc_attr( $imageHeight ) . '" />';
		
		echo '</a>';

	} else {
	
		echo '<a href="' . esc_url( home_url('/') ) . '" title="' . esc_attr( get_bloginfo('name') ) . '">';
		
		echo '<h1>'.get_bloginfo('name').'</h1>';
		
		echo '</a>';
		
		echo '<strong>'.get_bloginfo('description').'</strong>';
	}
}

/**
 *	Displays the copyright text.
 */
function fpsychology_show_copyright_text() {

	$footerText = get_theme_mod('fpsychology_footer_copyright', null);

	if ( !empty( $footerText ) ) {

		echo esc_html( $footerText ) . ' | ';		
	}
}

/**
 *	widgets-init action handler. Used to register widgets and register widget areas
 */
function fpsychology_widgets_init() {
	
	// Register Sidebar Widget.
	register_sidebar( array (
						'name'	 		 =>	 __( 'Sidebar Widget Area', 'fpsychology'),
						'id'		 	 =>	 'sidebar-widget-area',
						'description'	 =>  __( 'The sidebar widget area', 'fpsychology'),
						'before_widget'	 =>  '',
						'after_widget'	 =>  '',
						'before_title'	 =>  '<div class="sidebar-before-title"></div><h3 class="sidebar-title">',
						'after_title'	 =>  '</h3><div class="sidebar-after-title"></div>',
					) );
					
	/**
	 * Add Homepage Columns Widget areas
	 */
	register_sidebar( array (
							'name'			 =>  __( 'Homepage Column #1', 'fpsychology' ),
							'id' 			 =>  'homepage-column-1-widget-area',
							'description'	 =>  __( 'The Homepage Column #1 widget area', 'fpsychology' ),
							'before_widget'  =>  '',
							'after_widget'	 =>  '',
							'before_title'	 =>  '<h2 class="sidebar-title">',
							'after_title'	 =>  '</h2><div class="sidebar-after-title"></div>',
						) );
						
	register_sidebar( array (
							'name'			 =>  __( 'Homepage Column #2', 'fpsychology' ),
							'id' 			 =>  'homepage-column-2-widget-area',
							'description'	 =>  __( 'The Homepage Column #2 widget area', 'fpsychology' ),
							'before_widget'  =>  '',
							'after_widget'	 =>  '',
							'before_title'	 =>  '<h2 class="sidebar-title">',
							'after_title'	 =>  '</h2><div class="sidebar-after-title"></div>',
						) );
}

add_action( 'widgets_init', 'fpsychology_widgets_init' );

/**
 * Displays the slider
 */
function fpsychology_display_slider() { ?>

	<div class="camera_wrap camera_emboss" id="camera_wrap">
		<?php
			// display slides
			for ( $i = 1; $i <= 3; ++$i ) {

					$defaultSlideContent = __( '<h2>Lorem ipsum dolor</h2><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><a class="btn" title="Read more" href="#">Read more</a>', 'fpsychology' );
					
					$defaultSlideImage = get_template_directory_uri().'/images/slider/' . $i .'.jpg';

					$slideContent = get_theme_mod( 'fpsychology_slide'.$i.'_content', html_entity_decode( $defaultSlideContent ) );
					$slideImage = get_theme_mod( 'fpsychology_slide'.$i.'_image', $defaultSlideImage );

				?>
				
					<div data-thumb="<?php echo esc_attr( $slideImage ); ?>" data-src="<?php echo esc_attr( $slideImage ); ?>">
						<div class="camera_caption fadeIn">
							<?php echo $slideContent; ?>
						</div>
					</div>
<?php		} ?>
	</div><!-- #camera_wrap -->
<?php 
}

/**
 *	Displays the single content.
 */
function fpsychology_the_content_single() {

	// Display Thumbnails if thumbnail is set for the post
	if ( has_post_thumbnail() ) {

		the_post_thumbnail();
	}
	the_content( __( 'Read More...', 'fpsychology') );
}

/**
 * Register theme settings in the customizer
 */
function fpsychology_customize_register( $wp_customize ) {

    /**
	 * Add Social Sites Section
	 */
	$wp_customize->add_section(
		'fpsychology_social_section',
		array(
			'title'       => __( 'Social Sites', 'fpsychology' ),
			'capability'  => 'edit_theme_options',
		)
	);
	
	// Add facebook url
	$wp_customize->add_setting(
		'fpsychology_social_facebook',
		array(
		    'default'           => '#',
		    'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fpsychology_social_facebook',
        array(
            'label'          => __( 'Facebook Page URL', 'fpsychology' ),
            'section'        => 'fpsychology_social_section',
            'settings'       => 'fpsychology_social_facebook',
            'type'           => 'text',
            )
        )
	);

	// Add google+ url
	$wp_customize->add_setting(
		'fpsychology_social_google',
		array(
		    'default'           => '#',
		    'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fpsychology_social_google',
        array(
            'label'          => __( 'Google+ Page URL', 'fpsychology' ),
            'section'        => 'fpsychology_social_section',
            'settings'       => 'fpsychology_social_google',
            'type'           => 'text',
            )
        )
	);

	// Add twitter url
	$wp_customize->add_setting(
		'fpsychology_social_twitter',
		array(
		    'default'           => '#',
		    'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fpsychology_social_twitter',
        array(
            'label'          => __( 'Twitter Page URL', 'fpsychology' ),
            'section'        => 'fpsychology_social_section',
            'settings'       => 'fpsychology_social_twitter',
            'type'           => 'text',
            )
        )
	);

	// Add LinkedIn url
	$wp_customize->add_setting(
		'fpsychology_social_linkedin',
		array(
		    'default'           => '#',
		    'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fpsychology_social_linkedin',
        array(
            'label'          => __( 'LinkedIn Page URL', 'fpsychology' ),
            'section'        => 'fpsychology_social_section',
            'settings'       => 'fpsychology_social_linkedin',
            'type'           => 'text',
            )
        )
	);

	// Add Instagram url
	$wp_customize->add_setting(
		'fpsychology_social_instagram',
		array(
		    'default'           => '#',
		    'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fpsychology_social_instagram',
        array(
            'label'          => __( 'instagram Page URL', 'fpsychology' ),
            'section'        => 'fpsychology_social_section',
            'settings'       => 'fpsychology_social_instagram',
            'type'           => 'text',
            )
        )
	);

	// Add RSS Feeds url
	$wp_customize->add_setting(
		'fpsychology_social_rss',
		array(
		    'default'           => get_bloginfo( 'rss2_url' ),
		    'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fpsychology_social_rss',
        array(
            'label'          => __( 'RSS Feeds URL', 'fpsychology' ),
            'section'        => 'fpsychology_social_section',
            'settings'       => 'fpsychology_social_rss',
            'type'           => 'text',
            )
        )
	);

	// Add Tumblr url
	$wp_customize->add_setting(
		'fpsychology_social_tumblr',
		array(
		    'default'           => '#',
		    'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fpsychology_social_tumblr',
        array(
            'label'          => __( 'Tumblr Page URL', 'fpsychology' ),
            'section'        => 'fpsychology_social_section',
            'settings'       => 'fpsychology_social_tumblr',
            'type'           => 'text',
            )
        )
	);

	// Add YouTube channel url
	$wp_customize->add_setting(
		'fpsychology_social_youtube',
		array(
		    'default'           => '#',
		    'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fpsychology_social_youtube',
        array(
            'label'          => __( 'YouTube channel URL', 'fpsychology' ),
            'section'        => 'fpsychology_social_section',
            'settings'       => 'fpsychology_social_youtube',
            'type'           => 'text',
            )
        )
	);

	// Add Pinterest page url
	$wp_customize->add_setting(
		'fpsychology_social_pinterest',
		array(
		    'default'           => '#',
		    'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fpsychology_social_pinterest',
        array(
            'label'          => __( 'Pinterest Page URL', 'fpsychology' ),
            'section'        => 'fpsychology_social_section',
            'settings'       => 'fpsychology_social_pinterest',
            'type'           => 'text',
            )
        )
	);

	// Add VK page url
	$wp_customize->add_setting(
		'fpsychology_social_vk',
		array(
		    'default'           => '#',
		    'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fpsychology_social_vk',
        array(
            'label'          => __( 'VK Page URL', 'fpsychology' ),
            'section'        => 'fpsychology_social_section',
            'settings'       => 'fpsychology_social_vk',
            'type'           => 'text',
            )
        )
	);

	// Add Flickr page url
	$wp_customize->add_setting(
		'fpsychology_social_flickr',
		array(
		    'default'           => '#',
		    'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fpsychology_social_flickr',
        array(
            'label'          => __( 'Flickr Page URL', 'fpsychology' ),
            'section'        => 'fpsychology_social_section',
            'settings'       => 'fpsychology_social_flickr',
            'type'           => 'text',
            )
        )
	);

	// Add Vine page url
	$wp_customize->add_setting(
		'fpsychology_social_vine',
		array(
		    'default'           => '#',
		    'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fpsychology_social_vine',
        array(
            'label'          => __( 'Vine Page URL', 'fpsychology' ),
            'section'        => 'fpsychology_social_section',
            'settings'       => 'fpsychology_social_vine',
            'type'           => 'text',
            )
        )
	);
	
	/**
	 * Add Slider Section
	 */
	$wp_customize->add_section(
		'fpsychology_slider_section',
		array(
			'title'       => __( 'Slider', 'fpsychology' ),
			'capability'  => 'edit_theme_options',
		)
	);
	
	// Add slide 1 content
	$wp_customize->add_setting(
		'fpsychology_slide1_content',
		array(
		    'default'           => __( '<h2>Lorem ipsum dolor</h2><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><a class="btn" title="Read more" href="#">Read more</a>', 'fpsychology' ),
		    'sanitize_callback' => 'force_balance_tags',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fpsychology_slide1_content',
        array(
            'label'          => __( 'Slide #1 Content', 'fpsychology' ),
            'section'        => 'fpsychology_slider_section',
            'settings'       => 'fpsychology_slide1_content',
            'type'           => 'textarea',
            )
        )
	);
	
	// Add slide 1 background image
	$wp_customize->add_setting( 'fpsychology_slide1_image',
		array(
			'default' => get_template_directory_uri().'/images/slider/' . '1.jpg',
    		'sanitize_callback' => 'esc_url_raw'
		)
	);

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'fpsychology_slide1_image',
			array(
				'label'   	 => __( 'Slide 1 Image', 'fpsychology' ),
				'section' 	 => 'fpsychology_slider_section',
				'settings'   => 'fpsychology_slide1_image',
			) 
		)
	);
	
	// Add slide 2 content
	$wp_customize->add_setting(
		'fpsychology_slide2_content',
		array(
		    'default'           => __( '<h2>Lorem ipsum dolor</h2><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><a class="btn" title="Read more" href="#">Read more</a>', 'fpsychology' ),
		    'sanitize_callback' => 'force_balance_tags',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fpsychology_slide2_content',
        array(
            'label'          => __( 'Slide #2 Content', 'fpsychology' ),
            'section'        => 'fpsychology_slider_section',
            'settings'       => 'fpsychology_slide2_content',
            'type'           => 'textarea',
            )
        )
	);
	
	// Add slide 2 background image
	$wp_customize->add_setting( 'fpsychology_slide2_image',
		array(
			'default' => get_template_directory_uri().'/images/slider/' . '2.jpg',
    		'sanitize_callback' => 'esc_url_raw'
		)
	);

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'fpsychology_slide2_image',
			array(
				'label'   	 => __( 'Slide 2 Image', 'fpsychology' ),
				'section' 	 => 'fpsychology_slider_section',
				'settings'   => 'fpsychology_slide2_image',
			) 
		)
	);
	
	// Add slide 3 content
	$wp_customize->add_setting(
		'fpsychology_slide3_content',
		array(
		    'default'           => __( '<h2>Lorem ipsum dolor</h2><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><a class="btn" title="Read more" href="#">Read more</a>', 'fpsychology' ),
		    'sanitize_callback' => 'force_balance_tags',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fpsychology_slide3_content',
        array(
            'label'          => __( 'Slide #3 Content', 'fpsychology' ),
            'section'        => 'fpsychology_slider_section',
            'settings'       => 'fpsychology_slide3_content',
            'type'           => 'textarea',
            )
        )
	);
	
	// Add slide 3 background image
	$wp_customize->add_setting( 'fpsychology_slide3_image',
		array(
			'default' => get_template_directory_uri().'/images/slider/' . '3.jpg',
    		'sanitize_callback' => 'esc_url_raw'
		)
	);

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'fpsychology_slide3_image',
			array(
				'label'   	 => __( 'Slide 3 Image', 'fpsychology' ),
				'section' 	 => 'fpsychology_slider_section',
				'settings'   => 'fpsychology_slide3_image',
			) 
		)
	);

	/**
	 * Add Footer Section
	 */
	$wp_customize->add_section(
		'fpsychology_footer_section',
		array(
			'title'       => __( 'Footer', 'fpsychology' ),
			'capability'  => 'edit_theme_options',
		)
	);
	
	// Add footer copyright text
	$wp_customize->add_setting(
		'fpsychology_footer_copyright',
		array(
		    'default'           => '',
		    'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fpsychology_footer_copyright',
        array(
            'label'          => __( 'Copyright Text', 'fpsychology' ),
            'section'        => 'fpsychology_footer_section',
            'settings'       => 'fpsychology_footer_copyright',
            'type'           => 'text',
            )
        )
	);
}

add_action('customize_register', 'fpsychology_customize_register');

/*
Enqueue Script for top buttons
*/
function fpsychology_customizer_controls(){

	wp_register_script( 'fpsychology_customizer_top_buttons', get_template_directory_uri() . '/js/customizer-top-buttons.js', array( 'jquery' ), true  );
	wp_enqueue_script( 'fpsychology_customizer_top_buttons' );

	wp_localize_script( 'fpsychology_customizer_top_buttons', 'customBtns', array(
		'prodemo' => esc_html__( 'Demo Premium version', 'fpsychology' ),
        'proget' => esc_html__( 'Get Premium version', 'fpsychology' )
	) );
}
add_action( 'customize_controls_enqueue_scripts', 'fpsychology_customizer_controls' );

?>
