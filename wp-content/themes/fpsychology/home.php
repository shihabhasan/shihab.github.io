<?php get_header(); ?>

<?php fpsychology_display_slider(); ?>

<div class="clear">
</div><!-- .clear -->

<div id="main-content-wrapper">
	<div id="main-content">
		<?php if ( have_posts() ) : 
					// starts the loop
					while ( have_posts() ) :

						the_post();

						/*
						 * Include the post format-specific template for the content.
						 */
						get_template_part( 'content', get_post_format() );

					endwhile;
		?>
					<div class="navigation">
						<?php echo paginate_links( array( 'prev_next' => '', ) ); ?>
					</div><!-- .navigation -->
		<?php else :

					// if no content is loaded, show the 'no found' template
					get_template_part( 'content', 'none' );
				
			  endif; ?>
	</div><!-- #main-content -->

	<?php get_sidebar(); ?>
</div><!-- #main-content-wrapper -->

<?php get_footer(); ?>