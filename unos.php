<?php 
   if(isset($_POST['prihvati'])) {
    include 'connect.php';
    $picture = $_FILES['pphoto']['name'];
    $title = $_POST['title'];
    $about = $_POST['about'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $date = date('d.m.Y.');
    if(isset($_POST['archive'])) {
        $archive = 1;
    } else {
        $archive = 0;
    }

    $target_dir = 'img/'.$picture;
    move_uploaded_file($_FILES['pphoto']['tmp_name'], $target_dir);

    $stmt = $dbc->prepare("INSERT INTO vijesti (datum, naslov, sazetak, tekst, slika, kategorija, arhiva) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $date, $title, $about, $content, $picture, $category, $archive);

    $picture = $_FILES['pphoto']['name'];
    $title = $_POST['title'];
    $about = $_POST['about'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $date = date('d.m.Y.');
    $stmt->execute();



    $stmt->close();


	include 'skripta.php'; die;
}

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
        <section> 
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-item">
                <span id="porukaTitle" class="bojaPoruke"></span>
                <label for="title">Naslov vijesti</label>
                <div class="form-field">
                    <input type="text" name="title" id="title" class="form-field-textual">
                </div>
            </div>
            <div class="row">
                <div class="form-item col-12">
                    <span id="porukaAbout" class="bojaPoruke"></span>
                    <label for="about">Kratki sadržaj vijesti (do 50 znakova)</label>
                    <div class="form-field">
                        <textarea name="about" id="about" cols="30" rows="10" class="form-field-textual"></textarea>
                    </div>
                </div>
                <div class="form-item col-12">
                    <span id="porukaContent" class="bojaPoruke"></span>
                    <label for="content">Sadržaj vijesti</label>
                    <div class="form-field">
                        <textarea name="content" id="content" cols="30" rows="10" class="form-field-textual"></textarea>
                    </div>
                </div>

                <div class="form-item col-12">
                    <span id="porukaSlika" class="bojaPoruke"></span>
                    <label for="pphoto" >Slika: </label>
                    <div class="form-field">
                        <input type="file" name="pphoto" id="pphoto" class="input-text" accept="image/x-png,image/gif,image/jpeg">
                    </div>
                </div>
                <div class="form-item col-6">
                    <span id="porukaKategorija" class="bojaPoruke"></span>
                    <label for="category">Kategorija vijesti</label>
                    <div class="form-field">
                        <select name="category" id="category" class="form-field-textual">
                            <option value="izbor">Odaberite kategoriju</option>
                            <option value="Agrikultura">Agrikultura</option>
                            <option value="Stočarstvo">Stočarstvo</option>
                        </select>
                    </div>
                </div>
                <div class="form-item col-12">
                    <label>Spremiti u arhivu:
                        <div class="form-field">
                            <input type="checkbox" name="archive" id="archive">
                        </div>
                    </label>
                </div>
            </div>
            <div class="form-item">
                <button type="reset" value="Poništi">Poništi</button>
                <button type="submit" name="prihvati" id="slanje" value="Prihvati">Prihvati</button>
            </div>
        </form>
        </section>
        <script>
            document.getElementById("slanje").onclick = function(event) {

            var slanjeForme = true;

            var poljeTitle = document.getElementById("title");
            var title = document.getElementById("title").value;
            if (title.length < 5 || title.length > 30) {
            slanjeForme = false;
            poljeTitle.style.border="1px dashed red";
            document.getElementById("porukaTitle").innerHTML="Naslov vjesti mora imati između 5 i 30 znakova!<br>";
			} else {
            poljeTitle.style.border="1px solid green";
            document.getElementById("porukaTitle").innerHTML="";
            }

            var poljeAbout = document.getElementById("about");
            var about = document.getElementById("about").value;
            if (about.length < 10 || about.length > 100) {
            slanjeForme = false;
            poljeAbout.style.border="1px dashed red";
            document.getElementById("porukaAbout").innerHTML="Kratki sadržaj mora imati između 10 i 100 znakova!<br>";
			} else {
            poljeAbout.style.border="1px solid green";
            document.getElementById("porukaAbout").innerHTML="";
            }
            var poljeContent = document.getElementById("content");
            var content = document.getElementById("content").value;
            if (content.length == 0) {
            slanjeForme = false;
            poljeContent.style.border="1px dashed red";
            document.getElementById("porukaContent").innerHTML="Sadržaj mora biti unesen!<br>";
			} else {
            poljeContent.style.border="1px solid green";
            document.getElementById("porukaContent").innerHTML="";
            }
            var poljeSlika = document.getElementById("pphoto");
            var pphoto = document.getElementById("pphoto").value;
            if (pphoto.length == 0) {
            slanjeForme = false;
            poljeSlika.style.border="1px dashed red";
            document.getElementById("porukaSlika").innerHTML="Slika mora biti unesena!<br>";
			} else {
            poljeSlika.style.border="1px solid green";
            document.getElementById("porukaSlika").innerHTML="";
            }
            var poljeCategory = document.getElementById("category");
            if(document.getElementById("category").selectedIndex == 0) {
            slanjeForme = false;
            poljeCategory.style.border="1px dashed red";

            document.getElementById("porukaKategorija").innerHTML="Kategorija mora biti odabrana!<br>";
			} else {
            poljeCategory.style.border="1px solid green";
            document.getElementById("porukaKategorija").innerHTML="";
            }

            if (slanjeForme != true) {
            event.preventDefault();
        }

        };
    </script>
    </main>
    <footer>
       <p>Borna Bilandžija</p>
	    
    </footer>
</body>
</html>