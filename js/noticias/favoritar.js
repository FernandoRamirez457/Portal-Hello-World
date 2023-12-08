var icons = document.querySelectorAll('.favorite-icon');
var isFavoritedArray = Array.from({ length: icons.length }, () => false);

icons.forEach(function(icon, index) {
    icon.addEventListener('click', function() {
        toggleFavorite(index);
    });
});

function toggleFavorite(iconIndex) {
    isFavoritedArray[iconIndex] = !isFavoritedArray[iconIndex];
    localStorage.setItem('favorited', JSON.stringify(isFavoritedArray));
    updateIcon();
}

function updateIcon() {
    icons.forEach(function(icon, index) {
        icon.classList.toggle('favorited', isFavoritedArray[index]);
    });
}
