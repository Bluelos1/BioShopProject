<?php
include 'config.php';
session_start ();
$produkt = "SELECT * FROM products";
$id = $_SESSION[ 'id' ];
$uzytkownik = "select * from user_info where id = '$id'";
$select = mysqli_query ( $conn,$produkt );
$select2 = mysqli_query ( $conn,$uzytkownik );
$uzytkownik = mysqli_fetch_assoc ( $select2 );
if ( empty( $_SESSION[ 'id' ] ) ) {
    $_SESSION[ 'id' ] = 0;
}
if ( isset( $_POST[ "dodaj_do_koszyka" ] ) ) {
    if ( isset( $_SESSION[ "cart" ] ) ) {
        $item_array_id = array_column ( $_SESSION[ "cart" ],"item_id" );
        $quantity = $_POST["quantity"];
        $_SESSION["iloscdb"] = $_POST["iloscdb"];
        $_SESSION["produkt_id"] = $_POST["produkt_id"];
        $_SESSION["ile"] = $_POST["quantity"];
        $produkt_id = $_POST["produkt_id"];
        $zapytanie = "update products set stan = stan - '$quantity' where id = '$produkt_id'";
        mysqli_query ($conn,$zapytanie);
        if ( !in_array ( $_GET[ "id" ],$item_array_id ) ) {
            $count = count ( $_SESSION[ "cart" ] );
            $item_array = array (
                'item_id' => $_GET[ "id" ],
                'item_name' => $_POST[ "ukr_name" ],
                'item_price' => $_POST[ "ukr_price" ],
                'item_pricez' => $_POST[ "ukr_pricez" ],
                'item_quantity' => $_POST[ "quantity" ]
            );
            $_SESSION[ "cart" ][ $count ] = $item_array;

        } else {
            echo '<script> alert("Produkt został dodany")</script>';
            echo '<script>window.location="Sklep_z_jedzeniem.php"</script>';

        }
    } else {
        $item_array = array (
            'item_id' => $_GET[ "id" ],
            'item_name' => $_POST[ "ukr_name" ],
            'item_price' => $_POST[ "ukr_price" ],
            'item_pricez' => $_POST[ "ukr_pricez" ],
            'item_quantity' => $_POST[ "quantity" ]
        );
        $_SESSION[ "cart" ][ 0 ] = $item_array;

    }

}?>

<!Doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Pudełka</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
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
            if ( !empty( $_SESSION[ 'id' ] ) ) {
                echo 'zalogowano jako: ' . $uzytkownik[ 'name' ];
                echo '<li><a href = "wyloguj.php">Wyloguj</a>';
            } else {
                echo '<li><a href="login.php">Login</a>';
            }
            ?>
            <li><a href="cart.php"><i class="far fa-shopping-cart"></i></a></li>

        </ul>
    </div>
</section>
<section id="hero">
    <h1>Bio sklep</h1>
    <h1>Najświeższe warzywka i owocki</h1>

</section>
<div class="prod">
    <h4>Filtrowanie</h4>
    <form method="post">
        <select name="cena">
            <option value="rosnaco">Cena rosnaco</option>
            <option value="malejaco">Cena malejaco</option>
        </select>
        Cena od:
        <input type="text" name="cenaOd" pattern="\d+" placeholder="od">
        Cena do:
        <input type="text" name="cenaDo" pattern="\d+" placeholder="od">
        <input type="submit" name="sortuj" value="sortuj" class="btn btn-success">
    </form>
</div>
<?php

//sortowanie
if ( empty( $_POST[ 'sortuj' ] ) ) {
    $sort = "SELECT * FROM products";
    $select = mysqli_query ( $conn,$sort );
} else {
    if ( $_POST[ 'cena' ] == "rosnaco" ) {
        if ( $_POST[ 'cenaOd' ] == null || $_POST[ 'cenaDo' ] == null ) {
            $sort = "SELECT * FROM products order by cena_bez_dostawy ";
            $select = mysqli_query ( $conn,$sort );
        } else {
            $cenaOd = $_POST[ 'cenaOd' ];
            $cenaDo = $_POST[ 'cenaDo' ];
            $sort = "SELECT * FROM products where cena_bez_dostawy between '$cenaOd' and '$cenaDo' order by cena_bez_dostawy ";
            $select = mysqli_query ( $conn,$sort );
        }
    } elseif ( $_POST[ 'cena' ] == "malejaco" ) {
        if ( $_POST[ 'cenaOd' ] == null || $_POST[ 'cenaDo' ] == null ) {
            $sort = "SELECT * FROM products order by cena_bez_dostawy desc";
            $select = mysqli_query ( $conn,$sort );
        } else {
            $cenaOd = $_POST[ 'cenaOd' ];
            $cenaDo = $_POST[ 'cenaDo' ];
            $sort = "SELECT * FROM products where cena_bez_dostawy between '$cenaOd' and '$cenaDo' order by cena_bez_dostawy desc";
            $select = mysqli_query ( $conn,$sort );
        }
    }

}
?>
<?php
while ( $produkt = mysqli_fetch_assoc ( $select ) ) {
    ?>
    <form class="ccc" method="post" action="Sklep_z_jedzeniem.php?action=add&id=<?php echo $produkt[ "id" ]; ?>">
        <div class="prod2" >
            <?php echo '<a href = "szczegoly.php?id=' . $produkt[ 'id' ] . '"><img src = "' . $produkt[ 'img' ] . '"width=200px></a>' ?>
            <h2><?php echo $produkt[ 'nazwa' ] ?></h2>
            <h2>Cena bez dostawy: <?php echo $produkt[ 'cena_bez_dostawy' ] ?>zł</h2>
            <h2>Cena z dostawą: <?php echo $produkt[ 'cena_z_dostawa' ] ?>zł</h2>
            <h4>Opis: <?php echo $produkt[ 'opis' ] ?></h4>
            <h4>ilość: <?php echo $produkt[ 'stan' ] ?></h4>
            <input type="number" name="quantity" value="1" class="form-control"/>
            <input type="hidden" name="iloscdb" value="<?php echo $produkt["stan"];?>"/>
            <input type="hidden" name="produkt_id" value="<?php echo $produkt["id"];?>"/>
            <input type="hidden" name="ukr_name" value="<?php echo $produkt[ "nazwa" ]; ?>"/>
            <input type="hidden" name="ukr_price" value="<?php echo $produkt[ "cena_bez_dostawy" ]; ?>"/>
            <input type="hidden" name="ukr_pricez" value="<?php echo $produkt[ "cena_z_dostawa" ]; ?>"/>
            <input type="submit" name="dodaj_do_koszyka" style="margin-top:5px;" class="btn btn-success"
                   value="Dodaj do Koszyka"/>
        </div>
    </form>
    <?php
}

?>




</body>
</html>
