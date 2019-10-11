<?php

use PHPUnit\Framework\TestCase;

use App\Utils\Convertisseur;

class ConvertisseurTest extends TestCase{

	/**
     * Lorsqu'on appelle le constructeur, aucune exception n'est levée
     */
    public function test_appelle_le_constructeur()
    {
        $wrapper = new Convertisseur(1);
        $this->assertTrue(true);
    }

    /**
     * La conversion renvoi bien un entier
     */
    public function test_convertisseur_base10_vers_base10_1_renvoi_int()
    {
        $convert = new Convertisseur(1);
        $this->assertInternalType('string', $convert->getResultatConversion("10","10"));
    }

    /**
     * Convertir l'entier 1 de base 10 vers base 10
     */
    public function test_convertisseur_base10_vers_base10_1()
    {
        $convert = new Convertisseur("1");
        $this->assertEquals("1", $convert->getResultatConversion("10","10"));
    }

}

?>