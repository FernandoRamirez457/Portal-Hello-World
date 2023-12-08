//funcionalidade do navbar
function openNav() {
  document.getElementById("sidebar").style.width = "250px";
}

function closeNav() {
  document.getElementById("sidebar").style.width = "0";
}

function toggleSearchField() {
  document.getElementById("searchIcon").style.display = "none";
  document.getElementById("closeIcon").style.display = "inline-block";
  document.getElementById("searchField").style.display = "flex";
}

function closeSearchField() {
  document.getElementById("searchIcon").style.display = "inline-block";
  document.getElementById("closeIcon").style.display = "none";
  document.getElementById("searchField").style.display = "none";
}

function openUserPage() {
  // Implemente a lógica para navegar até a página do usuário
  window.location.href = 'php/Login/login_cad.php';
}