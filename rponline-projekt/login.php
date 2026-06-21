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
                <h2><a href="login.php">Login</a></h2>
                <div id="forma">
                    <form action="" method="POST">
                        <p>
                            <?php
                            if(isset($_POST['submit'])){
                                $user=$_POST['korisnicko_ime'];
                                $pass=$_POST['lozinka'];
                                $sql = "SELECT * FROM korisnik WHERE korisnicko_ime=?";
                                mysqli_stmt_prepare($stmt, $sql);
                                mysqli_stmt_bind_param($stmt,'s',$user);
                                mysqli_stmt_execute($stmt);
                                $result=mysqli_stmt_get_result($stmt);
                                if (mysqli_num_rows($result)>0){
                                    $row = mysqli_fetch_assoc($result);
                                    if(password_verify($pass,$row['lozinka'])){
                                        $_SESSION['user'] = $row['korisnicko_ime'];
                                        $_SESSION['level'] = $row['razina'];
                                        mysqli_close($dbc);
                                        header("Location: administracija.php");
                                        exit;
                                    }else{
                                        echo 'Lozinka je netočna!';
                                    }
                                }else{
                                    echo 'Nismo Vas uspjeli pronaći. Provjerite da li su svi podaci točno uneseni ili se <a href="registracija.php">registrirajte</a>.';
                                }
                            }else{
                                echo "Prijavi se za pristup administratorskoj stranici.";
                            }mysqli_close($dbc);
                            ?>    
                        </p>
                        <input required type="text" name="korisnicko_ime" placeholder="Korisničko ime">
                        <input required type="password" name="lozinka" placeholder="Lozinka">
                        <button type="submit" name="submit">Login</button>
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