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
        $from_email = 'vghao2000@gmail.com';
        $clientId = '327243645549-vst628hc2g3lgftitapvj2cmvn7r7hc2.apps.googleusercontent.com';
        $clientSecret = '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';
        $refreshToken = '1//0do1FEQWs0zvuCgYIARAAGA0SNwF-L9IrqN-TX9hw_VwaGVjFcqo1j0J6nqPS2VH7Lw-XCiI7pNjIzNUzapcYCHmvw9byQx_E0QY';
        $mail->setFrom($from_email, 'Hào Vương');

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