<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Responseconstant extends CI_Model{

    // Response code constants
    const HEADER_BAD_REQUEST = 400;
    const HEADER_UNAUTHORIZED = 401;
    const SUCCESS = 1;
    const SOCIAL_ID_NOT_FOUND = 2;
    const UNSUCCESS = 0;
    const NOTIFICATION_NOT_FOUND = 3;
    const APPKEY_NOT_FOUND = 4;
    const METHOD_NOT_FOUND = 5;
    const SOCIAL_ID_NOT_BELONG_TO_DATABASE = 6;
    /*
      const ALREADY_ADDED = 10;
      const REQUIRED_PARAMETER = 2;
      const ALREADY_REGISTER = 3;
      const INVALID_IMAGE = 4;
      const EMAIL_NOTVERIFIED = 6;
      const INVALID_REQUEST_METHOD = 1;
      const LOGIN_ACCOUNT_NOT_MATCH = 5;
      const INVALID_DISPENSARY = 7;
      const INVALID_PRODUCT =7;
      const INVALID_STRAIN =7;
      const ALREADY_EXIST = 8;
      const NO_MORE_RECORD = 9;
     */
    const ALREADY_LOGIN_ON_ANOTHER_DEVICE = 420;
      
    // Response messages
    public static function message($MessageKey = NULL, $SetMessage = NULL) {
        //echo $MessageKey; die;
        $Messages = array(
            'HEADER_UNAUTHORIZED' => empty($SetMessage) ? 'Unauthorized access.' : $SetMessage,
            'HEADER_BAD_REQUEST' => empty($SetMessage) ? 'Bad Request' : $SetMessage,
            'SUCCESS' => empty($SetMessage) ? 'Success' : $SetMessage,
            'UNSUCCESS' => empty($SetMessage) ? 'Somthing went wrong.' : $SetMessage,
            'REQUIRED_PARAMETER' => empty($SetMessage) ? 'Required Parameters Missing.' : $SetMessage,
            'INVALID_USER' => empty($SetMessage) ? 'Please enter correct employee code.' : $SetMessage,
            'INVALID_CREDENTIALS' => empty($SetMessage) ? 'Please enter valid credentials' : $SetMessage,
            'INVALID_PHONE' => empty($SetMessage) ? 'Please enter your registered phone number.' : $SetMessage,
            'INCORRECT_OTP' => empty($SetMessage) ? 'Please enter correct OTP.' : $SetMessage,
            'INCORRECT_PASSWORD' => empty($SetMessage) ? 'Please enter correct password.' : $SetMessage,
            'EMAIL_NOTEXIST' => empty($SetMessage) ? 'Email does not exist.' : $SetMessage,
            'EMAIL_ALREADYEXIST' => empty($SetMessage) ? 'Email already exist.' : $SetMessage,
            'MOBILE_ALREADYEXIST' => empty($SetMessage) ? 'Mobile Number already exist.' : $SetMessage,
            'ACCOUNT_ALREADYEXIST' => empty($SetMessage) ? 'Account Number is already exist.' : $SetMessage,
            'ADHAAR_ALREADYEXIST' => empty($SetMessage) ? 'Adhaar Number is already exist.' : $SetMessage,
            'MERCHANT_ID_ALREADYEXIST' => empty($SetMessage) ? 'Merchant Id  is already exist.' : $SetMessage,
            'ALREADY_LOGIN_ON_ANOTHER_DEVICE' => empty($SetMessage) ? 'You are already login on other device. Please logout from there.' : $SetMessage,
            'NOTIFICATION_NOT_FOUND' => empty($SetMessage) ? 'No Notification Found.' : $SetMessage,
            'EMAIL_SEND' => empty($SetMessage) ? 'Email sent successfully.' : $SetMessage,
            'LOGOUT' => empty($SetMessage) ? 'Logout successfully.' : $SetMessage,
            'ATTENDANCE_ALREADYEXIST' => empty($SetMessage) ? 'Your Attendance is already marked.' : $SetMessage,
            'THUMB_REGISTER' => empty($SetMessage) ? 'Please thumb register.' : $SetMessage,
            'DA_ADD_SUCCESSFULLY' => empty($SetMessage) ? 'DA has been added Successfully.' : $SetMessage,
            'ALREADYPRESENT' => empty($SetMessage) ? 'Already Present.' : $SetMessage,
            'DA_ROUTE_START' => empty($SetMessage) ? 'Your route has start.' : $SetMessage,
            'GPS_ON_SUCCESS' => empty($SetMessage) ? 'GPS ON.' : $SetMessage,
            'GPS_OFF_SUCCESS' => empty($SetMessage) ? 'GPS OFF.' : $SetMessage,
            'HALT_SUCCESS' => empty($SetMessage) ? 'HALT SUCCESS.' : $SetMessage,
            'ASSIGNMENT_ASSIGN_TO_DA' => empty($SetMessage) ? 'Assignment successfully assigned to DA.' : $SetMessage,
            'ASSIGNMENT_CLOSE_TO_DA' => empty($SetMessage) ? 'DA assignment close successfully .' : $SetMessage,
            'SESSION_HASBEEN_EXPIRED' => empty($SetMessage) ? 'Session has been expired .' : $SetMessage,
            'NO_RECORD_FOUND' => empty($SetMessage) ? 'No record found.' : $SetMessage,
            
            'END_OF_DAY_MAIL' => empty($SetMessage) ? 'Day End report has been successfully sent.' : $SetMessage,
            'ATTENDANCE_DA_REPORT_MAIL' => empty($SetMessage) ? 'Attendence DA report has been successfully sent.' : $SetMessage,
            'ATTENDANCE_VAN_REPORT_MAIL' => empty($SetMessage) ? 'Attendence Van report has been successfully sent.' : $SetMessage,
            'EXPENCE_MAIL' => empty($SetMessage) ? 'Expence report has been successfully sent.' : $SetMessage,
            
            'EMAIL_NOT_SENT' => empty($SetMessage) ? 'Email not sent.' : $SetMessage,
            
            'THUMB_REGISTER_SUCCESSFUL' => empty($SetMessage) ? 'Thumb register successfully.' : $SetMessage,


            'METHOD_NOT_FOUND' => empty($SetMessage) ? 'Method Name not found.' : $SetMessage,
            'APPKEY_NOT_FOUND' => empty($SetMessage) ? 'Appkey not found.' : $SetMessage,
            'SIGN_UP_FAIL' => empty($SetMessage) ? 'Something went Wrong.' : $SetMessage,
            'CREDENTIALS_DOESNOT_MATCH' => empty($SetMessage) ? 'Credentials does not match.' : $SetMessage,
            'EMAIL_EXIST' =>empty($SetMessage) ? 'Email already exist please login to your account.' : $SetMessage,
            'SOCIAL_ID_NOT_BELONG_TO_DATABASE' =>empty($SetMessage) ? 'Info not Inserted' : $SetMessage,
            'RESTURANT_NOT_FOUND' =>empty($SetMessage) ? 'there is no any registered resturants in this location.' : $SetMessage,
        );

        // Check, message key exist or not in messages array
        // echo $MessageKey;
        if (array_key_exists($MessageKey, $Messages))
            return $Messages[$MessageKey];
        // Show, message "No any messahe is given."
        else
            return 'No any message is given.';
    }

}
