<?php
include 'header.php';
 session_start();
    include_once("db.php");

 // Als je niet ingelogd bent wordt je naar login.php gestuurd.
    //echo $_SESSION['username']; 
    if(!isset($_SESSION['username'])) {
        //true al ingelogd
        header("location:login.php");
            } else{


if(!isset($_GET['pid'])) {
    header("location: login.php");
} else {
    $pid = $_GET['pid'];
        
    // alle comments bijhorend en betrevende artikel wordt verwijderd.
    $sql = "DELETE FROM offers WHERE art_id=$pid";
    mysqli_query($db, $sql);
    $sql = "DELETE FROM articles WHERE id=$pid";
    mysqli_query($db, $sql);
    header ("location: index.php");
}
}

?>