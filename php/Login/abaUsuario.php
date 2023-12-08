<?php
session_start();

if ((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true)) {
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    unset($_SESSION['imagem']);
    header('Location: ./login_cad.php');
} else {
    $nome = $_SESSION['nome'];
    $imagem = $_SESSION['imagem'];
    $email = $_SESSION['email'];
    // Obtenha a senha hash da sessão
    $senha = $_SESSION['senhaLen'];
    
    $senha_oculta = str_repeat('*',$senha);

    $dataFinal = $_SESSION['data_nasc'];

    // Converte a string em um objeto de data usando strtotime()
    $objetoData = strtotime($dataFinal);

    // Formata a data no formato DD-MM-YYYY usando date()
    $dataFormatada = date('d-m-Y', $objetoData);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área do Usuário</title>
    <link rel="stylesheet" type="text/css" href="./CSS/./usuario.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="apple-touch-icon" sizes="180x180" href="../../favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../../favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../../favicons/favicon-16x16.png">
    <link rel="manifest" href="../../favicons/site.webmanifest">

</head>
<style>
    /* Inicio do Header */
        body {
        background-color: white;
    }

    header {
        display: inline;
    }

    .logosHello {
        margin: 10px 0px 5px 50px;
        display: flex;
        gap: 15px;
        width: auto;
    }

    .logosHello img {
        height: 24px;
    }

    #navbar {
        background-color: var(--color-world);
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 20px;
        transition: background-color 0.5s ease;
    }

    #navbar div {
        display: flex;
        align-items: center;
        color: white;
    }

    /* MENUS RELACIONADO A PAGINA */
    :root {
        --color-world: rgba(0, 125, 250, 0.9);
        --color-news: rgb(194, 0, 0);
        --color-esportes: rgb(0, 188, 0);
        --color-entretenimento: #8a2be2;
        --color-jornalista: #ff6600;
        --opacity-color-world: rgba(0, 128, 255, 0.8);
        --opacity-color-news: rgb(194, 0, 0, 0.8);
        --opacity-color-esportes: rgb(0, 188, 0, 0.8);
        --opacity-color-entretenimento: hsl(271, 76%, 53%, 0.8);
        --opacity-color-jornalista: hsl(24, 100%, 50%, 0.8);
    }

    body.world #navbar {
        background-color: var(--color-world);
    }

    body.news #navbar {
        background-color: var(--color-news);
    }

    body.esportes #navbar {
        background-color: var(--color-esportes);
    }

    body.entretenimento #navbar {
        background-color: var(--color-entretenimento);
    }



    body.world #sidebar {
        background-color: var(--opacity-color-world);
    }

    body.news #sidebar {
        background-color: var(--opacity-color-news);
    }

    body.esportes #sidebar {
        background-color: var(--opacity-color-esportes);
    }

    body.entretenimento #sidebar {
        background-color: var(--opacity-color-entretenimento);
    }

    body.jornalista #sidebar {
        background-color: var(--opacity-color-jornalista);
    }


    #sidebar {
        height: 100%;
        width: 0;
        position: fixed;
        z-index: 1;
        top: 0;
        left: 0;
        overflow-x: hidden;
        transition: 0.5s;
        padding-top: 60px;
        background-color: rgba(0, 125, 250, 0.9);
    }

    #sidebar a {
        padding: 15px 20px;
        text-decoration: none;
        font-size: 20px;
        color: white;
        display: block;
        transition: 0.3s;
    }

    #sidebar a:hover {
        color: black;
    }

    #sidebar .closebtn {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 30px;
    }

    #searchIcon,
    #closeIcon {
        cursor: pointer;
        font-size: 24px;
        margin-right: 10px;
    }

    #searchField {
        display: none;
        margin-right: 10px;
    }

    #searchField input {
        padding: 10px;
        border: none;
        border-radius: 5px;
        font-size: 16px;
    }

    /* Adiciona regras de mídia para ajustar o layout em telas menores */
    @media screen and (max-width: 768px) {
        .logosHello {
            margin: 10px auto 5px;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .logosHello img {
            height: 20px;
        }

        #navbar {
            padding: 10px;
        }

        #sidebar {
            padding-top: 20px;
        }

        #sidebar a {
            font-size: 16px;
            padding: 10px 15px;
        }

        #searchField input {
            padding: 8px;
            font-size: 14px;
        }
    }
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600&display=swap');

    :root {
    --color-neutral-0: #0e0c0c;
    --color-neutral-10: #171717;
    --color-neutral-30: #a8a29e;
    --color-neutral-40: #f5f5f5;

}

