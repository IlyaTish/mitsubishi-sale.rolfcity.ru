<?php

if (!function_exists('array_get')) {

    /**
     * Get value from array with dot notation
     *
     * @param $array
     * @param $key
     * @param null $default
     * @param string $delimiter
     * @return mixed
     */
    function array_get($array, $key, $default = null, $delimiter = '.') {

        if (!is_string($key) || empty($key) || !count($array)) {
            return $default;
        }

        $keys = explode($delimiter, $key);
        foreach ($keys as $innerKey) {

            if (!array_key_exists($innerKey, $array)) {
                return $default;
            }

            $array = $array[$innerKey];
        }

        return $array;
    }
}

if (!function_exists('dd')) {
    /**
     * Dump the passed variables
     *
     * @param  mixed
     * @return void
     */
    function dd()
    {
        array_map(
            function ($x) {
                (new \Symfony\Component\VarDumper\VarDumper())->dump($x);
            },
            func_get_args()
        );
        die();
    }
}


if (!function_exists('env')) {
    /**
     * Gets the value of an environment variable
     *
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    function env($key, $default = null)
    {
        $value = getenv($key);
        if ($value === false) {
            return $default;
        }
        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return null;
        }
        $strLen = strlen($value);
        if ($strLen > 1 && $value[0] === '"' && $value[$strLen - 1] === '"') {
            return substr($value, 1, -1);
        }

        if(is_json($value)) {
            return json_decode($value, true);
        }
        return $value;
    }
}

if (!function_exists('base_path')) {
    /**
     * Get the path to the base folder
     *
     * @return string
     */
    function base_path()
    {
        return dirname(__DIR__);
    }
}

if (!function_exists('storage_path')) {
    /**
     * Get the path to the storage folder
     *
     * @return string
     */
    function storage_path()
    {
        return base_path() . '/storage';
    }
}

if (!function_exists('is_json')) {

    /**
     * Check string is valid json
     *
     * @param $string
     * @return bool
     */
    function is_json($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}


if (!function_exists('ip')) {

    /**
     * Get ip
     *
     * @return string|null
     */
    function ip() {
        foreach (['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR'] as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
        return null;
    }
}

if (!function_exists('url_parse')) {

    /**
     * Get url with path
     *
     * @param string $url
     * @param int $comp ( #7 = (binary) 111 = [schema, host, path])
     * @return string|null
     */
    function url_parse($url, $comp = 7) {
        $parseUrl = parse_url($url);

        if($comp & (1 << 2)) {
            $schema = array_get($parseUrl, 'scheme', '');
            $schema = $schema ? $schema . '://' : '';
        } else {
            $schema = '';
        }

        $host = $comp & (1 << 1) ?
            array_get($parseUrl, 'host', '') : '';

        if($comp & (1 << 0)) {
            $path = array_get($parseUrl, 'path', '');
            $path = $path != '/' ? $path : '';
        } else {
            $path = '';
        }
        return $parseUrl !== false ? $schema . $host . $path : '';
    }
}