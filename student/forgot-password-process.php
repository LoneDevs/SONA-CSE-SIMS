<?php

require '../dbconn.php';
require '../PHPMailer-5.2-stable/PHPMailerAutoload.php';
require '../PHPMailer-5.2-stable/class.smtp.php';
require '../PHPMailer-5.2-stable/class.phpmailer.php';
require '../PHPMailer-5.2-stable/class.phpmaileroauth.php';
require '../PHPMailer-5.2-stable/class.phpmaileroauthgoogle.php';
require '../PHPMailer-5.2-stable/class.pop3.php';


function forgotPasswordRequest($useremail){

    global $connection;

    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    $url = "https://sonacsesims.azurewebsites.net/student/create-new-password.php?selector=".$selector."&validator=".bin2hex($token);

    $expires = time()+600;// will expire after 10 min 

    $sql = "DELETE FROM student_reset_passwords WHERE reset_email = ? ";

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s",$useremail);
    $stmt->execute();

    $sql = "SELECT * FROM student_primary WHERE email = ? ";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s",$useremail);
    $stmt->execute();
    $result = $stmt->get_result();
    if (!$row = $result->fetch_assoc()) {
        return "User does not exist ! ";
    }
    $name = $row['name'];

    $hashedToken = password_hash($token,PASSWORD_BCRYPT);

    $sql = "INSERT INTO student_reset_passwords (reset_email,reset_selector,reset_token,reset_expires) VALUES(?,?,?,?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ssss",$useremail,$selector,$hashedToken,$expires);
    $stmt->execute();

    $stmt->close();
    $connection->close();

    try {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = '';
        $mail->Password = '';
        $mail->SMTPSecure ='tls';       // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTP

        $mail->setFrom('sonacse2019to2023@gmail.com', 'Admin'); // sender
        $mail->addAddress($useremail, $name); // recipient

        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'SIMS - Forgot Password';
        $mail->Body    = "<p>You can reset the password for your <strong> Sona CSE SIMS</strong> account by clicking the link below.</p><a href='$url'>".$url."</a><br><strong>Note : This reset token in valid for 10 minutes only.</strong><br>";
        $mail->Body.="<p>Ignore this email if you did not initiate this request. If you suspect anything malicious please reply to this mail to secure your account.</p> - LoneDevs Team";
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();    } catch (Exception $e) {
        return $e;
    }
    return "success";
}