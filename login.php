<?php 
session_start();
require_once 'conexao.php';


if (isset($_POST['usuario']) && isset($_POST['senha'])){
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];
    $_SESSION['usuario'] = $usuario;
    
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css?v=<?php echo time(); ?>">
    <title>Login</title>
</head>
<body>
    <div class="conteiner">
        <h1>LOGIN</h1>
        <div class="form">
            <form action="" method="post">

                <div class="input">
                    <img src="usuario.png" class="icon" alt="usuário">
                    <input type="text" name ="usuario" maxlength="20" placeholder="Usuário" required>
                </div>

                <div class="input">
                    <img src="cadeado.png" class="icon " alt="senha">
                    <input type="password" maxlength="12" placeholder="Senha" name= "senha" required>
                    <input type="checkbox">
                    
                    
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