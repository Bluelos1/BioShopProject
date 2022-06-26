<?php

include "config.php";
session_start ();
$produkt = "SELECT * FROM products";
error_reporting(0);
$select4 = mysqli_query ( $conn,$produkt );
$id = $_SESSION[ 'id' ];
$uzytkownik = "select * from user_info where id = '$id'";
$select2 = mysqli_query ( $conn,$uzytkownik );
$uzytkownik = mysqli_fetch_assoc ( $select2 );
$email = $_SESSION['email'];
$opinie="Select nazwa,tresc,img,opinia.ocena from opinia join products on products.id = opinia.id_produktu where id_uzytkownika = '$id'";
$select = mysqli_query ($conn,$opinie);
$zamowienie = "Select * FROM zamowienie where email = '$email'";
$select3 = mysqli_query ($conn,$zamowienie);

if (isset($_POST['usun'])){
    $delete1 = "DELETE FROM opinia WHERE id_uzytkownika='$id'";
    mysqli_query($conn,$delete1);
    $delete = "DELETE FROM user_info WHERE id='$id'";
    mysqli_query($conn,$delete);
    session_destroy();
    header("Location: Sklep_z_jedzeniem.php");

}

if (isset($_POST['submit'])){
    $uppercase = preg_match('@[A-Z]@', $_POST['haslo']);
    $lowercase = preg_match('@[a-z]@', $_POST['haslo']);
    $number    = preg_match('@[0-9]@', $_POST['haslo']);
    $specialChars = preg_match('@[^\w]@', $_POST['haslo']);

    if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($_POST['haslo']) < 8) {
        echo '<div class="alert alert-warning" style="text-align: center">
                    <strong>Słabe hasło musi mieć 8 liter,znak specialny i conajmniej jedna liczbe</strong> 
            </div>';
    }
    elseif(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        if ($_POST['haslo'] === $_POST['potwierdzHaslo']) {
            $newNazwa = mysqli_real_escape_string($conn, $_POST['nazwa']);
            $newEmail = mysqli_real_escape_string($conn, $_POST['email']);
            $newHaslo = mysqli_real_escape_string($conn, md5($_POST['haslo']));
            $updateQuery = "UPDATE user_info SET name='$newNazwa',email='$newEmail',password='$newHaslo' WHERE email='$email'";
            mysqli_query($conn, $updateQuery);
            $_SESSION['email'] = $newEmail;
            $email = $_SESSION['email'];
            header("Location: konto.php");
        }
        else{
            echo '<div class="alert alert-warning" style="text-align: center">
                      <strong>Pole haslo oraz potwierdz haslo musza byc takie same</strong> 
                  </div>';
        }
    }
    else{
        echo '<div class="alert alert-warning" style="text-align: center">
                      <strong>niepoprawny email</strong> 
                  </div>';
    }

}

?>
<!Doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Pudełka</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<section id="header">

    <div>

        <ul id="bar">
            <a href="Sklep_z_jedzeniem.php"><img src="img/logo.png" class="logo" id="logo" alt=""></a>
            <li><a class="active" href="Sklep_z_jedzeniem.php">Home</a></li>
            <li><a href="konto.php">Konto</a></li>
            <?php
            if(!empty($_SESSION['id'])){
                echo'zalogowano jako: '.$uzytkownik['name'];
                echo'<li><a href = "wyloguj.php">Wyloguj</a>';
            }else{
                echo '<li><a href="login.php">Login</a>';
            }
            ?>
            <li><a href="cart.php"><i class="far fa-shopping-cart"></i></a></li>

        </ul>
    </div>
</section>
<div class="prod">
    <h3>zmień dane</h3>
    <form method="post">
        <input type="text" name="nazwa" required placeholder="wpisz nową nazwe" class="box">
        <input type="text" name="email" required placeholder="wpisz nowy email" class="box">
        <input type="password" name="haslo" required placeholder="wpisz nowe haslo" class="box">
        <input type="password" name="potwierdzHaslo" required placeholder="potwierdz haslo" class="box">
        <input class="btn btn-default btn-sm" type="submit" name="submit" value="Zmien dane">
    </form>

    <form method="post">


        <input class="btn btn-warning btn-sm" type="submit" name="usun" value="Usun konto">
    </form>

</div>

<?php
while($opinie = mysqli_fetch_assoc($select )) {
    echo '
    <br>
       <form method="post" class="prod">
       <h1>Twoje opinie o danym produkcie:</h1>
      <img src="'.$opinie['img'].'" width="200px">
    <h3>' . $opinie['nazwa'] . '</h3>
   <h3>Opinia: ' . $opinie['tresc'] . '</h3>
    <h3>Ocena' . $opinie['ocena'] . '/5 </h3>
 </form>
    ';
}
?>
<h3 style="text-align: center">Historia zamówień</h3>
<?php

while($zamowienie = mysqli_fetch_assoc($select3)) {
    echo'<br>
<form method="post" class="prod">
    
    <h6>Koszt: ' . $zamowienie['koszt'] . 'zł</h6>
   <h6>Imie: ' . $zamowienie['imie'] . '</h6>
    <h6>Nazwisko: ' . $zamowienie['nazwisko'] . '</h6>
    <h6>Ulica: ' . $zamowienie['ulica'] . '</h6>
    <h6>Miasto: ' . $zamowienie['miasto'] . '</h6>
    <h6>Kod pocztowy: ' . $zamowienie['kod_pocz'] . '</h6>
    <h6>Metoda płatności: ' . $zamowienie['metoda_plat'] . '</h6>
    <h6>Metoda dostawy: ' . $zamowienie['metoda_dost'] . '</h6>
    <h6>Numer telefonu: ' . $zamowienie['numer'] . '</h6>
    <h6>Data przesyłki: ' . $zamowienie['data'] . '</h6>
    <h6>Email: ' . $zamowienie['email'] . '</h6>
 </form>
    ';
}
?>




</body>
</html>