footer {
    width: 100%;
    color: var(--color-neutral-40);
    margin-top: 40px;
}

.footer-link {
    text-decoration: none;
}

.logo_rodape{
    width: 290px;
}

#footer_content {
    background-color: var(--color-neutral-10);
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    padding: 3rem 3.5rem;
}

#footer_contacts h1 {
    margin-bottom: 0.75rem;
}

#footer_social_media {
    display: flex;
    gap: 2rem;
    margin-top: 1.5rem;
} 

#footer_social_media .footer-link {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 2.5rem;
    width: 2.5rem;
    color: var(--color-neutral-40);
    border-radius: 50%;
    transition: all 0.4s;
}

#footer_social_media .footer-link i {
    font-size: 1.25rem;    
}

#footer_social_media .footer-link:hover {
    opacity: 0.8;
}

#instagram {
    background: linear-gradient(#7f37c9, #ff2992, #ff9807);
}

#x {
    background-color: rgb(10, 117, 184);
}

#email {
    background-color: #c71400;
}

.footer-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    list-style: none;
}

.footer-list .footer-link {
    color: var(--color-neutral-30);
    transition: all 0.4s;
}

.footer-list .footer-link:hover {
    color: #7f37c9;
}

#footer_subscribe {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

#footer_subscribe p {
    color: var(--color-neutral-30);
}

#input_group {
    display: flex;
    align-items: center;
    background-color: var(--color-neutral-0);
    border-radius: 4px;
}

#input_group input {
    all: unset;
    padding: 0.75rem;
    width: 100%;
}

#input_group button {
    background-color: #7f37c9;
    border: none;
    color: var(--color-neutral-40);
    padding: 0px 1.25rem;
    font-size: 1.125rem;
    height: 100%;
    border-radius: 0px 4px 4px 0px;
    cursor: pointer;
    transition: all 0.4s;
}

#input_group button:hover {
    opacity: 0.8;
}

#footer_copyright {
    display: flex;
    justify-content: center;
    background-color: var(--color-neutral-0);
    font-size: 0.9rem;
    padding: 1.5rem;
    font-weight: 100;
}

@media screen and (max-width: 768px) {
    #footer_content {
        grid-template-columns: repeat(2, 1fr);
        gap: 2rem;
    }
}

@media screen and (max-width: 426px) {
    #footer_content {
        grid-template-columns: repeat(1, 1fr);
        padding: 3rem 2rem;
    }
}
</style>

