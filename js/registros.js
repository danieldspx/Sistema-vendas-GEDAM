function deleteTransaction (id) {
    $.ajax({
        url: 'functions_php/deleteRegistro.php',
        method: 'POST',
        type: 'POST',
        data: {id: id},
        success: function(msg){
            if(msg == "1"){
                Materialize.toast('Transação removida com sucesso.', 3000, 'green accent-3 cfontblack');
                $("#item"+id).remove();
            } else {
                Materialize.toast("Erro ao excluir a transação, tente novamente.", 6000, 'red lighten-1');
            }
        }
    });
}