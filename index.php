<?php
// Configurações do banco de dados
$host = 'localhost';
$dbname = 'desafio';
$username = 'desafio';  // usuário criado no MariaDB
$password = 'senhaSegura'; // senha do usuário

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}

// Inicializa variáveis
$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $idade = $_POST['idade'];
    $isento = isset($_POST['isento']) ? 1 : 0;
    $endereco = $_POST['endereco'];
    $periodo = $_POST['periodo'];
    $observacoes = $_POST['observacoes'];

    if (empty($nome) || empty($idade) || empty($endereco) || empty($periodo)) {
        $erro = "Todos os campos obrigatórios devem ser preenchidos.";
    } else {
        $sql = "INSERT INTO alunos (nome, idade, isento, endereco, periodo, observacoes) 
                VALUES (:nome, :idade, :isento, :endereco, :periodo, :observacoes)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':idade', $idade);
        $stmt->bindParam(':isento', $isento);
        $stmt->bindParam(':endereco', $endereco);
        $stmt->bindParam(':periodo', $periodo);
        $stmt->bindParam(':observacoes', $observacoes);

        if ($stmt->execute()) {
            $sucesso = "Aluno cadastrado com sucesso!";
        } else {
            $erro = "Erro ao cadastrar aluno.";
        }
    }
}

// Exibe mensagens
if ($erro) echo "<p style='color:red;'>$erro</p>";
if ($sucesso) echo "<p style='color:green;'>$sucesso</p>";
?>
