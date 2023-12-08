<?php
session_start();

// Verifica se o usuário já está logado
if (isset($_SESSION['nome'])) {
    header('Location: ./abaUsuario.php');
    exit();
}
?>


<?php

// Verifica se há uma mensagem de erro
if (isset($_SESSION['mensagem_erro'])) {
    echo '<script>alert("' . $_SESSION['mensagem_erro'] . '");</script>';

    // Limpa a mensagem de erro da sessão
    unset($_SESSION['mensagem_erro']);
}

// Função para gerar o token CSRF, se não existir na sessão
function gerarTokenCSRF()
{
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verificarTokenCSRF($token)
{
    return isset($_SESSION['csrf_token']) && $token === $_SESSION['csrf_token'];
}

// Cria a variável $tokenCSRF
$tokenCSRF = gerarTokenCSRF();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>FORM</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css'>
    <link rel="stylesheet" href="./CSS/login_cad.css">

    <link rel="apple-touch-icon" sizes="180x180" href="../../favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../../favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../../favicons/favicon-16x16.png">
    <link rel="manifest" href="../../favicons/site.webmanifest">

</head>

<body>
    <!-- Inico do Form -->
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form method="post" action="./login_cad.php" enctype="multipart/form-data">
                <h1>Criar uma conta</h1>
                <input type="text" name="nome" placeholder="Nome completo" required />
                <input type="email" name="email" placeholder="E-mail" required />
                <input type="password" name="pass" placeholder="Senha" class="senhas" required />
                <input type="password" name="pass2" placeholder="Confirmar Senha" class="senhas" required />
                <input type="text" name="data_nascimento" placeholder="Data de Nascimento (DD-MM-YYYY)" required />
                <input type="file" name="ft_perfil" placeholder="Imagem de perfil" required />
                <input type="hidden" name="csrf_token" value="<?php echo $tokenCSRF; ?>">
                <br><br>
                <div class="button-group">
                    <button type="submit" name="btn-register">Cadastrar-se</button>
                    <br><br>
                    <a href="../Cadastro/register_jorn.php"><button type="button" class="btn">Quero ser um jornalista</button></a>
                </div>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form action="./login.php" method="post">
                <h1>Entrar</h1>
                <br>
                <small>Entrar na sua conta</small>
                <br><br>
                <input type="email" name="email" id="email" placeholder="Email" />
                <input type="password" name="senha" id="senha" placeholder="Senha" />
                <br><br>
                <div class="button-group">
                    <a href="../../portal.html"><button type="button" class="btn">Voltar</button></a>
                    <button type="submit" class="btn" name="btn-submit">Logar</button>
                </div>
            </form>

        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Hello, Amigoo!</h1>
                    <p>Insira seus dados pessoais e comece sua jornada conosco</p>
                    <button class="ghost" id="signIn">Entrar</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Bem vindo de volta!!</h1>
                    <p>Para se manter conectado conosco, faça login com suas informações pessoais</p>
                    <button class="ghost" id="signUp" name="btn-submit">Entrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../../js/login_cad.js"></script>

    <!-- Fim do Form -->
</body>

</html>
<?php
if (isset($_POST['btn-register'])) {
    $tokenCSRF = $_POST['csrf_token'];
    if (!verificarTokenCSRF($tokenCSRF)) {
        die('Token CSRF inválido. Acesso negado.');
        session_abort();
    } else {
        $senha = $_POST['pass'];
        $senha2 = $_POST['pass2'];

        if ($senha == $senha2) {
            include_once('../../conexao.php');
            $conexao = conectar();

            $nome = $_POST['nome'];
            $data_nasc = $_POST['data_nascimento'];

            $date_object = DateTime::createFromFormat('d-m-Y', $data_nasc);

     
            if (isset($_FILES['ft_perfil'])) {
                $imagem = $_FILES['ft_perfil'];

             

                $pasta = "perfil_imagens/";
                $nomeDoArquivo = $imagem['name'];
                $nomenovoDoArquivo = uniqid();
                $estensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));
                if ($estensao != 'jpg' &&  $estensao != 'png')
                    die('Tipo de arquivo não aceito');
                $path = $pasta . $nomenovoDoArquivo . '.' . $estensao;
                $arquivo = move_uploaded_file($imagem["tmp_name"], $path);
            }

            if ($date_object) {
                $dataFinal = $date_object->format('Y-m-d');
            } else {
                // Trate o erro de formato de data inválido aqui
                echo '<script>alert("Formato de data inválido. Use o formato: dd-mm-yyyy");</script>';
            }

            $email = $_POST['email'];
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

            // Verificar duplicidade de e-mail
            $query = "SELECT email FROM jornalista WHERE email = '$email' UNION SELECT email FROM usuario WHERE email = '$email'";
            $result = mysqli_query($conexao, $query);

            

            if (mysqli_num_rows($result) > 0) {
                // E-mail já existe
                echo '<script>alert("E-mail já cadastrado. Por favor, escolha outro.");</script>';
            } else {
                // Inserir na tabela usuario
                $queryInsert = "INSERT INTO usuario(nome, data_nascimento, email, senha,imagem)
                    VALUES ('$nome', '$dataFinal', '$email', '$senha_hash', '$path')";
                $resultInsert = mysqli_query($conexao, $queryInsert);

                $strSenha = strlen($senha);

                fecharConexao($conexao);

                session_start();

                $_SESSION['registro'] = true;
                $_SESSION['nome'] = $nome;
                $_SESSION['data_nasc'] = $dataFinal;
                $_SESSION['email'] = $email;
                $_SESSION['senha'] = $senha_hash;
                $_SESSION['senhaLen'] = $strSenha;
                $_SESSION['imagem'] = $path;

                header('Location: ./abaUsuario.php');
            }
        } else {
?>
            <script>
                var senhas = document.querySelectorAll('.senhas');
                senhas[0].style.border = "1px solid red";
                senhas[1].style.border = "1px solid red";
                alert("Senhas incompatíveis");
            </script>
<?php
        }
    }
}
?>