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
            $mailSender = env('MAIL_SENDER');
            $mailSenderName = env('MAIL_SENDER_NAME');
            $message->from($mailSender, $mailSenderName);
            $message->to($email);
        });
    }
}