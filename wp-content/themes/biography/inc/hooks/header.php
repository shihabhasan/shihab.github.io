<?php
if ( ! function_exists( 'biography_set_global' ) ) :
/**
 * Setting global values for all saved customizer values
 *
 * @since Biography 1.0.0
 *
 * @param null
 * @return null
 *
 */
function biography_set_global() {
    /*Getting saved values start*/
    $GLOBALS['biography_customizer_saved_options'] = biography_get_all_options(1);
}
endif;
add_action( 'biography_action_before_head', 'biography_set_global', 0 );

if ( ! function_exists( 'biography_doctype' ) ) :
/**
 * Doctype Declaration
 *
 * @since Biography 1.0.0
 *
 * @param null
 * @return null
 *
 */
function biography_doctype() {
    ?>
    <!DOCTYPE html><html <?php language_attributes(); ?>>
<?php
}
endif;
add_action( 'biography_action_before_head', 'biography_doctype', 10 );

if ( ! function_exists( 'biography_before_wp_head' ) ) :
/**
 * Before wp head codes
 *
 * @since Biography 1.0.0
 *
 * @param null
 * @return null
 *
 */
function biography_before_wp_head() {
    ?>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php
}
endif;
add_action( 'biography_action_before_wp_head', 'biography_before_wp_head', 10 );

if( ! function_exists( 'biography_default_layout' ) ) :
    /**
     * Biography default layout function
     *
     * @since  Biography 1.0.0
     *
     * @param int
     * @return string
     */
    function biography_default_layout(){
        global $biography_customizer_saved_options;
        $biography_default_layout = $biography_customizer_saved_options['biography-default-layout'];
        return $biography_default_layout;
    }
endif;

if ( ! function_exists( 'biography_body_class' ) ) :
/**
 * add body class
 *
 * @since Biography 1.0.0
 *
 * @param null
 * @return null
 *
 */
function biography_body_class( $biography_body_classes ) {
    if(!is_front_page() || ( is_front_page() && 1 != biography_if_all_disable())){
        $biography_default_layout = biography_default_layout();
        if( !empty( $biography_default_layout ) ){
            if( 'left-sidebar' == $biography_default_layout ){
                $biography_body_classes[] = 'biography-left-sidebar';
            }
            elseif( 'right-sidebar' == $biography_default_layout ){
                $biography_body_classes[] = 'biography-right-sidebar';
            }
            elseif( 'no-sidebar' == $biography_default_layout ){
                $biography_body_classes[] = 'biography-no-sidebar';
            }
            else{
                $biography_body_classes[] = 'biography-right-sidebar';
            }
        }
        else{
            $biography_body_classes[] = 'biography-right-sidebar';
        }
    }
    return $biography_body_classes;

}
endif;
add_action( 'body_class', 'biography_body_class', 10, 1);

if ( ! function_exists( 'biography_page_start' ) ) :
/**
 * page start
 *
 * @since Biography 1.0.0
 *
 * @param null
 * @return null
 *
 */
function biography_page_start() {
?>
    <div id="page" class="hfeed site">
<?php
}
endif;
add_action( 'biography_action_before', 'biography_page_start', 15 );

if ( ! function_exists( 'biography_skip_to_content' ) ) :
/**
 * Skip to content
 *
 * @since Biography 1.0.0
 *
 * @param null
 * @return null
 *
 */
function biography_skip_to_content() {
    ?>
    <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'biography' ); ?></a>
   	<?php
}
endif;
add_action( 'biography_action_before_header', 'biography_skip_to_content', 10 );

if ( ! function_exists( 'biography_header' ) ) :
/**
 * Main header
 *
 * @since Biography 1.0.0
 *
 * @param null
 * @return null
 *
 */
