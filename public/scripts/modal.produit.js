$(document).ready(() => {

    $(".produit-test").click(async (event) => {
        console.log(event);
        event.preventDefault();

        const href = event.currentTarget.href;

        const responce = await axios.get(href);
        if (responce.status === 200) {
            $("#produit-modal-content").html(responce.data);
            const produitViewModal = new bootstrap.Modal(document.getElementById("produit-modal"), {})
            produitViewModal.show()
        }
    });


})