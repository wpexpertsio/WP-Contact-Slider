<?php

/**
 * @author Mohammad Mursaleen
 * @usage function to display slider
 */
function wpcs_create_slider_slider($slider_id){

    $prefix = "_" . $slider_id;

    $title = get_the_title($slider_id);
    $label_text_color = get_post_meta( $slider_id , 'wpcs_lable_text_color', true);
    $label_bg_color = get_post_meta( $slider_id , 'wpcs_lable_bg_color', true);
    $label_border_color = get_post_meta( $slider_id , 'wpcs_lable_border_color', true);
    $slider_position = get_post_meta( $slider_id , 'wpcs_slider_position', true);
    $slider_text_color = get_post_meta( $slider_id , 'wpcs_slider_text_color', true);
    $slider_bg_color = get_post_meta( $slider_id , 'wpcs_slider_bg_color', true);
    $form_bg_color = get_post_meta( $slider_id , 'wpcs_form_bg_color', true);
    $slider_border_color = get_post_meta( $slider_id , 'wpcs_slider_border_color', true);
    $hide_on_mobile = get_post_meta( $slider_id , 'wpcs_hide_on_mobile', true);
    $open_form = get_post_meta( $slider_id , 'wpcs_open_form', true);
    $position = !empty($slider_position) ? $slider_position : 'right' ;

    $top = 200;
    $width = 500;
    $inner_width = $width - 80;
    $push_body = false;
    $open_on_page_load =  !empty($open_form) ? $open_form : 'no';
    $open_on_page_load_after =  2 * 1000;
    $amimation_speed = 250;
    $every = 0;
    // $hide_label = 'no';

    $cross_icon_src = plugins_url( 'img/delete-sign.png', dirname(__FILE__) );
    $cursor_close_src = plugins_url( 'img/cursor_close.png', dirname(__FILE__) );

    ?>
    <script>
        jQuery(document).ready(function($){

            jQuery('#wpcs_tab<?php echo $prefix ?>').click(function($){

                if( ! (jQuery('#wpcs_content_main<?php echo $prefix ?>').hasClass('is_open')) ){

                    // Open slider
                    wpcs_open_slider<?php echo $prefix ?>();

                } else {

                    // close slider
                    wpcs_close_slider<?php echo $prefix ?>();

                }

            });

            jQuery("#wpcs_overlay<?php echo $prefix ?>, #wpcs_close_slider<?php echo $prefix ?>").click(function(){
                wpcs_close_slider<?php echo $prefix ?>();
            });

            <?php if($open_on_page_load == 'yes' && $every == 0){ ?>
            setTimeout( function(){

                wpcs_open_slider<?php echo $prefix ?>();

            }, <?php echo $open_on_page_load_after ?> );
            <?php } ?>

        });

        function wpcs_open_slider<?php echo $prefix ?>(do_repeat){

            do_repeat = typeof do_repeat !== 'undefined' ? do_repeat : 0 ;

            if( do_repeat !== 0 ){
                jQuery('#wpcs_content_main<?php echo $prefix ?>').addClass('do_repeat');
                jQuery( "#wpcs_content_main<?php echo $prefix ?>" ).data( "interval", do_repeat );
            }

            if( ! (jQuery('#wpcs_content_main<?php echo $prefix ?>').hasClass('is_open')) && !(jQuery('#wpcs_content_main<?php echo $prefix ?>').hasClass('is_opening')) ){

                // hide tap
                jQuery('#wpcs_tab<?php echo $prefix ?>').fadeTo("slow", 0);

                jQuery('#wpcs_content_main<?php echo $prefix ?>').addClass('is_opening');

                jQuery("#wpcs_overlay<?php echo $prefix ?>").addClass('wpcs_overlay_display_cross');

                jQuery( "#wpcs_overlay<?php echo $prefix ?>").fadeIn('fast');

                // PRO FEATURE - PUSH BODY

                jQuery('#wpcs_content_main<?php echo $prefix ?>').addClass('is_open');

            /*, #wpcs_tab<?php echo $prefix ?>*/
                jQuery( "#wpcs_content_main<?php echo $prefix ?>, body" ).animate({
                    opacity: 1,
                <?php echo  $position ?>: "+=<?php echo $width ?>"
            }, <?php echo $amimation_speed ?> , function() {

                    // hide tap
                    jQuery('#wpcs_tab<?php echo $prefix ?>').fadeTo("slow", 0);

                    // Trigger some thing here once completely open
                    jQuery( "#wpcs_content_inner<?php echo $prefix ?>").fadeTo("slow" , 1);

                    // Remove is_opening class
                    jQuery('#wpcs_content_main<?php echo $prefix ?>').removeClass('is_opening');

                });

            }

        }

        function wpcs_close_slider<?php echo $prefix ?>(){

            if( (jQuery('#wpcs_content_main<?php echo $prefix ?>').hasClass('is_open')) && !(jQuery('#wpcs_content_main<?php echo $prefix ?>').hasClass('is_closing')) ) {

                jQuery("#wpcs_overlay<?php echo $prefix ?>").removeClass('wpcs_overlay_display_cross');

                jQuery('#wpcs_content_main<?php echo $prefix ?>').addClass('is_closing');
                /* ,#wpcs_tab<?php echo $prefix ?>*/
                jQuery("#wpcs_content_main<?php echo $prefix ?>,body").animate({
                <?php echo  $position ?>:
                "-=<?php echo $width ?>"
            }
            , <?php echo $amimation_speed ?> ,
                function () {

                    // Trigger some thing here once completely close
                    jQuery("#wpcs_content_main<?php echo $prefix ?>").fadeTo("fast", 0);
                    jQuery("#wpcs_content_inner<?php echo $prefix ?>").slideUp('fast');
                    jQuery("#wpcs_overlay<?php echo $prefix ?>").fadeOut('slow');
                    jQuery('body').removeClass('fixed-body');

                    //  Removing is_open class in the end to avoid any confliction
                    jQuery('#wpcs_content_main<?php echo $prefix ?>').removeClass('is_open');
                    jQuery('#wpcs_content_main<?php echo $prefix ?>').removeClass('is_closing');


                    // display tap
                    jQuery('#wpcs_tab<?php echo $prefix ?>').fadeTo("slow", 1);

                });

                if( (jQuery('#wpcs_content_main<?php echo $prefix ?>').hasClass('do_repeat')) ) {
                    setTimeout(function () {
                        wpcs_open_slider<?php echo $prefix ?>(<?php echo $every ?>);
                    }, <?php echo $every ?> );
                }

            }

        }
    </script>
    <style>
        .fixed-body{
            position: relative;
        <?php echo  $position ?>: 0px;
        }
        div#wpcs_tab<?php echo $prefix ?> {
            border: 1px solid <?php echo $label_border_color ?>;
            border-<?php echo $cross_postion = ($position == 'left') ? 'top' : 'bottom' ; ?>:none;
            cursor: pointer;
            width: 170px;
            height: 34px;
            overflow: hidden;
            background: <?php echo $label_bg_color ?>;
            color: <?php echo  $label_text_color ?>;
            padding: 2px 0px 2px 0px;
            position: fixed;
            top: <?php echo $top; ?>px;
        <?php echo  $position ?>: -68px;
            text-align: center;
            -webkit-transform: rotate(-90deg);
            -moz-transform: rotate(-90deg);
            -ms-transform: rotate(-90deg);
            -o-transform: rotate(-90deg);
            transform: rotate(-90deg);
            z-index: 9999999;
            font-size: 18px;
        }
        div#wpcs_content_main<?php echo $prefix ?> {
            opacity:0;
            position: fixed;
            overflow-y: scroll;
            width: <?php echo $width ?>px;
            max-width: 100%;
            height: 100%;
            background: <?php echo $slider_bg_color ?>;
            color: black;
            top: 0px;
        <?php echo  $position ?>: -<?php echo $width ?>px;
            padding: 0px;
            margin: 0px;
            z-index: 9999999;
        }
        #wpcs_close_slider<?php echo $prefix ?> img {
            max-width: 100%;
        }
        div#wpcs_content_inner<?php echo $prefix ?> {
            display: none;
            max-width: 100%;
            min-height: 100%;
            background: <?php echo $form_bg_color ?>;
            padding: 20px 20px 20px 20px;
            margin: 60px 40px 60px 40px;
            color: <?php echo $slider_text_color ?>;
            border: 1px solid <?php echo $slider_border_color ?>;
        }
        div#wpcs_content_inner<?php echo $prefix ?> label{
            color: <?php echo $slider_text_color ?>;
        }
        div#wpcs_overlay<?php echo $prefix ?>{
            /*cursor: url(<?php echo  $cursor_close_src ?>), auto;*/
            display: none;
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0px;
            left: 0px;
            z-index: 999999;
            background: rgba(49, 49, 49, 0.65);
        }
        .wpcs_overlay_display_cross{
            cursor: url(<?php echo  $cursor_close_src ?>), auto;
        }
        #wpcs_content_main<?php echo $prefix ?>::-webkit-scrollbar {
            display: none;
        }
        div#wpcs_close_slider<?php echo $prefix ?> {
            top: 0px;
        <?php echo $cross_postion = ($position == 'left') ? 'right' : 'left' ; ?>: 0px;
            position: absolute;
            bottom: 0px;
            width: 32px;
            height: 32px;
            cursor: pointer;
            background: #0000007a;
            padding: 0px;
            overflow: hidden;
        }
        .wpcs-cf7, .wpcs-gf, .wpcs-wp-form, .wpcs-caldera-form, .wpcs-constant-forms, .wpcs-constant-forms,
        .wpcs-pirate-forms, .wpcs-si-contact-form, .wpcs-formidable, .wpcs-form-maker, .wpcs-form-craft,
        .visual-form-builde {
            overflow: hidden;
        }
        /***** WPCS Media Query ****/
        <?php if($hide_on_mobile == 'yes'){ ?>
        @media (max-width: 600px) {
            #wpcs_tab<?php echo $prefix ?>, #wpcs_content_main<?php echo $prefix ?> {
                display: none !important;
            }
        }
        <?php } ?>
    </style>
    <!-- WP Contact Slider -- start -->
    <div id="wpcs_tab<?php echo $prefix ?>"><?php echo $title ?></div>
    <div id="wpcs_content_main<?php echo $prefix ?>" >
        <div id="wpcs_close_slider<?php echo $prefix ?>"><img src="<?php echo  $cross_icon_src ?>"></div>
        <div id="wpcs_content_inner<?php echo $prefix ?>">
            <?php wpcs_display_slider_content($slider_id); ?>
        </div>
    </div>
    <!-- WP Contact Slider -- end -->
    <div id="wpcs_overlay<?php echo $prefix ?>"></div>
    <?php

}
