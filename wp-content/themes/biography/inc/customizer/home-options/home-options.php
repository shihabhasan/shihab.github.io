<?php
/*Featured text slider setting controls*/
$wp_customize->add_section( 'biography-home-service-pages', array(
    'capability' => 'edit_theme_options',
    'priority'       => 160,
    'title'          => __( 'Home/Front Service Section', 'biography' ),
    'description'    => __( 'Select pages for service section, you can also change the icon per page', 'biography' )
) );

$wp_customize->add_setting( 'biography-options[biography-home-service-enable]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $biography_customizer_defaults['biography-home-service-enable'],
    'sanitize_callback' => 'biography_sanitize_checkbox'
) );

$wp_customize->add_control( 'biography-options[biography-home-service-enable]', array(
    'label'                 =>  __( 'Enable Service', 'biography' ),
    'section'               => 'biography-home-service-pages',
    'type'                  => 'checkbox',
    'priority'              => 10,
    'settings' => 'biography-options[biography-home-service-enable]',
) );

$wp_customize->add_setting( 'biography-options[biography-home-service-page-1]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $biography_customizer_defaults['biography-home-service-page-1'],
    'sanitize_callback' => 'biography_sanitize_post'
) );

$wp_customize->add_control( 'biography-options[biography-home-service-page-1]', array(
    'label'                 =>  __( 'Select Page For Service 1', 'biography' ),
    'section'               => 'biography-home-service-pages',
    'type'                  => 'dropdown-pages',
    'priority'              => 20,
    'settings' => 'biography-options[biography-home-service-page-1]',
) );
$wp_customize->add_setting( 'biography-options[biography-home-service-icon-1]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $biography_customizer_defaults['biography-home-service-icon-1'],
    'sanitize_callback' => 'sanitize_text_field'
) );

$wp_customize->add_control( 'biography-options[biography-home-service-icon-1]', array(
    'label'                 =>  __( 'Icon For Service 1', 'biography' ),
    'description'           => sprintf( __( 'Use font awesome icon: Eg: %s. %sSee more here%s', 'biography' ), 'fa-desktop','<a href="'.esc_url('http://fontawesome.io/icons/').'" target="_blank">','</a>' ),
    'section'               => 'biography-home-service-pages',
    'type'                  => 'text',
    'priority'              => 30,
    'settings' => 'biography-options[biography-home-service-icon-1]',
) );

$wp_customize->add_setting( 'biography-options[biography-home-service-page-2]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $biography_customizer_defaults['biography-home-service-page-2'],
    'sanitize_callback' => 'biography_sanitize_post'
) );

$wp_customize->add_control( 'biography-options[biography-home-service-page-2]', array(
    'label'                 =>  __( 'Select Page For Service 2', 'biography' ),
    'section'               => 'biography-home-service-pages',
    'type'                  => 'dropdown-pages',
    'priority'              => 40,
    'settings' => 'biography-options[biography-home-service-page-2]',
) );

$wp_customize->add_setting( 'biography-options[biography-home-service-icon-2]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $biography_customizer_defaults['biography-home-service-icon-2'],
    'sanitize_callback' => 'sanitize_text_field'
) );

$wp_customize->add_control( 'biography-options[biography-home-service-icon-2]', array(
    'label'                 =>  __( 'Icon For Service 2', 'biography' ),
    'description'           => sprintf( __( 'Use font awesome icon: Eg: %s. %sSee more here%s', 'biography' ), 'fa-camera-retro','<a href="'.esc_url('http://fontawesome.io/icons/').'" target="_blank">','</a>' ),
    'section'               => 'biography-home-service-pages',
    'type'                  => 'text',
    'priority'              => 50,
    'settings' => 'biography-options[biography-home-service-icon-2]',
) );

$wp_customize->add_setting( 'biography-options[biography-home-service-page-3]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $biography_customizer_defaults['biography-home-service-page-3'],
    'sanitize_callback' => 'biography_sanitize_post'
) );

