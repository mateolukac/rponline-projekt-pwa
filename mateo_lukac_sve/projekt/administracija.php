<?php session_start(); include 'connect.php';?>
<?php
if(isset($_POST['unos'])){
    mysqli_close($dbc);
    header("Location: unos.php");
    exit;
}
if(isset($_POST['kraj'])){
    $_SESSION = [];
    session_destroy();
}
?>
<?php
if(!isset($_SESSION['user'])){
    mysqli_close($dbc);
    header("Location: login.php");
    exit;
}?>
<?php
$result="";
$stmt=mysqli_stmt_init($dbc);
if(isset($_POST['delete'])){
    $sql = "SELECT * FROM vijesti WHERE id=?";
    $id=$_POST['id'];
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt,'i',$id);
    mysqli_stmt_execute($stmt);
    $result=mysqli_stmt_get_result($stmt);
    while($row = mysqli_fetch_assoc($result)) {
        if (file_exists($row['slika'])) {
            unlink($row['slika']);
        }
    }
    $sql = "DELETE FROM vijesti WHERE id=?";
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt,'i',$id);
    mysqli_stmt_execute($stmt);
}
if(isset($_POST['update'])){
$id=$_POST['id'];
$sql = "SELECT * FROM vijesti WHERE id=?";
mysqli_stmt_prepare($stmt, $sql);
mysqli_stmt_bind_param($stmt,'i',$id);
mysqli_stmt_execute($stmt);
$result=mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$target_dir = $row['slika'];
if ($_FILES['slika']['error'] === UPLOAD_ERR_OK) {
    $target_dir = 'slike/'.uniqid().'_'.$_FILES['slika']['name'];
        if (file_exists($row['slika'])) {
            unlink($row['slika']);
        }
}
$title=$_POST['naslov'];
$about=$_POST['sazetak'];
$content=$_POST['sadrzaj'];
$category=$_POST['kategorija'];
if(isset($_POST['arhiva'])){
 $archive=1;
}else{
 $archive=0;
}
move_uploaded_file($_FILES["slika"]["tmp_name"], $target_dir);
$sql = "UPDATE vijesti SET naslov=?, sazetak=?, tekst=?,slika=?, kategorija=?, arhiva=? WHERE id=? ";
mysqli_stmt_prepare($stmt, $sql);
mysqli_stmt_bind_param($stmt,'sssssii',$title,$about,$content,$target_dir,$category,$archive,$id);
mysqli_stmt_execute($stmt);
}
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
        <div id="admin-contain">
            <?php
            if($_SESSION['level']>0){
            echo '<form id="admin-control" method="POST">
                <button type="submit" name="unos">UNOS VIJESTI</button>
                <button type="submit" name="kraj">KRAJ SESIJE</button>
            </form>';
                $query = "SELECT * FROM vijesti ORDER BY id DESC";
                $result = mysqli_query($dbc, $query);
                while($row = mysqli_fetch_array($result)) {
                echo '<form class="form-admin" enctype="multipart/form-data" action="" method="POST">
                    <div class="form-item"><img src="'.$row['slika'].'" alt="slika"></div>
                    <div class="form-item"><input required value="'.$row['naslov'].'" type="text" name="naslov" title="Naslov vijesti">
                    <textarea required name="sazetak" title="Kratki sažetak vijesti">'.$row['sazetak'].'</textarea>
                    <textarea required name="sadrzaj" title="Sadržaj vijesti...">'.$row['tekst'].'</textarea></div>
                    <div class="form-item"><select required name="kategorija">
                    <option value="" disabled selected>Kategorija vijesti</option>';
                if($row['kategorija']=="sport"){
                    echo '<option value="sport" selected>Sport</option>
                        <option value="politika">Politika</option>';
                }else{
                    echo '<option value="sport">Sport</option>
                        <option value="politika" selected>Politika</option>';
                }
                echo '</select><input type="file" name="slika" accept="image/*">
                    <label><input type="checkbox" name="arhiva"';
                if($row['arhiva']==1)echo 'checked';
                echo '>Arhiva </label></div>
                    <div class="form-item"><button type="reset">Poništi</button>
                    <button type="submit" name="update" >Promijeni</button>
                    <button type="submit" name="delete"  onclick="return confirm('."'Jeste li sigurni da želite obrisati odabranu vijest? Ova akcija se ne može poništiti!'".')">Izbriši</button></div>
                    <input type="hidden" name="id" value="'.$row['id'].'"></form>';}
                mysqli_close($dbc);
            }else{
               echo '<div class="kontejner">
                <section id="prava">
                <article class="clanak">
                    <div><h3>'.$_SESSION['user'].', nemate dovoljna prava za pristup ovoj stranici.</h3></div>
                </article>
            </section>
        </div>';
            echo '<form id="admin-control" method="POST">
                <button type="submit" name="kraj">KRAJ SESIJE</button>
            </form>';}
        ?>
        </div>
    </main>
    <footer>
        <div class="kontejner">
            <p>PROJEKT: RP ONLINE | IZRADIO: MATEO LUKAČ</p>
        </div>
    </footer>
</body>
</html>