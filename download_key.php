<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['key_content'])) {
    $keyContent = $_POST['key_content'];

    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="key.php"');
    header('Content-Length: ' . strlen($keyContent));
    echo $keyContent;
    exit;
}
?>
