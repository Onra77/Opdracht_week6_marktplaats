<?php
include 'header.php';
 session_start();
    include_once("db.php");

if(!isset($_GET['pid'])) {
    header("location: login.php");
} else {
    $pid = $_GET['pid'];
    $sql = "DELETE FROM articles WHERE id=$pid";
    mysqli_query($db, $sql);
    // alle comments bijhorend bovenstaande post wordt ook verwijderd.
    $sql = "DELETE FROM offers WHERE art_id=$pid";
    mysqli_query($db, $sql);
    header ("location: index.php");
}

?>