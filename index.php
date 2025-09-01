<?php
// Configuração do banco de dados
$host = 'localhost';
$dbname = 'formulario';
$username = 'root';
$password = 'root';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}

// Inicializa variáveis
$nome = $email = $mensagem = '';
$erro = $sucesso = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $mensagem = $_POST['mensagem'] ?? '';

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
            $nome = $email = $mensagem = ''; // limpa campos após envio
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <form method="POST" action="" class="p-4 border rounded shadow bg-light" style="max-width: 600px;">
                <h2 class="mb-3">Formulário de Contato</h2>

                <?php if ($erro) echo "<div class='alert alert-danger'>$erro</div>"; ?>
                <?php if ($sucesso) echo "<div class='alert alert-success'>$sucesso</div>"; ?>

                <div class="mb-3">
                    <label for="nome" class="form-label">Nome:</label>
                    <input type="text" id="nome" name="nome" class="form-control" value="<?php echo htmlspecialchars($nome); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="mensagem" class="form-label">Mensagem:</label>
                    <textarea id="mensagem" name="mensagem" class="form-control" rows="4" required><?php echo htmlspecialchars($mensagem); ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Enviar</button>
                <button type="reset" class="btn btn-secondary">Limpar</button>
            </form>
        </div>
    </div>
</body>
</html>
