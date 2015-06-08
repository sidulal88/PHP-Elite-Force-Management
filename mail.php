<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
<p> To <select name="to_mail" >
					<option value="">Select Police Unit</option>
					<option value="alauddin1987@gmail.com">INDUSTRIAL POLICE-1, DHAKA</option>
					<option value="alauddin1987@gmail.com">INDUSTRIAL POLICE-2, GAZIPUR</option>
					<option value="alauddin1987@gmail.com">INDUSTRIAL POLICE-3, CHITTAGONG</option>
				</select></p>
<p> From : <input type="text" name="from_mail" value="" size="36" placeHolder="Input Your Email"></p>
<p>Subject : <input type="text" size="32" name="subject" placeHolder="Input Your Email Subject" /></p>
<p>Message : <textarea name="message" placeHolder="Input Your Message" ></textarea></p>
  <p>
    <input type="file" name="file" />
</p>
  <p>
    <input type="submit" name="Submit" value="Submit" />
</p>
</form>
<?php


if($_POST['Submit'] == "Submit" )
{
 // additional headers
 		$to_mail = $_POST['to_mail'];
		$to =  "INDUSTRIAL POLICE-1, DHAKA";
		$from_mail = $_POST['from_mail'];
		$from = "Industrial Police Bangladesh";
		$subject = $_POST['subject'];
		$message = $_POST['message'];
		
        $headers .= "To: \"" . $to_mail . "\" <" . $to_mail . ">\n";
        $headers .= "From: \"" . $from_mail . "\" <" . $from_mail . ">\n";
        $headers .= "Return-Path: <" . $from_mail . ">\n";
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-Type: text/HTML; charset=ISO-8859-1\n";
        //$headers .= "Cc: $cc\r\n";
        //$headers .= "Bcc: $bcc\r\n";
        //$mail_status   = mail($to_mail, $subject, $message, $headers);

        $mail_status = 0;
        include_once("class.phpmailer.php");
        //$from = $from_mail;
        //$to = $to_mail;
        $subject = $subject;
		
        $mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPAuth = true;
		$mail->Host = "zmail.bcc.net.bd";
		$mail->Port = 25;
		$mail->Username = "industrialpolice@bcc.net.bd";
		$mail->Password = "industrialpolice2014";
		
        $mail->From = $from_mail;
		$mail->FromName = $from;
		//$mail->AddAddress('alauddin1987@yahoo.com', 'Md.Shahenur Alam Khan');  
        $mail->AddAddress($to_mail, $to);
        $mail->Subject = $subject;
		//Attach an image file
		//$mail->AddAttachment($_FILES['file']['tmp_name']);
		//$mail->AddAttachment("http://industrialpolice.gov.bd/uploads/tender/1.pdf");
		$mail->AddAttachment($_FILES['file']['tmp_name'], $_FILES['file']['name']);

        $mail->Body = $message;
        $mail->WordWrap = 50;
        $mail->PluginDir = dirname(__FILE__) . "/PHPMailer/";
        $mail->SetLanguage('en', $mail->PluginDir . "language/");
        if (!$mail->Send()) {
			echo $mail->ErrorInfo;
        } else {
            echo "Mail send Successully!";
        }
}

?>