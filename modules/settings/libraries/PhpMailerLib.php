<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PhpMailerLib 
{

    private $mail;  

	function __construct()
	{
		require_once(APPPATH."third_party/phpmailer/PHPMailer.php");
        $this->mail = new \PHPMailer\PHPMailer\PHPMailer;
        $this->mail->isSMTP();                                      // Set mailer to use SMTP
        $this->mail->Host = 'mail.edtools.io';  // Specify main and backup SMTP servers
        $this->mail->SMTPAuth = true;                               // Enable SMTP authentication
        $this->mail->Username = 'notification@edtools.io';
        $this->mail->Password = 'ddDs39bA';
        $this->mail->SMTPSecure = 'SSL';                            
        $this->mail->Port = '25';
	}



    public function testmessage($body)
    {
        $this->mail->setFrom($this->mail->Username, 'Report');
        $this->mail->addAddress('blackdesire002@gmail.com'); 
        $this->mail->isHTML(true);                                  
        $this->mail->Subject = 'test';
        $this->mail->Body    = $body;
        $email = $this->mail->send();
        $res = array('res'=>$email,'data'=>$this->mail);
        return $res;
    }


    public function parent_email_added($mails,$body)
    {
        $this->mail->setFrom($this->mail->Username, 'EdTools');
        foreach ($mails as $key => $mail) {
           $this->mail->addAddress($mail); 
        }
        $this->mail->isHTML(true);                                  
        $this->mail->Subject = 'Security message: New parent email added';
        $this->mail->Body    = $body;
        $email = $this->mail->send();
        $res = array('res'=>$email,'data'=>$this->mail);
        return $res;
    }


    public function parent_code_changed($mails,$body)
    {
        $this->mail->setFrom($this->mail->Username, 'EdTools');
        foreach ($mails as $key => $mail) {
           $this->mail->addAddress($mail); 
        }
        $this->mail->isHTML(true);                                  
        $this->mail->Subject = 'EdTools Parent Code Dear Parents';
        $this->mail->Body    = $body;
        $email = $this->mail->send();
        $res = array('res'=>$email,'data'=>$this->mail);
        return $res;
    }


    

}

