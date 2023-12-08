 export function criarNoticia(noticias) {
    noticias.forEach((noticia, index) => {
        var div_noticia = document.querySelector(".noticias__esquerda")
        div_noticia.innerHTML += ` 
          <div class="noticia">
            <div class="div_imagem_noticia">
              <img src="${noticia.image}" alt="imagem da noticia" />
            </div>
            <div class="div_descricao_noticia">
              <a class="linkNoticia" href="${noticia.url}" target="_blank">
                 <h3>${noticia.title}</h3>
              </a>
              <p>
                ${noticia.description}
              </p>
            </div>
          </div>`

        // Supondo que 'index' seja definido antes desta parte do código

        // Verificar se o elemento com a classe `.imgCarrossel${index}` existe
        var imgCarrossel1 = document.querySelector(`.imgCarrossel${index}`);

        if (imgCarrossel1) {
            // Atribuir a imagem do carrossel
            imgCarrossel1.src = noticia.image;
        }

        // Verificar se o elemento com a classe ".titulo_carrossel1" existe
        var titulo_carrossel1 = document.querySelector(`.titulo_carrossel${index}`);

        if (titulo_carrossel1) {
            // Atribuir o texto ao título do carrossel
            titulo_carrossel1.textContent = noticia.title;
        }

    });
}