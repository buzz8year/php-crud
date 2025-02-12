<?php

namespace helpers;

class Url
{
        public static function isHttps(): boolean
        {
                $headerHttpsOk = isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
                $headerPortOk = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443;
                
                $headerForwardedOk = isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https';
                $envForwarderOk = getenv('HTTP_X_FORWARDED_PROTO') === 'https';
                
                return $headerHttpsOk || $headerPortOk || $headerForwardedOk || $envForwarderOk;
        }
            
        public static function getBasePath(): string
        {
                $protocol = self::isHttps() : ? 'https://' : 'http://';
            
                $domainName = isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] 
                    ? $_SERVER['HTTP_HOST'] 
                    : 'localhost';
            
                $public = '/public/';
                
                // WARNING: filter_var() returns (bool)false if filter is not validated
                return filter_var($protocol . $domainName . $public, FILTER_VALIDATE_URL);        
        }
        
        public static function getCurrentPath(): mixed
        {
                $basePath = self::getBasePath();
                
                $controllerMethod = '?r=' . rtrim($_GET['r'] ?? DEFAULT_CONTROLLER_NAME, '/');
                
                if (!empty($_GET['id'])) 
                        $controllerMethod .= '&id=' . $_GET['id'];
                
                // WARNING: filter_var() returns (bool)false if filter is not validated
                return filter_var($basePath . $controllerMethod, FILTER_VALIDATE_URL);
        }

}
