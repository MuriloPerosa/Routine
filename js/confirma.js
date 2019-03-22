
//REALIZA CONFIRMAÇÃO DE LOGOUT.
$("#logout").on("click", function () {
    return confirm("Tem certeza que deseja encerrar esta sessão?");
});

//REALIZA CONFIRMAÇÃO DE EXCLUSÃO.
$("#delete").on("click", function () {
    return confirm("Tem certeza que deseja realizar esta exclusão?");
});

