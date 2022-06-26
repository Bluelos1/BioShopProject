<?php
include "config.php";
session_start ();
$id = $_SESSION[ 'id' ];
$uzytkownik = "select * from user_info where id = '$id'";
$select2 = mysqli_query ( $conn,$uzytkownik );
$uzytkownik = mysqli_fetch_assoc ( $select2 );


if ( isset( $_GET[ "action" ] ) ) {
    if ( $_GET[ "action" ] == "delete" ) {
        foreach ( $_SESSION[ "cart" ] as $keys => $values ) {
            if ( $values[ "item_id" ] == $_GET[ "id" ] ) {
                $idp = $values["item_id"];
                $i = $values["item_quantity"];
                $zapytanie = "update products set stan = stan + '$i' where id = '$idp'";
                mysqli_query ($conn,$zapytanie);
                unset( $_SESSION[ "cart" ][ $keys ] );
                echo '<script> alert("Produkt usunięty")</script>';
                echo '<script>window.location="cart.php"</script>';
            }
        }
    }
}

spl_autoload_register(function ($zamowienie) {
    include $zamowienie . '.php';
});

if(!empty($_POST['dodaj'])) {


    $d=date('d/m/y H:i:s');
    $z = new zamowienie($_SESSION['total'],$_POST['imie'],$_POST['nazwisko'],$_POST['ulica'],$_POST['miasto'],$_POST['kod_pocz'],$_POST['metoda_plat'],$_POST['metoda_dost'],$_POST['numer'],$d,$_SESSION['email']);
    $z->dod();

    unset($_SESSION['koszyk']);
    echo '<script> alert("Zamówiono!")</script>';
    echo '<script> window.location="konto.php"</script>';

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
<div style="clear:both"></div>
<br/>
<h3>Zamów produkty</h3>
<div class="table-responsive">
    <table class="table table-bordered"
    <tr>
        <th width="20%">Nazwa produktu</th>
        <th width="10%">Ilość</th>
        <th width="20%">Cena bez dostawy</th>
        <th width="20%">Cena z dostawą</th>
        <th width="15%">Suma</th>
        <th width="5%">Usuwanie</th>
    </tr>
    <?php
    if(!empty($_SESSION["cart"])){
        $total = 0;
        foreach($_SESSION["cart"]as$keys => $values){
            ?>
            <tr>
                <td><?php echo $values["item_name"];?>
                <td><?php echo $values["item_quantity"];?></td>
                <td><?php echo $values["item_price"];?></td>
                <td><?php echo $values["item_pricez"];?></td>
                <td><?php echo number_format(($values["item_quantity"] * $values["item_price"])+($values["item_pricez"]-$values["item_price"]),2); ?></td>
                <td><a href="cart.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Usuń</span></a></td>
            </tr>
            <?php
            $total = $total + ($values["item_quantity"] * $values["item_price"])+($values["item_pricez"]-$values["item_price"]);
            $_SESSION ["total"] = $total;
        }
        ?>
        <tr>
            <td></td>
            <td colspan="3" align="right">Suma</td>

            <td align="left"> <?php echo number_format($total, 2); ?>zł</td>
            <td></td>
        </tr>
        <?php
    }
    ?>
    </table>
</div>

<?php
 if(!empty($_SESSION['cart']))
        {
?>

<form method="post" class="prod1">
    <h3>Formularz zamówienia:</h3>
    <input pattern="[[:alpha:]]+" type="text" name="imie" placeholder="imię" required>
    <input pattern="[[:alpha:]]+" type="text" name="nazwisko" placeholder="nazwisko" required>
    <input pattern="\d{9}" type="text" name="numer" placeholder="numer telefonu" required>
    <input pattern="[[:alpha:]]+" type="text" name="miasto" placeholder="miasto" required>
    <input type="text" name="ulica" placeholder="ulica" required>
    <input pattern="^[_0-9]{2}-[_0-9]{3}$" type="text" name="kod_pocz" placeholder="kod pocztowy" required>
    <select name="metoda_plat">
        <option value="BLIK">BLIK</option>
        <option value="Za pobraniem">Za pobraniem</option>
        <option value="Przelew">Przelew</option>
    </select>
    <select name="metoda_dost">
        <option value="Paczkomat" >Paczkomat</option>
        <option value="Poczta_Polska" >Poczta Polska</option>
        <option value="Kurier">Kurier</option>
        <option value="Odbiór w punkcie">Odbiór w punkcie</option>
    </select>
    <input type="submit" name="dodaj" value="Kup">
</form>
<?php
        }
?>


</body>
</html>
