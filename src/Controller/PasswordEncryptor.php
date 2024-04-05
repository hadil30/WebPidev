<?php

// src/Utils/PasswordEncryptor.php

namespace App\Controller;

use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class PasswordEncryptor
{
    private $secretKey;
    private $salt;

    public function __construct(string $secretKey, string $salt)
    {
        $this->secretKey = $secretKey;
        $this->salt = $salt;
    }

    public function encrypt(string $strToEncrypt): string
    {
        try {
            // Générer une clé secrète
            $factory = new \Symfony\Component\Security\Core\Encoder\Pbkdf2PasswordEncoder(null, null, null, 65536, 256);
            $encodedSecretKey = $factory->encodePassword($this->secretKey, $this->salt);
            $secretKey = base64_decode($encodedSecretKey);

            // Initialiser le chiffrement
            $cipher = 'AES-256-CBC';
            $ivLength = openssl_cipher_iv_length($cipher);
            $iv = openssl_random_pseudo_bytes($ivLength);
            $encrypted = openssl_encrypt($strToEncrypt, $cipher, $secretKey, OPENSSL_RAW_DATA, $iv);

            if ($encrypted === false) {
                throw new \Exception('Erreur lors du chiffrement.');
            }

            return base64_encode($encrypted);
        } catch (\Exception $e) {
            throw new BadCredentialsException('Erreur lors du chiffrement : ' . $e->getMessage());
        }
    }

    public function decrypt(string $strToDecrypt): string
    {
        try {
            // Générer une clé secrète
            $factory = new \Symfony\Component\Security\Core\Encoder\Pbkdf2PasswordEncoder(null, null, null, 65536, 256);
            $encodedSecretKey = $factory->encodePassword($this->secretKey, $this->salt);
            $secretKey = base64_decode($encodedSecretKey);

            // Initialiser le déchiffrement
            $cipher = 'AES-256-CBC';
            $ivLength = openssl_cipher_iv_length($cipher);
            $iv = substr($this->salt, 0, $ivLength);
            $decrypted = openssl_decrypt(base64_decode($strToDecrypt), $cipher, $secretKey, OPENSSL_RAW_DATA, $iv);

            if ($decrypted === false) {
                throw new \Exception('Erreur lors du déchiffrement.');
            }

            return $decrypted;
        } catch (\Exception $e) {
            throw new BadCredentialsException('Erreur lors du déchiffrement : ' . $e->getMessage());
        }
    }
}
