<?php session_start(); include 'connect.php';?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="icon" href="favicon.ico">
    <title>RP Online</title>
</head>
<body>
    <header>
        <div class="kontejner">
            <h1><a href="indeks.php"><img src="logo.jpg" alt="RP ONLINE"></a></h1>
            <nav>
                <ul>
                    <li><a href="indeks.php">HOME</a></li>
                    <li><a href="kategorija.php?kategorija=sport">SPORT</a></li>
                    <li><a href="kategorija.php?kategorija=politika">POLITIKA</a></li>
                    <li id="trenutni"><a href=
                    <?php
                        if (isset($_SESSION['user'])) {
                            echo '"administracija.php"';
                        }else{
                            echo '"login.php"';
                        }
                    ?>>ADMINISTRACIJA</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <div class="kontejner">
            <section>
                <h2><a href="registracija.php">Registracija</a></h2>
                <div id="forma">
                    <form action="" method="POST">
                        <p>
                            <?php
                            if(isset($_POST['submit'])){
                                $user=$_POST['korisnicko_ime'];
                                $sql = "SELECT * FROM korisnik WHERE korisnicko_ime=?";
                                mysqli_stmt_prepare($stmt, $sql);
                                mysqli_stmt_bind_param($stmt,'s',$user);
                                mysqli_stmt_execute($stmt);
                                $result=mysqli_stmt_get_result($stmt);
                                if (mysqli_num_rows($result)>0){
                                    echo 'Korisničko ime je već zauzeto!';
                                }else{
                                    if($_POST['lozinka1']==$_POST['lozinka2']){
                                        $pass=password_hash($_POST['lozinka1'], CRYPT_BLOWFISH);
                                        $ime=$_POST['ime'];
                                        $prezime=$_POST['prezime'];
                                        $sql = "INSERT INTO korisnik (ime,prezime,korisnicko_ime,lozinka) VALUES (?,?,?,?)";
                                        mysqli_stmt_prepare($stmt, $sql);
                                        mysqli_stmt_bind_param($stmt,'ssss',$ime,$prezime,$user,$pass);
                                        mysqli_stmt_execute($stmt);
                                        echo 'Uspješno ste se registrirali!';
                                    }else{
                                        echo 'Lozinke se ne podudaraju!';
                                    }
                                }
                            }else{
                                echo "Registriraj se kao novi korisnik.";
                            }mysqli_close($dbc);
                            ?>    
                        </p>
                        <input required type="text" name="korisnicko_ime" placeholder="Korisničko ime">
                        <input required type="text" name="ime" placeholder="Ime">
                        <input required type="text" name="prezime" placeholder="Prezime">
                        <input required type="password" name="lozinka1" placeholder="Lozinka">
                        <input required type="password" name="lozinka2" placeholder="Ponovi lozinku">
                        <button type="submit" name="submit">Registracija</button>
                    </form>
                </div>
            </section>
        </div>
    </main>
    <footer>
        <div class="kontejner">
            <p>PROJEKT: RP ONLINE | IZRADIO: MATEO LUKAČ</p>
        </div>
    </footer>
</body>
</html>