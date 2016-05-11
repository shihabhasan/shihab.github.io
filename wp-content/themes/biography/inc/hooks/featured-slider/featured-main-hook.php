<?php
if ( ! function_exists( 'biography_text_slider_array' ) ) :
    /**
     * Featured Slider array creation
     *
     * @since Biography 1.0.0
     *
     * @param string $from_slider
     * @return array
     */
    function biography_text_slider_array( ){
        global $biography_customizer_saved_options;

        $biography_fs_contents_array[0]['biography-fs-title'] = __('Administrative Manager','biography');
        $biography_fs_contents_array[1]['biography-fs-title'] = __('Professional Developer','biography');
        $biography_fs_contents_array[0]['biography-fs-link'] = '#';

        $biography_fs_args = array();
        $biography_fs_posts = array();
        $biography_fs_posts[]['biography-fs-pages-ids'] =  $biography_customizer_saved_options['biography-fs-page-1'];
        $biography_fs_posts[]['biography-fs-pages-ids'] =  $biography_customizer_saved_options['biography-fs-page-2'];
        $biography_fs_posts[]['biography-fs-pages-ids'] =  $biography_customizer_saved_options['biography-fs-page-3'];

        $biography_fs_posts_ids = array();
        if( null != $biography_fs_posts ) {
            foreach( $biography_fs_posts as $biography_fs_post ) {
                if( 0 != $biography_fs_post['biography-fs-pages-ids'] ){
                    $biography_fs_posts_ids[] = $biography_fs_post['biography-fs-pages-ids'];
                }
            }
            if( !empty( $biography_fs_posts_ids )){
                $biography_fs_args =    array(
                    'post_type' => 'page',
                    'post__in' => $biography_fs_posts_ids,
                    'posts_per_page' => 3,
                    'orderby' => 'post__in'
                );
            }
        }

        if( !empty( $biography_fs_args )){
            // the query
            $biography_fs_contents_array = array();
            $biography_fs_post_query = new WP_Query( $biography_fs_args );
            if ( $biography_fs_post_query->have_posts() ) :
                $i = 0;
                while ( $biography_fs_post_query->have_posts() ) : $biography_fs_post_query->the_post();
                    $biography_fs_contents_array[$i]['biography-fs-title'] = get_the_title();
                    $biography_fs_contents_array[$i]['biography-fs-link'] = get_permalink();
                    $i++;
                endwhile;
                wp_reset_postdata();
            endif;
        }
        return $biography_fs_contents_array;
    }
endif;

if ( ! function_exists( 'biography_text_slider' ) ) :
    /**
     * Featured Slider
     *
     * @since Biography 1.0.0
     *
     * @param null
     * @return null
     *
     */
    function biography_text_slider() {
        global $biography_customizer_saved_options;
        if( 1 != $biography_customizer_saved_options['biography-fs-enable'] ){
            return null;
        }
        $biography_slider_arrays = biography_text_slider_array();
        if( is_array( $biography_slider_arrays )){
        ?>
            <!--text slider start-->
            <div class="slider-section">
                <div id="banner-slider" class="carousel slide" data-ride="carousel">
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        <?php
                        $i = 1;
                        foreach( $biography_slider_arrays as $biography_slider_array ){
                            if( 3 < $i){
                                break;
                            }
                            $active = '';
                            if( $i == 1 ){
                                $active = 'active';
                            }
                            ?>
                            <div class="item <?php echo esc_attr( $active ); ?>">
                                <div class="banner-slider-content">
                                    <?php echo esc_html( $biography_slider_array['biography-fs-title'] )?>
                                </div>
                            </div>
                            <?php
                            $i++;
                        }
                        ?>
                    </div>
                </div>
            </div><!-- .slider-section -->
            <!--text slider end-->
            <?php
        }
        ?>
        <?php
    }
endif;
add_action( 'biography_action_text_slider', 'biography_text_slider', 10 );

if ( ! function_exists( 'biography_after_text_slider' ) ) :
    /**
     * Add button after slider
     *
     * @since Biography 1.0.0
     *
     * @param null
     * @return null
     *
     */
    function biography_after_text_slider() {
        global $biography_customizer_saved_options;
        $biography_header_contact_url = $biography_customizer_saved_options['biography-header-contact-url'];
        $biography_header_resume_url = $biography_customizer_saved_options['biography-header-resume-url'];
        if( empty( $biography_header_contact_url) && empty ( $biography_header_resume_url ) ){
            return;
        }
        ?>
        <div class="goest-btn">
            <?php
            if( !empty( $biography_header_contact_url) ){
                ?>
                <a class="button button-feature button-contact" href="<?php echo esc_url( $biography_header_contact_url ); ?>">
                    <?php _e( 'Contact Me', 'biography' );?>
                </a>
                <?php
            }
            if( !empty( $biography_header_resume_url) ){
                ?>
                <a class="button button-feature button-resume line-btn" href="<?php echo esc_url( $biography_header_resume_url ); ?>">
                    <?php _e( 'Download Resume', 'biography' );?>
                </a>
                <?php
            }
            ?>
        </div>
        <?php
    }
endif;
add_action( 'biography_action_text_slider', 'biography_after_text_slider', 20 );