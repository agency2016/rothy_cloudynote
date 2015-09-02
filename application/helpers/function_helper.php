<?php
/**
 * Created by PhpStorm.
 * User: Sudarshan Biswas
 * Date: 12/4/13
 * Time: 1:00 PM
 */


function highlight_menu_level() {

}



//Show left side menu by determining access level.
function left_side_menu($session, $permission_level = array()) {
    $access_level = $session->userdata('CN_user_access_level');

?>

    <li class="nav-header">Dashboard</li>

    <?php if($access_level <= '1'): ?>
        <li><a href="<?php echo base_url('dashboard/'); ?>">User</a></li>
    <?php endif; ?>

<?php if(has_organisation() or $access_level <= '2'): ?>
        <?php if($access_level <= '4' and $access_level > '2'): ?>
                <li>
                    <a href="<?php echo base_url('user/profile'); ?>"><?php echo $session->userdata('CN_org_name'); ?></a>
                    <ul class="nav nav-list">
                        <li><a href="<?php echo base_url('user/students'); ?>">Students</a></li>
                        <li><a href="<?php echo base_url('user/add-students'); ?>">Add Students</a></li>
                        <li><a href="<?php echo base_url('user/classes'); ?>">Classes</a></li>
                        <?php if($access_level <= '3'):?>
                            <li><a href="<?php echo base_url('user/add-class'); ?>">Add Class</a></li>
                            <li><a href="<?php echo base_url('user/teacher-list'); ?>">Teacher(s)</a></li>
                            <li><a href="<?php echo base_url('user/invite-teacher'); ?>">Invite Teacher</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
        <?php endif; ?>

        <?php if($access_level <= '4'): ?>
                <li>
                    <a href="<?php echo base_url('notes'); ?>">Notes</a>
                    <ul class="nav nav-list">
                        <li><a href="<?php echo base_url('notes'); ?>">View All</a></li>
                    <?php if($access_level >= 3): ?>
                        <li><a href="<?php echo base_url('notes/new'); ?>">Add New</a></li>
                    <?php endif; ?>
                    </ul>
                </li>
        <?php endif; ?>

<?php else: ?>
        <li class="disabled">
            <a>Organisation Name</a>
            <ul class="nav nav-list">
                <li class="disabled"><a>Add Class</a></li>
                <?php if($access_level <= '3'):?>
                    <li class="disabled"><a>Invite Teacher</a></li>
                <?php endif; ?>
            </ul>
        </li>
        <li class="disabled">
            <a>Notes</a>
            <ul class="nav nav-list">
                <li class="disabled"><a>View All</a></li>
                <li class="disabled"><a>Add New</a></li>
            </ul>
        </li>

<?php

    endif;
}

/**
 * @return bool
 */

function has_organisation() {
    $CI =& get_instance();
    if($CI->session->userdata('CN_org_name') != '') {
        return true;
    } else {
        return false;
    }
}


function unique_id_generator($length = 32) {
    $key = '';
    $keys = array_merge(range(0, 9), range('a', 'z'));

    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }

    return md5($key.microtime());
}

// Generates a strong password of N length containing at least one lower case letter,
// one uppercase letter, one digit, and one special character. The remaining characters
// in the password are chosen at random from those four sets.
//
// The available characters in each set are user friendly - there are no ambiguous
// characters such as i, l, 1, o, 0, etc. This, coupled with the $add_dashes option,
// makes it much easier for users to manually type or speak their passwords.
//
// Note: the $add_dashes option will increase the length of the password by
// floor(sqrt(N)) characters.

function generateStrongPassword($length = 9, $add_dashes = false, $available_sets = 'luds')
{
    $sets = array();
    if(strpos($available_sets, 'l') !== false)
        $sets[] = 'abcdefghjkmnpqrstuvwxyz';
    if(strpos($available_sets, 'u') !== false)
        $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
    if(strpos($available_sets, 'd') !== false)
        $sets[] = '23456789';
    if(strpos($available_sets, 's') !== false)
        $sets[] = '!@#$%&*?';

    $all = '';
    $password = '';
    foreach($sets as $set)
    {
        $password .= $set[array_rand(str_split($set))];
        $all .= $set;
    }

    $all = str_split($all);
    for($i = 0; $i < $length - count($sets); $i++)
        $password .= $all[array_rand($all)];

    $password = str_shuffle($password);

    if(!$add_dashes)
        return $password;

    $dash_len = floor(sqrt($length));
    $dash_str = '';
    while(strlen($password) > $dash_len)
    {
        $dash_str .= substr($password, 0, $dash_len) . '-';
        $password = substr($password, $dash_len);
    }
    $dash_str .= $password;
    return trim($dash_str);
}


