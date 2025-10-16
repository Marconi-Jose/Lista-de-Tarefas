<?php 
require_once 'conexao.php';


if (isset($_POST['nome']) && isset($_POST['senha']) && isset($_POST['email']) && isset($_POST['sobrenome']) && isset($_POST['data_nascimento'])){

    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $email = $_POST['email'];
    $nascimento = $_POST['data_nascimento'];
    $senha = $_POST['senha'];

    $verificar = $pdo->prepare("SELECT COUNT(id) FROM usuarios WHERE email = :email");
    $verificar->execute(['email' => $email]);
    $existe = $verificar->fetchColumn();

    if($existe > 0){

         echo "<script>alert('Email já cadastrado!'); window.location='registrar.php';</script>";

    }else{

        $sql = "INSERT INTO usuarios (nome, sobrenome, nascimento, email, senha) 
                VALUES (:nome, :sobrenome, :nascimento, :email, :senha)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
            'nome' => $nome,
            'sobrenome' => $sobrenome,
            'nascimento' => $nascimento,
            'email' => $email,
            'senha'=> $senha
        ]);
    echo "<script>alert('Conta criada com sucesso!'); window.location='index.php';</script>";

    }

     

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css?v=<?php echo time(); ?>">
    <title>CRIAR CONTA</title>
</head>
<body>
    <div class="conteiner">
        <h1>CRIAR UMA CONTA</h1>
        <div class="form">
            <form action="" method="post">

                <div class="input">

                    <input type="text" name= "nome" placeholder = "Nome" required>
        
                </div>

                <div class="input">
                     <input type="text" name= "sobrenome" placeholder = "sobrenome" required>
                </div>

                <div class="input">
                    
                    <input type="email" name ="email"  placeholder="email@email.com" required>
                </div>

                <div class="input">
                    
                    <input type="password" maxlength="12" placeholder="Senha" name= "senha" required>
                    
                </div>

                <div class= "data">

                    <label for="data_nascimento">Data de nascimento: </label>
                    <input type="date" name = "data_nascimento" max = <?= date('Y-m-d') ?> required>

                </div>
                
                <button type="submit">Registrar</button>

                <div class="register-link">

                     <p>Ja tem conta? ir para <a href="login.php">Login</a></p>

                </div>

                     

                
            

            </form>
        </div>
    </div>
</body>
</html>