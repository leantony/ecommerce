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
 * Actually i wasn't aware of the Form::token() function in the form builder
 *
 * @return string
 */
function csrf_html()
{
    $csrf = csrf_token();

    return "<input type=\"hidden\" name=\"_token\" value=$csrf >";
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
    // actually copied from word-press
    /**
     * @param $data
     *
     * @return bool
     */
    function is_serialized($data)
    {
        // if it isn't a string, it isn't serialized
        if (!is_string($data))
            return false;
        $data = trim($data);
        if ('N;' == $data)
            return true;
        if (!preg_match('/^([adObis]):/', $data, $badions))
            return false;
        switch ($badions[1]) {
            case 'a' :
            case 'O' :
            case 's' :
                if (preg_match("/^{$badions[1]}:[0-9]+:.*[;}]\$/s", $data))
                    return true;
                break;
            case 'b' :
            case 'i' :
            case 'd' :
                if (preg_match("/^{$badions[1]}:[0-9.E-]+;\$/", $data))
                    return true;
                break;
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

            $money = new Money((int)$money, new Currency(config('site.currencies.default', 'KES')));
        }
        if ($returnMoneyObject) {
            return $money;
        }
        $formatter = new MoneyFormatter();

        return $formatter->format($money);
    }
}

/**
 * Generates a url to an auth page e.g login/register
 *
 * @param string $name
 * @param null $returnUrl
 * @param string $title
 * @param array $options
 * @return string
 */
function link_to_auth_route($name, $returnUrl = null, $title = 'Login', array $options = [])
{
    // no need to encode this url, as laravel already does it for us
    $target = $returnUrl;

    if (!is_null($target)) {
        Session::pull('url.intended');

        Session::put('url.intended', $target);
    }
    return link_to_route($name, $title, ['returnTo' => is_null($target) ? session('url.intended', '/') : $target], $options);
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