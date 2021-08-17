<?php

require_once("setting/phpmailer/PHPMailerAutoload.php");
include('setting/W3LL.settings.php');
include('setting/W3LL.function.php');

echo "               \e[1;91m××××××××××××××××××××××\e[0m××××××××××××××××××××××××\r\n";
echo "               \e[1;91m×					    ×\r\n";
echo "               \e[1;91m×\e[0m ɤɤ\      ɤɤ\  ɤɤɤɤɤɤ\  ɤɤ\       ɤɤ\       \e[1;91m×\r\n";
echo "               \e[1;32m×\e[0m ɤɤ | ɤ\  ɤɤ |ɤɤ ___ɤɤ\ ɤɤ |      ɤɤ |      \e[1;32m×\r\n";
echo "               \e[1;33m×\e[0m ɤɤ |ɤɤɤ\ ɤɤ |\_/   ɤɤ |ɤɤ |      ɤɤ |      \e[1;33m×\r\n";
echo "               \e[1;34m×\e[0m ɤɤ ɤɤ ɤɤ\\ɤɤ |  ɤɤɤɤɤ / ɤɤ |      ɤɤ |      \e[1;34m×\r\n";
echo "               \e[1;35m×\e[0m ɤɤɤɤ  _ɤɤɤɤ |  \___ɤɤ\ ɤɤ |      ɤɤ |      \e[1;35m×\r\n";
echo "               \e[1;36m×\e[0m ɤɤɤ  / \\ɤɤɤ |ɤɤ\   ɤɤ |ɤɤ |      ɤɤ |      \e[1;36m×\r\n";
echo "               \e[1;37m×\e[0m ɤɤ  /   \\ɤɤ |\\ɤɤɤɤɤɤ  |ɤɤɤɤɤɤɤɤ\ ɤɤɤɤɤɤɤɤ\ \e[1;37m×\r\n";
echo "               \e[1;91m×\e[0m \__/     \__| \______/ \________|\________|\e[1;91m×\r\n";
echo "               \e[1;91m×					    ×\r\n";
echo "               \e[1;91m××××××××××××××××××××××\e[0m××××××××××××××××××××××××\r\n";
echo "\r\n";
echo "\e[0m               ▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬ \e[0m\r\n";
echo "               \e[101m                                              \r\n";
echo "\e[0m                         W3LL SENDER v1.3 - LAST BLOOD         \r\n";
echo "               \e[107m                                              \r\n";
echo "\e[0m               ▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬ \r\n";
echo "\e[0m              \r\n";
echo "\r\n";



