var contadorItem = 1;

function appendItem(){
    $(".itens").append("<div class='row reference"+contadorItem+"'><div class='input-field col s3'><input id='itemX"+contadorItem+"' type='text' ><label class='active'>Nome</label></div><div class='input-field col s1'><input id='precoX"+contadorItem+"' type='number' ><label class='active'>Preço</label></div><div class='input-field col s1'><input id='qtdX"+contadorItem+"' type='number' ><label class='active'>Quantidade</label></div><div class='input-field col s3'><label class='active'>Venda</label><div class='switch'><label>Desativada<input type='checkbox' id='estoqueX"+contadorItem+"'><span class='lever'></span>Ativada</label></div></div><div class='input-field col s2'><input id='colorX"+contadorItem+"' type='text'><label for='colorX"+contadorItem+"' style='font-size: .8rem;-webkit-transform: translateY(-140%);transform: translateY(-140%);'>Cor no Gráfico</label></div><div class='input-field col s2'><i class='material-icons saveIcon' title='Salvar este item' onclick='addItem("+contadorItem+")'>save</i> <i class='material-icons deleteIcon' title='Remover este item.' onclick=\"$('.reference"+contadorItem+"').remove();\">remove_circle_outline</i></div></div>");
    $('#color'+contadorItem).ready(function(){
        $('#colorX'+contadorItem).spectrum({color: 'rgb(0,0,0)',preferredFormat: 'rgb',showAlpha: true});
    });
    contadorItem++;
}

function addItem (referencia) {
    var nome = $('#itemX'+referencia).val();
    var preco = $('#precoX'+referencia).val();
    var qtd = $('#qtdX'+referencia).val();
    var color = $('#colorX'+referencia).val();
    var flag = $('#estoqueX'+referencia).prop("checked") ? 1 : 0;
    var flagText = "";
    if(flag == 1){
       flagText = "checked";
    }
    $.ajax({
        url: 'functions_php/addItem.php',
        method: 'POST',
        type: 'POST',
        data: {nome: nome, preco: preco, quantidade: qtd, flag: flag, color:color},
        success: function(id){
            if($.isNumeric(parseInt(id))){
                Materialize.toast('Item adicionado com sucesso.', 3000, 'green accent-3 cfontblack');
                $('#color'+referencia).spectrum("destroy"); //Desliga o color picker
                $('.reference'+referencia).remove();
                $(".itens").append("<div class='row linha"+id+"'><div class='input-field col s3'><input id='item"+id+"' type='text' value='"+nome+"' ><label for='item"+id+"' class='active'>Nome</label></div><div class='input-field col s1'><input id='preco"+id+"' type='number' value='"+preco+"' ><label for='preco"+id+"' class='active'>Preço</label></div><div class='input-field col s1'><input id='qtd"+id+"' type='number' value='"+qtd+"' ><label for='qtd"+id+"' class='active'>Quantidade</label></div><div class='input-field col s3'><label class='active'>Venda</label><div class='switch'><label>Desativada<input type='checkbox' "+flagText+" id='estoque"+id+"'><span class='lever'></span>Ativada</label></div></div><div class='input-field col s2'><input id='color"+id+"' type='text'><label for='color"+id+"' style='font-size: .8rem;-webkit-transform: translateY(-140%);transform: translateY(-140%);'>Cor no Gráfico</label></div><div class='input-field col s2'><i class='material-icons saveIcon mr20' title='Salvar alterações.' onclick='updateItem("+id+")'>cloud_upload</i><i class='material-icons deleteIcon' title='Delete este item' onclick='deleteItem("+id+")'>delete_forever</i></div></div>");
                $('#color'+id).ready(function(){
                    console.log(color);
                    $('#color'+id).spectrum({color: color,preferredFormat: 'rgb',showAlpha: true});
                });
            } else {
                Materialize.toast("Houve algum erro ao salvar o item, tente novamente.", 6000, 'red lighten-1');
            }
        }
    });
}

function updateItem (referencia) { //Atualiza item no DB
    var nome = $('#item'+referencia).val();
    var preco = $('#preco'+referencia).val();
    var qtd = $('#qtd'+referencia).val();
    var flag = $('#estoque'+referencia).prop("checked") ? 1 : 0;
    var color = $('#color'+referencia).val();
    console.log(color);
    var flagText = "";
    if(flag == 1){
       flagText = "checked";
    }
    $.ajax({
        url: 'functions_php/updateItem.php',
        method: 'POST',
        type: 'POST',
        data: {nome: nome, preco: preco, quantidade: qtd, flag: flag, id: referencia, color: color},
        success: function(msg){
            if(msg == "1"){
                Materialize.toast('Item atualizado com sucesso.', 3000, 'green accent-3 cfontblack');
            } else {
                Materialize.toast("Houve algum erro ao atualizar o item, tente novamente.", 6000, 'red lighten-1');
            }
        }
    });
}

function deleteItem (referencia) {
    $.ajax({
        url: 'functions_php/deleteItem.php',
        method: 'POST',
        type: 'POST',
        data: {id: referencia},
        success: function(msg){
            if(msg == "1"){
                Materialize.toast('Item deletado com sucesso.', 3000, 'green accent-3 cfontblack');
                $('.linha'+referencia).remove();
            } else {
                Materialize.toast("Houve algum erro ao deletar o item, tente deletar as transações relacionadas com este item.", 6000, 'red lighten-1');
            }
        }
    });
}