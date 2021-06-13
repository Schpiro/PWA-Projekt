<?php
    session_start();
    include 'connect.php';
    define('UPLPATH', 'img/');
    $uspjesnaPrijava = false;
    if (isset($_POST['prijava'])) {
    $prijavaImeKorisnika = $_POST['username'];
    $prijavaLozinkaKorisnika = $_POST['lozinka'];
    
    $sql = "SELECT korisnicko_ime, lozinka, razina FROM korisnik
    WHERE korisnicko_ime = ?";
    $stmt = mysqli_stmt_init($dbc);
    if (mysqli_stmt_prepare($stmt, $sql)) {
    mysqli_stmt_bind_param($stmt, 's', $prijavaImeKorisnika);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    }
    mysqli_stmt_bind_result($stmt, $imeKorisnika, $lozinkaKorisnika, $levelKorisnika);
    mysqli_stmt_fetch($stmt);

    if (password_verify($_POST['lozinka'], $lozinkaKorisnika) && mysqli_stmt_num_rows($stmt) > 0) {
        $uspjesnaPrijava = true;
     
        if ($levelKorisnika == 1) {
        $admin = true;
        }
        else {
        $admin = false;
        }
        $_SESSION['$username'] = $imeKorisnika;
        $_SESSION['$level'] = $levelKorisnika;
        } else {
                $uspjesnaPrijava = false;
            }       
        }
    if(isset($_POST['delete'])) {
            $id=$_POST['id'];
            $query = "DELETE FROM vijesti WHERE id=$id";
            $result = mysqli_query($dbc, $query);
        }
    if(isset($_POST['update'])) {
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
        $id = $_POST['id'];
        $query = "UPDATE vijesti SET naslov='$title', sazetak='$about', tekst='$content', slika='$picture', kategorija='$category', arhiva='$archive' WHERE id=$id";
        $result = mysqli_query($dbc, $query);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>The Barn</title>
    <link href="style.css" media="all" rel="stylesheet" type="text/css"/>
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
        <div class="row">
            <?php
            if (($uspjesnaPrijava == true && $admin == true) || (isset($_SESSION['$username'])) && $_SESSION['$level'] == 1) { 
                if (($uspjesnaPrijava == true && $admin == true) ||
                (isset($_SESSION['$username'])) && $_SESSION['$level'] == 1) {
                $query = "SELECT * FROM vijesti";
                $result = mysqli_query($dbc, $query);
                echo '<div class="odjava" <p>Bok ' . $_SESSION['$username'] . '! Uspješno ste
                prijavljeni kao administrator.</p>
                <a href="logout.php">Odjava</a></div>';
                while($row = mysqli_fetch_array($result)) {
                    echo '<form action="" method="post" enctype="multipart/form-data">
                    <div class="form-item">
                    <span id="porukaTitle'.$row["id"].'" class="bojaPoruke"></span>
                        <label for="title" class="title">Naslov vijesti</label>
                    <div class="form-field">
                        <input type="text" name="title" id="title'.$row["id"].'" class="form-field-textual" value="'.$row['naslov'].'">
                    </div>
                </div>
                <div class="form-item">
                    <label for="about">Kratki sadržaj vijesti (do 50 znakova)</label>
                    <div class="form-field">
                    <span id="porukaAbout'.$row["id"].'" class="bojaPoruke"></span>
                        <textarea name="about" id="about'.$row["id"].'" cols="30" rows="10" class="form-field-textual">'.$row['sazetak'].'</textarea>
                    </div>
                </div>
                <div class="form-item">
                    <label for="content">Sadržaj vijesti</label>
                    <span id="porukaContent'.$row["id"].'" class="bojaPoruke"></span>
                    <div class="form-field">
                        <textarea name="content" id="content'.$row["id"].'" cols="30" rows="10" class="form-field-textual">'.$row['tekst'].'</textarea>
                    </div>
                </div>
                <div class="form-item">
                    <span id="porukaSlika'.$row["id"].'" class="bojaPoruke"></span>
                    <label for="pphoto" >Slika: </label>
                    <div class="form-field">
                        <input type="file" name="pphoto" id="pphoto'.$row["id"].'" class="input-text" accept="image/x-png,image/gif,image/jpeg" value="'.$row['slika'].'"> <br><img src="'.UPLPATH . $row['slika'].'">
                    </div>
                </div>
                <div class="form-item">
                    <span id="porukaKategorija'.$row["id"].'" class="bojaPoruke"></span>
                    <label for="category">Kategorija vijesti</label>
                    <div class="form-field">
                        <select name="category" id="category'.$row["id"].'" class="form-field-textual" value="'.$row['kategorija'].'">
                            <option value="0" selected disabled>Odaberite kategoriju</option>
                            <option value="Stočarstvo">Stočarstvo</option>
                            <option value="Agrikultura">Agrikultura</option>
                        </select>
                    </div>
                </div>
                <div class="form-item">
                    <label>Spremiti u arhivu:
                        <div class="form-field">';
                            if($row['arhiva'] == 0) {
                                echo '<input type="checkbox" name="archive" id="archive'.$row["id"].'" /> Arhiviraj?';
                            } else {
                                echo '<input type="checkbox" name="archive" id="archive'.$row["id"].'" checked/> Arhiviraj?';
                            } 
                            echo '
                            </div>
                            </label>
                        </div>
                        </div>
                        <div class="form-item">
                            <input type="hidden" name="id" class="form-field-textual" value="'.$row['id'].'">
                            <button type="reset" value="Poništi">Poništi</button>
                            <button type="submit" name="update"  id="slanje'.$row["id"].'" value="Prihvati">Prihvati</button>
                            <button type="submit" name="delete" value="Izbriši">Izbriši</button>
                        </div>
                    </form>
                    <script>
                        // Provjera forme prije slanja
                        document.getElementById("slanje'.$row["id"].'").onclick = function(event) {
                        var slanjeForme = true;
                        // Naslov vjesti (5-30 znakova)
                        var poljeTitle = document.getElementById("title'.$row["id"].'");
                        var title = document.getElementById("title'.$row["id"].'").value;
                        if (title.length < 5 || title.length > 30) {
                        slanjeForme = false;
                        poljeTitle.style.border="1px dashed red";
                        document.getElementById("porukaTitle'.$row["id"].'").innerHTML="Naslov vjesti mora imati između 5 i 30 znakova!<br>";
                        } else {
                        poljeTitle.style.border="1px solid green";
                        document.getElementById("porukaTitle'.$row["id"].'").innerHTML="";
                        }
                        // Kratki sadržaj (10-100 znakova)
                        var poljeAbout = document.getElementById("about'.$row["id"].'");
                        var about = document.getElementById("about'.$row["id"].'").value;
                        if (about.length < 10 || about.length > 100) {
                        slanjeForme = false;
                        poljeAbout.style.border="1px dashed red";
                        document.getElementById("porukaAbout'.$row["id"].'").innerHTML="Kratki sadržaj mora imati između 10 i 100 znakova!<br>";
                        } else {
                        poljeAbout.style.border="1px solid green";
                        document.getElementById("porukaAbout'.$row["id"].'").innerHTML="";
                        }
                        // Sadržaj mora biti unesen
                        var poljeContent = document.getElementById("content'.$row["id"].'");
                        var content = document.getElementById("content'.$row["id"].'").value;
                        if (content.length == 0) {
                        slanjeForme = false;
                        poljeContent.style.border="1px dashed red";
                        document.getElementById("porukaContent'.$row["id"].'").innerHTML="Sadržaj mora biti unesen!<br>";
                        } else {
                        poljeContent.style.border="1px solid green";
                        document.getElementById("porukaContent'.$row["id"].'").innerHTML="";
                        }
                        // Slika mora biti unesena
                        var poljeSlika = document.getElementById("pphoto'.$row["id"].'");
                        var pphoto = document.getElementById("pphoto'.$row["id"].'").value;
                        if (pphoto.length == 0) {
                        slanjeForme = false;
                        poljeSlika.style.border="1px dashed red";
                        document.getElementById("porukaSlika'.$row["id"].'").innerHTML="Slika mora biti unesena!<br>";
                        } else {
                        poljeSlika.style.border="1px solid green";
                        document.getElementById("porukaSlika'.$row["id"].'").innerHTML="";
                        }
                        // Kategorija mora biti odabrana
                        var poljeCategory = document.getElementById("category'.$row["id"].'");
                        if(document.getElementById("category'.$row["id"].'").selectedIndex == 0) {
                        slanjeForme = false;
                        poljeCategory.style.border="1px dashed red";
                        document.getElementById("porukaKategorija'.$row["id"].'").innerHTML="Kategorija mora biti odabrana!<br>";
                        } else {
                        poljeCategory.style.border="1px solid green";
                        document.getElementById("porukaKategorija'.$row["id"].'").innerHTML="";
                        }
                        if (slanjeForme != true) {
                        event.preventDefault();
                    }
                    }
                    </script>';
                    
            }
            }
            } else if ($uspjesnaPrijava == true && $admin == false) {
            echo '<div class="odjava"><p>Bok ' . $imeKorisnika . '! Uspješno ste prijavljeni, ali
            niste administrator.</p>
            <a href="logout.php">Odjava</a></div>';
            } else if (isset($_SESSION['$username']) && $_SESSION['$level'] == 0) {
            echo '<div class="odjava"><p>Bok ' . $_SESSION['$username'] . '! Uspješno ste
            prijavljeni, ali niste administrator.</p>
            <a href="logout.php">Odjava</a></div>';
            } else if ($uspjesnaPrijava == false) {
                echo '
                        <form action="administracija.php" method="POST" enctype="multipart/form-data">
                            <div class="wrapper">
                                <div class="item">
                                    <br>
                                    <span id="porukaUsername" class="bojaPoruke"></span>
                                    <label for="username">Korisni&#269ko ime:</label>
                                    <div class="form-field">
                                        <input type="text" name="username" id="username" class="form-field-textual">
                                    </div>
                                    <br>
                                    <div class="item">
                                        <span id="porukaPass" class="bojaPoruke"></span>
                                        <label for="lozinka">Lozinka:</label>
                                        <div class="form-field">
                                            <input type="password" name="lozinka" id="pass" class="form-field-textual">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="prijavaForma">
                                        <button type="submit" value="prijava" id="slanje" name="prijava">Prijava</button>
                                        <button class="link" type="submit" value="prijava" id="stil"><a href="register.php">register</a></button>
                                    </div>
                                    
                                <br>
                            </div>
                        </form>
                        <script type="text/javascript">
                            document.getElementById("slanje").onclick = function(event) {
                                
                                var slanjeForme = true;
                                
                                var poljeUsername = document.getElementById("username");
                                var username = document.getElementById("username").value;
                                if (username.length == 0) {
                                    slanjeForme = false;
                                    poljeUsername.style.border="1px dashed red";
                                    document.getElementById("porukaUsername").innerHTML="<br>Unesite korisnicko ime!<br>";
                                }
                                else {
                                    poljeUsername.style.border="1px solid green";
                                    document.getElementById("porukaUsername").innerHTML="";
                                }
                                
                                var poljePassword = document.getElementById("pass");
                                var username = document.getElementById("pass").value;
                                if (username.length == 0) {
                                    slanjeForme = false;
                                    poljePassword.style.border="1px dashed red";
                                    document.getElementById("porukaPass").innerHTML="<br>Unesite lozinku!<br>";
                                }
                                else {
                                    poljePassword.style.border="1px solid green";
                                    document.getElementById("porukaPassword").innerHTML="";
                                }
                                
                                if (slanjeForme != true) {
                                    event.preventDefault();
                                }
                            }
                        </script>'
                    ;
                        
            }
		?>
    </main>
    <footer>
       <p>Borna Bilandžija</p>
    </footer>	
</body>