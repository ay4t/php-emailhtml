# php-mailer-template

# Installation
```
composer require ay4t/php-mailer-template
```

# Example Usage
berikut ini contoh penggunaan dasar

```
/** new email registration */
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
$email->send();
```

contoh penggunaan dengan menerapkan template untuk email registrasi

```
/** new email registration */
$email  = new \Ay4t\Emailhtml\Mailer( $filename = 'account_welcome');
$email->mergeData([
    'fullname'          => 'your_fullname',
    'dashboard_url'     => 'https://localhost/dashboard',
    'username'          => 'aahadr',
    'password'          => '123123',
]);

$email->setAltBody('');
$email->setSubject('Subject Email');
$email->sendTo('email_to', 'your_fullname');
$email->send();
```
