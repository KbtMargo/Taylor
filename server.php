<?php
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$public = __DIR__ . '/public';

if ($uri !== '/' && file_exists($public . $uri)) {
    return false; // віддати статичний файл як є (css/js/img/ico)
}

require $public . '/index.php'; // все інше — через Laravel
