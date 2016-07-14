<?php

  $verificationCode = md5(uniqid("bill", true));

  $headers .= "Reply-To: Kwame Project\r\n"; 
  $headers .= "Return-Path: Kwame Project\r\n"; 
  $headers .= "From: Kwame Project\r\n";
  $headers .= "Organization: Kwame\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
  $headers .= "X-Priority: 3\r\n";
  $headers .= "X-Mailer: PHP". phpversion() ."\r\n";

  $message = "Hello bill! It appears you have registed an account with us.\r\nIn order to complete your registration, you must click the link below.\r\nhttp://www.kwameproject.byethost14.com/activate.php?code=".$verificationCode."\r\nThank you!";

  $message = wordwrap($message, 70, "\r\n");

  mail($email, 'Activate Your Account', $message, $headers);