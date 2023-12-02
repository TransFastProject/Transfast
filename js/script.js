// Pega todos os elementos com a classe 'card-transporte'
const cards = document.querySelectorAll('.card-transporte');
const buttonClose = document.getElementById("fechar-modal");
const modal = document.getElementById("home-dialog");

cards.forEach(card => {
    card.onclick = function () {
        const nome = card.dataset.nome;
        const telefone = card.dataset.telefone;
        const bairro = card.dataset.bairro;
        const estado = card.dataset.estado;
        const cidade = card.dataset.cidade;
        const monitor = card.dataset.monitor;

        // Atualiza as informações no modal
        document.querySelector('.nome').textContent = nome;
        document.querySelector('.telefone').textContent = telefone;
        document.querySelector('.bairro').textContent = bairro;
        document.querySelector('.estado').textContent = estado;
        document.querySelector('.cidade').textContent = cidade;
        document.querySelector('.monitor').textContent = monitor;

        // Exibe a foto do motorista
        const fotoBase64 = card.dataset.foto;
        document.querySelector('.foto').src = 'data:image/png;base64,' + fotoBase64;

        modal.showModal();
    };
});


// Adiciona o evento de clique ao botão de fechar
buttonClose.onclick = function () {
    modal.close();
};
