<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PHPMailer\PHPMailer\PHPMailer;

class UserFeedbackController extends Controller
{
    public function feedback(FeedbackRequest $request){

        $first = $request->input("ime");
        $last = $request->input("prezime");
        $email = $request->input("email");
        $content = $request->input("content");

        $mail = new PHPMailer(true);
        try {

            //Server settings
//            $mail->SMTPDebug = 2;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers

            $mail->SMTPAuth = true;
            $mail->SMTPSecure = true;
            // Enable SMTP authentication
            $mail->Username = 'phpmailer1995@gmail.com';                 // SMTP username
            $mail->Password = 'dusan1995';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                 // TCP port to connect to

            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            //Recipients
            $mail->setFrom('phpmailer1995@gmail.com', 'Pitanje');
            $mail->addAddress("duci1995@gmail.com");    // Add a recipient

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Pitanje';

            $mail->Body= "$first $last <br/> $email<br/>$content";

            $mail->send();

            return response(null,200);

        } catch (\Exception $e) {
            Log::debug("Greška pri slanju mejla za kontakt");
            return response(null ,500);
        }

    }
}
