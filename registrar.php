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
    <title>Registrar</title>
</head>
<body>
    <div class="conteiner">
        <h1>REGISTRO</h1>
        <div class="form">
            <form action="" method="post">
                <div class = "input">
                    <input type="text" name="nome" placeholder = "Nome completo" require>

                </div>

                <div class="input">
                    <img src="usuario.png" class="icon" alt="email">
                    <input type="email" name ="email"  placeholder="email@email.com" required>
                </div>

                <div class="input">
                    <img src="cadeado.png" class="icon " alt="senha">
                    <input type="password"  placeholder="Senha" name= "senha" required>
                    <input type="checkbox">
                    
                    
                </div>
                
                <button type="submit">Login</button>

                <div class="register-link">

                     <p>Não tem conta? <a href="registro.html">Registre-se</a></p>

                </div>

               

                
            

            </form>
        </div>
    </div>
</body>
</html>