/**
 * @param array $mail_info
 *  $mail_info = array(
 *      'from' => (string),
 *      'to' => (string|array),
 *      'cc' => (string|array),
 *      'bcc' => (string|array),
 *      'subject' => (string),
 *      'message' => (string),
 *      'header' => (string|array),
 *      'attachment' => (array|string)
 *  )
 * @param int $purpose
 * $purpose = 1 registration
 * $purpose = 2 forgot-password
 * $purpose = 3 parent invitation
 * $purpose = 4 staff invitation
 * $purpose = 5 send note
 * $purpose = 6 send reminder
 * @param int $individual_mail if to as an array then how this will react. set "to" to at a time send one by one
 */

function send_mail($mail_info = array(), $purpose = 1, $individual_mail = true) {
    $CI =& get_instance();
    $CI->load->library('email');

    $cc = "";
    $bcc = "";
    $subject = "CloudeNotes: ";

    //$registration_template = file_get_contents(APPPATH.'views/note_template/form.html');

    if( is_array($mail_info) ) {

        if( !empty($mail_info['cc']) ) {
            if( is_array($mail_info['cc']) ) {
                $fcc = true;
                foreach($mail_info['cc'] as $cc_item) {
                    if( $fcc ) {
                        $fcc = false;
                        $cc .= "$cc_item";
                    } else {
                        $cc .= ", $cc_item";
                    }
                }
                $CI->email->cc( $cc );
            } else {
                $CI->email->cc( $mail_info['cc'] );
            }
        }

        if( !empty($mail_info['bcc']) ) {
            if( is_array($mail_info['bcc']) ) {
                $bfcc = true;
                foreach($mail_info['bcc'] as $bcc_item) {
                    if( $bfcc ) {
                        $bfcc = false;
                        $bcc .= "$bcc_item";
                    } else {
                        $bcc .= ", $bcc_item";
                    }
                }
                $CI->email->bcc( $bcc );
            } else {
                $CI->email->bcc( $mail_info['bcc'] );
            }
        }

        /*if( $purpose == 1 ) {

        }*/

        $return_result = array(
            'success_mail_list'         => array(),
            'un_success_mail_list'      => array()
        );

        $patterns = array();
        $patterns[0] = '/{{logo_url}}/';
        $patterns[1] = '/{{terms_of_service_url}}/';
        $patterns[2] = '/{{privacy_policy}}/';
        $patterns[3] = '/{{about_clodenotes}}/';

        $replacements = array();
        $replacements[0] = base_url( 'resources/img/cloudenote_header_logo.png' );
        $replacements[1] = base_url( 'term-of-service' );
        $replacements[2] = base_url( 'privacy-policy' );
        $replacements[3] = base_url( 'about-us' );
        if( $purpose == '3' or $purpose == 3 ) {
            if( $individual_mail and is_array( $mail_info) ) {

                    $CI->email->clear();

                    $patterns[4] = '/{{organisation_name}}/';
                    $patterns[5] = '/{{note_public_url}}/';
                    $patterns[6] = '/{{staff_name}}/';
                    $patterns[7] = '/{message}/';
                    $replacements[4] = $mail_info['organisation_name'];
                    $replacements[5] = base_url( 'note/reply/public/'.base64_encode( $mail_info['parent_email'] ).'?content_only=enable' );
                    $replacements[6] = $mail_info['parent_fname'];
                    $replacements[7] = $mail_info['message_text'];


                    $mail_subject = $subject.$mail_info['subject'].' "'. $mail_info['note_title'].'"';
                    if( !empty( $mail_info['from'] ) ) {
                        $CI->email->from( $mail_info['from'], $mail_info['organisation_name'] );
                    } else {
                        $CI->email->from( 'no-reply@cloudenotes.com', $mail_info['organisation_name'] );
                    }
                    $CI->email->to( $mail_info['parent_email'] );
                    $CI->email->subject( $mail_subject );
                    //echo preg_replace( $patterns, $replacements, $mail_info['message'] );
                    $CI->email->message( preg_replace( $patterns, $replacements, $mail_info['message'] ) );

                    if( $CI->email->send() ) {
                        $temp_store['note_response_id'] = $mail_info['note_response_id'];
                        //$temp_store['note_response_child_id'] = $details['children_id'];
                        $temp_store['note_response_parent_email'] = $mail_info['parent_email'];

                        $return_result['success_mail_list'][] = $temp_store;
                    } else {
                        //echo $CI->email->print_debugger();
                        $temp_store['note_response_id'] = $mail_info['note_response_id'];
                        //$temp_store['note_response_child_id'] = $details['children_id'];
                        $temp_store['note_response_parent_email'] = $mail_info['parent_email'];

                        $return_result['un_success_mail_list'][] = $temp_store;
                    }

                if( count( $return_result['success_mail_list'] ) > 0 ){
                    return $return_result;
                } else {
                    return false;
                }
            }

        }

        else if( $purpose == '5' or $purpose == 5 ) {
            if( $individual_mail and is_array( $mail_info['to'] ) ) {
                foreach($mail_info['to'] as $details) {
                    $CI->email->clear();
                    /*if( empty( $details['children_id'] ) or empty( $details['parent_fname'] ) or empty( $details['parent_email'] ) or empty( $details['public_note_view_id'] ) or empty( $details['note_response_id'] ) or empty( $details['organisation_name'] ) or empty( $details['note_title'] ) ) {
                        continue;
                    }*/
                //    var_dump($details);
                    $patterns[4] = '/{{organisation_name}}/';
                    $patterns[5] = '/{{note_public_url}}/';
                    $patterns[6] = '/{{note_receiver_name}}/';

                    $replacements[4] = $details['organisation_name'];
                    $replacements[5] = base_url( 'note/reply/public/'.$details['children_id'].'/'.$details['public_note_view_id'].'/'.base64_encode( $details['parent_email'] ).'?content_only=enable' );
                    $replacements[6] = $details['parent_fname'];


                    $mail_subject = $subject.$mail_info['subject'].' "'. $details['note_title'].'"';
                    if( !empty( $mail_info['from'] ) ) {
                        $CI->email->from( $mail_info['from'], $details['organisation_name'] );
                    } else {
                        $CI->email->from( 'no-reply@cloudenotes.com', $details['organisation_name'] );
                    }
                    $CI->email->to( $details['parent_email'] );
                    $CI->email->subject( $mail_subject );
                    //echo preg_replace( $patterns, $replacements, $mail_info['message'] );
                    $CI->email->message( preg_replace( $patterns, $replacements, $mail_info['message'] ) );

                    if( $CI->email->send() ) {
                        $temp_store['note_response_id'] = $details['note_response_id'];
                        $temp_store['note_response_child_id'] = $details['children_id'];
                        $temp_store['note_response_parent_email'] = $details['parent_email'];

                        $return_result['success_mail_list'][] = $temp_store;
                    } else {
                        //echo $CI->email->print_debugger();
                        $temp_store['note_response_id'] = $details['note_response_id'];
                        $temp_store['note_response_child_id'] = $details['children_id'];
                        $temp_store['note_response_parent_email'] = $details['parent_email'];

                        $return_result['un_success_mail_list'][] = $temp_store;
                    }
                }
                if( count( $return_result['success_mail_list'] ) > 0 ){
                    return $return_result;
                } else {
                    return false;
                }
            } else {

            }
        } else if( $purpose == 1 or $purpose == '1' ) {
            $patterns[4] = '/{{account_activation_url}}/';
            $patterns[5] = '/{{registered_email}}/';
            $patterns[6] = '/{{password}}/';

            $replacements[4] = $mail_info['to']['active_url'];
            $replacements[5] = $mail_info['to']['email'];
            $replacements[6] = $mail_info['to']['password'];

            $mail_subject = $subject.$mail_info['subject'];

            $CI->email->from( $mail_info['from'], 'Clodenotes' );
            $CI->email->to( $mail_info['to']['email'] );
            $CI->email->subject( $mail_subject );
            $CI->email->message( preg_replace( $patterns, $replacements, $mail_info['message'] ) );
            if( $CI->email->send() ) {
                return true;
            } else {
                return false;
            }
        }else if( $purpose == 4 or $purpose == '4' ) {
            $patterns[4] = '/{{account_activation_url}}/';
            $patterns[5] = '/{{registered_email}}/';
            $patterns[6] = '/{{password}}/';

            $replacements[4] = $mail_info['to']['active_url'];
            $replacements[5] = $mail_info['to']['email'];
            $replacements[6] = $mail_info['to']['password'];

            $mail_subject = $subject.$mail_info['subject'];

            $CI->email->from( $mail_info['from'], 'Clodenotes' );
            $CI->email->to( $mail_info['to']['email'] );
            $CI->email->subject( $mail_subject );
            $CI->email->message( preg_replace( $patterns, $replacements, $mail_info['message'] ) );
            if( $CI->email->send() ) {
                return true;
            } else {
                return false;
            }
        }
    } else {
        return false;
    }
}