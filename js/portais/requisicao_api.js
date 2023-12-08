const apiKey = '1873737ab342376342a6b17ce9614889';
const baseUrl = 'https://gnews.io/api/v4/top-headlines?lang=pt&country=br&max=10&apikey=' + apiKey;

// Função para fazer uma requisição e armazenar os dados no LocalStorage
function fazerRequisicaoECadastrarLocalStorage(categoria, url) {
    return fetch(url)
        .then(response => response.json())
        .then(data => {
            const articles = data.articles;
            localStorage.setItem(categoria, JSON.stringify(articles));
        })
        .catch(error => console.error(`Erro na requisição para ${categoria}:`, error));
}

// Array de Promises para todas as requisições
const requests = [
    fazerRequisicaoECadastrarLocalStorage('Geral', baseUrl),
    fazerRequisicaoECadastrarLocalStorage('News', baseUrl + '&topic=world'),
    fazerRequisicaoECadastrarLocalStorage('Esportes', baseUrl + '&topic=sports'),
    fazerRequisicaoECadastrarLocalStorage('Entretenimento', baseUrl + '&topic=entertainment')
];

// Aguarda até que todas as Promises sejam resolvidas
Promise.all(requests)
    .then(() => {
        // Todas as requisições foram concluídas
        window.location.href = '../portal.html';
    })
    .catch(error => console.error('Erro ao processar requisições:', error));
