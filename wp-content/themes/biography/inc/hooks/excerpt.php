<?php
if( ! function_exists( 'biography_excerpt_length' ) ) :

    /**
     * Excerpt length
     *
     * @since  Biography 1.0.0
     *
     * @param null
     * @return int
     */
    function biography_excerpt_length( ){
        return esc_attr( 30 );
    }

endif;
add_filter( 'excerpt_length', 'biography_excerpt_length', 999 );