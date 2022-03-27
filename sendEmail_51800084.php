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
        $from_email = 'km010203aa@gmail.com';
        $clientId = '523061451821-1bgoqhfpj8rg18nclcd0cvkoi94i2ln7.apps.googleusercontent.com';
        $clientSecret = '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';
        $refreshToken = '1//0dH98MrZZa3D-CgYIARAAGA0SNwF-L9IrMMVhs4Ltm8Fv4GA0NecISxCG_qmFZbPjNqEwJWRgEpULH9BWQa2uOrFUhw0tJn_9_DI';
        $mail->setFrom($from_email, 'Fi Nguyễn');

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
        $mail->addAddress($_POST["email"]);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $_POST["subject"];
        $mail->Body    = $_POST["content"];
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
?>