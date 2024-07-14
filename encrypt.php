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

    // Prepare the key and IV content for download
    $keyFileContent = "<?php\n" .
                      'return [' . "\n" .
                      '    "key" => "' . $key . '",' . "\n" .
                      '    "iv" => "' . $iv . '",' . "\n" .
                      '];';

    // Prepare the PHP code to be executed
    $executableCode = "<?php\n" .
                      '$keyData = include __DIR__ . "/key.php";' . "\n" .
                      '$key = $keyData["key"];' . "\n" .
                      '$iv = $keyData["iv"];' . "\n" .
                      '$encryptedCodeBase64 = "' . $encryptedCodeBase64 . '";' . "\n" .
                      '$encryptedCode = base64_decode($encryptedCodeBase64);' . "\n" .
                      '$decryptedCode = openssl_decrypt($encryptedCode, "aes-256-cbc", $key, 0, $iv);' . "\n" .
                      'eval("?>".$decryptedCode);' . "\n" .
                      "?>";

    // Display the result
    echo '<h2>Encryption Successful!</h2>';
    echo '<h3>Key and IV</h3>';
    echo '<pre>' . htmlspecialchars($keyFileContent) . '</pre>';
    echo '<form method="post" action="download_key.php">';
    echo '<input type="hidden" name="key_content" value="' . htmlspecialchars($keyFileContent) . '">';
    echo '<button type="submit">Download Key File</button>';
    echo '</form>';
    echo '<h3>Encrypted PHP Code</h3>';
    echo '<form method="post" action="download_code.php">';
    echo '<textarea name="encrypted_code" rows="20" cols="80" readonly>' . htmlspecialchars($executableCode) . '</textarea><br>';
    echo '<input type="hidden" name="encrypted_code" value="' . htmlspecialchars($executableCode) . '">';
    echo '<button type="submit">Download Encrypted PHP Code</button>';
    echo '</form>';
}
?>
