<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  max-width: 300px;
  margin: auto;
  text-align: center;
  font-family: arial;
}

.title {
  color: black;
  font-size: 18px;
}

button {
  border: none;
  outline: 0;
  display: inline-block;
  padding: 8px;
  color: white;
  background-color: #000;
  text-align: center;
  cursor: pointer;
  width: 100%;
  font-size: 18px;
}

a {
  text-decoration:
  font-size: 22px;
  color: black;
}

button:hover, a:hover {
  opacity: 0.7;
}
</style>
</head>
<body>


<div class="card">

<?php
    //Profiel zelf
    // Als je niet ingelogd bent wordt je naar login.php gestuurd.
    if(!isset($_SESSION['username'])) {
        //true al ingelogd
        echo "<h3>Niet ingelogd</h3>";
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
                $post = "<div><p><h1>$username</h1><b>Email:&nbsp$email<br/>Aangemeld sinds:<br/>$date<p></div><p>Geplaatste artikel(en):</b>";
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
                $post = "<div><b>Wat:&nbsp</b><a href='index.php?pid=$id'/>$title</a>&nbsp<br/><b>Op:</b>&nbsp$date<p></div>";
                echo $post;
            }
        }
    }
}
?>
<div style="margin: 24px 0;">
    <a href="#"><i class="fa fa-dribbble"></i></a> 
    <a href="#"><i class="fa fa-twitter"></i></a>  
    <a href="#"><i class="fa fa-linkedin"></i></a>  
    <a href="#"><i class="fa fa-facebook"></i></a> 
</div>
 
 <p><button>Contact</button></p>
 
</div>


</body>
</html>