<?php
session_start();

// Verifica se o usuário está logado
if((!isset($_SESSION['id_jornalista']) == true )){
    echo '<script>
    alert("Você não tem permissão para acessar esta página. Você será redirecionado.");
    setTimeout(function() {
      window.location.href = "../jornalist-comunity.html";
    }, 500); // Redireciona após 5 segundos (ajuste conforme necessário)
  </script>';
  exit();
}else{
  // O código abaixo só será executado se o usuário estiver logado e for do tipo jornalista
  // Insira aqui o restante do seu código para jornalista
  $id_jornalista = $_SESSION['id_jornalista'];
}
?>

<!doctype html>
<html lang="pt-br">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Hello, world!</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        
  <link rel="stylesheet" href="../insert/css_insert/form_noticia.css">
</head>

<body>
  <i class="fa-solid fa-x" style="color: #000000;" onclick="goBack()"></i>

  <div class="container">
    <div class="form-container">
      <div class="left-container">
        <div class="left-inner-container">
          <h2>Bem Vindo Jornalista</h2>
          <p>Adicione ao Lado, a notícia que deseja publicar</p>
          <br>
          <p>Durante a Escrita do Conteúdo da Notícia, umas regras devem ser seguidas para que não haja ocorrencia de
            erros</p>
          <br>
          <p># - É um identificador que seu texto apresenta essa parte como titulo</p>
          <br>
          <p>Ex: # Sou um Subtítulo</p>
        </div>
      </div>
      <div class="right-container">
        <div class="right-inner-container">
          <form method="POST" action="insert_noticia.php" enctype="multipart/form-data">

            <label for="">ID de jornalista:</label>
            <input type="text" name="id_jorn" value="<?php echo $id_jornalista ?>" readonly>
            <br><br>

            <label for="titulo">Título:</label>
            <input type="text" name="titulo" required>

            <label for="subtitulo">Subtítulo:</label>
            <input type="text" name="subtitulo">

            <label for="data_publicacao">Data de Publicação:</label>
            <input type="date" name="data_publicacao">

            <label for="imagens">Imagens:</label>
            <input type="file" name="imagens" accept="image/*">

            <label for="texto">Texto:</label>
            <textarea name="texto" required></textarea>

            <button>Publicar</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    function goBack() {
      window.history.back();
    }
  </script>
</body>

</html>