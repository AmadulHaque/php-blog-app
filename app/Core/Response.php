<?php

namespace App\Core;

class Response
{
    protected $content;
    protected $status = 200;
    protected $headers = [];

    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    public function setStatusCode($status)
    {
        $this->status = $status;
        return $this;
    }

    public function header($key, $value)
    {
        $this->headers[$key] = $value;
        return $this;
    }

    public function send()
    {
        http_response_code($this->status);

        foreach ($this->headers as $key => $value) {
            header("$key: $value");
        }

        echo $this->content;
    }

    public static function notFound()
    {
        (new self())->setStatusCode(404)->setContent('404 Page Not Found')->send();
    }
}