$wp_customize->add_control( 'biography-options[biography-home-service-page-3]', array(
    'label'                 =>  __( 'Select Page For Service 3', 'biography' ),
    'section'               => 'biography-home-service-pages',
    'type'                  => 'dropdown-pages',
    'priority'              => 60,
    'settings' => 'biography-options[biography-home-service-page-3]',
) );

$wp_customize->add_setting( 'biography-options[biography-home-service-icon-3]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $biography_customizer_defaults['biography-home-service-icon-3'],
    'sanitize_callback' => 'sanitize_text_field'
) );

$wp_customize->add_control( 'biography-options[biography-home-service-icon-3]', array(
    'label'                 =>  __( 'Icon For Service 3', 'biography' ),
    'description'           => sprintf( __( 'Use font awesome icon: Eg: %s. %sSee more here%s', 'biography' ), 'fa-rocket','<a href="'.esc_url('http://fontawesome.io/icons/').'" target="_blank">','</a>' ),
    'section'               => 'biography-home-service-pages',
    'type'                  => 'text',
    'priority'              => 70,
    'settings' => 'biography-options[biography-home-service-icon-3]',
) );

/*Review Section*/
$wp_customize->add_section( 'biography-home-review', array(
    'capability' => 'edit_theme_options',
    'title'          => __( 'Home/Front Review Section', 'biography' ),
    'priority'       => 165
) );

$wp_customize->add_setting( 'biography-options[biography-home-review-enable]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $biography_customizer_defaults['biography-home-review-enable'],
    'sanitize_callback' => 'biography_sanitize_checkbox'
) );

$wp_customize->add_control( 'biography-options[biography-home-review-enable]', array(
    'settings' => 'biography-options[biography-home-review-enable]',
    'label'                 =>  __( 'Enable Review', 'biography' ),
    'section'               => 'biography-home-review',
    'type'                  => 'checkbox',
    'priority'              => 10
) );

$wp_customize->add_setting( 'biography-options[biography-home-about-page-id]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $biography_customizer_defaults['biography-home-about-page-id'],
    'sanitize_callback' => 'biography_sanitize_post'
) );

$wp_customize->add_control( 'biography-options[biography-home-about-page-id]', array(
    'settings' => 'biography-options[biography-home-about-page-id]',
    'label'                 =>  __( 'Select Page For About', 'biography' ),
    'section'               => 'biography-home-review',
    'type'                  => 'dropdown-pages',
    'priority'              => 20
) );

$wp_customize->add_setting( 'biography-options[biography-home-testimonial-title]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $biography_customizer_defaults['biography-home-testimonial-title'],
    'sanitize_callback' => 'sanitize_text_field'
) );

$wp_customize->add_control( 'biography-options[biography-home-testimonial-title]', array(
    'settings' => 'biography-options[biography-home-testimonial-title]',
    'label'                 =>  __( 'Testimonial Main Title', 'biography' ),
    'section'               => 'biography-home-review',
    'type'                  => 'text',
    'priority'              => 30
) );

$wp_customize->add_setting( 'biography-options[biography-home-testimonial-page-1]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $biography_customizer_defaults['biography-home-testimonial-page-1'],
    'sanitize_callback' => 'biography_sanitize_post'
) );

$wp_customize->add_control( 'biography-options[biography-home-testimonial-page-1]', array(
    'label'                 =>  __( 'Select Page For Testimonial 1', 'biography' ),
    'section'               => 'biography-home-review',
    'type'                  => 'dropdown-pages',
    'priority'              => 40,
    'settings' => 'biography-options[biography-home-testimonial-page-1]',
) );

$wp_customize->add_setting( 'biography-options[biography-home-testimonial-page-2]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $biography_customizer_defaults['biography-home-testimonial-page-2'],
    'sanitize_callback' => 'biography_sanitize_post'
) );

