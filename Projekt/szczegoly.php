<?php
include 'config.php';
session_start();

$id = $_GET['id'];
$idu=$_SESSION['id'];
$produkt = "SELECT * FROM products where id = '$id'";
$select = mysqli_query($conn,$produkt);
$produkt1 = "SELECT * FROM opinia where id_produktu = '$id'";
$wysopinia = mysqli_query($conn,$produkt1);
$osoba = "SELECT * FROM user_info where id = '$idu'";
$select2 = mysqli_query($conn,$osoba);
$osoba = mysqli_fetch_assoc($select2);

spl_autoload_register(function ($opinia) {
    include $opinia . '.php';
});
?>
<!Doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible"content="IE-edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Pudełka</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<section id="header">

    <div>

        <ul id="bar">
            <a href="Sklep_z_jedzeniem.php"><img src="img/logo.png" class="logo" id="logo" alt=""></a>
            <li><a class="active" href="Sklep_z_jedzeniem.php">Home</a></li>
            <li><a href="cart.php"><i class="far fa-shopping-cart"></i></a></li>

        </ul>
    </div>
</section>
<?php

$produkt=mysqli_fetch_assoc($select);
    echo '<div class = "prod1">
    <img src = "'.$produkt['img'].'"width=200px>
    <h1>'.$produkt['nazwa'].'</h1>
    <h2>Cena bez dostawy: '.$produkt['cena_bez_dostawy'].'zł</h2>
    <h2>Cena z dostawy: '.$produkt['cena_z_dostawa'].'zł</h2>
    <h4>Opis szczegółowy: '.$produkt['opis_duzy'].'</h4>
    </div>
    ';


?>

<form method="post" class = "prod1">
    <h2>opinia:</h2>
    <input type="text" required name="opinia">
    <h2>ocena:</h2>
    <input type="number" required name="ocena" min="1" max="5">
    <input type="submit" name="submit">
</form>
<?php
echo'<h3 class="prod1">Opinie uzytkownikow:</h3>';
while($produkt1=mysqli_fetch_assoc($wysopinia)){
    echo'<div class="prod"> <h4 class="prod1">'.$osoba['name'].'</h4>
    <h4 class="prod1">'.$produkt1['tresc'].'</h4>
    <h4 class="prod1">Ocena:'.$produkt1['ocena'].'/5</h4></div>';
}
?>
</body>
</html>

<?php
if(!empty($_POST['submit'])) {
    $opinia = new opinia($idu, $id, $_POST['opinia'], $_POST['ocena']);
    $opinia->add();
}








