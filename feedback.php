<?php require_once('settings.php');


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include_once(INCLUDE_DIR.'/title.inc.php');?>
<script src="js/sidebar.feedback.js"></script>

</head>

<body>

	<div class="wrapper"><?php include_once(INCLUDE_DIR.'/topBar.inc.php');?>
    
        <div class="contentWrapper">
        		<div class="leftside">

				<?php include_once(INCLUDE_DIR.'/leftBar.inc.php');?>
				
            </div>
            
			<div class="blogContent">
				<h1 class ="welcome_head">Mail Sender  </h1>
           	    <div class="pageBody">
				<?php 
					if( isset($_POST['Submit']) )
					{
					 // additional headers
					 $to_email_list = array("d.ip1@police.gov.bd", "d.ip2@police.gov.bd", "d.ip3@police.gov.bd", "dip4@police.gov.bd");
					 $to_name_list = array("INDUSTRIAL POLICE-1, DHAKA", "INDUSTRIAL POLICE-2, GAZIPUR", "INDUSTRIAL POLICE-3, CHITTAGONG", "INDUSTRIAL POLICE-4, Narayanganj");
					 
							$to_mail = $_POST['to_mail'];
							$to =  str_replace($to_email_list, $to_name_list, $to_mail);
							$from_mail = $_POST['from_mail'];
							$from = "Visitor";
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
							$mail->AddAddress($to_mail, $to);
							$mail->AddAddress('alauddin1987@gmail.com', 'Md. Alauddin'); 
							$mail->AddAddress('shahenbp@gmail.com',  'Md. Shahenur Alam Khan'); 
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
				
				</div>
		
			</div>
		
			</div>
            
      </div>
   <div class="footerarea"><?php include_once(INCLUDE_DIR.'/footer.inc.php');?></div>
<?php include_once(INCLUDE_DIR.'/feedback.inc.php');?>

</body>
</html>
