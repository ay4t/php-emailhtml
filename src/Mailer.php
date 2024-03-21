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

namespace Ay4t\Emailhtml;

use Ay4t\Emailhtml\Traits\GlobalSetterTraits;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    use GlobalSetterTraits;

    /**
     * @return \Ay4t\Emailhtml\Config\App();
     * @author Ayatulloh Ahad R <ayatulloh@indiega.net>
     */
    protected $config;
    
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
    
    /**
     * @var bool
     */
    private $debugOutput = true;

    private $phpMailer;


    public function __construct($filename = 'account_welcome', $config = null)
    {
        $this->config           = (!$config)? new \Ay4t\Emailhtml\Config\App() : $config;
        $this->template_path    = $this->config->template_path;
        $this->filename         = $filename;

        $this->phpMailer        = new PHPMailer(true);

        /* $this->data['base_url']         = $this->config->baseURL;
        $this->data['company_name']     = 'INDIEGA NETWORK';
        $this->data['company_address']  = 'Jl. Jend Sudirman 123 Kota Bahagia';
        $this->data['logo_url']         = 'https://indiega.net/templates/landrick/images/indiega-web-logo-path.svg'; */
    }

    public function render( $shared = false )
    {
        $loader     = new \Twig\Loader\FilesystemLoader( $this->template_path );
        $twig       = new \Twig\Environment($loader);

        $this->renderHTML   = $twig->render( $this->filename . '.html' , $this->data);
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
        $this->phpMailer->addAddress($to_email, $to_name);
        return $this;
    }

    /**
     * Undocumented function
     *
     * @param string $cc_email
     * @param string $cc_name
     * @return self
     */
    public function addCCto(string $cc_email, string $cc_name)
    {
        $this->phpMailer->addCC($cc_email, $cc_name);
        return $this;
    }

    /**
     * fungsi untuk proses mengirim email
     *
     * @return bool
     * @throws Exception
     **/
    public function send()
    {
        $output     = $this->render( true );

        //Create an instance; passing `true` enables exceptions
        // $mail = new PHPMailer(true);

        try {
            //Server settings
            $this->phpMailer->SMTPDebug = ($this->debugOutput)? SMTP::DEBUG_SERVER : false;                      //Enable verbose debug output
            $this->phpMailer->isSMTP();                                            //Send using SMTP
            $this->phpMailer->Host       = $this->config->Host;                     //Set the SMTP server to send through
            $this->phpMailer->SMTPAuth   = true;                                   //Enable SMTP authentication
            $this->phpMailer->Username   = $this->config->Username;                     //SMTP username
            $this->phpMailer->Password   = $this->config->Password;                               //SMTP password
            $this->phpMailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $this->phpMailer->Port       = $this->config->Port;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $this->phpMailer->setFrom($this->config->FromEmail, $this->config->FromName);
            $this->phpMailer->addReplyTo($this->config->FromEmail, $this->config->FromName);

            //Attachments
            /* $this->phpMailer->addAttachment('/var/tmp/file.tar.gz');
            $this->phpMailer->addAttachment('/tmp/image.jpg', 'new.jpg'); */

            //Content
            $this->phpMailer->isHTML(true);                                  //Set email format to HTML
            $this->phpMailer->Subject = $this->sendSubject;
            $this->phpMailer->Body    = $output;

            if(! empty($this->altBody)) $this->phpMailer->AltBody = $this->altBody;

            return $this->phpMailer->send();

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$this->phpMailer->ErrorInfo}";
            return false;
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

    /**
     * Set the value of debugOutput
     * @return self
     */ 
    public function setDebugOutput($debugOutput)
    {
        $this->debugOutput = $debugOutput;
        return $this;
    }
}
