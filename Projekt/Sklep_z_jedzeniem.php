<?php
include 'config.php';
session_start();
$produkt = "SELECT * FROM products";
$id = $_SESSION['id'];
$uzytkownik = "select * from user_info where id = '$id'";
$select = mysqli_query($conn,$produkt);
$select2 = mysqli_query($conn,$uzytkownik);
$uzytkownik = mysqli_fetch_assoc($select2);
if(empty($_SESSION['id'])){
    $_SESSION['id'] = 0;
}
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
            <?php
            if(!empty($_SESSION['id'])){
                echo'zalogowano jako: '.$uzytkownik['name'];
                echo'<li><a href = "wyloguj.php">Wyloguj</a></li>';
            }else{
                echo '<li><a href="login.php">Login</a></li>';
            }
            ?>
            <li><a href="cart.php"><i class="far fa-shopping-cart"></i></a></li>

        </ul>
    </div>
</section>
<section id="hero">
    <h2>Bio sklep</h2>
    <h1>Najświeższe warzywka i owocki</h1>
    <h4>Zamów już teraz najzdrowszy katering dietetyczny w twojej okolicy sprawdź już poniżej naszą oferte diet </h4>
    <p>Oszczędź już 20%! na długo terminowym zakupie</p>
    <div class="first"><a href="#box" id="link">Zamów</a></div>
</section>
<?php
while ($produkt=mysqli_fetch_assoc($select)){
    echo '<a href = "szczegoly.php?id='.$produkt['id'].'"><img src = "'.$produkt['img'].'"width=200px></a>
    <h1>'.$produkt['nazwa'].'</h1>
    <h2>'.$produkt['cena_bez_dostawy'].'zł</h2>
    ';

}
?>

</body>
</html>