$wp_customize->add_control( 'biography-options[biography-home-testimonial-page-2]', array(
    'label'                 =>  __( 'Select Page For Testimonial 2', 'biography' ),
    'section'               => 'biography-home-review',
    'type'                  => 'dropdown-pages',
    'priority'              => 50,
    'settings' => 'biography-options[biography-home-testimonial-page-2]',
) );

$wp_customize->add_setting( 'biography-options[biography-home-testimonial-page-3]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $biography_customizer_defaults['biography-home-testimonial-page-3'],
    'sanitize_callback' => 'biography_sanitize_post'
) );

$wp_customize->add_control( 'biography-options[biography-home-testimonial-page-3]', array(
    'label'                 =>  __( 'Select Page For Testimonial 3', 'biography' ),
    'section'               => 'biography-home-review',
    'type'                  => 'dropdown-pages',
    'priority'              => 60,
    'settings' => 'biography-options[biography-home-testimonial-page-3]'
) );

/*History Section*/
$wp_customize->add_section( 'biography-home-history-pages', array(
    'title'          => __( 'Home/Front History Section', 'biography' ),
    'priority'       => 170
) );

$wp_customize->add_setting( 'biography-options[biography-home-history-enable]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $biography_customizer_defaults['biography-home-history-enable'],
    'sanitize_callback' => 'biography_sanitize_checkbox'
) );

$wp_customize->add_control( 'biography-options[biography-home-history-enable]', array(
    'settings' => 'biography-options[biography-home-history-enable]',
    'label'                 =>  __( 'Enable History', 'biography' ),
    'section'               => 'biography-home-history-pages',
    'type'                  => 'checkbox',
    'priority'              => 10
) );

$wp_customize->add_setting( 'biography-options[biography-home-history-title]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $biography_customizer_defaults['biography-home-history-title'],
    'sanitize_callback' => 'sanitize_text_field'
) );

$wp_customize->add_control( 'biography-options[biography-home-history-title]', array(
    'settings' => 'biography-options[biography-home-history-title]',
    'label'                 =>  __( 'History Main Title', 'biography' ),
    'section'               => 'biography-home-history-pages',
    'type'                  => 'text',
    'priority'              => 15
) );
$wp_customize->add_setting( 'biography-options[biography-home-history-page-1]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $biography_customizer_defaults['biography-home-history-page-1'],
    'sanitize_callback' => 'biography_sanitize_post'
) );

$wp_customize->add_control( 'biography-options[biography-home-history-page-1]', array(
    'label'                 =>  __( 'Select Page For History 1', 'biography' ),
    'section'               => 'biography-home-history-pages',
    'type'                  => 'dropdown-pages',
    'priority'              => 20,
    'settings' => 'biography-options[biography-home-history-page-1]',
) );
$wp_customize->add_setting( 'biography-options[biography-home-history-duration-1]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $biography_customizer_defaults['biography-home-history-duration-1'],
    'sanitize_callback' => 'sanitize_text_field'
) );

$wp_customize->add_control( 'biography-options[biography-home-history-duration-1]', array(
    'settings' => 'biography-options[biography-home-history-duration-1]',
    'label'                 =>  __( 'Duration For History 1', 'biography' ),
    'section'               => 'biography-home-history-pages',
    'type'                  => 'text',
    'priority'              => 30
) );
$wp_customize->add_setting( 'biography-options[biography-home-history-icon-1]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $biography_customizer_defaults['biography-home-history-icon-1'],
    'sanitize_callback' => 'sanitize_text_field'
) );

$wp_customize->add_control( 'biography-options[biography-home-history-icon-1]', array(
    'label'                 =>  __( 'Icon For History 1', 'biography' ),
    'description'           => sprintf( __( 'Use font awesome icon: Eg: %s. %sSee more here%s', 'biography' ), 'fa-desktop','<a href="'.esc_url('http://fontawesome.io/icons/').'" target="_blank">','</a>' ),
    'section'               => 'biography-home-history-pages',
    'type'                  => 'text',
    'priority'              => 35,
    'settings' => 'biography-options[biography-home-history-icon-1]',
) );

