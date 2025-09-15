<?php
// Detalhes do banco de dados
$servidor = "localhost";
$usuario = "root"; // Usuário padrão do XAMPP
$senha = ""; // Senha padrão do XAMPP é vazia
$banco = "tarefas_db";

// Criar a conexão
try {
    $pdo = new PDO("mysql:host=$servidor;dbname=$banco;charset=utf8", $usuario, $senha);
    // Configura o PDO para lançar exceções em caso de erros
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Se a conexão falhar, mostra o erro
    die("Erro na conexão: " . $e->getMessage());
}
?>