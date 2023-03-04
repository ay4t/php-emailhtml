<?php
/*
 * File: MailerTemplate.php
 * Project: src
 * Created Date: Mo Nov 2022
 * Author: Ayatulloh Ahad R
 * Email: ayatulloh@indiega.net
 * Phone: 085791555506
 * -------------------------
 * Last Modified: Mon Nov 14 2022
 * Modified By: Ayatulloh Ahad R
 * -------------------------
 * Copyright (c) 2022 Indiega Network 

 * -------------------------
 * HISTORY:
 * Date      	By	Comments 

 * ----------	---	---------------------------------------------------------
 */

namespace Ay4t\PHPMailerTemplate;

use Ay4t\PHPMailerTemplate\Traits\GlobalSetterTraits;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class MailerTemplate
{
    use GlobalSetterTraits;

    /**
     * @var \Ay4t\PHPMailerTemplate\Config\App();
     * @author Ayatulloh Ahad R <ayatulloh@indiega.net>
     */
    protected $config;

    private $sendToEmail;
    private $sendToName     = false;
    
    /**
     * @var string
     * @author Ayatulloh Ahad R <ayatulloh@indiega.net>
     */
    private $sendSubject;

    /**
     * @var string
     * @author Ayatulloh Ahad R <ayatulloh@indiega.net>
     */
    private $altBody;

    public function __construct()
    {
        $this->template_path    = __DIR__ . '/Templates/default/';
        $this->config           = new \Ay4t\PHPMailerTemplate\Config\App();

        $this->data['base_url']         = $this->config->baseURL;
        $this->data['company_name']     = 'INDIEGA NETWORK';
        $this->data['company_address']  = 'Jl. Jend Sudirman 123 Kota Bahagia';
        $this->data['logo_url']         = 'https://indiega.net/templates/landrick/images/indiega-web-logo-path.svg';
    }

    public function render( $shared = false )
    {
        $loader     = new \Twig\Loader\FilesystemLoader( $this->template_path );
        $twig       = new \Twig\Environment($loader);

        $this->renderHTML   = $twig->render( $this->filename , $this->data);
        if( !$shared ) echo $this->renderHTML;

        return $this->renderHTML;
    }

    /**
     * Undocumented function
     *
     * @param  string $to_email
     * @param  string $to_name
     *
     * @return self             
     * @author Ayatulloh Ahad R <ayatulloh@indiega.net>
     * @throws Exception
     */
    public function sendTo(string $to_email, string $to_name)
    {
        $this->sendToName   = $to_name;
        $this->sendToEmail  = $to_email;
        return $this;
    }

    /**
     * fungsi untuk proses mengirim email
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function send()
    {
        $output     = $this->render( true );

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = $this->config->Host;                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $this->config->Username;                     //SMTP username
            $mail->Password   = $this->config->Password;                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = $this->config->Port;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom($this->config->FromEmail, $this->config->FromName);
            $mail->addAddress($this->sendToEmail, $this->sendToName);     //Add a recipient
            $mail->addReplyTo($this->config->FromEmail, $this->config->FromName);

            //Attachments
            /* $mail->addAttachment('/var/tmp/file.tar.gz');
            $mail->addAttachment('/tmp/image.jpg', 'new.jpg'); */

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $this->sendSubject;
            $mail->Body    = $output;

            if(! empty($this->altBody)) $mail->AltBody = $this->altBody;

            return $mail->send();

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
    
    /**
     * menggabungkan data array yang nantinya akan digunakan di VIEW dan digabung dengan property data
     *
     * @param array $var Description
     **/
    public function mergeData(array $var)
    {
        $this->data = array_merge( $this->data, $var );
        return $this;
    }

	/**
	 * Set the value of sendSubject
	 * @param   string  $sendSubject  
	 * @return  self
	 */
	public function setSubject(string $sendSubject)
	{
		$this->sendSubject = $sendSubject;
		return $this;
	}

	/**
	 * Set the value of altBody
	 * @param   string  $altBody  
	 * @return  self
	 */
	public function setAltBody(string $altBody)
	{
		$this->altBody = $altBody;
		return $this;
	}
}
