<?php
if ( ! function_exists( 'biography_home_service_array' ) ) :
    /**
     * Featured Slider array creation
     *
     * @since Biography 1.0.0
     *
     * @param null
     * @return array
     */
    function biography_home_service_array(  ){
        global $biography_customizer_saved_options;
        $biography_home_service_contents_array = array();

        $biography_home_service_contents_array[0]['biography-home-service-title'] = __('Web Developing', 'biography');
        $biography_home_service_contents_array[0]['biography-home-service-content'] = __("Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.", 'biography');
        $biography_home_service_contents_array[0]['biography-home-service-link'] = '#';
        $biography_home_service_contents_array[0]['biography-home-service-icon'] = 'fa-desktop';

        $biography_home_service_contents_array[1]['biography-home-service-title'] = __('Photography', 'biography');
        $biography_home_service_contents_array[1]['biography-home-service-content'] = __("Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.", 'biography');
        $biography_home_service_contents_array[1]['biography-home-service-link'] = '#';
        $biography_home_service_contents_array[1]['biography-home-service-icon'] = 'fa-camera-retro';

        $biography_home_service_contents_array[2]['biography-home-service-title'] = __('Customer Support', 'biography');
        $biography_home_service_contents_array[2]['biography-home-service-content'] = __("Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.", 'biography');
        $biography_home_service_contents_array[2]['biography-home-service-link'] = '#';
        $biography_home_service_contents_array[2]['biography-home-service-icon'] = 'fa-rocket';

        $biography_icons_arrays = array();
        $biography_home_service_args = array();
        $biography_home_service_posts = array();

        $biography_home_service_posts[0]['biography-home-service-pages-ids'] = $biography_customizer_saved_options['biography-home-service-page-1'];
        $biography_home_service_posts[1]['biography-home-service-pages-ids'] = $biography_customizer_saved_options['biography-home-service-page-2'];
        $biography_home_service_posts[2]['biography-home-service-pages-ids'] = $biography_customizer_saved_options['biography-home-service-page-3'];

        $biography_home_service_posts[0]['biography-home-service-page-icon'] = $biography_customizer_saved_options['biography-home-service-icon-1'];
        $biography_home_service_posts[1]['biography-home-service-page-icon'] = $biography_customizer_saved_options['biography-home-service-icon-2'];
        $biography_home_service_posts[2]['biography-home-service-page-icon'] = $biography_customizer_saved_options['biography-home-service-icon-3'];

        $biography_home_service_posts_ids = array();
        if( null != $biography_home_service_posts ) {
            foreach( $biography_home_service_posts as $biography_home_service_post ) {
                if( isset($biography_home_service_post['biography-home-service-pages-ids']) && 0 != $biography_home_service_post['biography-home-service-pages-ids'] ){
                    $biography_home_service_posts_ids[] = $biography_home_service_post['biography-home-service-pages-ids'];
                    if( isset( $biography_home_service_post['biography-home-service-page-icon'] )){
                        $biography_home_service_page_icon = $biography_home_service_post['biography-home-service-page-icon'];
                    }
                    else{
                        $biography_home_service_page_icon =' fa-desktop';
                    }
                    $biography_icons_arrays[] = $biography_home_service_page_icon;
                }
            }
            if( !empty( $biography_home_service_posts_ids )){
                $biography_home_service_args =    array(
                    'post_type' => 'page',
                    'post__in' => $biography_home_service_posts_ids,
                    'posts_per_page' => 3,
                    'orderby' => 'post__in'
                );
            }
        }
        // the query
        if( !empty( $biography_home_service_args )){
            $biography_home_service_contents_array = array(); /*again empty array*/
            $biography_home_service_post_query = new WP_Query( $biography_home_service_args );
            if ( $biography_home_service_post_query->have_posts() ) :
                $i = 0;
                while ( $biography_home_service_post_query->have_posts() ) : $biography_home_service_post_query->the_post();
                    $biography_home_service_contents_array[$i]['biography-home-service-title'] = get_the_title();
                    $biography_home_service_contents_array[$i]['biography-home-service-content'] = biography_words_count( 30 ,get_the_content());
                    $biography_home_service_contents_array[$i]['biography-home-service-link'] = get_permalink();
                    if(isset( $biography_icons_arrays[$i] )){
                        $biography_home_service_contents_array[$i]['biography-home-service-icon'] = $biography_icons_arrays[$i];
                    }
                    else{
                        $biography_home_service_contents_array[$i]['biography-home-service-icon'] = 'fa-desktop';
                    }
                    $i++;
                endwhile;
                wp_reset_postdata();
            endif;
        }
        return $biography_home_service_contents_array;
    }
endif;

if ( ! function_exists( 'biography_home_service' ) ) :
    /**
     * Featured Slider
     *
     * @since Biography 1.0.0
     *
     * @param null
     * @return null
     *
     */
    function biography_home_service() {
        global $biography_customizer_saved_options;
        if( 1 != $biography_customizer_saved_options['biography-home-service-enable'] ){
            return null;
        }
        $biography_service_arrays = biography_home_service_array(  );
        if( is_array( $biography_service_arrays )){
            ?>
            <!--service section start-->
            <section class="wrapper wrap-service">
                <div class="container">
                    <div class="service-inner">
                        <div class="row">
                            <?php
                            $i = 1;
                            foreach( $biography_service_arrays as $biography_service_array ){
                                if( 3 < $i){
                                    break;
                                }
                                ?>
                                <div class="col-md-4">
                                    <div class="service-list">
                                        <div class="icon-section">
                                            <i class="fa <?php echo esc_attr( $biography_service_array['biography-home-service-icon'] ); ?>"></i>
                                        </div>
                                        <h3>
                                            <a href="<?php echo esc_url( $biography_service_array['biography-home-service-link'] );?>" title="<?php echo esc_attr( $biography_service_array['biography-home-service-title'] ); ?>">
                                                <?php echo esc_html( $biography_service_array['biography-home-service-title'] );?>
                                            </a>
                                        </h3>
                                        <p>
                                            <?php echo wp_kses_post( $biography_service_array['biography-home-service-content'] );?>
                                        </p>
                                    </div>
                                </div>
                                <?php
                                $i++;
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </section>

            <!--service section end-->

            <?php
        }
        ?>
        <?php
    }
endif;
add_action( 'homepage', 'biography_home_service', 10 );