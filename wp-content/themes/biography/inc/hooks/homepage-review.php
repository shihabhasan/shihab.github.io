<?php
if (!function_exists('biography_home_about_default')) :
    /**
     * About default content
     *
     * @since Biography 1.0.0
     *
     * @param null
     * @return null
     *
     */
    function biography_home_about_default() {
        ?>
        <div class="block-title">
            <h2><?php _e('WHY HIRE ME ?', 'biography'); ?></h2>
            <div class="title-divider"><span></span></div>
        </div>
        <div class="about-content">
            <p>
                <?php _e('Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.', 'biography'); ?>
            </p>
            <div class="btn-container">
                <a class="button button-link" href="#">
                    <?php _e('Read More', 'biography'); ?>
                </a>
            </div>
        </div>
        <?php
    }
endif;

if (!function_exists('biography_home_review')) :
    /**
     * Featured Slider
     *
     * @since Biography 1.0.0
     *
     * @param null
     * @return null
     *
     */
    function biography_home_review() {
        global $biography_customizer_saved_options;
        if( 1 != $biography_customizer_saved_options['biography-home-review-enable'] ){
            return null;
        }
        ?>
        <section class="wrapper wrap-about">
            <div class="container">
                <div class="col-md-6">
                    <?php
                    $biography_home_about_page_id = $biography_customizer_saved_options['biography-home-about-page-id'];
                    if( 0 != $biography_home_about_page_id ){
                        // the query
                        $biography_fs_args = array(
                            'page_id' => $biography_home_about_page_id
                        );
                        $biography_fs_post_query = new WP_Query( $biography_fs_args );
                        if ( $biography_fs_post_query->have_posts() ) :
                            while ( $biography_fs_post_query->have_posts() ) : $biography_fs_post_query->the_post();
                                ?>
                                <div class="block-title">
                                    <h2><?php the_title(); ?></h2>
                                    <div class="title-divider"><span></span></div>
                                </div>
                                <div class="about-content">
                                    <?php $content = biography_words_count(50, get_the_content());
                                    echo '<p>'.wp_kses_post( $content )."</p>";
                                    ?>
                                    <div class="btn-container">
                                        <a class="button button-link" href="<?php the_permalink()?>">
                                            <?php _e('Read More', 'biography'); ?>
                                        </a>
                                    </div>
                                </div>
                                <?php
                            endwhile;
                            wp_reset_postdata();
                        else:
                            biography_home_about_default();
                        endif;
                    }
                    else{
                        biography_home_about_default();
                    }
                    ?>
                </div>
                <div class="col-md-6">
                    <?php do_action( 'biography_action_home_testimonial'); ?>
                </div>
            </div>
        </section>
        <?php
    }
endif;
add_action( 'homepage', 'biography_home_review', 20 );