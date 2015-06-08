<?php
/**
 * Simple Mail Class
 *  
 * @package SMail
 * @category SMail
 * @name SMail
 * @version 1.0
 * @author Shay Anderson 05.11
 */
final class SMail {
      /**
       * Name of attachment (ex: test.txt)
       *
       * @var string $attachment_name
       */
      public $attachment_name;

      /**
       * Full path of attachment (ex: files/test.txt)
       *
       * @var string $attachment_path
       */
      public $attachment_path;

      /**
       * Mail body content
       *
       * @var string $body
       */
      public $body;

      /**
       * Last error (if error occurred)
       *
       * @var string $error
       */
      public $error;

      /**
       * Sender email address
       *
       * @var string $from
       */
      public $from;

      /**
       * Email subject
       *
       * @var string $subject
       */
      public $subject;

      /**
       * Recipient email address
       *
       * @var string $to
       */
      public $to;

      /**
       * Send email
       *
       * @return bool
       */
      public function send() {
            // check for valid params
            if($this->to) {
                  // set boundry
                  $boundary = md5(rand(5000, 500000000) . date("r"));

                  // set attachment if exists
                  $attachment = null;
                  if($this->attachment_path && $this->attachment_name) {
                        // check if attachment file exists
                        if(file_exists($this->attachment_path)) {
                              $attachment = chunk_split(base64_encode(file_get_contents($this->attachment_path)));
                        } else {
                              $this->error = "Failed to send mail, attachment file \"{$this->attachment_path}\" not found";
                              return false;
                        }
                  }

                  // set headers
                  $headers = null;
                  if($this->from) {
                        $headers = "From: {$this->from}\r\nReply-To: {$this->from}";
                  }
                  if($attachment) {
                        $headers .= "\r\nMIME-Version: 1.0\r\nContent-Type: multipart/mixed; boundary=\"_1_{$boundary}\"";
                  }

                  // set body
                  $body = null;
                  if($attachment) {
                        $body = "This is a multi-part message in MIME format.

--_1_{$boundary}
Content-Type: multipart/alternative; boundary=\"_2_{$boundary}\"

--_2_$boundary
Content-Type: text/plain; charset=\"iso-8859-1\"
Content-Transfer-Encoding: 7bit

{$this->body}

--_2_{$boundary}--
--_1_{$boundary}
Content-Type: application/octet-stream; name=\"{$this->attachment_name}\"
Content-Transfer-Encoding: base64
Content-Disposition: attachment

{$attachment}
--_1_{$boundary}--";
                  } else {
                        $body = $this->body;
                  }

                  // send mail
                  if(mail($this->to, $this->subject, $body, $headers)) {
                        return true;
                  } else {
                        $this->error = "Failed to send mail (check SMTP settings)";
                        return false;
                  }

            // fail
            } else {
                  $this->error = "Failed to send mail, invalid params";
                  return false;
            }
      }
}
?>
