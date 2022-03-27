<?php
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\OAuth;
    use League\OAuth2\Client\Provider\Google;
    require 'vendor/autoload.php';

    $mail = new PHPMailer(true);

    try {
        // Account settings
        $from_email = '518H0589@student.tdtu.edu.vn';
        $clientId = '920008759253-2c7l1agq58pkstocbp4b3ihqqic9lns1.apps.googleusercontent.com';
        $clientSecret = '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';
        $refreshToken = '1//0dllpzg5g_hBcCgYIARAAGA0SNwF-L9Iri6tZL2A2k0H7P7BC2ATXOolOpSbaKmmLwzp_3_blXjXAHf88E_u79_k1qiVp8QzMnTM';
        $mail->setFrom($from_email, 'TRAN DINH ANH VU');

        // Create a new OAuth2 provider instance
        $provider = new Google(
            [
                'clientId' => $clientId,
                'clientSecret' => $clientSecret,
            ]
        );

        // Server settings
        $mail->isSMTP();
        $mail->SMTPDebug  = 0;
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->AuthType   = 'XOAUTH2';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;
        $mail->MessageID  = "<" . md5('HELLO'.(idate("U")-1000000000).uniqid()) . '@gmail.com>';
        $mail->XMailer    = 'Google Gmail';
        $mail->CharSet    = PHPMailer::CHARSET_UTF8;

        // Pass the OAuth provider instance to PHPMailer
        $mail->setOAuth(
            new OAuth(
                [
                    'provider' => $provider,
                    'clientId' => $clientId,
                    'clientSecret' => $clientSecret,
                    'refreshToken' => $refreshToken,
                    'userName' => $from_email,
                ]
            )
        );

        // Recipients
        $mail->addAddress($_POST["recipientEmail"]);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $_POST["mailTitle"];
        $mail->Body    = $_POST["mailContent"];
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
?>