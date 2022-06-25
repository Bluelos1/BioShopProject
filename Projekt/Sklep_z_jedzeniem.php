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
if(isset($_POST["dodaj_do_koszyka"])){
    if(isset($_SESSION["cart"])){
        $item_array_id = array_column($_SESSION["cart"], "item_id");
        if(!in_array($_GET["id"],$item_array_id)){
            $count = count($_SESSION["cart"]);
            $item_array = array(
                'item_id' => $_GET["id"],
                'item_name' => $_POST["ukr_name"],
                'item_price' => $_POST["ukr_price"],
                'item_quantity' => $_POST["quantity"]
            );
            $_SESSION["cart"][$count]=$item_array;
        }
        else{
            echo '<script> alert("Produkt został dodany")</script>';
            echo '<script>window.location="Sklep_z_jedzeniem.php"</script>';
        }
    }else{
        $item_array = array(
                'item_id' => $_GET["id"],
                'item_name' => $_POST["ukr_name"],
                'item_price' => $_POST["ukr_price"],
                'item_quantity' => $_POST["quantity"]
        );
        $_SESSION["cart"][0] = $item_array;
    }
}
if(isset($_GET["action"])){
    if($_GET["action"] =="delete"){
        foreach ($_SESSION["cart"] as $keys => $values){
            if($values["item_id"] == $_GET["id"]){
                unset($_SESSION["cart"][$keys]);
                echo '<script> alert("Produkt usunięty")</script>';
                echo '<script>window.location="Sklep_z_jedzeniem.php"</script>';
            }
        }
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
<section id="hero">
    <h1>Bio sklep</h1>
    <h1>Najświeższe warzywka i owocki</h1>

</section>
<?php
while ($produkt=mysqli_fetch_assoc($select)){
    ?>
    <form method="post" action="Sklep_z_jedzeniem.php?action=add&id=<?php echo $produkt["id"]; ?>">
    <div class = "prod">
    <?php echo '<a href = "szczegoly.php?id='.$produkt['id'].'"><img src = "'.$produkt['img'].'"width=200px></a>'?>
    <h2><?php echo $produkt['nazwa']?></h2>
    <h2>Cena bez dostawy: <?php echo $produkt['cena_bez_dostawy']?>zł</h2>
    <h2>Cena z dostawą: <?php echo$produkt['cena_z_dostawa']?>zł</h2>
    <h4>Opis: <?php echo $produkt['opis']?></h4>
    <h4>ilość: <?php echo $produkt['stan']?></h4>
    <input type="text" name="quantity" value="1" class="form-control" />
    <input type="hidden" name="ukr_name" value="<?php echo $produkt["nazwa"]; ?>" />
    <input type="hidden" name="ukr_price" value="<?php echo $produkt["cena_bez_dostawy"]; ?>" />
    <input type="submit" name="dodaj_do_koszyka" style="margin-top:5px;" class="btn btn-success" value="Dodaj do Koszyka" />
    </div>
    </form>
    <?php

}
?>
<div style="clear:both"></div>
<br/>
<h3>Order Details</h3>
<div class="table-responsive">
    <table class="table table-bordered"
           <tr>
               <th width="40%">Nazwa produktu</th>
               <th width="10%">Ilość</th>
               <th width="20%">Cena bez dostawy</th>
               <th width="15%">Suma</th>
               <th width="5%">Akcja</th>
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
        <td><?php echo number_format($values["item_quantity"] * $values["item_price"],2); ?></td>
        <td><a href="Sklep_z_jedzeniem.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Usuń</span></a></td>
    </tr>
    <?php
            $total = $total + ($values["item_quantity"] * $values["item_price"]);
        }
        ?>
    <tr>
        <td colspan="3" align="right">Suma</td>
        <td align="right">$ <?php echo number_format($total, 2); ?></td>
        <td></td>
    </tr>
    <?php
    }
    ?>
    <table
    </div>


</body>
</html>
