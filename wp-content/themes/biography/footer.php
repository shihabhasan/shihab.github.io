<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package biography
 * @since biography 1.0.0
 */

/**
 * biography_action_after_content hook
 * @since biography 1.0.0
 *
 * @hooked null
 */
do_action( 'biography_action_after_content' );

/**
 * biography_action_before_footer hook
 * @since biography 1.0.0
 *
 * @hooked null
 */
do_action( 'biography_action_before_footer' );

/**
 * biography_action_footer hook
 * @since biography 1.0.0
 *
 * @hooked biography_footer - 10
 */
do_action( 'biography_action_footer' );

/**
 * biography_action_after_footer hook
 * @since biography 1.0.0
 *
 * @hooked null
 */
do_action( 'biography_action_after_footer' );

/**
 * biography_action_after hook
 * @since biography 1.0.0
 *
 * @hooked biography_page_end - 10
 */
do_action( 'biography_action_after' );
?>
<?php wp_footer(); ?>
</body>
</html>