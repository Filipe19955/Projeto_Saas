$(document).ready(function() {    
    listar();    
} );

function listar(){
	var id_usuario = localStorage.id_usu;
    var id_empresa = localStorage.id_empresa;
    $.ajax({
        url: 'paginas/' + pag + "/listar.php",
        method: 'POST',
        data: {id_usuario, id_empresa},
        dataType: "html",

        success:function(result){
            $("#listar").html(result);
            $('#mensagem-excluir').text('');
        }
    });
}

function inserir(){
    $('#id_usuario').val(localStorage.id_usu);
    $('#id_empresa').val(localStorage.id_empresa);
    $('#mensagem').text('');
    $('#titulo_inserir').text('Inserir Registro');
    $('#modalForm').modal('show');
    limparCampos();
}




$("#form").submit(function () {

    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: 'paginas/' + pag + "/salvar.php",
        type: 'POST',
        data: formData,

        success: function (mensagem) {
            $('#mensagem').text('');
            $('#mensagem').removeClass()
            if (mensagem.trim() == "Salvo com Sucesso") {

                $('#btn-fechar').click();
                listar();          

            } else {

                $('#mensagem').addClass('text-danger')
                $('#mensagem').text(mensagem)
            }


        },

        cache: false,
        contentType: false,
        processData: false,

    });

});



function excluir(id){
    $('#mensagem-excluir').text('Excluindo...')
    var id_empresa = localStorage.id_empresa;
	var id_usuario = localStorage.id_usu;
    $.ajax({
        url: 'paginas/' + pag + "/excluir.php",
        method: 'POST',
        data: {id, id_usuario, id_empresa},
        dataType: "html",

        success:function(mensagem){
            if (mensagem.trim() == "Excluído com Sucesso") {
                listar();
            } else {
                $('#mensagem-excluir').addClass('text-danger')
                $('#mensagem-excluir').text(mensagem)
            }
        }
    });
}



function ativar(id, acao){
	var id_usuario = localStorage.id_usu;
    var id_empresa = localStorage.id_empresa;
    $.ajax({
        url: 'paginas/' + pag + "/mudar-status.php",
        method: 'POST',
        data: {id, id_usuario, acao, id_empresa},
        dataType: "html",

        success:function(mensagem){
            if (mensagem.trim() == "Alterado com Sucesso") {
                listar();
            } else {
                $('#mensagem-excluir').addClass('text-danger')
                $('#mensagem-excluir').text(mensagem)
            }
        }
    });
}





function baixar(id, pg, id_listar){    
    var id_usuario = localStorage.id_usu;
    var id_empresa = localStorage.id_empresa;

    if(pg != "" && pg != "undefined" && pg != undefined){        
        pag = pg;        
    }

    $.ajax({
        url: 'paginas/' + pag + "/baixar.php",
        method: 'POST',
        data: {id, id_usuario, id_empresa},
        dataType: "html",

        success:function(mensagem){
            if (mensagem.trim() == "Baixado com Sucesso") {
                if(id_listar == "" || id_listar == "undefined" || id_listar == undefined){
                    listar();
                }else{
                    listarContas(id_listar);
                    alert('Pagamento Confirmado!')
                }
                
                
            } else {
                $('#mensagem-excluir').addClass('text-danger')
                $('#mensagem-excluir').text(mensagem)
            }
        }
    });
}
