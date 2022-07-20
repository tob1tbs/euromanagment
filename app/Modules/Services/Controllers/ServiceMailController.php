<?php

namespace App\Modules\Services\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class ServiceMailController extends Controller
{
    protected $email;
    protected $password;

    public function __construct() {
        $this->email = "chikhladze.mt@gmail.com";
        $this->password = "Idriftge";
    }

    public function SendInvoiceMail($mail_subject, $mail_recepient) {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->CharSet = 'utf-8';
        $mail->SMTPAuth =true;
        $mail->SMTPSecure = 'tsl';
        $mail->Host = "smtp.gmail.com"; 
        $mail->Port = 587; 
        $mail->Username = $this->email; 
        $mail->Password = $this->password;
        $mail->setFrom($this->email, 'Caspigroup Contact');
        $mail->Subject = $mail_subject;
        $mail->MsgHTML('პროფილის აქტივაციის ბმული:');
        $mail->addAddress($mail_recepient, "Caspigroup"); 
        $mail->send();
    }
}
