<?php


namespace App\Model\Form\Service;


class PasswordHasher {

    const ENCRYPTION_KEY = '#4ewr%*&()WE3dR@#!@#$^_(*&4wd%$d2';

    /**
     * @param $string
     * @return string
     */
    public function encrypt($string) {
        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext_raw = openssl_encrypt($string, $cipher, self::ENCRYPTION_KEY, $options=OPENSSL_RAW_DATA, $iv);
        $hmac = hash_hmac('sha256', $ciphertext_raw, self::ENCRYPTION_KEY, $as_binary=true);
        $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
        return $ciphertext;
    }


    /**
     * @param $string
     * @return string
     */
    public function decrypt($string) {
        $c = base64_decode($string);
        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
        $iv = substr($c, 0, $ivlen);
        $sha2len=32;
        $ciphertext_raw = substr($c, $ivlen+$sha2len);
        $plaintext = openssl_decrypt($ciphertext_raw, $cipher, self::ENCRYPTION_KEY, $options=OPENSSL_RAW_DATA, $iv);
        return $plaintext;
    }
}