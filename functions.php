<?php
define('SECRET_KEY', 'sfarcab@lpsolutions'); // Change this to a secure key

// Function to encrypt data
function encryptData($data) {
    $key = SECRET_KEY;
    $iv = substr(hash('sha256', $key), 0, 16); // Generate IV from key
    return base64_encode(openssl_encrypt(json_encode($data), "AES-256-CBC", $key, 0, $iv));
}

// Function to decrypt data
function decryptData($encryptedData) {
    $key = SECRET_KEY;
    $iv = substr(hash('sha256', $key), 0, 16);
    return json_decode(openssl_decrypt(base64_decode($encryptedData), "AES-256-CBC", $key, 0, $iv), true);
}
?>
