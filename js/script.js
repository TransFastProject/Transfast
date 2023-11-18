const a = document.getElementById("card1")
const buttonClose = document.getElementById("fechar-modal")
const modal = document.querySelector("dialog")

a.onclick = function () {
    modal.showModal()
}

buttonClose.onclick = function () {
    modal.close();
}

