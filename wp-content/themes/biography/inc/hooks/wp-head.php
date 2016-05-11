<?php
if( ! function_exists( 'biography_wp_head' ) ) :

    /**
     * Biography wp_head hook
     *
     * @since  Biography 1.0.0
     */
    function biography_wp_head(){
        global $biography_google_fonts,$biography_customizer_saved_options;
        $biography_customizer_saved_options['biography-font-family-site-identity'];
        $biography_font_family_site_identity = $biography_google_fonts[$biography_customizer_saved_options['biography-font-family-site-identity']];
        $biography_font_family_h1_h6 = $biography_google_fonts[$biography_customizer_saved_options['biography-font-family-h1-h6']];
        /*Color options */
        $biography_h1_h6_color = $biography_customizer_saved_options['biography-h1-h6-color'];
        $biography_link_color = $biography_customizer_saved_options['biography-link-color'];
        $biography_link_hover_color = $biography_customizer_saved_options['biography-link-hover-color'];
        $biography_site_identity_color = $biography_customizer_saved_options['biography-site-identity-color'];
        ?>
        <style type="text/css">
            /*site identity font family*/
            .site-title,
            .site-title a,
            .site-description,
            .site-description a{
                font-family: '<?php echo esc_attr( $biography_font_family_site_identity ); ?>'!important;
            }
            /*Title font family*/
            h1, h1 a,
            h2, h2 a,
            h3, h3 a,
            h4, h4 a,
            h5, h5 a,
            h6, h6 a {
                font-family: '<?php echo esc_attr( $biography_font_family_h1_h6 ); ?>'!important;
            }
            <?php
            /*Main h1-h6 color*/
            if( !empty($biography_h1_h6_color) ){
            ?>
            h1, h1 a,
            h2, h2 a,
            h3, h3 a,
            h4, h4 a,
            h5, h5 a,
            h6, h6 a{
                color: <?php echo esc_attr( $biography_h1_h6_color );?> !important; /*#212121*/
            }
            <?php
            }
          /*Link color*/
            if( !empty($biography_link_color) ){
            ?>
            a,
            a > p,
            .posted-on a,
            .cat-links a,
            .tags-links a,
            .author a,
            .comments-link a,
            .edit-link a,
            .nav-links .nav-previous a,
            .nav-links .nav-next a,
            .page-links a {
                color: <?php echo esc_attr( $biography_link_color ); ?> !important; /*#212121*/
            }
            <?php
            }
            /*Link Hover color*/
              if( !empty($biography_link_hover_color) ){
              ?>
              a:hover,
              a > p:hover,
              .posted-on a:hover,
              .cat-links a:hover,
              .tags-links a:hover,
              .author a:hover,
              .comments-link a:hover,
              .edit-link a:hover,
              .nav-links .nav-previous a:hover,
              .nav-links .nav-next a:hover,
              .page-links a:hover {
                  color: <?php echo esc_attr( $biography_link_hover_color ); ?> !important; /*#212121*/
              }
              <?php
              }
            /*header menu text*/
            if( !empty( $biography_site_identity_color ) ){
            ?>
            .site-title,
            .site-title a,
            .site-description,
            .site-description a{
                color: <?php echo esc_attr( $biography_site_identity_color );?>!important;
            }
            <?php
            }
            $biography_custom_css = $biography_customizer_saved_options['biography-custom-css'];
            $biography_custom_css_output = '';
            if ( ! empty( $biography_custom_css ) ) {
                $biography_custom_css_output .= $biography_custom_css;
            }
            echo $biography_custom_css_output;/*escaping done above*/
            ?>
        </style>
    <?php
    }
endif;
add_action( 'wp_head', 'biography_wp_head' );
