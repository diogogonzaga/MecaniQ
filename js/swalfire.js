// Script para os alertas bonitos 

function account(event) {
    event.preventDefault();

    Swal.fire({
        title: "Área exclusiva para oficinas",
html: "Esta página é apenas para oficinas.<br>Deseja prosseguir?",
         icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sim, entrar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "account/login/index.html";
        }
    });
}





