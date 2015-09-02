<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Return table of access
 *
 * @access    public
 * @return    bool
 */
if (!function_exists('get_access_capability_box')) {
    function get_access_capability_box() {
        $role = array(
            '1' =>  array(
                    'createnote'        => 1,
                    'readnote'          => 1,
                    'editnote'          => 1,
                    'deletenote'        => 1,
                    'sendnote'          => 1,
                    'schedulenote'      => 1
                ),
            '2' => array(
                'createnote'        => 1,
                'readnote'          => 1,
                'editnote'          => 1,
                'deletenote'        => 1,
                'sendnote'          => 1,
                'schedulenote'      => 1
            ),
            '3' => array(
                'createnote'        => 1,
                'readnote'          => 1,
                'editnote'          => 1,
                'deletenote'        => 1,
                'sendnote'          => 1,
                'schedulenote'      => 1
            ),
            '4' => array(
                'createnote'        => 1,
                'readnote'          => 1,
                'editnote'          => 1,
                'deletenote'        => 1,
                'sendnote'          => 1,
                'schedulenote'      => 1
            ),
            '5' => array(
                'createnote'        => 2,
                'readnote'          => 1,
                'editnote'          => 2,
                'deletenote'        => 2,
                'sendnote'          => 2,
                'schedulenote'      => 2
            ),
            '6' => array(
                'createnote'        => 2,
                'readnote'          => 1,
                'editnote'          => 2,
                'deletenote'        => 2,
                'sendnote'          => 2,
                'schedulenote'      => 2
            ),

        );

        return $role;
    }
}

// ------------------------------------------------------------------------

/**
 * Send an email
 *
 * @access    public
 * @return    bool
 */
if (!function_exists('send_email')) {
    function send_email($recipient, $subject = 'Test email', $message = 'Hello World') {
        return mail($recipient, $subject, $message);
    }
}


/* End of file email_helper.php */
/* Location: ./system/helpers/email_helper.php */