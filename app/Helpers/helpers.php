<?php


use App\Support\DTOs\Emails\EmailDataDTO;

if (!function_exists('getMailData')){
    function getMailData($email, $data = []){
        $mailData = new EmailDataDTO();
        $mailData->email = $email;
        $mailData->view = 'mails.student.created';
        $mailData->subject = 'New Account';
        $mailData->data = (object)$data;

        return $mailData;
    }
}
