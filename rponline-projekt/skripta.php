<?php session_start(); include 'connect.php';?>
<?php
header('Content-Type: text/html; charset=utf-8');
$picture = $_FILES['slika']['name'];
$title=$_POST['naslov'];
$about=$_POST['sazetak'];
$content=$_POST['sadrzaj'];
$category=$_POST['kategorija'];
$date=date('d.m.Y.');
if(isset($_POST['arhiva'])){
    $archive=1;
}else{
    $archive=0;
}
$target_dir = 'slike/'.uniqid().'_'.$picture;
move_uploaded_file($_FILES["slika"]["tmp_name"], $target_dir);
$sql = "INSERT INTO vijesti (datum, naslov, sazetak, tekst, slika, kategorija,arhiva ) VALUES (?,?,?,?,?,?,?)";
$stmt=mysqli_stmt_init($dbc);
 if (mysqli_stmt_prepare($stmt, $sql)){
    mysqli_stmt_bind_param($stmt,'ssssssi',$date,$title,$about,$content,$target_dir,$category,$archive);
    mysqli_stmt_execute($stmt);
 }
mysqli_close($dbc);
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
                    <li <?php if($_POST['kategorija']=='sport')echo 'id="trenutni"';?>><a href="kategorija.php?kategorija=sport">SPORT</a></li>
                    <li <?php if($_POST['kategorija']=='politika')echo 'id="trenutni"';?>><a href="kategorija.php?kategorija=politika">POLITIKA</a></li>
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
                <h2>
                    <?php
                        if($_POST['kategorija']=='sport')
                            echo '<a href="kategorija.php?kategorija=sport">Sport</a>';
                        else
                            echo '<a href="kategorija.php?kategorija=politika">Politika</a>';
                    ?>
                </h2>
                <article class="clanak">
                    <div>
                        <h3>
                            <?php
                                echo $_POST['naslov'];
                            ?>
                        </h3>
                        <p id="datum">
                            <?php
                                echo $date;
                            ?>
                        </p>
                    </div>
                    <img src="<?php echo $target_dir;?>" alt="slika">
                    <div>
                        <p>
                            <?php
                                echo $_POST['sazetak'];
                            ?>
                        </p>
                        <p>
                            <?php
                                echo $_POST['sadrzaj'];
                            ?>
                        </p>
                    </div>
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