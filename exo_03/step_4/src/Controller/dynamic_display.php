<?php
//Create a page that dynamically displays a movie detail. If the film does not exist, an
//error will be displayed.

require_once __DIR__.'/../../vendor/autoload.php';

$configs = require __DIR__. '/../../config/app.conf.php';

Service\DBConnector::setConfig($configs['db']);

try{
    $connection = Service\DBConnector::getConnection();
} catch (\PDOException $exception) {
    http_response_code(500);
    echo 'Impossible to connect to the DB, contact the support';
    exit(10);
}




?>