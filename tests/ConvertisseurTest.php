<?php

use PHPUnit\Framework\TestCase;

use App\Utils\Convertisseur;

class ConvertisseurTest extends TestCase{

	/**
     * Lorsqu'on appelle le constructeur, aucune exception n'est levée
     */
    public function test_appelle_le_constructeur()
    {
        $wrapper = new Convertisseur("1");
        $this->assertTrue(true);
    }

    /**
     * La conversion renvoi bien un array
     */
    public function test_convertisseur_base10_vers_base10_1_renvoi_array()
    {
        $convert = new Convertisseur("1");
        $this->assertInternalType("array", $convert->getResultatConversion("10","10"));
    }

    /**
     * Convertir 1 de base 10 vers base 10
     */
    public function test_convertisseur_base10_vers_base10_1()
    {
        $convert = new Convertisseur("1");
        $this->assertEquals(array(0,"1"), $convert->getResultatConversion("10","10"));
    }

    /**
     * Convertir 10 de base 2 vers base 10
     */
    public function test_convertisseur_base2_vers_base10_1()
    {
        $convert = new Convertisseur("10");
        $this->assertEquals(array(0,"2"), $convert->getResultatConversion("2","10"));
    }

    /**
     * Convertir 2 de base 10 vers base 2
     */
    public function test_convertisseur_base10_vers_base2_2()
    {
        $convert = new Convertisseur("2");
        $this->assertEquals(array(0,"10"), $convert->getResultatConversion("10","2"));
    }

    /**
     * Convertir 1234 de base N vers base 10
     */
    public function test_convertisseur_baseN_vers_base10_1234()
    {
        $convert = new Convertisseur("1234");
        $this->assertEquals(array(0,"194"), $convert->getResultatConversion("5","10"));
        $this->assertEquals(array(0,"4660"), $convert->getResultatConversion("16","10"));
    }

    /**
     * Convertir 1234 de base 10 vers base N
     */
    public function test_convertisseur_base10_vers_baseN_1234()
    {
        $convert = new Convertisseur("1234");
        $this->assertEquals(array(0,"10011010010"), $convert->getResultatConversion("10","2"));
        $this->assertEquals(array(0,"4d2"), $convert->getResultatConversion("10","16"));
    }

    /**
     * Convertir negatifs
     */
    public function test_convertisseur_negatif()
    {
        $convert = new Convertisseur("-1234");
        $this->assertEquals(array(0,"-10011010010"), $convert->getResultatConversion("10","2"));
        $this->assertEquals(array(0,"-4d2"), $convert->getResultatConversion("10","16"));
        $this->assertEquals(array(0,"-194"), $convert->getResultatConversion("5","10"));
        $this->assertEquals(array(0,"-4660"), $convert->getResultatConversion("16","10"));
    }

}

?>