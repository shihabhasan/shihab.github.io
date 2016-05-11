<?php
if ( ! function_exists( 'biography_posts_navigation' ) ) :

    /**
     * Posts navigation options
     *
     * @since  Biography 1.0.0
     *
     * @param null
     * @return int
     */
    function biography_posts_navigation() {
        the_posts_navigation();
    }
endif;
add_action( 'biography_action_posts_navigation', 'biography_posts_navigation' );