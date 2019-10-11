<?php
namespace App\Utils;

class Convertisseur{

    private $nb;

    public function __construct($nombreAConvertir){
        $this->nb = $nombreAConvertir;
    }

    public function getResultatConversion($baseInitiale, $baseFinale){

        $symboles = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
        $nbDec = 0;

        $poids = strlen($this->nb) - 1;

        $tabDuNb = str_split($this->nb, 1);

        foreach ($tabDuNb as $x) {
            $nbDec += $x * pow($baseInitiale, $poids);
            $poids -= 1;
        }

        $nbChars = strlen($nbDec)-1;

        $res = "";

        $listPoids = range(0, $nbChars);

        $listRestes = array();

        while ($nbDec!=0) {
            $reste = $nbDec % $baseFinale;
            $nbDec = intval($nbDec / $baseFinale);
            $listRestes[] = $reste;

            $res = $res."".$symboles[$x];
        }
        return $res;
    }

    public function getResultatConversion2($baseInitiale, $baseFinale){

        $symboles = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
        
        
        $nbDec = 0;
        $poids = strlen($this->nb) - 1;
        $tabDuNb = str_split($this->nb, 1);
        foreach ($tabDuNb as $x) {
            $nbDec += $x * pow($baseInitiale, $poids);
            $poids -= 1;
        }

        $nbChars = log($nbr_dec)/log($baseFinale) + 1;

        $res = "";

        $listPoids = range(0, $nbChars);
        foreach ($listPoids as $poids) {
            $x = $nbDec / pow($baseFinale, $nbChars-1-$poids);
            $nbDec -= $x * pow($baseFinale, $nbChars-1-$poids);
            $res = $res."".$symboles[$x];
        }
        return $res;
    }
}