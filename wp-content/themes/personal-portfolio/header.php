<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Personal Portfolio

 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'personal-portfolio' ); ?></a>
	<header id="masthead" class="site-header" role="banner">
		<div class="site-branding">
        	<div class="header-top">
            	<div class="site-description"><?php personalportfolio_contact("header");?></div>
                <div class="header-search"><?php
                	personalportfolio_social_media ("header");
					if (get_theme_mod( 'search_form', 1)) get_search_form();
				?></div>
            </div><!-- .header-top -->
        	
		<?php
        if ( get_theme_mod('logo' , get_template_directory_uri() . '/images/logo.png') ) {
        ?>
            <div class="header-logo-image">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
                <img src="<?php echo esc_url( get_theme_mod('logo' , get_template_directory_uri() . '/images/logo.png') ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
                </a>
            </div><!-- #header-logo-image -->
        <?php
        } else {
        ?>
        	<div class="header-text">
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
        	</div>
        <?php
        }
        ?>
            <div class="clear"></div>
		</div><!-- .site-branding -->
	</header><!-- #masthead -->
    
    <nav id="site-navigation" class="main-navigation <?php if((is_home())or(is_single())or(is_search())or(is_archive())){echo 'mr';}?>" role="navigation">
        <?php wp_nav_menu( array( 'theme_location' => 'menu-1', 'menu_id' => 'primary-menu' ) ); ?>
        
        <div class="clear"></div>
        <div class="nav-foot"></div>
    </nav><!-- #site-navigation -->
    
<?php
// Slider
if( get_theme_mod( 'enable_slider', 1 ) && is_front_page() && $paged <= 1 && ! is_404() ) {?>
    <div class="site-slider"><div class="inner">
    <?php personalportfolio_slider();?>
    <div class="clear"></div></div></div>
<?php }?>
<div id="content" class="site-content">
<!--Breadcrumb NavXT support-->
<div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
<?php if(function_exists('bcn_display'))bcn_display();?>
</div>