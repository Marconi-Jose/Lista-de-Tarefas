<?php 
session_start();
require_once 'conexao.php';

if (isset($_SESSION['id_usuario'])) {
    header("Location: tarefas.php");
    exit;
}


if (isset($_POST['email']) && isset($_POST['senha'])){
    $email = $_POST['email'];
    $senha = $_POST['senha'];


    $sql = "SELECT * FROM usuarios WHERE email = :email and senha = :senha";
    $stmt = $pdo ->prepare($sql);
    $stmt -> execute ([
        'email' => $email,
        'senha' => $senha
    ]);
    $usuario = $stmt->fetch();

    if($usuario){
        $_SESSION['id_usuario'] = $usuario['id'];
        $_SESSION['nome'] = $usuario['nome'];
        header("Location: tarefas.php");
        exit();

    }else{
         $erro = "Email ou senha incorreto!";

    }
    
}

?>



<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css?v=<?php echo time(); ?>">
    <title>LOGIN</title>
</head>
<body>
    <div class="conteiner">
        <h1>LOGIN</h1>
        <div class="form">
             <?php if (!empty($erro)) echo "<p style='color:red;'>$erro</p>"; ?>
            <form action="" method="post">

                <div class="input">
                    <img src="usuario.png" class="icon" alt="usuário">
                    <input type="email" name ="email"  placeholder="Seu E-mail" required>
                </div>

                <div class="input">
                    <img src="cadeado.png" class="icon " alt="senha">
                    <input type="password" maxlength="12" placeholder="Senha" name= "senha" required>
                    
                </div>
                
                <button type="submit">Login</button>
              
                <div class="register-link">

                     <p>Não tem conta? <a href="registrar.php">Registre-se</a></p>

                </div>

            </form>
        </div>
    </div>
</body>
</html>