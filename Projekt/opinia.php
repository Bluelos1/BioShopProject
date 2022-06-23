<?php
class opinia{
    private $id_uzytkownia;
    private $id_produktu;
    private $tresc;
    private $ocena;

    /**
     * @param $id_uzytkownia
     * @param $id_produktu
     * @param $tresc
     * @param $ocena
     */
    public function __construct($id_uzytkownia, $id_produktu, $tresc, $ocena)
    {
        $this->id_uzytkownia = $id_uzytkownia;
        $this->id_produktu = $id_produktu;
        $this->tresc = $tresc;
        $this->ocena = $ocena;
    }


    public function add(){
        include 'config.php';
        $insert = "INSERT INTO opinia (id_uzytkownika, id_produktu, tresc, ocena) VALUES ('$this->id_uzytkownia','$this->id_produktu','$this->tresc','$this->ocena')";
        $conn -> query($insert);
    }


}