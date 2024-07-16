<?php


if (!function_exists('view')) {
    function view(string $view, array $data = [])
    {
        extract($data);
        require __DIR__ . "/../../views/{$view}.php";    
    }
}

if (!function_exists('redirect')) {
    function redirect($url, $data = []) {
        if (!empty($data)) {
            session_start();
            foreach ($data as $key => $value) {
                $_SESSION[$key] = $value;
            }
            session_write_close();
        }

        if (!headers_sent()) {
            header("Location: $url");
        } else {
            echo "<script>window.location.href='$url';</script>";
        }
        exit();
    }
}



function escape($string) {
    return htmlentities($string, ENT_QUOTES, 'UTF-8');
}


if (!function_exists('dd')) {
    function dd() 
    {
        echo '<pre>';
        array_map(function($x) {var_dump($x);}, func_get_args());
        die;
    }
}

if (!function_exists('response')) {
    function response($newcode = null){
        static $code = 200;
        if($newcode !== NULL)
        {
            header('X-PHP-Response-Code: '.$newcode, true, $newcode);
            if(!headers_sent())
                $code = $newcode;
        }       
        return $code;
    }
}

if (!function_exists('base_path')) {
    /**
     * Get the base path of the application.
     *
     * @param  string  $path
     * @return string
     */
    function base_path($path = '')
    {
        return __DIR__ . '/../../' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}




if (!function_exists('abrot')) {
    function abrot(string $view)
    {
    
        require __DIR__ . "/../../views/errors/{$view}.php";    
       
    }
}
