<?php
include 'config.php';
session_start();
$id = $_SESSION[ 'id' ];
$uzytkownik = "select * from user_info where id = '$id'";
$select2 = mysqli_query ( $conn,$uzytkownik );
$uzytkownik = mysqli_fetch_assoc ( $select2 );
$id = $_GET['id'];
$idu=$_SESSION['id'];
$produkt = "SELECT * FROM products where id = '$id'";
$select = mysqli_query($conn,$produkt);
$produkt1 = "SELECT * FROM opinia where id_produktu = '$id'";
$wysopinia = mysqli_query($conn,$produkt1);
$osoba = "SELECT * FROM opinia Join user_info on opinia.id_uzytkownika = user_info.id where id_produktu = '$id'";
$select3 = mysqli_query($conn,$osoba);

if ( isset( $_POST[ "dodaj_do_koszyka" ] ) ) {
    if ( isset( $_SESSION[ "cart" ] ) ) {
        $item_array_id = array_column ( $_SESSION[ "cart" ],"item_id" );
        $quantity = $_POST["quantity"];
        $_SESSION["iloscdb"] = $_POST["iloscdb"];
        $_SESSION["produkt_id"] = $_POST["produkt_id"];
        $_SESSION["ile"] = $_POST["quantity"];
        $zapytanie = "update products set stan = stan - '$quantity' where id = '$id'";
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
            echo '<script>window.location="szczegoly.php?id='.$id.'</script>';

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
}

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
<section id="header">

    <div>

        <ul id="bar">
            <a href="Sklep_z_jedzeniem.php"><img src="img/logo.png" class="logo" id="logo" alt=""></a>
            <li><a class="active" href="Sklep_z_jedzeniem.php">      Home</a></li>
            <li><a href="konto.php">Konto</a></li>
            <?php
            if ( !empty( $_SESSION[ 'id' ] ) ) {
                echo 'zalogowano jako: ' . $uzytkownik[ 'name' ];
                echo '<li><a href = "wyloguj.php">    Wyloguj</a>';
            } else {
                echo '<li><a href="login.php">Login</a>';
            }
            ?>
            <li><a href="cart.php"><i class="far fa-shopping-cart"></i></a></li>

        </ul>
    </div>
</section>
<?php

while ($produkt=mysqli_fetch_assoc($select)){
    ?>
<form method="post" action="szczegoly.php?action=add&id=<?php echo $produkt[ "id" ]; ?>">
    <div class = "prod1">
    <img src = "<?php echo $produkt['img']?>"width=200px>
    <h1><?php echo$produkt['nazwa']?></h1>
    <h2>Cena bez dostawy: <?php echo $produkt['cena_bez_dostawy']?>zł</h2>
    <h2>Cena z dostawą: <?php echo $produkt['cena_z_dostawa']?>zł</h2>
    <h4>Opis szczegółowy: <?php echo $produkt['opis_duzy']?></h4>
        <h4>ilość: <?php echo $produkt[ 'stan' ] ?></h4>
        <input type="number" name="quantity" value="1" style="width: 100px"/>
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

<form method="post" class = "prod1">
    <h2>opinia:</h2>
    <input type="text" required name="opinia">
    <h2>ocena:</h2>
    <input type="number" required name="ocena" min="1" max="5">
    <input type="submit" name="submit">
</form>
<?php
echo'<h3 class="prod1">Opinie uzytkownikow:</h3>';
while($produkt1=mysqli_fetch_assoc($select3)){
    echo'<div class="prod"> <h4 class="prod1">'.$produkt1['name'].'</h4>
    <h4 class="prod1">'.$produkt1['tresc'].'</h4>
    <h4 class="prod1">Ocena:'.$produkt1['ocena'].'/5</h4></div>';
}
?>
</body>
</html>

<?php

if(!empty($_POST['submit'])) {
    $id = $_GET[ 'id' ];
    $idu = $_SESSION[ 'id' ];
    $db = mysqli_select_db ( $conn,'dieta_sklep_hindus' );
    $zapytanie = "SELECT user_info.id from user_info join opinia on user_info.id=opinia.id_uzytkownika where user_info.id='$idu' and id_produktu='$id'";
    $wynik = mysqli_query ( $conn,$zapytanie );
    $liczba = mysqli_num_rows ( $wynik );


    if ( $liczba > 0 ) {
        echo '<script>alert("dodaleś już opinie")</script>';
    } else {
        $opinia = new opinia( $idu,$id,$_POST[ 'opinia' ],$_POST[ 'ocena' ] );
        $opinia->add ();
    }
}








