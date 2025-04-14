<?php 
$serverName="localhost";
$userName="root";
$password="";
$dataBaseName="mini-project";
$cn = mysqli_connect($serverName,$userName,$password,$dataBaseName);
if($cn){
    /*echo "connected";*/
}else{
    die("connexion faild : ".mysqli_connect_error());
}
?>