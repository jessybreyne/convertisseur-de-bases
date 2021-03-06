<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Routing\Annotation\Route;

use App\Utils\Convertisseur;

class ConvertisseurController extends AbstractController{
    
    /**
    * @Route("/", methods={"GET"})
    */
    public function accueil(){
        return $this->render('convertisseur/accueil.html.twig');
    }
    
    /**
    * @Route("/", methods={"POST"})
    */
    public function getConversion(){
        $nb = $_POST['nb'];
        $baseInitiale = $_POST['initiale'];
        $baseFinale = $_POST['finale'];
        $convert = new Convertisseur($nb);
        $res = $convert->getResultatConversion($baseInitiale, $baseFinale);
        if($res[0]==1){
            return $this->render('convertisseur/accueil.html.twig', [
                'erreur'=>$res[1]
                ]);
        }elseif($res[0]==0){
            return $this->render('convertisseur/accueil.html.twig', [
                'resultat'=>$res[1],
                'baseInitiale'=>$baseInitiale,
                'baseFinale'=>$baseFinale,
                'nombre'=>$nb
                ]);
        }

        
    }
    
}