import { criarElementoJournalist } from "./criando_noticias.js";

function fetchNoticias() {
    fetch('./select/select_json_noticias.php')
        .then(response => response.json())
        .then(data => {
            console.log(data);
            criarElementoJournalist(data, 2);
        })
        .catch(error => {
            console.error('Erro ao buscar dados: ', error);
        });
}

window.onload = function () {
    fetchNoticias();
};
