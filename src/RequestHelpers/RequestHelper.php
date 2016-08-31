<?php

namespace Auburus\FormValidation\RequestHelpers;

use Psr\Http\Message\RequestInterface;
use FormValidation\RequestHelpers\RequestHelperInterface;

/**
 * Since there is no way to know what kind of request object
 * will be (Symfony, Laravel, custom-made, ...), I've made
 * this request helper that just provides some methods for
 * obtaining the parameters.
 */
class RequestHelper implements RequestHelperInterface
{
    protected $request;

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    public function getQueryParams()
    {
        $query = $this->getUri()->getQuery();
    }

    public function getBodyParams()
    {
    }

    public function getAllParams()
    {
    }

    protected function parseQuery($str, $urlEncoding = true)
    {
        $result = [];
        if ($str === '') {
            return $result;
        }
        if ($urlEncoding === true) {
            $decoder = function ($value) {
                return rawurldecode(str_replace('+', ' ', $value));
            };
        } elseif ($urlEncoding == PHP_QUERY_RFC3986) {
            $decoder = 'rawurldecode';
        } elseif ($urlEncoding == PHP_QUERY_RFC1738) {
            $decoder = 'urldecode';
        } else {
            $decoder = function ($str) { return $str; };
        }

        foreach (explode('&', $str) as $kvp) {
            $parts = explode('=', $kvp, 2);
            $key = $decoder($parts[0]);
            $value = isset($parts[1]) ? $decoder($parts[1]) : null;
            if (!isset($result[$key])) {
                $result[$key] = $value;
            } else {
                if (!is_array($result[$key])) {
                    $result[$key] = [$result[$key]];
                }
                $result[$key][] = $value;
            }
        }
        return $result;
    }
}
