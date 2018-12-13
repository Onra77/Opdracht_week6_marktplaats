<?php include 'header.php';?>
<?php include 'user.php';?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Personal Page R&M Marktplaats</title>
    <form action="personal.php" method="POST" id=search>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <input type="text" name="zoekbalk" placeholder="zoeken"><br/>
    <input name="zoek" type="submit" value="zoeken">
</form>
</head>
<body>
<div id=personal>

  <?php
    require_once("nbbc.php");
    $bbcode = new BBCode;
    ?>


<?php
    //Profiel zelf
    // Als je niet ingelogd bent wordt je naar login.php gestuurd.
    if(!isset($_SESSION['username'])) {
        //true al ingelogd
        header("location:login.php");
        } else {

    $username = $_SESSION['username'];
    $sql = "SELECT *, DATE_FORMAT(date, '%D %M %Y om %H:%i') as date_formatted FROM login WHERE username='$username'";       
    $res = mysqli_query($db, $sql) or die(mysqli_error($db));
    $post ="";
    // Geeft alleen mogelijkheid to wijzigen en verwijderen als ingelog bent.   
    if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
        //true al ingelogd
        if(mysqli_num_rows($res) >0) {
            while($row = mysqli_fetch_assoc($res)) {
                $id = $row['id'];
                $username = $row['username'];
                $email = $row['email'];
                $date = $row['date_formatted'];
                $post = "<div><p><h1>$username</h1><b>Email:</b>&nbsp$email<br/><b>Aangemeld sinds:</b>&nbsp$date<p></div><p>Geplaatste artikel(en):</b>";
                echo $post;
            }
        }
        }
    }

 //de laatste geplaatste artikelen
 if(!isset($_SESSION['username'])) {
    } else {

    $sql = "SELECT *, DATE_FORMAT(date, '%D %M %Y om %H:%i') as date_formatted FROM articles WHERE author='$username' ORDER BY date DESC";    
    $res = mysqli_query($db, $sql) or die(mysqli_error($db));
    $post ="";
    // Geeft alleen mogelijkheid to wijzigen en verwijderen als ingelog bent.   
    if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
        //true al ingelogd
        if(mysqli_num_rows($res) >0) {
            while($row = mysqli_fetch_assoc($res)) {
                $id = $row['id'];
                $title = $row['title'];
                $content = $row['content'];
                $author = $row['author'];
                $cats = $row['cat_id'];
                $date = $row['date_formatted'];
                $admin = "<div><a href='del_post.php?pid=$id'>Verwijder</a>&nbsp;<a href='edit_post.php?pid=$id'>Wijzig</a>&nbsp</div>";
                $output = $bbcode->Parse($content);
                $post = "<div><b>Wat:&nbsp</b><a href='index.php?pid=$id'/>$title</a>&nbsp<b>geplaatst&nbspop:</b>&nbsp$date&nbsp$admin<br/></div>";
                echo $post;
            }
        }
    }
}
?>
</div>
</body>
<?php include 'footer.php';?>
</html>