function biography_header() {
    global $biography_customizer_saved_options;
    if ( function_exists( 'has_custom_logo' ) ) {
        $biography_logo = get_custom_logo(); 
    }
     elseif ( !function_exists( 'has_custom_logo' ) ) {
    $biography_logo = esc_url($biography_customizer_saved_options['biography-logo']);
    }
    else{
        $biography_logo = '';
    }
    $biography_header_bg_img = esc_url( get_header_image() );
    $biography_enable_social_icons = esc_attr($biography_customizer_saved_options['biography-enable-social-icons']);
    $nav_col_fixed = 'col-md-12 col-sm-12';
    if( 1 == $biography_enable_social_icons ){
        if( has_nav_menu('social')){
           $nav_col_fixed = 'col-md-6 col-sm-8';
        }
    }
    ?>
    <header id="masthead" class="site-header block-section biography-nav-left" role="banner" style="background-image: url('<?php echo  $biography_header_bg_img;?>');">
		<div class="block-overlay-content">
		<div class="head-top">
			<div class="container">
				<div class="<?php echo esc_attr( $nav_col_fixed);?> col-xs-12">
					<nav id="site-navigation" class="main-navigation" role="navigation">
						<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
						<i class="fa fa-bars"></i>
						</button>
						<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', 'depth' => 5) ); ?>
					</nav><!-- #site-navigation -->
				</div>
				<?php
                if( 1 == $biography_enable_social_icons ){
                    if( has_nav_menu('social')){
                    ?>
                    <div class="col-md-6 col-sm-4 col-xs-12">
                        <div class="social-icon-only">
                        <?php
                        $social_nav_args = array(
                            'theme_location'  => 'social',
                            'container'       => 'div',
                            'container_class' => 'biography-social-section',
                            'depth' => 1
                        );
                        wp_nav_menu( $social_nav_args );
                        ?>
                        </div>
                     </div>
                        <?php
                    }
                }
                ?>
			</div>
		</div>
		<div class="banner-section">
			<div class="container">
				<div class="row">
					<div class="col-md-12 col-lg-10 col-lg-offset-1">
					<?php
					if( !empty( $biography_logo)){
					?>
					<div class="photo-section">
						<span>
                      <?php  if ( !function_exists( 'has_custom_logo' ) ) { ?>
							<img src="<?php echo $biography_logo;?>" alt="<?php esc_attr( get_bloginfo( 'name' ) ); ?>">
                      <?php } else { ?>
                        <?php echo $biography_logo;?>
                      <?php } ?> 
						</span>
					</div><!-- .photo-section -->
					<?php
					}
					?>
					<div class="author-content">
						<div class="site-branding">
							<?php if ( is_front_page() && is_home() ) : ?>
								<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
							<?php else : ?>
								<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
							<?php endif; ?>
							<p class="site-description"><?php bloginfo( 'description' ); ?></p>
						</div><!-- .site-branding -->
						<?php
						/**
                         * biography_action_text_slider hook
                         * @since Biography 1.0.0
                         *
                         * @hooked biography_text_slider -10
                         * @hooked biography_after_text_slider -20
                         */
                        do_action( 'biography_action_text_slider' );
						?>
					</div><!-- .author-content -->
					</div>
				</div>
			</div>
		</div>
		</div>
	</header><!-- #masthead -->
<?php
}
endif;
add_action( 'biography_action_header', 'biography_header', 10 );

if( ! function_exists( 'biography_add_breadcrumb' ) ) :

/**
 * Breadcrumb
 *
 * @since Biography 1.0.0
 *
 * @param null
 * @return null
 *
 */
    function biography_add_breadcrumb(){
        // Bail if Home Page
        if ( is_front_page() || is_home() ) {
            return;
        }
        echo '<div id="breadcrumb"><div class="container">';
         biography_simple_breadcrumb();
        echo '</div><!-- .container --></div><!-- #breadcrumb -->';
    }
endif;
add_action( 'biography_action_after_header', 'biography_add_breadcrumb', 10 );

if( ! function_exists( 'biography_content_start' ) ) :

/**
 * Content Start
 *
 * @since Biography 1.0.0
 *
 * @param null
 * @return void
 *
 */
    function biography_content_start(){
        if ( !is_front_page() || ( is_front_page() && 'posts' == get_option( 'show_on_front' ) ) ) {
            echo '<div id="content" class="site-content">';
        }
    }
    
endif;
add_action( 'biography_action_before_content', 'biography_content_start', 10 );