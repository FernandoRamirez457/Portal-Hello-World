import { criarNoticia } from "./noticias_today.js";
import { criarNoticiaDeOntem } from "./noticias_yesterday.js";

// Função para fazer a requisição no localStorage ou na API
async function requisicaoNoticia(categoria) {
    const today = new Date();
    const yesterday = new Date(today);
    yesterday.setDate(today.getDate() - 1);

    const yesterdayFormatted = formatDateToISO8601(yesterday);
    const diaAtualFormatado = formatarData(today);
    const diaAnteriorFormatado = formatarData(yesterday);

    document.querySelector(".titulo_data_atual").innerHTML = `Últimas Noticias - ${diaAtualFormatado}`;
    document.querySelector(".titulo_data_anterior").innerHTML = `Postagens Anteriores:`;

    // Verificar se os dados estão no localStorage
    const dadosLocais = localStorage.getItem(categoria);

    if (dadosLocais) {
        const noticias = JSON.parse(dadosLocais);
        criarNoticia(noticias);
    }

    const array_categorys = ['general', 'sports', 'entertainment'];
    let category_url = '';
    
    switch (categoria) {
        case 'News':
            category_url = array_categorys[0]
            break;
        case 'Esportes':
            category_url = array_categorys[1]
            break;
        case 'Entretenimento':
            category_url = array_categorys[2]
            break;
        default:
            console.log('Categoria não reconhecida');
    }

    await requisicaoNoticiaDeOntem(yesterdayFormatted,category_url);
}

async function requisicaoNoticiaDeOntem(yesterdayFormatted,category_url) {
    try {
        const api = await fetch(`https://gnews.io/api/v4/top-headlines?to=${yesterdayFormatted}&category=${category_url}&lang=pt&country=br&max=6&apikey=07407256e88b4c5e821b5c06501a4970`);
        const noticias = await api.json();
        criarNoticiaDeOntem(noticias.articles);
    } catch (error) {
        console.error('Erro ao obter notícias de ontem:', error);
    }
}

const body = document.querySelector('body');
const categoria = body.classList[0];

// Capitalize a primeira letra da classe
const categoriaCapitalizada = capitalizeFirstLetter(categoria);

requisicaoNoticia(categoriaCapitalizada);

function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function formatarData(data) {
    const dia = String(data.getDate()).padStart(2, '0');
    const mes = String(data.getMonth() + 1).padStart(2, '0');
    const ano = data.getFullYear();
    return `${dia}/${mes}/${ano}`;
}

function formatDateToISO8601(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    const hours = String(date.getHours()).padStart(2, '0');
    const minutes = String(date.getMinutes()).padStart(2, '0');
    const seconds = String(date.getSeconds()).padStart(2, '0');

    return `${year}-${month}-${day}T${hours}:${minutes}:${seconds}Z`;
}