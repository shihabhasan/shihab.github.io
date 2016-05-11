<?php
/**
 * check if all sections of front page disable
 *
 * @since biography 1.0.0
 */
if ( ! function_exists( 'biography_if_all_disable' ) ) :
    function biography_if_all_disable() {
        global $biography_customizer_saved_options;
        if(
            1 != $biography_customizer_saved_options['biography-home-service-enable'] &&
            1 != $biography_customizer_saved_options['biography-home-history-enable'] &&
            1 != $biography_customizer_saved_options['biography-home-review-enable']
        )
        {
            return 0;
        }
        else{
            return 1;
        }
    }
endif;
if ( ! function_exists( 'biography_front_page' ) ) :
    /**
     * Before main content
     *
     * @since biography 1.0.0
     *
     * @param null
     * @return null
     *
     */
    function biography_front_page() {
        if ( 'posts' == get_option( 'show_on_front' ) ) {
            include( get_home_template() );
        }
        elseif( 1 == biography_if_all_disable()){
            /**
             * homepage hook
             * @since Biography 1.0.0
             *
             * @hooked biography_home_service -  10
             * @hooked biography_home_review -  20
                * @subhooked biography_home_testimonial 10
             * @hooked biography_home_history -  30
             */
            do_action('homepage');
        }
        else {
            include( get_page_template() );
        }

    }
endif;
add_action( 'biography_action_front_page', 'biography_front_page', 10 );