<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Code Encryptor</title>
</head>
<body>
    <h1>PHP Code Encryptor</h1>
    <form action="encrypt.php" method="post">
        <label for="code">PHP Code:</label><br>
        <textarea id="code" name="code" rows="10" cols="50" required></textarea><br><br>
        
        <label for="key">Encryption Key (32 characters):</label><br>
        <input type="text" id="key" name="key" maxlength="32" required><br><br>
        
        <label for="iv">Initialization Vector (IV) (16 characters):</label><br>
        <input type="text" id="iv" name="iv" maxlength="16" required><br><br>
        
        <input type="submit" value="Encrypt Code">
    </form>
</body>
</html>
