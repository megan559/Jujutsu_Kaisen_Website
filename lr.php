<?php

$conn = new mysqli(
    "localhost",
    "root",
    "User",
    "web"

);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"),true);
    if($data['type']==="register"){
        $username=$data['uname'];
        $password=$data['password'];
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);
        if ($stmt->execute()) {
            echo json_encode(["status"=>"success"]);
        } else {
            echo json_encode(["status"=>"failure"]);
	
        }
        $stmt->close();
    }
    elseif($data['type']==="login"){
        $username=$data['uname'];
        $password=$data['password'];
        $stmt = $conn->prepare("select * from users where username=? and password=?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            echo json_encode([
                "status" => "success"
            
            ]);
        } else {
            echo json_encode([
                "status" => "not_found"
            ]);
        }
        
        $stmt->close();
    }

}

?>

