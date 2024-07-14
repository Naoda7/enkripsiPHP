<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $code = $_POST['code'];
    $key = $_POST['key'];
    $iv = $_POST['iv'];

    // Ensure the key and IV are of the correct length for AES-256-CBC
    if (strlen($key) !== 32 || strlen($iv) !== 16) {
        die('Key must be 32 characters and IV must be 16 characters.');
    }

    // Encrypt the code
    $encryptedCode = openssl_encrypt($code, 'aes-256-cbc', $key, 0, $iv);

    if ($encryptedCode === false) {
        die('Encryption failed.');
    }

    // Encode the encrypted code with Base64
    $encryptedCodeBase64 = base64_encode($encryptedCode);

    // Prepare the PHP code to be executed
    $executableCode = "<?php\n" .
                      '$key = "' . $key . '";' . "\n" .
                      '$iv = "' . $iv . '";' . "\n" .
                      '$encryptedCodeBase64 = "' . $encryptedCodeBase64 . '";' . "\n" .
                      '$encryptedCode = base64_decode($encryptedCodeBase64);' . "\n" .
                      '$decryptedCode = openssl_decrypt($encryptedCode, "aes-256-cbc", $key, 0, $iv);' . "\n" .
                      'eval("?>".$decryptedCode);' . "\n" .
                      "?>";

    // Output the executable code
    echo '<h2>Encrypted PHP Code</h2>';
    echo '<textarea rows="20" cols="80">' . htmlspecialchars($executableCode) . '</textarea>';
}
?>
