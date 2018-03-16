
# Sistema de Gerenciamento de Vendas - GEDAM
Sistema a ser utilizado nas vendas do GEDAM durante eventos.
Sistema criado por: Daniel dos Santos Pereira

## Getting Started
* Crie um Banco de Dados com o nome de "SGVC"
* Acesse o DB "SGVC" (criado no passo anterior) e importe o arquivo "SGVC.sql" da pasta "Modelo DB"
* Adicione seu usuário e senha para acessar o sistema na tabela "staff". A senha deve ser uma string de 32 caracteres resultado de uma criptografia md5.
  * Para criar a senha em md5 dê um "echo md5('12345678');" onde 12345678 é a sua senha, para isso você pode usar o site [PHPTester](http://phptester.net/) que simula um arquivo PHP sendo executado e mostra o resultado.
  * Ex. de Usuário: user_teste, Senha: 12345678 :
    ```
    INSERT INTO staff(nome, usuario, senha) VALUES ("Nome Teste","user_teste","25d55ad283aa400af464c76d713c07ad");
    ```
* Acesse o arquivo "config.php" em "./private_html_protected/config.php".
  * Altere as constantes 'DB_PASSWORD' e 'DB_USERNAME' para a senha e username do seu phpMyAdmin, respectivamente. 
* Acesse:
  ```
  127.0.0.1/SGVC/ ou localhost/SGVC/
  ```
* Faça o Login utilizando o usuário e senha que você criou.


## Primeiros passos:

Todas as páginas são acessiveis por esse menu fluatuante:

![](https://imgur.com/HPCJBoC.png)

### Adicionar Item

 1. Adicione os itens do sistema: Clicle no icone "Gerenciar Itens"
 
 ![](https://i.imgur.com/5XZlci1.png)
 
 2. Na página de ***Gerenciar Itens*** você deverá clicar no icone "Adicionar novo item"
 
 ![enter image description here](https://imgur.com/xA5fn0A.png)
 
 3. Digite as informações relevantes e **não se esqueça de escolher a
    cor no gráfico**. Utilize ponto e **NÃO VÍRGULAS** no preço dos itens.

	 
	 - Esta cor é para identificação do item no gráfico gerado pelo sistema
   na página **"Gráficos"** referente às vendas realizadas.
   
    - Observe que ao adicionar o item temos a opção **"Venda"** com os valores *"Ativada"* ou *"Desativada"*. Caso você deixe marcado *"Desativada"* (que é o valor padrão), o item não será disponibilizado para venda, apesar de estar presente no sistema. Isso pode ser útil caso algum item acabe do estoque e você queira removê-lo do painel de vendas.
    
    ![enter image description here](https://imgur.com/6C77ceG.png)
    

 4. Clique no botão **"Salvar este item"**.
----------
### Realizar venda

 1. No painel de vendas, adicione os itens requeridos pelo cliente clicando no botão de mais. Para remover, clique no botão de menos. Você poderá digitar caso o valor seja alto ou caso lhe convenha.
 2. O total a ser pago pelo cliente será mostrado no canto superior esquerdo.
 3. Digite o valor entregue pelo cliente no campo **"Pagamento"** e clique em pagar. Vamos simular que o cliente comprou 1 refrigerante e 2 pipocas. O valor total é de R$ 3.5 e o cliente entregou uma nota de 10 reais.
 
 ![enter image description here](https://imgur.com/efmsj9i.png)
 
4. Ao clicar no botão **PAGAR** o sistema mostrará o troco (se houver) e as opções de **PAGAR** (para efetuar a venda) e **CANCELAR** (para cancelar a venda caso o cliente tenha desistido da compra). Ao clicar em **PAGAR** o sistema limpará todos os campos e reiniciará para uma nova venda, além de confirmar a compra.

![](https://imgur.com/2WgzlLX.png)

  - Deseja cancelar a venda e apagar os campos para iniciar uma nova venda? Clique em **CANCELAR**, e depois clique no botão flutuante e clique no icone **Limpar input's** (É o último icone Azul da esquerda).
----------
### Alterar venda efetuada
Há casos em que o cliente comprou e você efetuou a compra no sistema, mas ele voltou atrás ou quando ele foi buscar o estoque já tinha acabado. Então você deverá devolver o dinheiro. Para o ***Valor total arrecadado*** , disponibilizado pela página de gráfico, ser o mais preciso possível deveremos cancelar a venda desse cliente. Para isso sigas os passos:

 1. Vamos cancelar a compra que acabamos de realizar. Observe que antes de cancelarmos os gráficos mostram o valor toral arrecadado como R$ 3.5
 
 ![enter image description here](https://imgur.com/hqdIAl7.png)
 
 2. Acesse a página de registros e clique no icone da lixeira para excluir a transação. Observe que cada tipo de item gera um transação. Se vendemos pipoca e refrigerante serão geradas duas transações. As transações geradas na mesma venda terão a ***Hora*** de venda igual.
 
 ![enter image description here](https://imgur.com/ozMwfXe.png)

3. Se verificarmos a página de **Gráficos** veremos que os gráficos não serão gerados e o valor arrecadado será R$ 0, como já era de





 se esperar uma vez que não há nenhuma transação registrada.
 
![enter image description here](https://imgur.com/PA8Vvs0.png)

----------
### Encerrar sessão - Logout
Para sair basta clicar no ícone vermelho no canto superior direito.

![enter image description here](https://imgur.com/Rsg2uqy.png)
