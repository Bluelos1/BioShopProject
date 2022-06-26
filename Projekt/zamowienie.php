<?php

class zamowienie
{
    private $koszt;
private $imie;
private $nazwisko;
private $ulica;
private $miasto;
private $kod_pocz;
private $metoda_plat;
private $metoda_dost;
private $numer;
private $data;
private $email;

    /**
     * @param $imie
     * @param $nazwisko
     * @param $ulica
     * @param $miasto
     * @param $kod_pocz
     * @param $metoda_plat
     * @param $metoda_dost
     * @param $numer
     * @param $data
     * @param $email
     */
    public function __construct($koszt,$imie,$nazwisko,$ulica,$miasto,$kod_pocz,$metoda_plat,$metoda_dost,$numer,$data,$email)
    {
        $this->koszt = $koszt;
        $this->imie = $imie;
        $this->nazwisko = $nazwisko;
        $this->ulica = $ulica;
        $this->miasto = $miasto;
        $this->kod_pocz = $kod_pocz;
        $this->metoda_plat = $metoda_plat;
        $this->metoda_dost = $metoda_dost;
        $this->numer = $numer;
        $this->data = $data;
        $this->email = $email;
    }
    function dod(){
        include 'config.php';
        $query = "Insert into zamowienie(koszt,imie, nazwisko, ulica, miasto, kod_pocz, metoda_plat, metoda_dost, numer, data, email) values ('$this->koszt','$this->imie','$this->nazwisko','$this->ulica','$this->miasto','$this->kod_pocz','$this->metoda_plat','$this->metoda_dost','$this->numer','$this->data','$this->email')";
        $conn -> query($query);
    }



}