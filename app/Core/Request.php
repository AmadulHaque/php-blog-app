<?php

namespace App\Core;

class Request 
{
    protected array $query = [];
    protected array $request = [];
    protected array $files = [];
    protected array $server = [];
    protected array $cookies = [];
    protected array $headers = [];

    public static function capture()
    {
        $request = new self();
        $request->initialize();

        return $request;
    }

    protected function initialize()
    {
        $this->query = $_GET;
        $this->request = $_POST;
        $this->files = $_FILES;
        $this->server = $_SERVER;
        $this->cookies = $_COOKIE;
        $this->headers = getallheaders();
    }

    public function method()
    {
        return $this->server['REQUEST_METHOD'];
    }

    public function uri()
    {
        return parse_url($this->server['REQUEST_URI'], PHP_URL_PATH);
    }

    public function input($key = null, $default = null)
    {
        return $key ? ($this->request[$key] ?? $default) : $this->request;
    }

    public function query($key = null, $default = null)
    {
        return $key ? ($this->query[$key] ?? $default) : $this->query;
    }

    public function file($key)
    {
        return $this->files[$key] ?? null;
    }

    public function header($key = null)
    {
        return $key ? ($this->headers[$key] ?? null) : $this->headers;
    }

    public function cookie($key = null)
    {
        return $key ? ($this->cookies[$key] ?? null) : $this->cookies;
    }

    public function server($key = null)
    {
        return $key ? ($this->server[$key] ?? null) : $this->server;
    }

    public function getMethod()
    {
        return $this->server('REQUEST_METHOD');
    }

    
    public function getPathInfo()
    {
        $requestUri = $this->server('REQUEST_URI');
        $scriptName = $this->server('SCRIPT_NAME');

        if (strpos($requestUri, $scriptName) === 0) {
            $pathInfo = substr($requestUri, strlen($scriptName));
        } else {
            $phpSelf = $this->server('PHP_SELF');
            if (strpos($requestUri, $phpSelf) === 0) {
                $pathInfo = substr($requestUri, strlen($phpSelf));
            } else {
                $origScriptName = $this->server('ORIG_SCRIPT_NAME');
                if (strpos($requestUri, $origScriptName) === 0) {
                    $pathInfo = substr($requestUri, strlen($origScriptName));
                } else {
                    // If none of the above match, fallback to REQUEST_URI
                    $pathInfo = $requestUri;
                }
            }
        }

        // Remove query string from path info
        if (($pos = strpos($pathInfo, '?')) !== false) {
            $pathInfo = substr($pathInfo, 0, $pos);
        }

        return $pathInfo;
    }

    public function all()
    {
        return [
            'query' => $this->query(),
            'request' => $this->input(),
            'files' => $this->files,
            'cookies' => $this->cookies,
            'headers' => $this->headers,
            'server' => $this->server,
        ];
    }
}
