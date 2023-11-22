const a = document.getElementById("card1")
const buttonClose = document.getElementById("fechar-modal")
const modal = document.getElementById("home-dialog")

a.onclick = function () {
    modal.showModal()
}

buttonClose.onclick = function () {
    modal.close();
}

const avaliar = document.getElementById("avaliar")
const avaliarClose = document.getElementById("avaliar-close")
const modalAvaliar = document.querySelector("modal-avaliacao")
const bodyDialog = document.getElementById("fundoDialog")

avaliar.onclick = function () {
    modalAvaliar.showModal();
    bodyDialog.style.display = "block";
};

avaliarClose.onclick = function () {
    modalAvaliar.close();
}