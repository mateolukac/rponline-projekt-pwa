<?php session_start(); include 'connect.php';?>
<?php
$query = "SELECT * FROM vijesti WHERE id='".$_GET['id']."'";
$result = mysqli_query($dbc, $query);
$row = mysqli_fetch_array($result)
?>
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
                    <li <?php if($row['kategorija']=='sport') echo 'id="trenutni"';?>><a href="kategorija.php?kategorija=sport">SPORT</a></li>
                    <li <?php if($row['kategorija']=='politika') echo 'id="trenutni"';?>><a href="kategorija.php?kategorija=politika">POLITIKA</a></li>
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
                <h2><a href="kategorija.php?kategorija=<?php if($row['kategorija']=='sport') echo 'sport">Sport'; else echo 'politika">Politika';?></a></h2>
                <article class="clanak">
                    <?php
                    echo '<div><h3>'.$row['naslov'].'</h3>
                            <p id="datum">'.$row['datum'].'</p></div>';
                    echo '<img src="'. $row['slika'] .'" alt="slika">';
                    echo '<div><p>'.$row['sazetak'].'</p><p>'.$row['tekst'].'</p></div>';
                    mysqli_close($dbc);
                    ?>
                </article>
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