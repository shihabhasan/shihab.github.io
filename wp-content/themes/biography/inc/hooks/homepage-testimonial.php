<?php
if (!function_exists('biography_home_testimonial_array')) :
    /**
     * Featured Slider array creation
     *
     * @since Biography 1.0.0
     *
     * @param null
     * @return array
     */
    function biography_home_testimonial_array(){

        global $biography_customizer_saved_options;
        $biography_home_testimonial_contents_array = array();
        $biography_home_testimonial_contents_array[0]['biography-home-testimonial-title'] = __('Sayer Name, CEO','biography');
        $biography_home_testimonial_contents_array[0]['biography-home-testimonial-image'] = get_template_directory_uri().'/assets/img/sayer.jpg';
        $biography_home_testimonial_contents_array[0]['biography-home-testimonial-content'] = __("The set doesn't moved. Deep don't fru it fowl gathering heaven days moving creeping under from i air. Set it fifth Meat was darkness. every bring in it.",'biography');

        $biography_home_testimonial_posts[0]['biography-home-testimonial-pages-ids'] = $biography_customizer_saved_options['biography-home-testimonial-page-1'];
        $biography_home_testimonial_posts[1]['biography-home-testimonial-pages-ids'] = $biography_customizer_saved_options['biography-home-testimonial-page-2'];
        $biography_home_testimonial_posts[2]['biography-home-testimonial-pages-ids'] = $biography_customizer_saved_options['biography-home-testimonial-page-3'];

        $biography_home_testimonial_posts_ids = array();
        if (null != $biography_home_testimonial_posts) {
            foreach ($biography_home_testimonial_posts as $biography_home_testimonial_post) {
                if (0 != $biography_home_testimonial_post['biography-home-testimonial-pages-ids']) {
                    $biography_home_testimonial_posts_ids[] = $biography_home_testimonial_post['biography-home-testimonial-pages-ids'];
                }
            }
            if( !empty( $biography_home_testimonial_posts_ids )){
                $biography_home_testimonial_args = array(
                    'post_type' => 'page',
                    'post__in' => $biography_home_testimonial_posts_ids,
                    'posts_per_page' => 3,
                    'orderby' => 'post__in'
                );
            }
        }
        // the query
        if( !empty( $biography_home_testimonial_args )){
            $biography_home_testimonial_contents_array = array();
            $biography_home_testimonial_post_query = new WP_Query($biography_home_testimonial_args);
            if ($biography_home_testimonial_post_query->have_posts()) :
                $i = 0;
                $indicator = 0;
                while ($biography_home_testimonial_post_query->have_posts()) : $biography_home_testimonial_post_query->the_post();
                    $url = get_template_directory_uri().'/assets/img/sayer-no-image.jpg';
                    if(has_post_thumbnail()){
                        $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'thumbnail' );
                        $url = $thumb['0'];
                    }
                    $biography_home_testimonial_contents_array[$i]['biography-home-testimonial-title'] = get_the_title();
                    $biography_home_testimonial_contents_array[$i]['biography-home-testimonial-image'] = $url;
                    $biography_home_testimonial_contents_array[$i]['biography-home-testimonial-content'] = biography_words_count( 30 ,get_the_content());
                    $i++;
                    $indicator++;
                endwhile;
                wp_reset_postdata();

            endif;
        }
        return $biography_home_testimonial_contents_array;
        


    }
endif;

if (!function_exists('biography_home_testimonial')) :
    /**
     * Featured Slider
     *
     * @since Biography 1.0.0
     *
     * @param null
     * @return null
     *
     */
    function biography_home_testimonial() {
        global $biography_customizer_saved_options;
        $biography_home_testimonial_title = $biography_customizer_saved_options['biography-home-testimonial-title'];

        $biography_testimonial_arrays = biography_home_testimonial_array();
        if (is_array($biography_testimonial_arrays)) {
            ?>
            <!--biography testimonial start-->
            <?php
            if( !empty( $biography_home_testimonial_title )){
                ?>
                <div class="block-title">
                    <h2>
                        <?php
                        echo esc_html( $biography_home_testimonial_title );
                        ?>
                    </h2>
                    <div class="title-divider"><span></span></div>
                </div>
                <?php
            }
            ?>
            <div class="testimonial-section">

               <div id="testimonial-slide" class="carousel slide" data-ride="carousel" data-interval="7000">
                    <!-- Indicators -->
                    <?php 
                
                if (  !empty($biography_testimonial_arrays[1]['biography-home-testimonial-title'])  ) {
                    ?>
                    <ol class="carousel-indicators">
                        <?php
                        $i = 0;
                        foreach( $biography_testimonial_arrays as $biography_testimonial_array ){
                            if (3 < $i) {
                                break;
                            }
                            ?>
                            <li data-target="#testimonial-slide" data-slide-to="<?php echo absint($i);?>" class="<?php echo $i == 0 ? 'active' : '';?>"></li>
                            <?php
                            $i++;
                        
                        }
                        ?>
                    </ol>
                    <?php  } ?>
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">

                        <?php
                        $i = 0;
                        foreach( $biography_testimonial_arrays as $biography_testimonial_array ){
                            if (3 < $i) {
                                break;
                            }
                            ?>
                            <div class="item <?php echo $i == 0 ? 'active' : '';?>">
                                <div class="sayer-thumb">
                                    <img src="<?php echo esc_url( $biography_testimonial_array['biography-home-testimonial-image']); ?>" alt="<?php echo esc_attr( $biography_testimonial_array['biography-home-testimonial-title'] ); ?>">
                                </div>
                                <div class="testimonial-content">
                                    <p>
                                        <?php echo wp_kses_post( $biography_testimonial_array['biography-home-testimonial-content'] ); ?>
                                    </p>
                                    <div class="sayer-detail">
                                        <span class="sayer-name">
                                            <?php echo esc_html( $biography_testimonial_array['biography-home-testimonial-title'] ); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $i++;
                        }
                        ?>
                    </div>
                </div>
            </div>
            <!--biography testimonial end-->
        <?php
        }
    }
endif;
add_action( 'biography_action_home_testimonial', 'biography_home_testimonial', 10 );