<?php


namespace App\Manager;


Abstract class AppManager
{
    const PRM_DATE = 17.04;
    const CSPE = 22.50;
    const CTA = 27.04;
    const CIPHERING = 'AES-128-CTR';
    const OPTION = 0;
    const ENCRYPT_IV = '1234567891011121';
    const ENCRYPT_KEY = 'GoProGoogleMax';
    const TLE_C5 = 9.90;
    const TLE_C4_INF_250_KVA = 3.30;
    const TLE_C2_C3_INF_216_KVA = 3.30;

    public static function calculPartFixe($d3, $n7, $i3, $h3, $o7, $j3, $p7, $k3, $q7):float {
        return $d3*$n7+($i3-$h3)*$o7+($j3-$i3)*$p7+($k3-$j3)*$q7;
    }

    public static function calculPartVariable($h3, $n10, $i3, $o10, $j3, $p10, $k3, $q10):float {
        return ($h3*$n10)+($i3*$o10)+($j3*$p10)+($k3*$q10);
    }


    /**
     * @return false|string
     */
    public static function encrypt(string $plaintext)
    {
        return openssl_encrypt($plaintext, self::CIPHERING, self::ENCRYPT_KEY, self::OPTION, self::ENCRYPT_IV);
    }

    /**
     * @return false|string
     */
    public static function decrypt(string $encryption)
    {
        return openssl_decrypt($encryption, self::CIPHERING, self::ENCRYPT_KEY, self::OPTION, self::ENCRYPT_IV);
    }
}