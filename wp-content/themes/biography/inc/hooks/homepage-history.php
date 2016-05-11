<?php
if ( ! function_exists( 'biography_home_history_array' ) ) :
    /**
     * Featured Slider array creation
     *
     * @since Biography 1.0.0
     *
     * @param null
     * @return array
     */
    function biography_home_history_array(  ){
        global $biography_customizer_saved_options;
        $biography_home_history_contents_array = array();

        $biography_home_history_contents_array[0]['biography-home-history-duration'] = __('2006-2009', 'biography');
        $biography_home_history_contents_array[0]['biography-home-history-title'] = __('Web Developing', 'biography');
        $biography_home_history_contents_array[0]['biography-home-history-content'] = __("Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.", 'biography');
        $biography_home_history_contents_array[0]['biography-home-history-link'] = '#';
        $biography_home_history_contents_array[0]['biography-home-history-icon'] = 'fa-desktop';

        $biography_home_history_contents_array[1]['biography-home-history-duration'] = __('2010-2013', 'biography');
        $biography_home_history_contents_array[1]['biography-home-history-title'] = __('Photography', 'biography');
        $biography_home_history_contents_array[1]['biography-home-history-content'] = __("Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.", 'biography');
        $biography_home_history_contents_array[1]['biography-home-history-link'] = '#';
        $biography_home_history_contents_array[1]['biography-home-history-icon'] = 'fa-camera-retro';

        $biography_home_history_contents_array[2]['biography-home-history-duration'] = __('2014-current', 'biography');
        $biography_home_history_contents_array[2]['biography-home-history-title'] = __('Customer Support', 'biography');
        $biography_home_history_contents_array[2]['biography-home-history-content'] = __("Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.", 'biography');
        $biography_home_history_contents_array[2]['biography-home-history-link'] = '#';
        $biography_home_history_contents_array[2]['biography-home-history-icon'] = 'fa-rocket';

        $biography_duration_arrays = array();
        $biography_icons_arrays = array();
        $biography_home_history_args = array();

        $biography_home_history_posts = array();
        $biography_home_history_posts[0]['biography-home-history-pages-ids'] = $biography_customizer_saved_options['biography-home-history-page-1'];
        $biography_home_history_posts[1]['biography-home-history-pages-ids'] = $biography_customizer_saved_options['biography-home-history-page-2'];
        $biography_home_history_posts[2]['biography-home-history-pages-ids'] = $biography_customizer_saved_options['biography-home-history-page-3'];

        $biography_home_history_posts[0]['biography-home-history-page-icon'] = $biography_customizer_saved_options['biography-home-history-icon-1'];
        $biography_home_history_posts[1]['biography-home-history-page-icon'] = $biography_customizer_saved_options['biography-home-history-icon-2'];
        $biography_home_history_posts[2]['biography-home-history-page-icon'] = $biography_customizer_saved_options['biography-home-history-icon-3'];

        $biography_home_history_posts[0]['biography-home-history-duration'] = $biography_customizer_saved_options['biography-home-history-duration-1'];
        $biography_home_history_posts[1]['biography-home-history-duration'] = $biography_customizer_saved_options['biography-home-history-duration-2'];
        $biography_home_history_posts[2]['biography-home-history-duration'] = $biography_customizer_saved_options['biography-home-history-duration-3'];

        $biography_home_history_posts_ids = array();
        if( null != $biography_home_history_posts ) {
            foreach( $biography_home_history_posts as $biography_home_history_post ) {
                if( isset($biography_home_history_post['biography-home-history-pages-ids']) && 0 != $biography_home_history_post['biography-home-history-pages-ids'] ){
                    $biography_home_history_posts_ids[] = $biography_home_history_post['biography-home-history-pages-ids'];
                    if( isset( $biography_home_history_post['biography-home-history-page-icon'] )){
                        $biography_home_history_page_icon = $biography_home_history_post['biography-home-history-page-icon'];
                    }
                    else{
                        $biography_home_history_page_icon =' fa-desktop';
                    }
                    if( isset( $biography_home_history_post['biography-home-history-duration'] )){
                        $biography_home_history_duration = $biography_home_history_post['biography-home-history-duration'];
                    }
                    else{
                        $biography_home_history_duration = '';
                    }
                    $biography_icons_arrays[] = $biography_home_history_page_icon;
                    $biography_duration_arrays[] = $biography_home_history_duration;
                }
            }
            if( !empty( $biography_home_history_posts_ids )){
                $biography_home_history_args =    array(
                    'post_type' => 'page',
                    'post__in' => $biography_home_history_posts_ids,
                    'posts_per_page' => 3,
                    'orderby' => 'post__in'
                );
            }
        }
        // the query
        if( !empty( $biography_home_history_args )){
            $biography_home_history_contents_array = array(); /*again empty array*/
            $biography_home_history_post_query = new WP_Query( $biography_home_history_args );
            if ( $biography_home_history_post_query->have_posts() ) :
                $i = 0;
                while ( $biography_home_history_post_query->have_posts() ) : $biography_home_history_post_query->the_post();
                    $biography_home_history_contents_array[$i]['biography-home-history-title'] = get_the_title();
                    $biography_home_history_contents_array[$i]['biography-home-history-content'] = biography_words_count( 30 ,get_the_content());
                    $biography_home_history_contents_array[$i]['biography-home-history-link'] = get_permalink();
                    if(isset( $biography_icons_arrays[$i] )){
                        $biography_home_history_contents_array[$i]['biography-home-history-icon'] = $biography_icons_arrays[$i];
                    }
                    else{
                        $biography_home_history_contents_array[$i]['biography-home-history-icon'] = 'fa-desktop';
                    }

                    if(isset( $biography_duration_arrays[$i] )){
                        $biography_home_history_contents_array[$i]['biography-home-history-duration'] = $biography_duration_arrays[$i];
                    }
                    else{
                        $biography_home_history_contents_array[$i]['biography-home-history-duration'] = '';
                    }
                    $i++;
                endwhile;
                wp_reset_postdata();
            endif;
        }
        return $biography_home_history_contents_array;
    }
