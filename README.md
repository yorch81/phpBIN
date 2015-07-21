# phpBIN #

## Description ##
PHP Library for validate BIN/IIN Numbers Cards

## Requirements ##
* [PHP 5.4.1 or higher](http://www.php.net/)
* [BINList](http://www.binlist.net/)
* [Medoo](http://medoo.in/)
* [MySQL](https://www.mysql.com/)
* [MongoDb](https://www.mongodb.com/)

## Developer Documentation ##
Execute phpdoc -d phpBIN/

## Unit Test ##
For run Unit Test, complete information connection and execute the next commands:
> phpunit PhpBINTest.php
> phpunit PhpBINTestMy.php
> phpunit PhpBINTestMon.php

## Installation ##
Create file composer.json
~~~

{
    "require": {
    	"php": ">=5.4.0",
        "yorch/phpbin" : "dev-master",
        "catfan/medoo": "dev-master"
    }
}

~~~

Execute composer.phar install

## Example ##
~~~

$mybin = PhpBIN::getInstance('BinList');

var_dump($mybin->getInfo("111904"));

~~~

## Notes ##
This library uses http://www.binlist.net/ with this limits.

Limits

Due to the high volume of queries we've implemented a throttling mechanism, which allows at most 10,000 queries per hour. After reaching this hourly quota, all your requests result in HTTP 403 (Forbidden) until it clears up on the next roll over.

For local Database implementation must configure with the connect method. 

Check MySQL import script binbase.sql.

For import binbase to MongoDb check mongo.script and execute commands.

## References ##
http://www.binlist.net/

P.D. Let's go play !!!




