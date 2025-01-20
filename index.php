<?php

function caesarCipher($text, $scroll) {
    $cipherText = "";
    for ($i = 0; $i < strlen($text); $i++) {
        $char = $text[$i];
        if (preg_match("/[a-zA-Z]/", $char)) {
            $asciiOffset = ctype_upper($char) ? 65 : 97;
            $code = ((ord($char) - $asciiOffset + $scroll) % 26 + 26) % 26 + $asciiOffset;
            $cipherText .= chr($code);
        } else {
            $cipherText .= $char; // Buradaki hata düzeltildi
        }
    }
    return $cipherText;
}

function encrypt($text, $scroll) {
    return caesarCipher($text, $scroll);
}

function decrypt($text, $scroll) {
    return caesarCipher($text, -$scroll);
}

// Formdan gelen veriyi işleyelim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $text = $_POST['text'] ?? '';
    $scroll = isset($_POST['scroll']) ? intval($_POST['scroll']) : 0;
    $action = $_POST['action'] ?? '';

    if ($action == 'encrypt') {
        $result = encrypt($text, $scroll);
    } elseif ($action == 'decrypt') {
        $result = decrypt($text, $scroll);
    } else {
        $result = 'Hatalı işlem!';
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caesar Cipher</title>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="text-center">Caesar Cipher</h2>

    <form method="post">
        <div class="form-group">
            <label for="text">Text:</label>
            <input type="text" id="text" name="text" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="scroll">Scroll Amount:</label>
            <input type="number" id="scroll" name="scroll" class="form-control" value="0" min="0" >
        </div>

        <div class="text-center">
            <button type="submit" name="action" value="encrypt" class="btn btn-primary">Encrypt</button>
            <button type="submit" name="action" value="decrypt" class="btn btn-secondary ml-2">Decrypt</button>
        </div>

        <div class="mt-3">
            <h4>Result:</h4>
            <pre><?php echo htmlspecialchars($result); ?></pre>
        </div>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
