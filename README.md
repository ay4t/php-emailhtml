# php-mailer-template

# Example Usage

```/** new email registration */
    $email  = new \Ay4t\PHPMailerTemplate\Commands\Welcome();
    $email->mergeData([
        'fullname'          => 'your_fullname',
        'dashboard_url'     => 'https://localhost/dashboard',
        'username'          => 'aahadr',
        'password'          => '123123',
    ]);

    $email->setAltBody('');
    $email->setSubject('Subject Email');
    $email->sendTo('email_to', 'your_fullname');
    $email->send();```