<?php
namespace App\Utils;

class Convertisseur{

    private $nb;
    private $signe;

    // le constructeur a le nombre absolue et son signe
    public function __construct($nombreAConvertir){
        $this->nb = self::getAbsolue($nombreAConvertir);
        $this->signe = self::getSigne($nombreAConvertir);
    }

    // garde le nombre sans le signe
    public function getAbsolue($nombreAConvertir){
        $tab = str_split($nombreAConvertir, 1);
        if($tab[0]=="-"){
            unset($tab[0]);
            $res="";
            foreach ($tab as $x) {
                $res = $res."".$x;
            }
            return $res;
        }else{
            return $nombreAConvertir;
        }
    }

    // garde en mémoire le signe du nombre de depart
    public function getSigne($nombreAConvertir){
        $tab = str_split($nombreAConvertir, 1);
        if($tab[0]=="-"){
            return "-";
        }else{
            return "";
        }
    }

    // prends un chiffre romain et donne son decimal
    public function getDecimalDuNbRomain($romain){
        $tab = str_split($romain, 1);
        $res=0;
        for ($i=0; $i < sizeof($tab); $i++) { 
            if($tab[$i]=="M"){
                $res+=1000;
            }elseif($tab[$i]=="D"){
                $res+=500;
            }elseif($tab[$i]=="C"){
                $res+=100;
            }elseif($tab[$i]=="L"){
                $res+=50;
            }elseif($tab[$i]=="X"){
                $res+=10;
            }elseif($tab[$i]=="V"){
                $res+=5;
            }elseif($tab[$i]=="I"){
                if(!isset($tab[$i+1])){
                    $res+=1;
                }elseif($tab[$i+1]!="I"){
                    $res-=1;
                }else{
                    $res+=1;
                }
            }
        }
        return "".$res;
    }

    // retourne une liste avec 1 si erreur, 0 si pas d'erreur et le resultat ou le message d'erreur
    public function getResultatConversion($baseInitiale, $baseFinale){

        if($baseInitiale=="romain"){
            $nombreTraitable = self::getDecimalDuNbRomain($this->nb);
            $problemeBaseInitiale = false;
            $problemeBaseDuNombreDepart = false;
            $baseInitiale = 10;
        }else{
            $nombreTraitable = $this->nb;
            $problemeBaseInitiale = self::problemeBaseInitiale($baseInitiale);
            $problemeBaseDuNombreDepart = self::problemeBaseDuNombreDepart($baseInitiale, $nombreTraitable);
        }

        $problemeBaseFinale = self::problemeBaseFinale($baseFinale);

        
        if($problemeBaseInitiale){
            return array(1, $problemeBaseInitiale);
        }
        elseif($problemeBaseFinale){
            return array(1, $problemeBaseFinale);
        }
        elseif($problemeBaseDuNombreDepart){
            return array(1, $problemeBaseDuNombreDepart);
        }
        else{
            $nombreDec = self::getBaseNvers10($baseInitiale, $nombreTraitable);
            $res = $this->signe."".self::getBase10versN($baseFinale, $nombreDec);
            if($res=="" or $res=="-"){
                $res="0";
            }
            return array(0, $res);
        }
    }

    // converti un nombre d'une base entre 2 et 62 en decimale
    public function getBaseNvers10($baseInitiale, $nombreEnBaseN){
        $symboles = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z','A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

        $nbDec = 0;
        $poids = strlen($nombreEnBaseN) - 1;

        $tabDuNb = str_split($nombreEnBaseN, 1);

        foreach ($tabDuNb as $nbPasJuste) {
            $tabDuNbJuste[] = array_search($nbPasJuste, $symboles);
        }

        foreach ($tabDuNbJuste as $x) {
            $nbDec += $x * pow($baseInitiale, $poids);
            $poids -= 1;
        }

        return $nbDec;
    }

    // converti un nombre de décimale vers une base entre 2 et 62
    public function getBase10versN($baseFinale, $nombreDecimal){
        $symboles = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z','A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
        $nbChars = strlen($nombreDecimal)-1;        
        $res = "";
        $listPoids = range(0, $nbChars);
        $listRestes = array();
        
        while ($nombreDecimal!=0) {
            $reste = $nombreDecimal % $baseFinale;
            $nombreDecimal = intval($nombreDecimal / $baseFinale);
            $listRestes[] = $reste;
        }
        $listRestes = array_reverse($listRestes);
        foreach ($listRestes as $x) {
            $res = $res."".$symboles[$x];
        }
        
        return $res;
    }

    // regarde si le nombre de depart est correct
    public function problemeBaseDuNombreDepart($baseInitiale, $nombre){
        $symboles = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z','A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
        $tabDuNb = str_split($nombre, 1);

        foreach ($tabDuNb as $caractere) {
            if(!in_array($caractere, $symboles) or array_search($caractere, $symboles)>$baseInitiale){
                return "Erreur, le nombre en entré n'est pas en base ".$baseInitiale.".";
            }
        }
        return false;
    }

    // regarde si la base initiale est correcte
    public function problemeBaseInitiale($baseInitiale){
        if(is_numeric($baseInitiale) and $baseInitiale<63 and $baseInitiale>1){
            return false;
        }
        else{
            return "La base initiale est incorrecte.";
        }
    }

    // regarde si la base finale est correcte
    public function problemeBaseFinale($baseFinale){
        if(is_numeric($baseFinale) and $baseFinale<63 and $baseFinale>1){
            return false;
        }
        else{
            return "La base finale est incorrecte.";
        }
    }
    
}