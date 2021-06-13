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
        <section class="row">
            <h2 class="category col-12"><?php echo $category; ?></h2>
            <h1 class="title col-12"><?php echo $title; ?></h1>
            <p class="autor col-12">AUTOR:</p>
            <p class="objavljeno col-12">OBJAVLJENO:</p>
        <section class="slika">
            <?php echo "<img src='img/$picture'"; ?>
        </section>
        <section class="about">
            <i><?php echo $about; ?></i>
        </section>
        <section class="content">
            <p><?php echo $content; ?></p>
        </section>
        </section>
    </main>
	<footer>
       <p>Borna Bilandžija</p>
	    
    </footer>
</body>
</html>