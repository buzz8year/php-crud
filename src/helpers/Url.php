<?php

namespace helpers;


class Url
{
    // EXPLAIN: ...
	public static function getQuery() : ?string
	{	
        $exp = explode('/', $_SERVER['REQUEST_URI']);
		return ltrim(end($exp), '?');
	}


    // EXPLAIN: ...
    public static function getBasePath()
    {
        // EXPLAIN: ...
        $https =
            (
                (isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
                || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)
                || (getenv('HTTP_X_FORWARDED_PROTO') === 'https')
                || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
            );

        $protocol = $https ? 'https://' : 'http://';
        
        // EXPLAIN: ...
        $domainName = isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] ? $_SERVER['HTTP_HOST'] : 'localhost';

        // EXPLAIN: ...
        $public = '/public/';

        // WARNING: filter_var() returns (bool)false if filter is not validated, - rethink...
        return filter_var($protocol . $domainName . $public, FILTER_VALIDATE_URL);        
    }




    // EXPLAIN: ...
    public static function getCurrentPath()
    {
        // EXPLAIN: ...
        $basePath = self::getBasePath();

        // EXPLAIN: ...
        $controllerMethod = '?r=' . rtrim($_GET['r'] ?? DEFAULT_CONTROLLER_NAME, '/');

        // EXPLAIN: ...
        if (!empty($_GET['id'])) 
        {
            $controllerMethod .= '&id=' . $_GET['id'];
        }

        // WARNING: filter_var() returns (bool)false if filter is not validated, - rethink...
        return filter_var($basePath . $controllerMethod, FILTER_VALIDATE_URL);
    }

}