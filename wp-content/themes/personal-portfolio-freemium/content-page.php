<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Personal Portfolio

 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
        
        <div class="entry-meta">
        <?php edit_post_link( __( 'Edit', 'personal-portfolio' ), '<span class="edit-link"><i class="fa fa-edit"></i> ', '</span>' ); ?>
        </div>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'personal-portfolio' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
    
</article><!-- #post-## -->
