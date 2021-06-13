<?php
include 'connect.php';
define('UPLPATH', 'img/');
$id =$_GET['id'];
$query = "SELECT * FROM vijesti WHERE id='$id'";
$result = mysqli_query($dbc, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>The Barn</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<body>
   <header>
        <section class="logo">
            <img src="img/logo.png" class="logo">
        </section>
        <nav>
            <ul class="nav justify-content-center">
            <li><a href="index.php">Početna</a></li>
                <li><a href="kategorija.php?id=Agrikultura">Agrikultura</a></li>
                <li><a href="kategorija.php?id=Stočarstvo">Stočarstvo</a></li>
                <li><a href="administracija.php">Administracija</a></li>
                <li><a href="unos.php">Unos</a></li>
            </ul>
        </nav>
		 
	</header>
    <main class="container">
        <?php 
            while($row = mysqli_fetch_array($result)) {
				$id = $row['id'];
                echo '<div class="row">
                <h2 class="category col-12"><span>'.$row['kategorija'].'</span></h2>
                <h1 class="title col-12">'. $row['naslov'] .'</h1>
                <p class="col-12">AUTOR:</p>
                <p class="col-12">OBJAVLJENO: <span>'.$row['datum'].'</span> </p>
                </div>
                <section class="slika">
                     
                         <img src="'.UPLPATH . $row['slika'].'">
                    
                </section>
                <section class="about">
                    <p>
                     <i>'.$row['sazetak'].'</i>
                    </p>
                </section>
                <section class="sadrzaj"> 
                    <p>
                      '.$row['tekst'].'
                    </p>
                </section>';
            }
        ?>
    </main>
    <footer>
       <p>Borna Bilandžija</p>
	    
    </footer>
</body>
</html>