<?php

$host = '127.0.0.1';  // usar IP evita alguns erros de socket
$dbname = 'formulario';
$username = 'formuser';   // usuário criado no MySQL
$password = '12345';      // senha que você definiu

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Conectado com sucesso!<br>";
} catch (PDOException $e) {
    die("❌ Erro ao conectar: " . $e->getMessage());
}


$nome = $email = $mensagem = '';
$erro = $sucesso = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $mensagem = $_POST['mensagem'];

    if (empty($nome) || empty($email) || empty($mensagem)) {
        $erro = "Todos os campos são obrigatórios.";
    } else {
        $sql = "INSERT INTO contatos (nome, email, mensagem) VALUES (:nome, :email, :mensagem)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':mensagem', $mensagem);

        if ($stmt->execute()) {
            $sucesso = "Mensagem enviada com sucesso!";
        } else {
            $erro = "Erro ao enviar a mensagem.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Contato</title>
</head>
<body>
    <h1>Formulário de Contato</h1>

    <?php
    if ($erro) {
        echo "<p style='color: red;'>$erro</p>";
    }

    if ($sucesso) {
        echo "<p style='color: green;'>$sucesso</p>";
    }
    ?>

    <form method="POST" action="">
        <label for="nome">Nome:</label><br>
        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($nome); ?>" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br><br>

        <label for="mensagem">Mensagem:</label><br>
        <textarea id="mensagem" name="mensagem" rows="4" required><?php echo htmlspecialchars($mensagem); ?></textarea><br><br>

        <button type="submit">Enviar</button>
    </form>
</body>
</html>
