<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['encrypted_code'])) {
    $encryptedCode = $_POST['encrypted_code'];

    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="encrypted_code_' . time() . '.php"');
    header('Content-Length: ' . strlen($encryptedCode));
    echo $encryptedCode;
    exit;
}
?>
