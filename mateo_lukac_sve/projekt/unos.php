<?php session_start(); include 'connect.php';?>
<?php
if(!isset($_SESSION['user'])){
    mysqli_close($dbc);
    header("Location: login.php");
    exit;
}else if($_SESSION['level']==0 ){
    mysqli_close($dbc);
    header("Location: administracija.php");
    exit;
}?>
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
                <h2><a href="unos.php">Unos</a></h2>
                <div id="forma">
                    <form action="skripta.php" method="POST" name="dojmovnik" enctype="multipart/form-data">
                        <input required type="text" name="naslov" placeholder="Naslov vijesti">
                        <textarea required name="sazetak" placeholder="Kratki sažetak vijesti"></textarea>
                        <textarea required name="sadrzaj" placeholder="Sadržaj vijesti..."></textarea>
                        <select required name="kategorija">
                            <option value="" disabled selected>Kategorija vijesti</option>
                            <option value="sport">Sport</option>
                            <option value="politika">Politika</option>
                        </select>
                        <input required type="file" name="slika" accept="image/*">
                        <label>
                            <input type="checkbox" name="arhiva" id="checkbox">
                            Spremi u arhivu
                        </label>
                        <button type="submit">Pošalji</button>
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