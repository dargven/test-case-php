<?php

use application\modules\Answer;
use application\modules\Application;

header('Content-Type: Application/json; charset = utf-8');
header('Access-Control-Allow-Origin: *');
require 'vendor/autoload.php';
require 'config.php';


function result($params)
{
    $method = $params['method'];
    if ($method) {
        $app = new Application();
        return match ($method) {
            'addOrder' => $app->addOrder($params),
            default => ['error' => 102],
        };
    }
    return ['error' => 101];

}

//
echo json_encode(Answer::response(result($_GET)), JSON_UNESCAPED_UNICODE);