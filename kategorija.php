<?php
    include 'connect.php';
    define('UPLPATH', 'img/');
	
	$kategorija = $_GET['id'];
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

        <section class="naslov row">
            <h2><?php echo $kategorija; ?> svi članci</h2>
        </section>
        <section class="row">
            <?php
                $query = "SELECT * FROM vijesti WHERE kategorija='$kategorija'";
                $result = mysqli_query($dbc, $query);
                $i = 0;
                while($row = mysqli_fetch_array($result)) {
                    echo '<article class="col-12  col-sm-12 col-lg-3 col-md-6">';
                        echo '<img src="'. UPLPATH . $row ['slika'] .'"';
                        echo '<div class="media_body">';
                        echo '<h4 class="title">';
                        echo '<a href="clanak.php?id='.$row['id'].'">';
                        echo $row['naslov'];
                        echo '</a></h4>';
                        echo '</div>';
                    echo '</article>';
                }
            ?>
                        
        </section>
    </main>
	<footer>
       <p>Borna Bilandžija</p>
	    
    </footer>
</html>