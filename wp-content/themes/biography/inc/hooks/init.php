<?php
/**
 * Implement Editor Styles
 *
 * @since Biography 1.0.0
 *
 * @param null
 * @return null
 *
 */
add_action( 'init', 'biography_add_editor_styles' );

if ( ! function_exists( 'biography_add_editor_styles' ) ) :
    function biography_add_editor_styles() {
        add_editor_style( 'editor-style.css' );
    }
endif;