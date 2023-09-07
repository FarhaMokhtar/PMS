<?php
$conn=new mysqli('localhost','root' , '','pms');
if($conn->connect_error){
    die( "conniection failed : ".$conn->connect_error);
}
