<?php
public function processRequest(){
    $request_method = $_SERVER["REQUEST_METHOD"];
    switch($request_method){
        case 'POST':
            $this->handlePost();
            break;
        case 'GET':
            $this->handleGet();
            break;
        default:
            $this->respond(500);
            break;
    }
}

public function handlePost(){
    $data = json_decode(file_get_contents("php://input"), true);
    $this->respond(200, $this->dataHandler->handleData($data));
}

public function handleGet(){
    $this->respond(200, $this->dataHandler->getData());
}

public function respond($status, $data = NULL){
    header("HTTP/1.1 " . $status . " " . $this->requestStatus($status));
    header("Content-Type: application/json;charset=utf-8");
    if($data){
        echo json_encode($data);
    }
}

?>