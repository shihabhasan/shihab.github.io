<?php

/**
 * The front-page template file.
 *
 * @package Biography
 * @since Biography 1.0.0
 */

get_header();
/**
 * biography_action_front_page hook
 * @since biography 1.0.0
 *
 * @hooked biography_action_front_page -  10
 * @sub_hooked homepage -  10
 */
do_action( 'biography_action_front_page' );
get_footer();

