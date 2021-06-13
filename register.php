<?php 
    header('Content-Type: text/html; charset=utf-8');

    $servername = "localhost";
    $username = "root";
    $password= "";
    $basename= "projekt";


    $dbc = mysqli_connect($servername, $username, $password, $basename) or die('Error connecting to MySQL server'.mysqli_error());
    mysqli_set_charset($dbc, "utf-8");

	
	if(isset($_POST['prijava'])){
		$ime = $_POST['ime'];
		$prezime = $_POST['prezime'];
		$username = $_POST['username'];
		$lozinka = $_POST['pass'];
		$hashed_password = password_hash($lozinka, PASSWORD_BCRYPT);
		$razina = 0;
		$registriranKorisnik = '';
		
		$sql = "SELECT korisnicko_ime FROM korisnik WHERE korisnicko_ime = ?";
		$stmt = mysqli_stmt_init($dbc);
		
		if (mysqli_stmt_prepare($stmt, $sql)) {
			mysqli_stmt_bind_param($stmt, 's', $username);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_store_result($stmt);
		}
		if(mysqli_stmt_num_rows($stmt) > 0){
			$msg='Korisnicko ime vec postoji!';
		}
		else{
			$sql = "INSERT INTO korisnik (ime, prezime,korisnicko_ime, lozinka, razina)VALUES (?, ?, ?, ?, ?)";
			$stmt = mysqli_stmt_init($dbc);
			if (mysqli_stmt_prepare($stmt, $sql)) {
				mysqli_stmt_bind_param($stmt, 'ssssd', $ime, $prezime, $username, $hashed_password, $razina);
				mysqli_stmt_execute($stmt);
				$registriranKorisnik = true;
			}
		}
		mysqli_close($dbc);
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
        <div class="row">
        <form enctype="multipart/form-data" action="" method="POST">
            <div class="form-item">
                <span id="porukaIme" class="bojaPoruke"></span>
                <label for="title">Ime: </label>
                <div class="form-field">
                    <input type="text" name="ime" id="ime" class="form-fieldtextual">
                </div>
            </div>
            <div class="form-item">
                <span id="porukaPrezime" class="bojaPoruke"></span>
                <label for="about">Prezime: </label>
                <div class="form-field">
                    <input type="text" name="prezime" id="prezime" class="formfield-textual">
                </div>
            </div>
            <div class="form-item">
                <span id="porukaUsername" class="bojaPoruke"></span>
                <label for="content">Korisničko ime:</label>
                <div class="form-field">
                    <input type="text" name="username" id="username" class="formfield-textual">
                </div>
            </div>
            <div class="form-item">
                <span id="porukaPass" class="bojaPoruke"></span>
                <label for="pphoto">Lozinka: </label>
                <div class="form-field">
                    <input type="password" name="pass" id="pass" class="formfield-textual">
                </div>
            </div>
            <div class="form-item">
                <span id="porukaPassRep" class="bojaPoruke"></span>
                <label for="pphoto">Ponovite lozinku: </label>
                <div class="form-field">
                    <input type="password" name="passRep" id="passRep" class="form-field-textual">
                </div>
            </div>
            <div class="form-item">
                <button class="link" type="submit" value="prijava" id="stil"><a href="administracija.php">Prijava</a></button>
                <button type="submit" value="Prijava" name="prijava" id="slanje">Registriraj se</button>
            </div>   
        </form>
</div>
        <script type="text/javascript">
            document.getElementById("slanje").onclick = function(event) { 
                var slanjeForme = true;
                var poljeIme = document.getElementById("ime");
                var ime = document.getElementById("ime").value;
                if (ime.length == 0) {
                    slanjeForme = false;
                    poljeIme.style.border="1px dashed red";
                    document.getElementById("porukaIme").innerHTML="<br>Unesite ime!<br>";
                } else {
                    poljeIme.style.border="1px solid green";
                    document.getElementById("porukaIme").innerHTML="";
                }
                var poljePrezime = document.getElementById("prezime");
                var prezime = document.getElementById("prezime").value;
                if (prezime.length == 0) {
                    slanjeForme = false;
                    poljePrezime.style.border="1px dashed red";
                    document.getElementById("porukaPrezime").innerHTML="<br>Unesite Prezime!<br>";
                    
                } else {
                    poljePrezime.style.border="1px solid green";
                    document.getElementById("porukaPrezime").innerHTML="";
                }
               var poljeUsername = document.getElementById("username");
                var username = document.getElementById("username").value;
                if (username.length == 0) {
                    slanjeForme = false;
                    poljeUsername.style.border="1px dashed red";
                    document.getElementById("porukaUsername").innerHTML="<br>Unesite korisničko ime!<br>";
                   
                } else {
                    poljeUsername.style.border="1px solid green";
                    document.getElementById("porukaUsername").innerHTML="";
                }
                var poljePass = document.getElementById("pass");
                var pass = document.getElementById("pass").value;
                var poljePassRep = document.getElementById("passRep");
                var passRep = document.getElementById("passRep").value;
                if (pass.length == 0 || passRep.length == 0 || pass != passRep) {
                    slanjeForme = false;
                    poljePass.style.border="1px dashed red";
                    poljePassRep.style.border="1px dashed red";
                    document.getElementById("porukaPass").innerHTML="<br>Lozinke nisu iste!<br>";
                    document.getElementById("porukaPassRep").innerHTML="<br>Lozinke nisu iste!<br>";
                    return false;
                } else {
                    poljePass.style.border="1px solid green";
                    poljePassRep.style.border="1px solid green";
                    document.getElementById("porukaPass").innerHTML="";
                    document.getElementById("porukaPassRep").innerHTML="";
                }
            }
            if (slanjeForme != true) {
                event.preventDefault();
            }
        </script>
    </main>
    <footer>
       <p>Borna Bilandžija</p>
	    
    </footer>
</body>
</html>