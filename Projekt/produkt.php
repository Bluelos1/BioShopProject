<?php
class produkt{
    private $img;
    private $nazwa;
    private $cena_z_dostawa;
    private $cena_bez_dostawy;
    private $opis_duzy;
    private $opis;
    private $rodzaj;
    private $ocena;

    /**
     * @param $img
     * @param $nazwa
     * @param $cena_z_dostawa
     * @param $cena_bez_dostawy
     * @param $opis_duzy
     * @param $opis
     * @param $rodzaj
     * @param $ocena
     */
    public function __construct($img, $nazwa, $cena_z_dostawa, $cena_bez_dostawy, $opis_duzy, $opis, $rodzaj, $ocena)
    {
        $this->img = $img;
        $this->nazwa = $nazwa;
        $this->cena_z_dostawa = $cena_z_dostawa;
        $this->cena_bez_dostawy = $cena_bez_dostawy;
        $this->opis_duzy = $opis_duzy;
        $this->opis = $opis;
        $this->rodzaj = $rodzaj;
        $this->ocena = $ocena;
    }
    public function add(){
        include 'config.php';
        $insert = "INSERT INTO products  (img, nazwa, cena_z_dostawa, cena_bez_dostawy, opis_duzy, opis, rodzaj, ocena) VALUES ('$this->img','$this->nazwa','$this->cena_z_dostawa','$this->cena_bez_dostawy','$this->opis_duzy','$this->opis_duzy','$this->opis','$this->rodzaj','$this->ocena')";
        $conn -> query($insert);
    }


}
