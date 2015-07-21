<?php

use app\Antony\DomainLogic\Modules\ShoppingCart\Formatters\MoneyFormatter;
use Illuminate\Database\Eloquent\Model;
use Money\Currency;
use Money\Money;

/**
 * @return mixed
 */
function allowed_ips()
{
    return config('site.backend.allowedIPS');
}

/**
 * @return mixed
 */
function api_login_enabled()
{
    return config('site.account.authentication.OAUTH2.login');
}

/**
 * @return mixed
 */
function api_registration_enabled()
{
    return config('site.account.authentication.OAUTH2.registration');
}

/**
 * @return string
 */
function error_image()
{
    return asset(config('site.static.error'));
}

/**
 * @return string
 */
function default_ajax_image()
{
    return asset(config('site.static.ajax'));
}

/**
 * @return string
 */
function alt_ajax_image()
{
    return asset(config('site.static.ajax2'));
}

/**
 * @return string
 */
function empty_image()
{
    return asset(config('site.static.blank'));
}

/**
 * @return string
 */
function large_ajax_image()
{
    return asset(config('site.static.ajax3'));
}

/**
 * @return string
 */
function default_user_avatar()
{
    return asset(config('site.static.avatar'));
}

/**
 * @return mixed
 */
function max_star_rating()
{
    return config('site.reviews.stars');
}

/**
 * Helper to generate hidden html input field with embedded csrf token
 *
 * @return string
 */
function csrf_html()
{
    return Form::token();
}

if (!function_exists('eq')) {

    /**
     * Checks if two values are equal
     *
     * @param $value1
     * @param $value2
     * @param bool $strict
     *
     * @return bool
     */
    function eq($value1, $value2, $strict = true)
    {

        return $strict ? $value1 === $value2 : $value1 == $value2;
    }
}

if (!function_exists('int_random')) {

    /**
     * generate secure random numbers
     *
     * @param int $min
     * @param int $max
     *
     * @param int $bytes
     *
     * @return int|number
     */
    function int_random($min = 1000, $max = 99999999, $bytes = 4)
    {
        if (function_exists('openssl_random_pseudo_bytes')) {
            $strong = true;
            $n = 0;

            do {
                $n = hexdec(
                    bin2hex(openssl_random_pseudo_bytes($bytes, $strong))
                );
            } while ($n < $min || $n > $max);

            return $n;
        } else {
            return mt_rand($min, $max);
        }
    }
}

/**
 * beautify a name, by capitalizing its first letters and removing spaces
 *
 * @param $name
 *
 * @return string
 */
function beautify($name)
{
    return ucwords(preg_replace("/[^A-Za-z0-9 ]/", '-', $name));
}

/**
 * Allows us to generate an SEO compatible name/url
 *
 * @param $string
 *
 * @return mixed|string
 */
function preetify($string)
{
    return str_slug($string, '-');
}

if (!function_exists('file_exists_on_server')) {

    /**
     * Ok, obviously there exists the 'file_exists' function by default in PHP
     * but this is just a simple wrapper around it
     *
     * @param $file
     *
     * @return bool
     */
    function file_exists_on_server($file)
    {
        if (empty($file)) {
            return false;
        }

        return file_exists(public_path() . $file);
    }
}

if (!function_exists('delete_file')) {

    /**
     * Allows us to delete a file from the public path
     *
     * @param $file
     *
     * @return bool
     */
    function delete_file($file)
    {
        if (empty($file)) {
            return false;
        }

        return File::delete(public_path() . $file);
    }
}

if (!function_exists('display_img')) {

    /**
     * Allows us to display a picture/image of a model. if it has one already
     *
     * @param Model $model
     * @param bool $fromUrl
     * @param string $image
     * @param bool $mustExistOnServer
     * @return string
     */
    function display_img($model, $fromUrl = false, $image = 'image', $mustExistOnServer = true)
    {
        if (is_null($model)) {
            // display from url
            if (file_exists_on_server($fromUrl)) {
                return asset($fromUrl);
            }
            return asset(error_image());
        }
        // if the image is not on our server, then we just skip the checks
        if ($mustExistOnServer) {

            if (file_exists_on_server($model->$image)) {
                return asset($model->$image);
            }
            return asset(error_image());
        }

        if (!is_null(asset($model->$image))) {

            return asset($model->$image);
        }
        return asset(error_image());
    }
}


if (!function_exists('is_serialized')) {

    // http://stackoverflow.com/questions/1369936/check-to-see-if-a-string-is-serialized
    // actually copied directly from the word-press core
    /**
     * @param $data
     *
     * @param bool $strict
     * @return bool
     */
    function is_serialized($data, $strict = true)
    {
        // if it isn't a string, it isn't serialized.
        if (!is_string($data)) {
            return false;
        }
        $data = trim($data);
        if ('N;' == $data) {
            return true;
        }
        if (strlen($data) < 4) {
            return false;
        }
        if (':' !== $data[1]) {
            return false;
        }
        if ($strict) {
            $lastc = substr($data, -1);
            if (';' !== $lastc && '}' !== $lastc) {
                return false;
            }
        } else {
            $semicolon = strpos($data, ';');
            $brace = strpos($data, '}');
            // Either ; or } must exist.
            if (false === $semicolon && false === $brace)
                return false;
            // But neither must be in the first X characters.
            if (false !== $semicolon && $semicolon < 3)
                return false;
            if (false !== $brace && $brace < 4)
                return false;
        }
        $token = $data[0];
        switch ($token) {
            case 's' :
                if ($strict) {
                    if ('"' !== substr($data, -2, 1)) {
                        return false;
                    }
                } elseif (false === strpos($data, '"')) {
                    return false;
                }
            // or else fall through
            case 'a' :
            case 'O' :
                return (bool)preg_match("/^{$token}:[0-9]+:/s", $data);
            case 'b' :
            case 'i' :
            case 'd' :
                $end = $strict ? '$' : '';
                return (bool)preg_match("/^{$token}:[0-9.E-]+;$end/", $data);
        }
        return false;
    }
}

if (!function_exists('h')) {

    /**
     * hash a value by default, using SHA256
     *
     * @param $data
     *
     * @return string
     */
    function h($data)
    {
        return hash('sha256', $data);
    }

}

if (!function_exists('format_money')) {

    /**
     * Formats a money object to price + value. eg Money A becomes KSH 10000
     *
     * @param $money
     *
     * @param bool $returnMoneyObject
     *
     * @return mixed
     */
    function format_money($money, $returnMoneyObject = false)
    {
        if (!$money instanceof Money) {

            $money = new Money(is_int($money) ? $money : (int)$money, new Currency(config('site.currencies.default', 'KES')));
        }

        return $returnMoneyObject ? $money : (new MoneyFormatter())->format($money);

    }
}

/**
 * Generates a url to an auth page e.g login/register
 *
 * @param string $name
 * @param null $returnUrl
 * @param string $title
 * @param bool $displayReturn
 * @param array $options
 * @return string
 */
function link_to_auth_route($name, $returnUrl = null, $title = 'Login', $displayReturn = false, array $options = [])
{
    // no need to encode this url, as laravel already does it for us
    $target = $returnUrl;

    if (!is_null($target)) {

        app('session')->pull('url.intended');

        app('session')->put('url.intended', $target);
    }
    return link_to_route($name, $title, $displayReturn ? ['returnTo' => is_null($target) ? session('url.intended', '/') : $target] : [], $options);
}

/**
 * Generates a secure url to a route
 *
 * @param $name
 * @param array $params
 * @return string
 */
function link_to_secure_route($name, array $params = [])
{

    $url = route($name, $params);

    return secure_url($url);
}