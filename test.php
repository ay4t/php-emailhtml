<?php
/*
 * File: test.php
 * Project: php-emailhtml
 * Created Date: Fr Mar 2023
 * Author: Ayatulloh Ahad R
 * Email: ayatulloh@indiega.net
 * Phone: 085791555506
 * -------------------------
 * Last Modified: Fri Mar 17 2023
 * Modified By: Ayatulloh Ahad R
 * -------------------------
 * Copyright (c) 2023 Indiega Network 

 * -------------------------
 * HISTORY:
 * Date      	By	Comments 

 * ----------	---	---------------------------------------------------------
 */

 //display all php error
 ini_set('display_errors', 1);
 ini_set('display_startup_errors', 1);
 error_reporting(E_ALL);

require_once 'vendor/autoload.php';

$email  = new \Ay4t\Emailhtml\Mailer();
$email->mergeData([
    'fullname'          => 'your_fullname',
    'dashboard_url'     => 'https://localhost/dashboard',
    'username'          => 'aahadr',
    'password'          => '123123',
]);

$email->setAltBody('');
$email->setSubject('Subject Email');
$email->sendTo('email_to', 'your_fullname');
// $email->send();

$email->render();