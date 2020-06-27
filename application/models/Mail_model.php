<?php
class Mail_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('email');
    }
    public function sendMail($reciever,$subject,$content){
        
        require 'PHPMailer-master/class.phpmailer.php';
        require 'PHPMailer-master/class.smtp.php';
        require 'PHPMailer-master/PHPMailerAutoload.php';

        /*$mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPDebug = 1;
        $mail->SMTPSecure = 'ssl';
        $mail->Host = 'mail.nearbycure.com';
        $mail->Port = 465;
        $mail->Username = 'vss@nearbycure.com';
        $mail->Password = 'Fs?-d6Jdv{Pf';
        $mail->SMTPAuth = true;      // TCP port to connect to        
        $mail->SetFrom('vss@nearbycure.com');*/
		$mail = new PHPMailer();
        $mail->IsSMTP(false);
        $mail->SMTPDebug = 0;
        $mail->SMTPSecure = 'tls';
        $mail->Host = 'mail.hashtaglabs.in';
		$mail->Port = 465;
		$mail->Username = 'devendra.nai@hashtaglabs.in';
		$mail->Password = 'Test@123';
		$mail->SMTPAuth = true;      // TCP port to connect to        
		$mail->setfrom('devendra.nai@hashtaglabs.in');
		
        $mail->AddAddress($reciever); 
        
        //$mail->AddAttachment( $file_to_attach , $user_detail['resume'] );
        //$mail->AddAttachment( $path , 'application/octet-stream');
        $mail->IsHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = $content;        
        
        if(!$mail->Send())
        {
          return 1;
        } else{
           return 0;
        }
    }
}
?>