<body style="background-color: white;">
    <!--COMEÇO DO NAVBAR-->

    <header>
        <div class="logosHello">
            <a href="../../portal.html">
                <img src="../../img/hello_world_color.png" alt="logo Hello World" />
            </a>
            <a href="../../hello_news.html">
                <img src="../../img/hello_news_color.png" alt="logo hello Esportes" />
            </a>
            <a href="../../hello_gossip.html">
                <img src="../../img/hello_gossip_color.png" alt="logo Hello Entretenimento" />
            </a>
            <a href="../../hello_sports.html">
                <img src="../../img/hello_sports_color.png" alt="logo hello Esportes" />
            </a>
            <a href="../../jornalist-comunity.html">
                <img src="../../img/hello_journalist_color.png" alt="logo Hello Jornalistas" />
            </a>
        </div>

        <div id="navbar">

            <div onclick="openNav()">
                <i class="fas fa-bars" style="color: #ffffff; font-size: 24px;"></i>
                <p style="margin: 0 10px; font-size: 18px;">Menu</p>
            </div>
            <div>
                <a href="../../index.html"><img src="../../img/hello_world_color.png" alt="Logo Hello journalist" style="height: 40px;" /></a>
            </div>
            <div style="display: flex; align-items: center;">
                <span id="searchIcon" onclick="toggleSearchField()">
                    <i class="fas fa-search" style="color: #ffffff; font-size: 24px;"></i>
                </span>
                <div id="searchField" style="display: none;">
                    <input type="text" placeholder="Pesquisar" />
                </div>
                <span id="closeIcon" onclick="closeSearchField()" style="display: none;">
                    <i class="fas fa-times" style="color: #ffffff; font-size: 24px;"></i>
                </span>
                <a href="./logout.php">Sair</a>
            </div>
        </div>

        <div id="sidebar">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <a href="../..//portal.html" style="font-size: 24px;">Hello World</a>
            <a href="../../hello_news.html" style="font-size: 24px;">Hello News</a>
            <a href="..//../hello_gossip.html" style="font-size: 24px;">Hello Gossip</a>
            <a href="../../hello_sports.html" style="font-size: 24px;">Hello Sports</a>
            <a href="../Login/abaUsuario.php" style="font-size: 24px;">Perfil</a>
            <a href="../..//jornalist-comunity.html" style="font-size: 24px;">Comunidade jornalística</a>
        </div>
    </header>
    <div class="container">
        <!-- Cabeçalho da página -->

        <div class="profile-label">Perfil</div>
        <!-- Seção do perfil do usuário -->
        <center>
            <div class="profile-section">
                <img id="profileImage" class="profile-image" src="<?php echo $imagem ?>" alt="Foto de Perfil">
                <div class="user-info">
                    <div class="user-name"><?php echo $nome ?></div>
                </div>
                <h4>Seus Dados:</h4>
                <p>Email: <?php echo $email ?></p>
                <p>Senha: <?php echo $senha_oculta ?></p>
                <p>Data de Nascimento: <?php echo $dataFormatada ?></p>
            </div>
        </center>
        <!-- Linha divisória -->
        <div class="divider"></div>

        <!-- Ícone do menu -->
        <!-- Seção de estatísticas -->

        <footer>
    <div id="footer_content">
      <div id="footer_contacts">
        <img class="logo_rodape" src="./img/logo_hello_world_portal.png" alt="">

        <div id="footer_social_media">
          <a href="#" class="footer-link" id="instagram">
            <i class="fa-brands fa-instagram"></i>
          </a>

          <a href="#" class="footer-link" id="x">
            <i class="fa-brands fa-twitter" style="color: #ffffff;"></i>
          </a>

          <a href="#" class="footer-link" id="email">
            <i class="fa-solid fa-envelope" style="color: #ffffff;"></i>
          </a>
        </div>
      </div>

      <ul class="footer-list">
        <li>
          <h3>Assuntos</h3>
        </li>
        <li>
          <a href="#" class="footer-link">Hello News</a>
        </li>
        <li>
          <a href="#" class="footer-link">Hello Gossip</a>
        </li>
        <li>
          <a href="#" class="footer-link">Hello Sports</a>
        </li>
      </ul>

      <ul class="footer-list">
        <li>
          <h3>Comunidade</h3>
        </li>
        <li>
          <a href="#" class="footer-link">Perfil</a>
        </li>
        <li>
          <a href="#" class="footer-link">Comunidade</a>
        </li>
        <li>
          <a href="#" class="footer-link">Site de Apresentação</a>
        </li>
      </ul>

      <ul class="footer-list">
        <li>
          <h3>API's</h3>
        </li>
        <li>
          <a href="#" class="footer-link">GNews</a>
        </li>
        <li>
          <a href="#" class="footer-link">ClimaTempo</a>
        </li>
      </ul>
    </div>

    <div id="footer_copyright">
      &#169
      2023 all rights reserved
    </div>
  </footer>
        <script>
            function showItems(category) {
                // Esconde todas as categorias
                document.getElementById('likedPosts').style.display = 'none';
                document.getElementById('savedPosts').style.display = 'none';
                document.getElementById('commentedPosts').style.display = 'none';

                // Mostra a categoria clicada
                document.getElementById(category).style.display = 'flex';
            }

            function updateFavoriteList() {
                const favorites = JSON.parse(localStorage.getItem('favorites')) || [];
                const savedPostsDiv = document.getElementById('savedPosts');
                savedPostsDiv.innerHTML = '';

                favorites.forEach(fav => {
                    const savedPostDiv = document.createElement('div');
                    savedPostDiv.className = 'saved-post';
                    savedPostDiv.textContent = fav.name;
                    savedPostsDiv.appendChild(savedPostDiv);
                });
            }

            function clearFavorites() {
                localStorage.removeItem('favorites');
                updateFavoriteList(); // Atualiza a lista após a remoção
            }

            updateFavoriteList();

            function previewImage() {
                const imageInput = document.getElementById('imageInput');
                const profileImage = document.getElementById('profileImage');

                const file = imageInput.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const imageDataURL = e.target.result;
                        profileImage.src = imageDataURL;
                        // Salvar o caminho da imagem no armazenamento local
                        localStorage.setItem('profileImage', imageDataURL);

                        // Ocultar o input de arquivo após o upload
                        imageInput.style.display = 'none';
                    };
                    reader.readAsDataURL(file);
                }
            }

            // Verificar se há uma imagem armazenada localmente
            const storedImage = localStorage.getItem('profileImage');
            if (storedImage) {
                document.getElementById('profileImage').src = storedImage;

                // Ocultar o input de arquivo se houver uma imagem armazenada
                document.getElementById('imageInput').style.display = 'none';
            }
        </script>



    </div>
    <script src="../../js/navbar.js"></script>
</body>

</html>