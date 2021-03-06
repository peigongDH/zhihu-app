<?php
/**
 * Created by PhpStorm.
 * User: zhangpei-home
 * Date: 2017/7/2
 * Time: 19:25
 */

namespace App\Mailer;


use Illuminate\Support\Facades\Mail;
use Naux\Mail\SendCloudTemplate;

class Mailer
{
    protected function sendTo($template, $email, array $data)
    {
        $content = new SendCloudTemplate($template, $data);
        Mail::raw($content, function ($message) use($email) {
            $mailSender = config('mail.mail_sender');
            $mailSenderName = config('mail.mail_sender_name');
            $message->from($mailSender, $mailSenderName);
            $message->to($email);
        });
    }
}