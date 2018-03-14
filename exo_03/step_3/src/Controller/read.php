<?php 
//Create a page which lists the movies in the database in an HTML table. This table will
//contain, per film, only the name of the film, the director, and the year of production..
//One column of this table will contain a "see more info" link to see the detailed
//information sheet of a film.

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

$id = null;
if ( !empty($_GET['id'])) {
    $id = $_GET['id'] ?? null;
    $id = intval($id);
}
if ( null==$id ) {
    header("Location: /index.php");
}else {
    $sql = 'SELECT * FROM movies WHERE id = ?';
    $statement = $connection->prepare($sql);
    $statement->execute(array($id));
    $resultall = $statement->fetchall();
    foreach ($resultall as $row){
        $movieid=$row['title'];
        $moviename=$row['director'];
        $movieyear=$row['year_of_prod'];

    }



?>