HaPi – Harvest API
==================

Fork of `gridonic/hapi` PHP Wrapper Library for the Harvest API. Adds the use of oAuth Tokens.

Caution - Deprecation Coming - January 1st, 2019
-----
Please be aware, this implementation appears to be version 1 of Harvest's API. Harvest has deprecated it.
We will have to update it to version 2 in the near future.
API documentation is avaible for
[Version 1](https://help.getharvest.com/api-v1/) and
[Version 2](https://help.getharvest.com/api-v2/).


Installation
-----

`composer require cogitools/hapi`

This package includes `tightenco\collect` a standalone version of `Illuminate\Support\Collection` used in Laravel.

### Configuration

You can either configure this as a Laravel service or as a standalone library:

#### Laravel service

Add this to the array in `config/services.php`:
```
'harvest' => [
    'client_id' => env('HARVEST_CLIENT_ID'),
    'client_secret' => env('HARVEST_SECRET'),
    'redirect' => env('HARVEST_CALLBACK'),
],
```

Then in your `.env` file add the following: (Obviously with the appropriate tokens)
```
HARVEST_CLIENT_ID=
HARVEST_SECRET=
HARVEST_CALLBACK=
```

#### Standalone library

Simply store the CLIENT_ID and CLIENT_SECRET somewhere safe (you'll probably have some sort of
config or env file in your app, right?), and add them like this:

```php
$harvest = (new Harvest\HarvestAPI)
	->setClientId(HARVEST_CLIENT_ID)
	->setClientSecret(HARVEST_CLIENT_SECRET)
	->setAccount(HARVEST_ACCOUNT);
```

Usage
-----

### Example OAuth2 authentication
TODO. Redirect your user to `$harvest->getAuthorizeUrl()` and store the final token from 
`$harvest->accessToken($code)` somewhere safe. It will be used for all other calls.

### Example Controller Use
```
$token = App\ServiceToken::find(6);
    
$users = (new Harvest\HarvestAPI)
    ->setToken($token->token)
    ->getUsers();

if ($users->isSuccess()) {
    dd($users->data());
} else {
    $newToken = (new Harvest\HarvestAPI)
        ->refreshToken($token->refresh_token)
        ->data();

    $token->token = $newToken->access_token;
    $token->refresh_token = $newToken->refresh_token;
    $token->save();
}
```




New Way (using access_token provided by oAuth2):

```php
<?php
require __DIR__ . '/vendor/autoload.php';

$users = (new Harvest\HarvestAPI)
    ->setToken($token)
    ->getActiveUsers();
```

> Also, in this fork, the data return type is set to `json`, this can be changed by using the following:

```
$harvest = (new Harvest\HarvestAPI)->setReturnDataType('xml');
```
OR:
```
$harvest = (new Harvest\HarvestAPI)->setReturnDataType('json');
```

As of now, it is nothing fancy, so pretty much if you don't set anything, `json` is returned, if you set the return type to anything other than `json`, `xml` will be returned. Basically, some `ifs` are used to verify that the data type is still `json` if it is any other string, `xml` will be returned.

Old way (using password):
```php
<?php
require __DIR__ . '/vendor/autoload.php';

$api = new Harvest\HarvestApi();
$api->setUser('your@email.com');
$api->setPassword('password');
$api->setAccount('account');

$result = $api->getClient(12345);
```

Run tests
---------

Tests include some live API calls by default. For this to work, you will have to create a local copy of
```harvest_api_config.json``` by copying the provided ```harvest_api_config.json.dist``` and providing your own
Harvest account credentials.

In order to exclude the tests that require a valid Harvest account and internet connection, invoke the test runner
as follows:

    phpunit --exclude-group=internet

License
-------

Hapi is licensed under the GPL-3 License - see the `LICENSE` file for details

Acknowledgements
----------------

This version of the library is a rewrite that uses composer and proper PSR-0 standard
for autoloading. The original version of the library was written by Matthew John Denton
and can be downloaded from http://labs.mdbitz.com/harvest-api

Submitting bugs and feature requests
------------------------------------

Since this is a rewrite, it is very well possible that some parts of the library
do not work yet or anymore. Bugs and feature request are tracked on [GitHub](https://github.com/cogitools/hapi/issues)
