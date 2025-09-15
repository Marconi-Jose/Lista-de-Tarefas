<?php
// Inclui o arquivo de conexão
require_once 'conexao.php';

// --- Lógica para ADICIONAR uma nova tarefa ---
if (isset($_POST['descricao'])) {
    $descricao = $_POST['descricao'];
    if (!empty($descricao)) {
        $sql = "INSERT INTO tarefas (descricao) VALUES (:descricao)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['descricao' => $descricao]);
    }
}

// --- Lógica para ATUALIZAR (concluir) uma tarefa ---
if (isset($_GET['concluir'])) {
    $id = $_GET['concluir'];
    $sql = "UPDATE tarefas SET concluida = 1 WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    header('Location: index.php'); // Redireciona para evitar reenvio
    exit();
}

// --- Lógica para EXCLUIR uma tarefa ---
if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];
    $sql = "DELETE FROM tarefas WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    header('Location: index.php'); // Redireciona
    exit();
}

// --- Lógica para LER (buscar) todas as tarefas ---
$sql = "SELECT * FROM tarefas ORDER BY data_criacao DESC";
$stmt = $pdo->query($sql);
$tarefas = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tarefas</title>
    <style>
        /* CSS Básico para deixar mais bonito */
        body { font-family: sans-serif; background-color: #f4f4f4; }
        .container { width: 50%; margin: 50px auto; background: white; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { text-align: center; }
        form { display: flex; margin-bottom: 20px; }
        form input[type="text"] { flex: 1; padding: 10px; border: 1px solid #ddd; }
        form button { padding: 10px; background: #007bff; color: white; border: none; cursor: pointer; }
        ul { list-style-type: none; padding: 0; }
        li { padding: 10px; border-bottom: 1px solid #ddd; display: flex; justify-content: space-between; align-items: center; }
        li.concluida { text-decoration: line-through; color: #888; }
        .acoes a { text-decoration: none; color: white; padding: 5px 8px; margin-left: 5px; border-radius: 3px;}
        .concluir-btn { background-color: #28a745; }
        .excluir-btn { background-color: #dc3545; }
    </style>
</head>
<body>

    <div class="container">
        <h1>Minha Lista de Tarefas</h1>

        <form action="index.php" method="POST">
            <input type="text" name="descricao" placeholder="Digite uma nova tarefa..." required>
            <button type="submit">Adicionar</button>
        </form>

        <ul>
            <?php foreach ($tarefas as $tarefa): ?>
                <li class="<?php echo $tarefa['concluida'] ? 'concluida' : ''; ?>">
                    <?php echo htmlspecialchars($tarefa['descricao']); ?>
                    <div class="acoes">
                        <?php if (!$tarefa['concluida']): ?>
                            <a href="index.php?concluir=<?php echo $tarefa['id']; ?>" class="concluir-btn">Concluir</a>
                        <?php endif; ?>
                        <a href="index.php?excluir=<?php echo $tarefa['id']; ?>" class="excluir-btn" onclick="return confirm('Tem certeza?');">Excluir</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

</body>
</html>
