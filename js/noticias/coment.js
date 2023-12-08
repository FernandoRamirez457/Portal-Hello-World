function addComment() {
    // Obter o valor do comentário
    var commentText = document.getElementById('comment').value;

    // Criar uma nova caixa de comentário
    var newCommentBox = document.createElement('div');
    newCommentBox.className = 'comment-box';
    newCommentBox.innerHTML = '<p>' + commentText + '</p>';

    // Adicionar a nova caixa de comentário ao contêiner
    document.getElementById('commentsContainer').appendChild(newCommentBox);

    // Limpar o campo de comentário
    document.getElementById('comment').value = '';
}