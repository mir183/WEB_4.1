<?php

$connect=new mysqli("localhost","root","","perfume");


if($connect->connect_error){
    die("Connection failed: " . $connect->connect_error);
}


?>