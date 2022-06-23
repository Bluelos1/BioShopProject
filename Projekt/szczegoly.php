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
    echo '<img src = "'.$produkt['img'].'"width=200px>
    <h1>'.$produkt['nazwa'].'</h1>
    <h2>'.$produkt['cena_bez_dostawy'].'zł</h2>
    
    ';


?>

<form method="post" >
    <h2>opinia:</h2>
    <input type="text" name="opinia">
    <h2>ocena:</h2>
    <input type="number" name="ocena">
    <input type="submit" name="submit">
</form>
<?php
echo'<h1>Opinie uzytkownikow:</h1>';
while($produkt1=mysqli_fetch_assoc($wysopinia)){
    echo'<h1>'.$osoba['name'].'</h1>';
    echo'<h1>'.$produkt1['tresc'].'</h1>';
    echo'<h1>'.$produkt1['ocena'].'</h1>';
}
?>
</body>
</html>

<?php
if(!empty($_POST['submit'])) {
    $opinia = new opinia($idu, $id, $_POST['opinia'], $_POST['ocena']);
    $opinia->add();
}








