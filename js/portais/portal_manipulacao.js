const geralString = localStorage.getItem('Geral');
const geralData = JSON.parse(geralString);

const newsMain = document.querySelector('.news-main');
const mainLink = document.createElement('a');  // Criar um elemento de âncora
mainLink.href = geralData[0].url;  // Definir o atributo href para o URL desejado
mainLink.target = '_blank';  // Configurar para abrir em uma nova guia/janela
mainLink.textContent = geralData[0].title;  // Definir o texto do link
newsMain.children[0].appendChild(mainLink);  // Adicionar o link como filho do primeiro elemento da newsMain

// Define a imagem de fundo para a div news-main
newsMain.style.backgroundImage = `url(${geralData[0].image})`;

const miniNews = document.querySelectorAll('.mini-news');

miniNews.forEach((miniNewsItem, i) => {
    const h1 = miniNewsItem.querySelector('h1');
    const miniLink = document.createElement('a');  // Criar um elemento de âncora
    miniLink.href = geralData[i + 1].url;  // Definir o atributo href para o URL desejado
    miniLink.target = '_blank';  // Configurar para abrir em uma nova guia/janela
    miniLink.textContent = geralData[i + 1].title;  // Definir o texto do link
    h1.textContent = '';  // Limpar o texto atual do h1
    h1.appendChild(miniLink);  // Adicionar o link como filho do h1

    miniNewsItem.style.backgroundImage = `url(${geralData[i + 1].image})`;
});


// CATEGORIES
function updateCategoryData(categoryKey, startIdx, endIdx) {
    const categoryString = localStorage.getItem(categoryKey);
    const categoryData = JSON.parse(categoryString);

    let cont = 0;

    const categoryElements = document.querySelectorAll(`.news`);

    for (let i = startIdx; i <= endIdx && i < categoryData.length && i < categoryElements.length; i++) {
        const linknews = categoryElements[i].querySelector('a')
        linknews.setAttribute('target', '_blank')
        const title = categoryElements[i].querySelector('h1');
        const subtitle = categoryElements[i].querySelector('.subtitle')
        const date = categoryElements[i].querySelector('.date')
        const img_news = categoryElements[i].querySelector('img');

        if (title) {
            linknews.href = categoryData[cont].url
            title.textContent = categoryData[cont].title;
            subtitle.textContent = categoryData[cont].description

            const publicationDate = new Date(categoryData[cont].publishedAt);
            const formattedDate = new Intl.DateTimeFormat('pt-BR', {
                day: 'numeric',
                month: 'long',
                year: 'numeric',
                hour: 'numeric',
                minute: 'numeric'
            }).format(publicationDate);

            date.textContent = `Publicado em ${formattedDate}`;
        

            // Adiciona um ouvinte de erro para lidar com falhas no carregamento da imagem
            img_news.onerror = function () {
                // Verifica a categoria e define a cor de fundo apropriada
                if (categoryKey === 'News') {
                    img_news.style.backgroundColor = 'rgb(194, 0, 0)';
                } else if (categoryKey === 'Entretenimento') {
                    img_news.style.backgroundColor = '#8a2be2';
                } else if (categoryKey === 'Esportes') {
                    img_news.style.backgroundColor = 'rgb(0, 188, 0)';
                }
            };

            // Define o atributo src da imagem
            img_news.src = categoryData[cont].image;
        }
        cont += 1;
    }
}

updateCategoryData('News', 0, 2);
updateCategoryData('Entretenimento', 3, 5);
updateCategoryData('Esportes', 6, 8);
