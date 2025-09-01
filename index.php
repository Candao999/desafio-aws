<?php
// Mostra erros (útil para debugging)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Configuração do banco
$host = 'localhost';
$dbname = 'desafio';
$username = 'desafio'; // usuário que você criou no MariaDB
$password = 'senhaSegura';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}

// Recebe dados do formulário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['txtNome'];
    $idade = $_POST['txtIdade'];
    $isento = isset($_POST['chkAtivo']) ? 1 : 0;
    $endereco = $_POST['txtEndereco'];
    $periodo = $_POST['rdbTurno'];
    $observacoes = $_POST['txtObservacoes'];

    // Prepara e executa INSERT
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
        echo "<p style='color:green;'>Aluno cadastrado com sucesso!</p>";
    } else {
        echo "<p style='color:red;'>Erro ao cadastrar aluno.</p>";
    }
}
?>
