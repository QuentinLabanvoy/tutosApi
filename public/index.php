<?php

require('../src/init.php');

use tutoAPI\Controllers\tutoController;

// Evaluation de la requête
$length = strlen(BASE_PATH) + 1;
$uri = substr($_SERVER['REQUEST_URI'], $length);
$method = $_SERVER['REQUEST_METHOD'];

switch (true) {

    case preg_match('#^tutos/(\d+)$#', $uri, $matches) && $method == 'GET':

        $id = $matches[1];

        $controller = new tutoController();

        return $controller->show($id);

        break;

    case preg_match('#^tutos((\?)|$)#', $uri) && $method == 'GET':

        $controller = new tutoController();

        return $controller->index();

        break;
    case preg_match('#^tutos/((\?)|$)#', $uri) && $method == 'POST':

        $controller = new tutoController();

        return $controller->add();

        break;
    case preg_match('#^tutos/(\d+)$#', $uri, $matches) && $method == 'PATCH':
        $id = $matches[1];
        $controller = new tutoController();

        return $controller->patch($id);

        break;
    case preg_match('#^tutos/(\d+)$#', $uri, $matches) && $method == 'DELETE':
        $id = $matches[1];
        $controller = new tutoController();

        return $controller->deletes($id);

        break;


    default:

        http_response_code(404);

        echo json_encode('erreur 404');
}
