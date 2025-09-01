<?php
$host = 'localhost';
$dbname = 'desafio';       // nome do banco
$username = 'desafio';      // usuário
$password = 'senhaSegura';  // senha

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexão bem-sucedida!\n";
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    if ($tables) {
        echo "Tabelas no banco:\n" . implode("\n", $tables) . "\n";
    } else {
        echo "Não há tabelas no banco.\n";
    }
} catch (PDOException $e) {
    die("Erro ao conectar: " . $e->getMessage() . "\n");
}
?>
