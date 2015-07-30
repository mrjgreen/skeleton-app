<?php namespace Application;

/**
 * @param $input
 * @return string
 */
function base64_url_encode($input)
{
    return urlencode(strtr(base64_encode($input), '/=', '-_'));
}

/**
 * @param $input
 * @return string
 */
function base64_url_decode($input)
{
    return base64_decode(strtr(urldecode($input), '-_', '/='));
}