# Login with Google APIs Client Library for PHP

Reference Docs
https://developers.google.com/identity/sign-in/web/sign-in

login with google account quickly

## Setup
There are a few setup steps you need to complete before you can use this library:

1.  Go to the [Credentials page](https://console.developers.google.com/).
2.  Click Create credentials > OAuth client ID.
3.  Select the Web application application type.
4.  Name your OAuth 2.0 client and click Create


## install

```php
composer require google/apiclient
```

### place your OAuth key in application\config\config.php

ex.
```php
$config['clientID'] = '98XXXX.....apps.googleusercontent.com';
$config['clientSecret'] = 'GXXXX...B';
```

### open your page

http://localhost:8080/googleLogin/index.php

