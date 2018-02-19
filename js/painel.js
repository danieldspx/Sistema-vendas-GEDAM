var estoque = [];
var total = 0;

$.fn.extend({
  animateCss: function(animationName, callback) {
    var animationEnd = (function(el) {
      var animations = {
        animation: 'animationend',
        OAnimation: 'oAnimationEnd',
        MozAnimation: 'mozAnimationEnd',
        WebkitAnimation: 'webkitAnimationEnd',
      };

      for (var t in animations) {
        if (el.style[t] !== undefined) {
          return animations[t];
        }
      }
    })(document.createElement('div'));

    this.addClass('animated ' + animationName).one(animationEnd, function() {
      $(this).removeClass('animated ' + animationName);

      if (typeof callback === 'function') callback();
    });

    return this;
  },
});

function updateQuantidade(){
    $.ajax({
        url: 'functions_php/searchQtd.php',
        method: 'POST',
        type: 'POST',
        success: function(msg){
            var exploded = msg.split('&');
            exploded.forEach(function(item){ //Setta a quantidade em um array estoque em que o id é o indice
                let id = parseInt(item.substring(0,item.indexOf('-')));
                let quantidade = parseInt(item.substring(item.indexOf('-')+1));
                estoque[id] = quantidade;
            });
        }
    });
}

$(document).ready(function(){    
    $('.plus').click(function(){ //Aumenta quantidade de itens do input
        let id = "#"+this.dataset.reference;
        let value = isNaN($(id).val()) ? 0 : $(id).val();
        value++;
        $(id).val(value);
    });
    $('.minus').click(function(){ //Diminui quantidade de itens do input
        let id = "#"+this.dataset.reference;
        let value = isNaN($(id).val()) ? 0 : $(id).val();
        if(value>0){
            value--;
            $(id).val(value); 
        }
    });
    $('.qtdItemInput').change(function(){ //Evitar numeros negativos no input
        if(this.value<0 || this.value == null){
           this.value = 0;
        }
        updateTotal();
    });
    $('.qtdItemInput').click(function(){ //Caso a pessoa queira digitar
        this.select();
    });
    $.ajax({ //Busca precos
        url: 'functions_php/searchPreco.php',
        method: 'POST',
        type: 'POST',
        success: function(msg){
            var exploded = msg.split('&');
            exploded.forEach(function(item){
                let id = item.substring(0,item.indexOf('-'));
                let preco = parseFloat(item.substring(item.indexOf('-')+1));
                $("#item"+id).data('preco',preco);
            });
        }
    });
    updateQuantidade();
});

function updateTotal () {
    total = 0;
    $('.qtdItemInput').each(function(){//Percorre todos os inputs para somar o total
        let preco = parseFloat($("#"+this.id).data('preco'));
        let quantidade = parseInt(this.value);
        total += quantidade * preco;
    });
    updateTotalInput();
}

function updateTotalInput () { //Atualiza o input de total da venda
    $("#totalInput").val(total);
    Materialize.updateTextFields();
}


function plusItem (id) { //Aumenta quantidade de itens na compra na variavel total
    total += parseFloat($("#item"+id).data('preco'));
    updateTotalInput();
}

function minusItem (id) { //Diminui quantidade de itens na compra na variavel total
    if($("#item"+id).val()>0){
        total -= parseFloat($("#item"+id).data('preco'));
        updateTotalInput();
    }
}

function verificaEstoque () { //Evitar vender mais do que itens no estoque
    var flag = 0;
    $('.qtdItemInput').each(function(){
        var indice = parseInt(this.dataset.reference);
        if(this.value>estoque[indice]){
            Materialize.toast("Apenas "+estoque[indice]+" "+$('#nome'+this.dataset.reference).text()+"(s) em estoque.", 3000, 'red lighten-1');
            flag = 1;
        }
    });
    if(flag == 1){ //Se algum item passou da quantidade em estoque
       return false;
    } else {
        return true;
    }
}

function openPayment () { //Abre poup-up de confirmacao de pagamento
    updateQuantidade();
    if(verificaEstoque()){
        updateTotal();
        var totalP = parseFloat($('#totalInput').val());
        var pagamento = parseFloat($('#pagamentoInput').val());
        if(pagamento>=totalP){
            $('#popTotal').text(total);
            $('#popPago').text(pagamento);
            $('#popTroco').text(pagamento-totalP);
            $('.poupup').css('display','block');
            $('.poupup').animateCss('fadeIn');
        } else {
            Materialize.toast("O pagamento é menor que o total.", 4000, 'red lighten-1');
        }
    }
}

function closePayment () { //Fecha poup-up de confirmacao de pagamento
    $('.poupup').animateCss('fadeOut',function(){
        $('.poupup').css('display','none');
        $('#popTotal').text("");
        $('#popPago').text("");
        $('#popTroco').text("");
    });
}

function registerTransation () { //Salva transacao no DB
    $("#btnTransaction").addClass("disabled");
    var chain = "";
    $('.qtdItemInput').each(function(){
        if(this.value>0){
            chain += this.dataset.reference+"_"+this.value+"&";
        }
    });
    if(chain.slice(-1)=='&'){
        chain = chain.substring(0,chain.length-1);
    }
    $.ajax({
        url: 'functions_php/registerTransaction.php',
        method: 'POST',
        type: 'POST',
        data: {chain: chain},
        success: function(msg){
            if(msg=='1'){
                Materialize.toast('Transação efetuada com sucesso.', 3000, 'green accent-3 cfontblack');
                closePayment();
                clearEverything();
                $("#btnTransaction").removeClass("disabled");
            } else {
                Materialize.toast("Erro na transação.", 4000, 'red lighten-1');
            }
        }
    });
}

function clearEverything(){
    $('#pagamentoInput').val('');
    total = 0;
    updateTotalInput();
    $('.qtdItemInput').each(function(){
        this.value = 0;
    });
}

