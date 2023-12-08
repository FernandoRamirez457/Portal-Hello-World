const Apikey = '1873737ab342376342a6b17ce9614889';

if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function (position) {
        const lat = position.coords.latitude;
        const long = position.coords.longitude;

        const urlApi = `https://api.openweathermap.org/data/2.5/weather?lang=pt_br&lat=${lat}&lon=${long}&appid=${Apikey}&units=metric`;

        fetch(urlApi)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                updateWeatherData(data);
            })
            .catch(error => console.error(`Erro na requisição para`, error));
    });
}

function updateWeatherData(data) {
    document.querySelector(".city").innerText = data.name;
    document.querySelector(".weather").innerText = capitalizeFirstLetter(data.weather[0].description);
    document.querySelector(".temp").innerText = `${Math.round(data.main.temp)}°C`;

    const img = document.querySelector('.img_clima');
    updateWeatherImage(data.weather[0].description, img);

    document.querySelector(".minTemp").innerText = `${Math.round(data.main.temp_min)}°C`;
    document.querySelector(".maxTemp").innerText = `${Math.round(data.main.temp_max)}°C`;
}

function updateWeatherImage(weatherDescription, img) {
    const weatherImages = {
        'ensolarado': './img/weather_ims/limpo.png',
        'chuva': './img/weather_ims/chuva.png',
        'nuvens carregadas': './img/weather_ims/chuva.png',
        'nuvens dispersas': './img/weather_ims/neblina.png',
        'nuvens trovejantes': './img/weather_ims/trovoada.png',
        'nevoeiro': './img/weather_ims/nublado.png',
        'neve': './img/weather_ims/nevando.png',
        'geada': './img/weather_ims/ventania.png',
        'granizo': './img/weather_ims/granizo.png',
        'vento Forte': './img/weather_ims/ventania.png',
        'chuvisco': './img/weather_ims/chuva.png',
        'céu limpo': './img/weather_ims/limpo.png',
        'neblina': './img/weather_ims/neblina.png',
        'chuva fraca': './img/weather_ims/chuva.png',
        'chuva torrencial': './img/weather_ims/chuva.png',
        'calor abrasador': './img/weather_ims/limpo.png',
        'garoa': './img/weather_ims/garoa.png',
        'nublado': './img/weather_ims/nublado.png',
    };

    const defaultImage = './img/weather_ims/default.png';

    img.src = weatherImages[weatherDescription] || defaultImage;
}

function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}
