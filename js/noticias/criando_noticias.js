const main = document.querySelector('main');

export function criarElementoJournalist(data, quantidade) {
    // Verifica se a quantidade é um número e maior que zero
    if (isNaN(quantidade) || quantidade <= 0) {
        console.error('Quantidade inválida. A quantidade deve ser um número maior que zero.');
        return;
    }

    // Verifica se há dados para exibir
    if (!data || data.length === 0) {
        const mensagem = document.createElement('p');
        mensagem.textContent = 'Ainda não há publicações.';
        main.appendChild(mensagem);
        return;
    }

    // Dividir os dados em sessões
    const sessoes = [];

    for (let i = 0; i < data.length; i += quantidade) {
        sessoes.push(data.slice(i, i + quantidade));
    }

    // Criar elementos para cada sessão
    sessoes.forEach((sessao, index) => {
        const section = document.createElement('section');
        section.classList.add('base-news-journalist', `sessao-${index + 1}`);

        sessao.forEach(item => {
            const baseJournalist = document.createElement('div');
            baseJournalist.classList.add('base-journalist');

            const usernameJournalist = document.createElement('div');
            usernameJournalist.classList.add('username-journalist');
            usernameJournalist.innerHTML = `
                <img src="./img/chico_barney.jfif" alt="">
                <h1>${item.nome_jornalista}</h1>
            `;

            const newsJournalist = document.createElement('div');
            newsJournalist.classList.add('news-journalist');
            newsJournalist.innerHTML = `
                <img src="./img/img_news_journalist/${item.imagens}" alt="">
                <div class="info">
                    <a href='pag_noticia.html?id=${item.id_noticia}'><h1 class="title">${item.titulo}</h1></a>
                    <p class="subtitle">${item.subtitulo}</p>
                    <p class="date">Publicado ${item.data_publicacao}</p>
                </div>
            `;

            baseJournalist.appendChild(usernameJournalist);
            baseJournalist.appendChild(newsJournalist);
            section.appendChild(baseJournalist);
        });

        // Adiciona a nova seção ao corpo do documento
        main.appendChild(section);
    });
}