$wp_customize->add_setting( 'biography-options[biography-home-history-page-2]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $biography_customizer_defaults['biography-home-history-page-2'],
    'sanitize_callback' => 'biography_sanitize_post'
) );

$wp_customize->add_control( 'biography-options[biography-home-history-page-2]', array(
    'label'                 =>  __( 'Select Page For History 2', 'biography' ),
    'section'               => 'biography-home-history-pages',
    'type'                  => 'dropdown-pages',
    'priority'              => 40,
    'settings' => 'biography-options[biography-home-history-page-2]',
) );
$wp_customize->add_setting( 'biography-options[biography-home-history-duration-2]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $biography_customizer_defaults['biography-home-history-duration-2'],
    'sanitize_callback' => 'sanitize_text_field'
) );

$wp_customize->add_control( 'biography-options[biography-home-history-duration-2]', array(
    'settings' => 'biography-options[biography-home-history-duration-2]',
    'label'                 =>  __( 'Duration For History 2', 'biography' ),
    'section'               => 'biography-home-history-pages',
    'type'                  => 'text',
    'priority'              => 50
) );
$wp_customize->add_setting( 'biography-options[biography-home-history-icon-2]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $biography_customizer_defaults['biography-home-history-icon-2'],
    'sanitize_callback' => 'sanitize_text_field'
) );

$wp_customize->add_control( 'biography-options[biography-home-history-icon-2]', array(
    'label'                 =>  __( 'Icon For History 2', 'biography' ),
    'description'           => sprintf( __( 'Use font awesome icon: Eg: %s. %sSee more here%s', 'biography' ), 'fa-camera-retro','<a href="'.esc_url('http://fontawesome.io/icons/').'" target="_blank">','</a>' ),
    'section'               => 'biography-home-history-pages',
    'type'                  => 'text',
    'priority'              => 55,
    'settings' => 'biography-options[biography-home-history-icon-2]',
) );

$wp_customize->add_setting( 'biography-options[biography-home-history-page-3]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $biography_customizer_defaults['biography-home-history-page-3'],
    'sanitize_callback' => 'biography_sanitize_post'
) );

$wp_customize->add_control( 'biography-options[biography-home-history-page-3]', array(
    'label'                 =>  __( 'Select Page For History 3', 'biography' ),
    'section'               => 'biography-home-history-pages',
    'type'                  => 'dropdown-pages',
    'priority'              => 60,
    'settings' => 'biography-options[biography-home-history-page-3]',
) );
$wp_customize->add_setting( 'biography-options[biography-home-history-duration-3]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $biography_customizer_defaults['biography-home-history-duration-3'],
    'sanitize_callback' => 'sanitize_text_field'
) );

$wp_customize->add_control( 'biography-options[biography-home-history-duration-3]', array(
    'settings' => 'biography-options[biography-home-history-duration-3]',
    'label'                 =>  __( 'Duration For History 3', 'biography' ),
    'section'               => 'biography-home-history-pages',
    'type'                  => 'text',
    'priority'              => 65
) );
$wp_customize->add_setting( 'biography-options[biography-home-history-icon-3]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $biography_customizer_defaults['biography-home-history-icon-3'],
    'sanitize_callback' => 'sanitize_text_field'
) );

$wp_customize->add_control( 'biography-options[biography-home-history-icon-3]', array(
    'label'                 =>  __( 'Icon For History 3', 'biography' ),
    'description'           => sprintf( __( 'Use font awesome icon: Eg: %s. %sSee more here%s', 'biography' ), 'fa-rocket','<a href="'.esc_url('http://fontawesome.io/icons/').'" target="_blank">','</a>' ),
    'section'               => 'biography-home-history-pages',
    'type'                  => 'text',
    'priority'              => 70,
    'settings' => 'biography-options[biography-home-history-icon-3]',
) );