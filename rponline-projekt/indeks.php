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
                    <li id="trenutni"><a href="indeks.php">HOME</a></li>
                    <li><a href="kategorija.php?kategorija=sport">SPORT</a></li>
                    <li><a href="kategorija.php?kategorija=politika">POLITIKA</a></li>
                    <li><a href=
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
                <h2><a href="kategorija.php?kategorija=sport">Sport</a></h2>
                <?php
                    $query = "SELECT * FROM vijesti WHERE arhiva=0 AND kategorija='sport' ORDER BY id DESC LIMIT 3";
                    $result = mysqli_query($dbc, $query);
                    while($row = mysqli_fetch_array($result)) {
                        echo '<article>';
                        echo '<div><img src="'.$row['slika'].'" alt="slika"></div>';
                        echo '<div>';
                        echo '<h3><a href="clanak.php?id='.$row['id'].'">'.$row['naslov'].'</a></h3>';
                        echo  '<p>'.$row['sazetak'].'</p>';
                        echo '</div>';
                        echo '</article>';
                    }
                ?>
            </section>
            <section>
                <h2><a href="kategorija.php?kategorija=politika">Politika</a></h2>
                <?php
                    $query = "SELECT * FROM vijesti WHERE arhiva=0 AND kategorija='politika' ORDER BY id DESC LIMIT 3";
                    $result = mysqli_query($dbc, $query);
                    while($row = mysqli_fetch_array($result)) {
                        echo '<article>';
                        echo '<div><img src="'.$row['slika'].'" alt="slika"></div>';
                        echo '<div>';
                        echo '<h3><a href="clanak.php?id='.$row['id'].'">'.$row['naslov'].'</a></h3>';
                        echo  '<p>'.$row['sazetak'].'</p>';
                        echo '</div>';
                        echo '</article>';
                    }
                    mysqli_close($dbc);
                ?> 
                
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