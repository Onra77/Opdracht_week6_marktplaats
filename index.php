<?php include 'header.php';?>
<?php include 'user.php';?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>R&M Marktplaats</title>
    <form action="index.php" method="POST" id=search>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <input type="text" name="zoekbalk" placeholder="zoeken"><br/>
    <input name="zoek" type="submit" value="zoeken">
    <input type="button" value="Ik" onclick="location.href='personal.php';">
</form>
</head>
<body> 

<div id=zoekresultaat>
    <?php
    require_once("nbbc.php");
    $bbcode = new BBCode;
    include 'profile.php';
    ?>
    
</div>

<div id=blog>
<?php 
$zoekbalk ='';

if($$zoekbalk = '') {

if(isset($_POST['zoek'])){
    $zoekbalk = $_POST['zoekbalk'];
    $con=mysqli_connect("localhost","root","","marktplaats");
    $sql = "SELECT * FROM articles WHERE author LIKE '%$zoekbalk%' OR title LIKE '%$zoekbalk%'";
    $query=mysqli_query($con, $sql);
    $rowcount=mysqli_num_rows($query);
    echo "Resultaat: ";
    echo $rowcount;
    if($rowcount ==0){
     //   echo "<h3>Geen resultaat!</h3>";
    } else {
        while($row=mysqli_fetch_assoc($query)) {
            $id = $row['id'];
            $author = $row['author'];
            $title = $row['title'];
            $post = "<br/><br/><b>Author:</b>&nbsp$author&nbsp&nbsp<b>van:</b>&nbsp<a href='index.php?pid=$id'/>$title</a>";
            echo $post;
        } 
    }
} 
    
} else {

if(!isset($_GET['pid'])) {
    include 'article.php';
    } else {
        $pid=$_GET['pid'];
        //sql output on pid value.

        $sql = "SELECT *, DATE_FORMAT(date, '%D %M %Y om %H:%i') as date_formatted FROM articles WHERE id='$pid' ORDER BY date DESC";  
        $con=mysqli_connect("localhost","root","","marktplaats");
        $query=mysqli_query($con, $sql); 
        while($row = mysqli_fetch_assoc($query)) {
            $id = $row['id'];
            $title = $row['title'];
            $content = $row['content'];
            $author = $row['author'];
            $cats = $row['cat_id'];
            $date = $row['date_formatted'];
            $admin = "<div><a href='del_post.php?pid=$id'>Verwijder</a>&nbsp;of&nbsp<a href='edit_post.php?pid=$id'>Wijzig</a>&nbspartikel</div>";
            $output = $bbcode->Parse($content);
            if ($author==$username) {
                $post = "<div><a href='index.php?pid=$id'/><b>$title</a></b><p><b>Wie:</b>&nbsp$author&nbsp<b>Categorie:</b>&nbsp$cats&nbsp<b>op:&nbsp</b>$date&nbsp<p><b>Omschrijving:</b><p>$output<p>$admin</div>";
                echo $post;
            } else {
                $post = "<div><a href='index.php?pid=$id'/><b>$title</a></b><p><b>Wie:</b>&nbsp$author&nbsp<b>Categorie:</b>&nbsp$cats&nbsp<b>op:&nbsp</b>$date&nbsp<p><b>Omschrijving:</b><p>$output<p></div>";
            echo $post;
            }
            
            
            
            
            
          
            // Geeft alleen mogelijkheid to wijzigen en verwijderen als je ingelogd bent.   
            if(!isset($_SESSION['username'])) {
            //true al ingelogd
                     
            } else {
                    include 'comments.php';
            }
        }
    }
}
?>
</div>
</body>
<?php include 'footer.php';?>
</html>