endif;

if ( ! function_exists( 'biography_home_history' ) ) :
    /**
     * Featured Slider
     *
     * @since Biography 1.0.0
     *
     * @param null
     * @return null
     *
     */
    function biography_home_history() {
        global $biography_customizer_saved_options;
        if( 1 != $biography_customizer_saved_options['biography-home-history-enable'] ){
            return null;
        }
        $biography_home_history_title = $biography_customizer_saved_options['biography-home-history-title'];
        $biography_history_arrays = biography_home_history_array();
        if( is_array( $biography_history_arrays )){
            ?>
            <!--history section start-->
            <section class="wrapper wrap-resume">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            if( !empty( $biography_home_history_title ) ){
                                ?>
                                <div class="block-title">
                                    <h2><?php echo esc_html( $biography_home_history_title ); ?></h2>
                                    <div class="title-divider"><span></span></div>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="resume-list-outer">
                                <?php
                                $i = 1;
                                foreach( $biography_history_arrays as $biography_history_array ){
                                    if( 3 < $i){
                                        break;
                                    }
                                    ?>
                                    <div class="resume-list">
                                        <div class="date">
                                            <?php echo esc_html( $biography_history_array['biography-home-history-duration'] );?>
                                        </div>
                                        <div class="icon">
                                            <i class="fa <?php echo esc_attr( $biography_history_array['biography-home-history-icon'] ); ?>"></i>
                                        </div>
                                        <div class="textbox">
                                            <h3>
                                                <a href="<?php echo esc_url( $biography_history_array['biography-home-history-link'] );?>" title="<?php echo esc_attr( $biography_history_array['biography-home-history-title'] ); ?>">
                                                    <?php echo esc_html( $biography_history_array['biography-home-history-title'] );?>
                                                </a>
                                            </h3>
                                            <?php echo wp_kses_post( $biography_history_array['biography-home-history-content'] );?>
                                        </div>
                                    </div>
                                    <?php
                                    $i++;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--history section end-->
            <?php
        }
        ?>
        <?php
    }
endif;
add_action( 'homepage', 'biography_home_history', 30 );