<?php
include_once 'my.php';
/* Namespace alias. */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/* Include the Composer generated autoload.php file. */
// include('C:\xampp\composer\vendor\autoload.php';

/* If you installed PHPMailer without Composer do this instead: */

include('PHPMailer\src\Exception.php');
include('PHPMailer\src\PHPMailer.php');
include('PHPMailer\src\SMTP.php');

function mailme($title,$address,$username,$body){
/* Create a new PHPMailer object. Passing TRUE to the constructor enables exceptions. */
$mail = new PHPMailer(TRUE);

/* Open the try/catch block. */
try {
   /* Set the mail sender. */
   $mail->isSMTP();
   $mail->Host = 'smtp.gmail.com';
   $mail->Port = 587;
   $mail->SMTPAuth = true;
   $mail->SMTPSecure = 'tls';

  /* Username (email address). */
   $mail->Username = 'budgetty.app@gmail.com';

  /* Google account password. */
  $mail->Password = '081070walE';
   $mail->setFrom('budgetty.app@gmail.com', 'JobSume');

   /* Add a recipient. */
   $mail->addAddress($address, $username);

   /* Set the subject. */
   $mail->Subject = $title;
    $mail->isHTML(true);
   /* Set the mail message body. */
   $mail->Body = '
      <html>
         <body>
            <img src="https://budgetty.netlify.app/logo.png" width=50px height=50px/>
            <h2>Hi '.$username.'</h2>
              '.$body.'
              <br/>
             
              The   Chrony Team.
              <footer>
               Contact Email : budgetty.app@gmail.com 
               &copy; 2020 Chrony Inc
               <small>You can reply to this email</small>
              </footer>
            </body>
      </html>
   ';

   /* Finally send the mail. */
   $mail->send();
   return true;
}
catch (Exception $e)
{
   /* PHPMailer exception. */
  $error = $e->errorMessage();
  logerror($error.$body);
  // return 400;
}
catch (\Exception $e)
{
   /* PHP exception (note the backslash to select the global namespace Exception class). */
   $error = $e->getMessage();
   logerror($error.$body);
  //  return 500;
}
}

?>