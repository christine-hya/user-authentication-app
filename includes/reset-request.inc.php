<?php

  //EMAIL

  use PHPMailer\PHPMailer\PHPMailer;
  require 'C:\MAMP\composer\vendor\autoload.php';

  $mail = new PHPMailer();
  $mail->isSMTP();
  $mail->Host = 'smtp.mailtrap.io';
  $mail->SMTPAuth = true;
  $mail->Username = 'fbac85340577e6';
  $mail->Password = '386b57287326ea';
  $mail->SMTPSecure = 'tls';
  $mail->Port = 2525;
  
  $mail->setFrom('info@mailtrap.io', 'Mailtrap');
  $mail->addReplyTo('info@mailtrap.io', 'Mailtrap');
  $mail->addAddress('recipient1@mailtrap.io', 'Tim');
  
  $mail->isHTML(true);

//CREATE URL TO SEND

if (isset($_POST["reset-request-submit"])) {

    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    $url = "localhost/user-authentication-app/create-new-password.php?selector" . $selector . "&validator=" . bin2hex($token);

    $expires = date("U") + 1800;

    require "dbh.inc.php";

    $userEmail = $_POST["email"];


    $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "Something went wrong!";
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $userEmail);
        mysqli_stmt_execute($stmt);
    }

    $sql = "INSERT INTO pwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "Something went wrong!";
        exit();
    } else {
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hashedToken, $expires);
        mysqli_stmt_execute($stmt);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    //$to = $userEmail;

    //$subject = 'Reset your library password';

    //$message = '<p>We received a password reset request. The link to reset your password is below.
    //If you did not make this request, you can ignore this email.</p>';
    //$message .= '<p>Here is your password reset link: </p>';
    //$message .= '<a href="' . $url . '">' . $url . '</a></p>';

    //$headers = "From: library <library@gmail.com>\r\n";
    //$headers .= "Reply-To: <library@gmail.com>\r\n";
    //$headers .= "Content-type: text/html\r\n";

    //mail($to, $subject, $message, $headers);

    $mail->Subject = 'Reset your library password';
    $mailContent = '<p>We received a password reset request. The link to reset your password is below.
    If you did not make this request, you can ignore this email.</p>';
    $mailContent .= '<p>Here is your password reset link: </p>';
    $mailContent .= '<a href="' . $url . '">' . $url . '</a></p>';

    $mail->Body = $mailContent;

    $mail->send();
    
    header("Location: ../reset-password.php?reset=success");

} else {
    header("Location: ../index.php");
}


