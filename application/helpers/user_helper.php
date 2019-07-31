<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**

 * Database helper
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Db * @author		Kumar Gaurav
 * @website		http://www.tekshapers.com
 * @company     Tekshapers Inc 
 * @since		Version 1.0
 */
// ------------------------------------------------------------------------
/**
 * get_user_data 
 * 
 * return default time zone date and time
 *
 * @access	public
 */

if (!function_exists('get_user_data')) {
    function get_user_data($id = null) {
        $CI = &get_instance();
        $CI->db->select('users.*,CONCAT(users.first_name," ",users.last_name) as name', false);
        $CI->db->where('users.id', $id);
        $query = $CI->db->get('users');
        if ($query->num_rows() > 0)
            return $query->row();
        else
            show_404();
    }
}


// ------------------------------------------------------------------------
/**
 * @Function _sendEmail
 * @purpose load layout page 
 * @created  6 dec 2014
 */
if (!function_exists('sendEmail')) {
    function sendEmail($email_data) {
        $CI = &get_instance();
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = true;
        $CI->email->set_mailtype("html");
        $CI->email->initialize($config);
        $CI->email->from($email_data['from'], ucwords($email_data['sender_name']));
        $CI->email->to($email_data['to']);
        if (!empty($email_data['cc'])) {
            $CI->email->cc($email_data['cc']);
        }
        if (!empty($email_data['bcc'])) {
            $CI->email->bcc($email_data['bcc']);
        }
        if(!empty($email_data['file']))
        {
            $CI->email->attach($email_data['file']);
        }
        $CI->email->subject(ucfirst($email_data['subject']));
        $data['message']=$email_data['message'];
        $msg=$CI->load->view('email_template/email',$data,true);
        //$msg=$data['message'];
        $CI->email->message($msg);
        $CI->email->send();
        
    }
}

if (!function_exists('isAdmin')) {
    function isAdmin() {
        $CI = &get_instance();
        $userInfo = currentuserinfo();
        return ($userInfo->user_type == 1) ? true : false;
    }
}

if (!function_exists('isManager')) {
    function isManager() {
        $CI = &get_instance();
        $userInfo = currentuserinfo();
        return ($userInfo->user_type == 2) ? true : false;
    }
}

if (!function_exists('isExecutive')) {
    function isExecutive() {
        $CI = &get_instance();
        $userInfo = currentuserinfo();
        return ($userInfo->user_type == 3) ? true : false;
    }
}

if (!function_exists('isGuest')) {
    function isGuest() {
        $CI = &get_instance();
        $userInfo = currentuserinfo();
        return ($userInfo->user_type == 4) ? true : false;
    }
}

