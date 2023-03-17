<?php
/*
* File: App.php
* Project: Config
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

namespace Ay4t\Emailhtml\Config;

class App 
{
    //Set Base URL for domain. Jika Anda menjalankan pada Framework Codeigniter maka abaikan property ini
    public $baseURL     = '';

    //Set the SMTP server to send through
    public $Host       = 'smtp.example.com';

    //SMTP username
    public $Username   = 'user@example.com';

    //SMTP password
    public $Password   = 'your_SNTP_password';

    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    public $Port        = 465;

    public $FromName    = 'Indiega Network';
    public $FromEmail   = 'ayatulloh@indiega.net';
}

