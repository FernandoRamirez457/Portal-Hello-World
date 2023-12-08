<?php
session_start();
if (isset($_POST['btn-submit']) && !empty($_POST['email']) && !empty($_POST['senha'])) {

    include_once('../../conexao.php');
    $conexao = conectar();

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Use declaração preparada para evitar injeção de SQL
    $stmt = $conexao->prepare("SELECT 'usuario' AS tipo, id_usuario AS id, nome, data_nascimento, email, senha, imagem
                                   FROM usuario
                                   WHERE email = ?
                                   UNION
                                   SELECT 'jornalista' AS tipo, id_jornalista AS id, nome, data_nascimento, email, senha, imagem
                                   FROM jornalista
                                   WHERE email = ?");
    $stmt->bind_param("ss", $email, $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows < 1) {
        unset($_SESSION['email']);
        unset($_SESSION['senha']);
        $_SESSION['mensagem_erro'] = "Nenhum registro compatível encontrado!";
        header('Location: ./login_cad.php');
    } else {
        $row = $resultado->fetch_assoc();
        $senha_hash = $row['senha'];

        // Verificar a senha usando password_verify
        if (password_verify($senha, $senha_hash)) {
            $strSenha = strlen($senha);
            // Senha correta, realizar o login
            $id = $row['id'];
            $tipo = $row['tipo'];

            // Check the user type and set the appropriate ID in the session
            if ($tipo === 'usuario') {
                $_SESSION['id_usuario'] = $id;
            } elseif ($tipo === 'jornalista') {
                $_SESSION['id_jornalista'] = $id;
                $_SESSION['tipo'] = $tipo;
            }

            $_SESSION['senhaLen'] = $strSenha;


            $_SESSION['nome'] = $row['nome'];
            $_SESSION['data_nasc'] = $row['data_nascimento'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['imagem'] = $row['imagem'];


            $_SESSION['senha'] = $senha_hash; // Salvar o hash da senha na sessão
            fecharConexao($conexao);
            header('Location: abaUsuario.php');
            exit();
        } else {
            // Senha incorreta
            include_once('../../conexao.php');
            $conexao = conectar();

            $_SESSION['mensagem_erro'] = "Erro, Email e / ou Senha Incorretos!";

            unset($_SESSION['email']);
            unset($_SESSION['senha']);
            fecharConexao($conexao);
            header('Location: login_cad.php');
            exit();
        }
    }

    // Fechar a declaração preparada
    $stmt->close();
} else {
    include_once('../../conexao.php');
    $conexao = conectar();

    $_SESSION['mensagem_erro'] = "Erro, Email e / ou Senha Incorretos!";

    fecharConexao($conexao);
    header('Location: login_cad.php');
    exit();
}
