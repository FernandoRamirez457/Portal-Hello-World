export function criarNoticiaDeOntem(noticias) {
    noticias.forEach(noticia => {
        var div_noticiaDireita = document.querySelector(".noticias_anteriores")
        div_noticiaDireita.innerHTML += ` 
            <div class="noticia_direita">
            <div class="div_img_noticia_direita">
              <img src="${noticia.image}" alt="imagem da noticia" />
            </div>
            <div class="div_descricao_noticia_direira">
              <h3>
              <a href="${noticia.url}" target="_blank">
              ${noticia.title}
              </a>
              </h3>
            </div>
          </div>
           `
    });
}