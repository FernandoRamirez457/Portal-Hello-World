<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserir Notícia</title>
    <script>
        setTimeout(function() {
            window.location.href = "../jornalist-comunity.html";
        }, 3000); // Redireciona após 5 segundos (ajuste conforme necessário)
    </script>
</head>
<body>


<?php
require '../conexao.php';
$conexao = conectar();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $subtitulo = $_POST['subtitulo'];
    $data_publicacao = $_POST['data_publicacao'];
    $texto = $_POST['texto'];
    $id_jornalista = $_POST['id_jorn'];
 
    $imagens = $_FILES['imagens'];

    if ($imagens['error'] === UPLOAD_ERR_OK) {
        $imagem_temp = $imagens['tmp_name'];
        $imagem_nome = $imagens['name'];

        // Move a imagem para um diretório no servidor
        move_uploaded_file($imagem_temp, "../img/img_news_journalist/$imagem_nome");
    } else {
        echo "Erro ao fazer o upload da imagem.";
        exit; // Saia do script se houver erro no upload da imagem
    }

    // Usando declaração preparada para inserção de dados
    $sql_inserir = "INSERT INTO noticias (id_jornalista,titulo, subtitulo, data_noticia, imagens, conteudo) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_inserir = $conexao->prepare($sql_inserir);

    // Vincular os parâmetros
    $stmt_inserir->bind_param("ssssss",$id_jornalista, $titulo, $subtitulo, $data_publicacao, $imagem_nome, $texto);

    if ($stmt_inserir->execute()) {
        echo "Notícia salva com sucesso!";
    } else {
        echo "Erro ao salvar notícia: " . $stmt_inserir->error;
        exit; // Saia do script se houver erro na inserção
    }

    // Salvar o ID da notícia inserida
    $id_inserido = $stmt_inserir->insert_id;

    // Fechar a declaração de inserção
    $stmt_inserir->close();
}

fecharConexao($conexao);
?>

</body>
</html>
