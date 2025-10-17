<?php

require_once 'conexao.php';
session_start();
date_default_timezone_set('America/Sao_Paulo');



if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

$id_usuario = $_SESSION['id_usuario'];


if (isset($_POST['descricao'])) {
    $descricao = $_POST['descricao'];
    $prioridade = $_POST['prioridade'] ?? 'baixa';
    $data_inicial = date('Y-m-d');
    $data_final = $_POST['data_final'];

   
   if (!empty($descricao)) {
         $sql = "INSERT INTO tarefas (descricao, prioridade, data_inicial, data_final, id_usuario) 
                VALUES (:descricao, :prioridade, :data_inicial, :data_final, :id_usuario)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'descricao' => $descricao,
            'prioridade' => $prioridade,
            'data_inicial' => $data_inicial,
            'data_final' => $data_final,
            'id_usuario' => $id_usuario
        ]);
    }
}

if (isset($_GET['concluir'])) {
    $id = $_GET['concluir'];
    $sql = "UPDATE tarefas SET concluida = 1 WHERE id = :id and id_usuario = :id_usuario";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id, 'id_usuario' => $id_usuario]);
    header('Location: tarefas.php'); 
    exit();
}


if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];
    $sql = "DELETE FROM tarefas WHERE id = :id and id_usuario = :id_usuario";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id , 'id_usuario' => $id_usuario]);
    header('Location: tarefas.php'); 
    exit();
}


$sql = "SELECT *, DATEDIFF(data_final, data_inicial) AS prazo 
        FROM tarefas 
        WHERE id_usuario = :id_usuario
        ORDER BY data_inicial DESC";

$stmt = $pdo ->prepare ($sql);
$stmt -> execute(["id_usuario" => $id_usuario]);
$tarefas = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="tarefas.css?v=<?php echo time(); ?>">
    <title>Lista de Tarefas</title>
    
</head>
<body>
    <header>

       <p>Bem vindo <strong><?=htmlspecialchars($_SESSION['nome'])?></strong> <a href="logout.php">Sair</a></p>

    </header>
    
    <div class="container">
        <h1>Minha Lista de Tarefas</h1>

        <form action="tarefas.php" method="POST">
           <input type="text" name="descricao" placeholder="Digite uma nova tarefa..." required>

            <div class="grupo-data">
                <label><strong>Finalizar tarefa:</strong></label>
                <input type="date" class="data" name="data_final" min=<?= date('Y-m-d') ?> required>
            </div>

            <label class="prioridade" for=""><strong>Prioridade:</strong></label>
            
            <div class ="grupo-radio">
                <input type="radio" name = "prioridade" value ="alta" id = "alta">
                <label  for="alta">Alta</label>
                <input type="radio" name = "prioridade" value = "baixa" id = "baixa">
                <label  for="baixa">Baixa</label>
            </div>
            <button type="submit">Adicionar</button>
        </form>

        <ul>
           <table>
    <thead>
        <tr>
            <th>Descrição</th>
            <th>Prioridade</th>
            <th>Prazo (dias)</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tarefas as $tarefa): ?>
            
            <tr class="<?php echo $tarefa['concluida'] ? 'concluida' : ''; ?> <?php echo $tarefa['prioridade'] === 'alta' ? 'prioridade-alta' : ''; ?>
                <?php echo $tarefa['prioridade'] === 'baixa' ? 'prioridade-baixa' : ''; ?>">
                <td class= "pronto"><?php echo htmlspecialchars(strtoupper($tarefa['descricao'])); ?></td>
                <td class= "pronto"><?php echo htmlspecialchars(strtoupper($tarefa['prioridade'])); ?></td>
                <td class= "pronto"><?php echo htmlspecialchars($tarefa['prazo']); ?></td>
                <td>

                    <?php if (!$tarefa['concluida']): ?>
                        <a href="tarefas.php?concluir=<?php echo $tarefa['id']; ?>" class="concluir-btn">Concluir</a>
                    <?php endif; ?>

                    <a href="tarefas.php?excluir=<?php echo $tarefa['id']; ?>" class="excluir-btn" onclick="return confirm('Tem certeza?');">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
        </ul>
    </div>
</body>
</html>
