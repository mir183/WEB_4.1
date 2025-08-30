<?php

include '../connect.php';

$id=$_GET['id'];

$stmt=$connect->prepare("DELETE FROM info WHERE id = ?");
$stmt->bind_param("i", $id);

if($stmt->execute()){
    header("Location: create.php");
    exit();
}else{
    echo "Error: ".$stmt->error;
}

$stmt->close();
$connect->close();

?>
