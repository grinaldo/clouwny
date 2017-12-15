<?php
if (!function_exists('backendRouteName')) {

    /**
     * Generate backendcms route name
     *
     * @param string $name
     * @return string
     */
    function backendRouteName($name)
    {
        return \Config::get('backend.prefix_url') . '.' . $name;
    }
}

if (!function_exists('backendRoute')) {

    /**
     * Generate a Backendcms backend URL to a named route.
     *
     * @param  string  $route
     * @param  array   $parameters
     * @return string
     */
    function backendRoute($route, $parameters = array())
    {
        return route(backendRouteName($route), $parameters);
    }
}

if (!function_exists('backendLoginUrl')) {

    /**
     * Get login_url configuration value
     *
     * @return string
     */
    function backendLoginUrl()
    {
        return \Config::get('backend.login_url');
    }
}

if (!function_exists('backendLogoutUrl')) {

    /**
     * Get login_url configuration value
     *
     * @return string
     */
    function backendLogoutUrl()
    {
        return \Config::get('backend.logout_url');
    }
}

if (!function_exists('backendPath')) {

    /**
     * Generate Backendcms backend path (without hostname)
     *
     * @param string $path
     * @return string
     */
    function backendPath($path = null)
    {
        return \Config::get('backend.prefix_url') . '/' . $path;
    }
}

if (!function_exists('backendUrl')) {

    /**
     * Generate a backendcms backend url for the application.
     *
     * @param  string  $path
     * @param  mixed   $parameters
     * @param  bool    $secure
     * @return string
     */
    function backendUrl($path = null, $parameters = array(), $secure = null)
    {
        return url(backendPath($path), $parameters, $secure);
    }
}

if (!function_exists('backendViewName')) {

    /**
     * Generate a backendcms view
     *
     * @param string $name
     * @return string
     */
    function backendViewName($name)
    {
        return 'admin.' . $name;
    }
}

if (!function_exists('backendTrans')) {

    /**
     * Translate the given message.
     *
     * @param  string  $id
     * @param  array   $parameters
     * @param  string  $domain
     * @param  string  $locale
     * @return string
     */
    function backendTrans($id, $parameters = array(), $domain = 'messages', $locale = null)
    {
        return trans('backend.' . $id, $parameters, $domain, $locale);
    }
}

if (!function_exists('backendLangs')) {
    function backendLangs()
    {
        return \Config::get('backend.lang');
    }
}

if (!function_exists('isAcceptLang')) {
    function isAcceptLang($lang)
    {
        return in_array($lang, array_keys(backendLangs()));
    }
}

if (!function_exists('addStringToArrayValue')) {
    function addStringToArray($key, $value, &$array, $check = false)
    {
        if (is_null($value)) {
            return null;
        }

        if ($check && isset($array[$key])) {
            return $array[$key];
        }

        $array[$key] = $value . (empty($array[$key])?'':' '.$array[$key]);
        return$array[$key];
    }
}

if (!function_exists('uploadRelativePath')) {
    function uploadRelativePath($path = '')
    {
        $path = trim($path, DIRECTORY_SEPARATOR);
        return 'files' . ($path?DIRECTORY_SEPARATOR.$path:$path);
    }
}

if ( ! function_exists('stringJson')) {
    function stringJson($string) {
        return addcslashes(str_limit($string, 200), "\n\r\t\\");
    }
}
