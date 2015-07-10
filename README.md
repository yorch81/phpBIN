# phpBIN #

## Description ##
PHP Library for validate BIN/IIN Numbers Cards

## Requirements ##
* [PHP 5.4.1 or higher](http://www.php.net/)
* [BINList](http://www.binlist.net/)

## Developer Documentation ##
Execute phpdoc -d phpBIN/

## Installation ##
Create file composer.json

{
    "require": {
        "yorch/phpbin": "dev-master"
    }
}

Execute composer.phar install

## Example ##
~~~
// PhpBIN
$bin = new PhpBIN('binlist');

~~~

## Notes ##
This library uses http://www.binlist.net/ with this limits.

Limits

Due to the high volume of queries we've implemented a throttling mechanism, which allows at most 10,000 queries per hour. After reaching this hourly quota, all your requests result in HTTP 403 (Forbidden) until it clears up on the next roll over.

## References ##
http://www.binlist.net/

P.D. Let's go play !!!




