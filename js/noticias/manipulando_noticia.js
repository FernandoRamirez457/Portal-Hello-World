function fetchNoticias() {
    // Obter o ID da URL
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('id');

    if (!id) {
        console.error('ID não encontrado na URL.');
        return;
    }

    fetch('./select/select_json_noticias.php')
        .then(response => response.json())
        .then(data => {
            const news = data.find(item => item.id_noticia == id);

            if (!news) {
                console.error('Notícia não encontrada para o ID fornecido.');
                return;
            }

            exibirNoticia(news);
        })
        .catch(error => {
            console.error('Erro ao buscar dados: ', error);
        });
}

function exibirNoticia(news) {
    console.log(news);

    // Atualizar o título da página
    document.title = news.titulo;

    // Atualizar os elementos do DOM com os dados da notícia
    atualizarElemento('.title', news.titulo);
    atualizarElemento('.subtitle', news.subtitulo);
    atualizarElemento('.date', formatarData(news.data_publicacao));
    const imgElement = document.querySelector('.img_news');

    if (imgElement && news.imagens) {
        // Construir a URL completa da imagem
        const urlCompleta = `./img/img_news_journalist/${news.imagens}`;
        
        // Atualizar o atributo src da imagem
        imgElement.src = urlCompleta;
        imgElement.alt = "Imagem da notícia";
    }


    // Processar o texto da notícia
    const resultado = processarTexto(news.texto);

    console.log(resultado);
    // Atualizar o elemento de resultado com o HTML gerado
    document.querySelector('.content').innerHTML = resultado;
}

function atualizarElemento(seletor, valor) {
    const elemento = document.querySelector(seletor);
    if (elemento) {
        elemento.textContent = valor;
    }
}

function processarTexto(texto) {
    // Dividir o texto em linhas
    const linhas = texto.split('\n');

    // Inicializar string para armazenar o resultado
    let resultado = '';

    // Iterar sobre cada linha do texto
    for (let i = 0; i < linhas.length; i++) {
        const linha = linhas[i].trim();

        // Verificar se a linha é marcada como subtítulo
        if (linha.startsWith('# ')) {
            // Adicionar formato para subtítulo (negrito e tamanho 28px)
            resultado += `<h2 style="font-size: 28px; font-weight: bold;">${linha.substring(2)}</h2>`;
        } else if (linha.includes('"')) {
            // Verificar se a linha contém aspas duplas
            const partes = linha.split('"');
            resultado += `<p style="font-size: 20px; font-weight: bold;" class='entrevista'>${partes[0]}"<span style="font-size: 20px; font-weight: bold;">${partes[1]}</span>"${partes[2] || ''}</p>`;
        } else {
            // Caso contrário, é considerado texto normal
            resultado += `<p>${linha}</p>`;
        }
    }

    return resultado;
}


function formatarData(dataString) {
    const data = new Date(dataString);
    const options = { day: '2-digit', month: 'long', year: 'numeric' };

    const dia = data.toLocaleString('pt-BR', { day: '2-digit' });
    const mes = data.toLocaleString('pt-BR', { month: 'long' });
    const ano = data.toLocaleString('pt-BR', { year: 'numeric' });

    return `Publicado ${dia} de ${mes} de ${ano}`;
}

window.onload = function () {
    fetchNoticias();
};
