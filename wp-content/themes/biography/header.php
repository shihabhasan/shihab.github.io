<?php
/**
 * The default template for displaying header
 *
 * @package Biography
 * @since Biography 1.0.0
 */

/**
 * biography_action_before_head hook
 * @since Biography 1.0.0
 *
 * @hooked biography_set_global -  0
 * @hooked biography_doctype -  10
 */
do_action( 'biography_action_before_head' );?>
<head>

	<?php
	/**
	 * biography_action_before_wp_head hook
	 * @since Biography 1.0.0
	 *
	 * @hooked biography_before_wp_head -  10
	 */
	do_action( 'biography_action_before_wp_head' );

	wp_head();

	/**
	 * biography_action_after_wp_head hook
	 * @since Biography 1.0.0
	 *
	 * @hooked null
	 */
	do_action( 'biography_action_after_wp_head' );
	?>

</head>

<body <?php body_class(); ?>>

<?php
/**
 * biography_action_before hook
 * @since Biography 1.0.0
 *
 * @hooked biography_page_start - 15
 */
do_action( 'biography_action_before' );

/**
 * biography_action_before_header hook
 * @since Biography 1.0.0
 *
 * @hooked biography_skip_to_content - 10
 */
do_action( 'biography_action_before_header' );


/**
 * biography_action_header hook
 * @since Biography 1.0.0
 *
 * @hooked biography_after_header - 10
 */
do_action( 'biography_action_header' );


/**
 * biography_action_after_header hook
 * @since Biography 1.0.0
 *
 * @hooked null
 */
do_action( 'biography_action_after_header' );


/**
 * biography_action_before_content hook
 * @since Biography 1.0.0
 *
 * @hooked biography_content_start -10
 */
do_action( 'biography_action_before_content' );
?>