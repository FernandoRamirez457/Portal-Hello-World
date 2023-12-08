<?php
    session_start();

    if (isset($_POST['btn-submit'])) {

        function verificarTokenCSRF($token)
    {
        return isset($_SESSION['csrf_token']) && $token === $_SESSION['csrf_token'];
    }

        
        $tokenCSRF = $_SESSION['csrf_token'];
        if (!verificarTokenCSRF($tokenCSRF)) {
            die('Token CSRF inválido. Acesso negado.');
        } else {
            $senha = $_POST['pass'];
            $senha2 = $_POST['pass2']; 

            if ($senha == $senha2) {
                include_once('../../conexao.php');
                $conexao = conectar();

                $nome = $_POST['name'];
                $data_nasc = $_POST['birth'];

                $date_object = DateTime::createFromFormat('d-m-Y', $data_nasc);


                
            if (isset($_FILES['ft_perfil'])) {
                $imagem = $_FILES['ft_perfil'];

                $pasta = "perfil_imagens/";
                $nomeDoArquivo = $imagem['name'];
                $nomenovoDoArquivo = uniqid();
                $estensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));
                // Verifica se a extensão não é jpg ou png
                if ($estensao != 'jpg' && $estensao != 'png') {
                    // Exibe uma mensagem de erro usando JavaScript
                    echo '<script>alert("Tipo de arquivo não aceito");</script>';

                    // Redireciona para a página desejada após o alerta
                    echo '<script>window.location.href = "register_jorn.php";</script>';
                        exit; // Certifica-se de que o script é encerrado após o redirecionamento
                }
                $path = $pasta . $nomenovoDoArquivo . '.' . $estensao;
                $arquivo = move_uploaded_file($imagem["tmp_name"],"../Login/" . $path);
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
                    // Inserir na tabela jornalista
                    $queryInsert = "INSERT INTO jornalista(nome, data_nascimento, email, senha, imagem)
                        VALUES ('$nome', '$dataFinal', '$email', '$senha_hash', '$path')";
                    $resultInsert = mysqli_query($conexao, $queryInsert);
    
                    // Obter o ID do jornalista recém-inserido
                    $id_jornalista = mysqli_insert_id($conexao);

                    $strSenha = strlen($senha);
    
                    fecharConexao($conexao);

                    session_start();

                    $_SESSION['senhaLen'] = $strSenha;
                    $_SESSION['registro'] = true;
                    $_SESSION['id_jornalista'] = $id_jornalista;
                    $_SESSION['tipo'] = "jornalista";
                    $_SESSION['nome'] = $nome;
                    $_SESSION['data_nasc'] = $dataFinal;
                    $_SESSION['email'] = $email;
                    $_SESSION['senha'] = $senha_hash;
                    $_SESSION['imagem'] = $path;

                    header('Location: ../Login/abaUsuario.php');
                }
            } else {
                ?>
                <script>
                    var senhas = document.querySelectorAll('#input_pass');
                    senhas[0].style.backgroundColor = "red";
                    senhas[1].style.backgroundColor = "red";
                    alert("Senhas incompatíveis");
                </script>
            <?php
            }
        }
    }
    ?>