function Kirim($email, $smtp_acc, $W3LL_setup)
{
    $smtp           = new SMTP;
    $smtp->do_debug = 0;

    $smtpserver     = $smtp_acc['host'];
    $smtpport       = $smtp_acc['port'];
    $smtpuser       = $smtp_acc['username'];
    $smtppass       = $smtp_acc['password'];
    $priority       = $W3LL_setup['priority'];
    $userandom      = $W3LL_setup['userandom'];
    $sleeptime      = $W3LL_setup['sleeptime'];
    $replacement    = $W3LL_setup['replacement'];
    $userremoveline = $W3LL_setup['userremoveline'];
    $fromname       = $W3LL_setup['fromname'];
    $frommail       = $W3LL_setup['frommail'];
    $subject        = $W3LL_setup['subject'];
    $msgfile        = $W3LL_setup['msgfile'];
    $filepdf        = $W3LL_setup['filesend'];
    $randurl        = $W3LL_setup['scampage'];

    if (!$smtp->connect($smtpserver, $smtpport)) {
        throw new Exception('Connect failed');
    }

    //Say hello
    if (!$smtp->hello(gethostname())) {
        throw new Exception('EHLO failed: ' . $smtp->getError()['error']);
    }

    $e = $smtp->getServerExtList();

    if (array_key_exists('STARTTLS', $e)) {
        $tlsok = $smtp->startTLS();
        if (!$tlsok) {
            throw new Exception('Failed to start encryption: ' . $smtp->getError()['error']);
        }
        if (!$smtp->hello(gethostname())) {
            throw new Exception('EHLO (2) failed: ' . $smtp->getError()['error']);
        }
        $e = $smtp->getServerExtList();
    }

    if (array_key_exists('AUTH', $e)) {

        if ($smtp->authenticate($smtpuser, $smtppass)) {
            $mail           = new PHPMailer;
            $mail->Encoding = 'base64'; // 8bit base64 multipart/alternative quoted-printable
            $mail->CharSet  = 'UTF-8';
            $mail->headerLine("format", "flowed");
            /*  Smtp connect    */
            //$mail->addCustomHeader('X-Ebay-Mailtracker', '11400.000.0.0.df812eaca5dd4ebb8aa71380465a8e74');
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->Host     = $smtpserver;
            $mail->Port     = $smtpport;
            $mail->Priority = $priority;
            $mail->Username = $smtpuser;
            $mail->Password = $smtppass;

            if ($userandom == 1) {
                $rand     = rand(1, 50);
                $fromname = randName($rand);
                $frommail = randMail($rand);
                $subject  = randSubject($rand);
            }

            if ($W3LL_setup['filesend'] == 0) {
                $filepdf = file_get_contents($AddAttachment);
                $mail->AddAttachment($filepdf);
            }

            $asu       = RandString1(8);
            $asu1      = RandString(5);
            $asu2      = RandString1(5);
            $nmbr      = RandNumber(5);
            $fromnames = str_replace('##randstring##', $asu1, $fromname);
            $frommails = str_replace('##randstring##', $asu, $frommail);
            $subjects  = str_replace('##randstring##', $asu2, $subject);

            $mail->setFrom($frommails, $fromnames);

            $mail->AddAddress($email);

            $mail->Subject = $subjects;
            if ($replacement == 1) {
                $msg = lettering($msgfile, $email, $frommail, $fromname, $randurl, $subject);
            } else {
                $msg = file_get_contents($msgfile);
            }

            $mail->msgHTML($msg);

            if (!$mail->send()) {
                echo "SMTP Error : " . $mail->ErrorInfo;
                exit();
            } else {
				echo "\e[1;91m▐▬▬▬▬▬[ W3LL SENDER ]▬▬▬▬▬ \r\n";
                echo "\e[1;91m▐ »\e[1;34mTime      \e[0m    : \e[0m";
                echo date('h:i:s A');
                echo "\e[1;34m \r\n";
				echo "\e[1;91m▐ »\e[1;34mSend From\e[0m     :\e[0m $smtpuser\e[0m\n";
				echo "\e[1;91m▐ »\e[1;34mSend To   \e[0m    : $email\e[0m\r\n"; 
				echo "\e[1;91m▐ »\e[1;34mSend Status\e[0m   : \e[1;32mSuccess!\e[0m\n";
				
            }
            $mail->clearAddresses();

        } else {
            throw new Exception('SMTP ERROR :' .$smtp->getError()['error']);
        }

        $smtp->quit(true);

    }

}



    $file = file_get_contents($W3LL_setup['mail_list']);
    if ($file) {
        $ext = preg_split('/\n|\r\n?/', $file);
        echo "                              ▄▄▄▄▄▄▄▄▄▄▄▄▄▄\e[0m \r\n";
        echo "\e[1;91m▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▌\e[1;32mSENDER READY\e[0m\e[1;91m▐▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄\e[0m\n";
		echo "\e[1;91m▐                             \e[0m▀▀▀▀▀▀▀▀▀▀▀▀▀▀\e[0m\n";		
        $smtp_key = 0;
        foreach ($ext as $num => $email) {

            if ($smtp_key == count($smtp_acc)) {
                $smtp_key = 0;
            }
            //kirim
            Kirim($email, $smtp_acc[$smtp_key], $W3LL_setup);

            $smtp_key++;

            ///
            sleep($W3LL_setup['sleeptime']);
        }
        if ($W3LL_setup['userremoveline'] == 1) {
            $remove = Removeline($mailist, $email);
			
        }
		echo "\e[1;91m▐                               \e[0m▄▄▄▄▄▄▄▄▄▄▄\e[0m \r\n";
		echo "\e[1;91m▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▌\e[1;32mSEND DONE\e[0m\e[1;91m▐▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀\e[0m\n";
		echo "\e[1;91m                                \e[0m▀▀▀▀▀▀▀▀▀▀▀\e[0m \r\n";
        echo "\r\n";
    }
