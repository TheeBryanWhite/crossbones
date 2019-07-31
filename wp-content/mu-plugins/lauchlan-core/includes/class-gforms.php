<?php

/**
 * Customizes Gravity Forms
 */

/**
 * Move scripts to footer
 */
add_filter('gform_init_scripts_footer', '__return_true');

/**
 * Prevent Gravity Forms notification emails to developer@vtldesign.com
 */
function lauchlan_stop_gform_admin_spam($email) {

    if ($email['to'] === 'bwhite@lauchlanx.com') {
        $email['abort_email'] = true;
    }

    return $email;
}

add_filter('gform_pre_send_email', 'lauchlan_stop_gform_admin_spam');
