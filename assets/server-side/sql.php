<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/sql-credentials.php';

if($_SERVER['HTTP_ORIGIN']) {
    header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
}

function getPost($name, $default = NULL) {
    if(isset($_POST[$name])) {
        return $_POST[$name];
    }
    else {
        return $default;
    }
}

$sql = getPost('query');

if( !$sql ) {
    errorResponse("No query sent", "Pohodný náhled do databáze přes Adminer: https://sql.jandolejs.cz/adminer");
}

$database = SqlCredentials::getConnection();

try {
    $query = $database->query($sql);
    $rowsCount = $query->getRowCount();
    $insertedId = $database->getInsertId();

    $data = [];
    try{
        while(($row = $query->fetch()) !== FALSE) {
            $data[] = iterator_to_array($row);
        }
    }
    catch(\PDOException $e) {
        if($e->getCode() == 'HY000') { // CRUD queries has not fetch ability
            $data = FALSE;
        }
        else throw $e;
    }

    successResponse([
        'results' => $data,
        'rows' => $rowsCount,
        'insertedId' => $insertedId,
    ]);
}
catch(\PDOException $e) {
    errorResponse("Chybný SQL: " . $e->getMessage() . " (code: " . $e->getCode() . ")");
}
catch(\Exception $e) {
    errorResponse("Neznámá chyba: " . $e->getMessage() . " (code: " . $e->getCode() . ")");
}

function successResponse($data) {
    $response = [
        'status' => TRUE,
        'data' => $data,
    ];
    sendResponse($response);
    die();
}

function errorResponse($message, $tip = null) {
    $response = [
        'status' => FALSE,
        'error' => $message,
    ];
    if($tip) {
        $response['tip'] = $tip;
    }
    sendResponse($response);
    die();
}

function sendResponse($response) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}