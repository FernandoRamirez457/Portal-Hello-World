<?php
    session_start();

    // Verifica se há uma mensagem de erro
    if (isset($_SESSION['mensagem_erro'])) {
        echo '<script>alert("' . $_SESSION['mensagem_erro'] . '");</script>';

        // Limpa a mensagem de erro da sessão
        unset($_SESSION['mensagem_erro']);
    }

    // Função para gerar o token CSRF
    function gerarTokenCSRF()
    {
        return bin2hex(random_bytes(32));
    }

    // Cria a variável $tokenCSRF
    $tokenCSRF = isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : gerarTokenCSRF();

    // Se o token não existir na sessão, atualiza com o novo valor gerado
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = $tokenCSRF;
    }
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/jornalista.css">
    <link rel="shortcut icon" href="imgs/incone.png" type="image/x-icon">
    <title>Torne-se um Jornalista</title>
    <link rel="apple-touch-icon" sizes="180x180" href="../../favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../../favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../../favicons/favicon-16x16.png">
    <link rel="manifest" href="../../favicons/site.webmanifest">

</head>

<body>
    <!--Mostrando as informações para o cliente-->
    
    <div class="box">
        <form method="post" action="./register.php" enctype="multipart/form-data">
            <br>
            <h1>Torne-se um Jornalista</h1>
            <input type="text" name="name" id="input_name" class="input_user" placeholder="Nome completo" required/>
            <input type="text" name="birth" id="input_birth" class="input_user" placeholder="Data de Nasc (exemplo:DD-MM-YYYY)" required/>
            <input type="text" name="email" id="input_email" class="input_user" placeholder="E-mail" required/>
            <input type="password" name="pass" id="input_pass" class="input_user" placeholder="Senha" required/>
            <input type="password" name="pass2" id="input_pass" class="input_user" placeholder="Confirmar Senha"required/>
            <label for="f">foto de perfil</label>
            <input type="file" name="ft_perfil" id="ft_perfil" placeholder="Imagem de perfil" required />
            <input type="hidden" name="csrf_token" value="<?php echo $tokenCSRF; ?>">
                <br>
            <div class="button-group">
                <a href="../Login/login_cad.php"><button type="button" class="btn">Voltar</button></a>
                <button type="submit" class="btn" name="btn-submit">Finalizar</button>
            </div>
            <br>
            </div>
        </form>
</div>
    </body>

    </html>

