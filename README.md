# php-mailer-template

# Installation
```
composer config minimum-stability dev
composer config repositories.Emailhtml vcs git@github.com:ay4t/php-emailhtml.git
composer require ay4t/php-emailhtml:main-dev
```

# Example Usage

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