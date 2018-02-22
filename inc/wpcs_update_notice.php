<?php

add_action('admin_footer','wpcs_notice_script');
/**
 * @author Mohammad Mursaleen
 * @usage script to run ajax request on closing notice
 */
function wpcs_notice_script(){
?>
<script>
    jQuery(document).on( 'click', '.wpcs-first-notice .notice-dismiss', function() {
        jQuery.ajax({
            url: ajaxurl,
            data: {
                action: 'dismiss_wpcs_notice'
            }
        })
    })
</script>
<?php
}


add_action( 'admin_notices', 'wpcs_update_notice' );
/**
 * @author Mohammad Mursaleen
 * @usage display update notice
 */
function wpcs_update_notice() {

    if (  get_option('wpcs_display_notice_1') == 'no' ) {
        return;
    }

    $class = 'notice notice-info is-dismissible wpcs-first-notice';
    $heading = __( 'Introducing WP Contact Slider 2.0!' , 'wpcs' );
    $message = __( '<p>With 2.0 introducing New UI with improved user experience. Check <a href="https://wordpress.org/plugins/wp-contact-slider/#developers">changelog</a> for more details.</p><p><span class="dashicons dashicons-groups"></span><a href="https://wordpress.org/support/plugin/wp-contact-slider" target="_blank"  ><strong>Get Some Help!</strong></a></p>' , 'wpcs');

    printf( '<div data-dismissible="notice-one-forever-wpcs" class="%1$s"><h2 style="font-size: 20px;font-weight: 800;" >%2$s</h2>%3$s</div>', esc_attr( $class ), esc_html( $heading ) ,  $message  );

}


/**
 * @author : Mohammad Mursaleen
 * @usage : save in option to not display it again
 */
function wpcs_dismiss_update_notice(){

    update_option('wpcs_display_notice_1','no');

}
add_action('wp_ajax_dismiss_wpcs_notice', 'wpcs_dismiss_update_notice');