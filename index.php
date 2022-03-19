<?php

include('function.php');

?>

<!doctype html>
<html lang="pt-BR">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="library/jstable.css" />

    <script src="library/jstable.min.js" type="text/javascript"></script>

    <title>Doações</title>
</head>

<body>

    <div class="container">
        <h1 class="mt-5 mb-5 text-center text-danger"><b>Doações</b></h1>

        <span id="success_message"></span>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col col-md-6">Dados do cliente</div>
                    <div class="col col-md-6" align="right">
                        <button type="button" name="add_data" id="add_data" class="btn btn-success btn-sm">Adicionar</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tabela_cliente" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nome Completo</th>
                                <th>Email</th>
                                <th>CPF</th>
                                <th>Telefone</th>
                                <th>Data de Nascimento</th>
                                <th>Data do Cadastro</th>
                                <th>Intervalo de Doação</th>
                                <th>Valor da Doação</th>
                                <th>Forma de Pagamento</th>
                                <th>Endereço</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo fetch_top_five_data($connect); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>


<div class="modal" id="cliente_modal" tabindex="-1">
    <form method="post" id="form_cliente">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="modal_title">Adicionar Cliente</h5>

                    <button type="button" class="btn-close" id="close_modal" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Nome Completo</label>
                        <input type="text" name="nome_completo" id="nome_completo" class="form-control" />
                        <span class="text-danger" id="nome_completo_erro"></span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" name="email" id="email" class="form-control" />
                        <span class="text-danger" id="email_erro"></span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">CPF</label>
                        <input type="text" name="cpf" id="cpf" class="form-control" />
                        <span class="text-danger" id="cpf_erro"></span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Telefone</label>
                        <input type="text" name="telefone" id="telefone" class="form-control" />
                        <span class="text-danger" id="telefone_erro"></span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Data de Nascimento</label>
                        <input type="text" name="data_nascimento" id="data_nascimento" class="form-control" />
                        <span class="text-danger" id="data_nascimento_erro"></span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Data do Cadastro</label>
                        <input type="text" name="data_cadastro" id="data_cadastro" class="form-control" />
                        <span class="text-danger" id="data_cadastro_erro"></span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Intervalo de Doação</label>
                        <select name="intervalo_doacao" id="intervalo_doacao" class="form-control">
                            <option value="Debito">Único</option>
                            <option value="Bimestral">Bimestral</option>
                            <option value="Semestral">Semestral</option>
                            <option value="Anual">Anual</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Valor da Doação</label>
                        <input type="text" name="valor_doacao" id="valor_doacao" class="form-control" />
                        <span class="text-danger" id="valor_doacao_erro"></span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Forma de Pagamento</label>
                        <select name="forma_pagamento" id="forma_pagamento" class="form-control">
                            <option value="Debito">Débito</option>
                            <option value="Credito">Crédito</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Endereço</label>
                        <input type="text" name="endereco" id="endereco" class="form-control" />
                        <span class="text-danger" id="endereco_erro"></span>
                    </div>

                </div>

                <div class="modal-footer">

                    <input type="hidden" name="cliente_id" id="cliente_id" />
                    <input type="hidden" name="action" id="action" value="Adicionar" />
                    <button type="button" class="btn btn-primary" id="action_button">Adicionar</button>
                </div>

            </div>

        </div>

    </form>

</div>

<div class="modal-backdrop fade show" id="modal_backdrop" style="display:none;"></div>

<script>
    var table = new JSTable("#tabela_cliente", {
        serverSide: true,
        deferLoading: <?php echo count_all_data($connect); ?>,
        ajax: "fetch.php"
    });

    function _(element) {
        return document.getElementById(element);
    }

    function open_modal() {
        _('modal_backdrop').style.display = 'block';
        _('cliente_modal').style.display = 'block';
        _('cliente_modal').classList.add('show');
    }

    function close_modal() {
        _('modal_backdrop').style.display = 'none';
        _('cliente_modal').style.display = 'none';
        _('cliente_modal').classList.remove('show');
    }

    function reset_data() {
        _('form_cliente').reset();
        _('action').value = 'Adicionar';
        _('nome_completo_erro').innerHTML = '';
        _('email_erro').innerHTML = '';
        _('cpf_erro').innerHTML = '';
        _('telefone_erro').innerHTML = '';
        _('data_nascimento_erro').innerHTML = '';
        _('data_cadastro_erro').innerHTML = '';
        _('valor_doacao_erro').innerHTML = '';
        _('endereco_erro').innerHTML = '';
        _('modal_title').innerHTML = 'Adicionar Cliente';
        _('action_button').innerHTML = 'Adicionar';
    }

    _('add_data').onclick = function() {
        open_modal();
        reset_data();
    }

    _('close_modal').onclick = function() {
        close_modal();
    }

    _('action_button').onclick = function() {

        var form_data = new FormData(_('form_cliente'));

        _('action_button').disabled = true;

        fetch('action.php', {

            method: "POST",

            body: form_data

        }).then(function(response) {

            return response.json();

        }).then(function(responseData) {

            _('action_button').disabled = false;

            if (responseData.success) {
                _('success_message').innerHTML = responseData.success;

                close_modal();

                table.update();
            } else {
                if (responseData.nome_completo_erro) {
                    _('nome_completo_erro').innerHTML = responseData.nome_completo_erro;
                } else {
                    _('nome_completo_erro').innerHTML = '';
                }

                if (responseData.email_erro) {
                    _('email_erro').innerHTML = responseData.email_erro;
                } else {
                    _('email_erro').innerHTML = '';
                }

                if (responseData.cpf_erro) {
                    _('cpf_erro').innerHTML = responseData.cpf_erro;
                } else {
                    _('cpf_erro').innerHTML = '';
                }

                if (responseData.telefone_erro) {
                    _('telefone_erro').innerHTML = responseData.telefone_erro;
                } else {
                    _('telefone_erro').innerHTML = '';
                }

                if (responseData.data_nascimento_erro) {
                    _('data_nascimento_erro').innerHTML = responseData.data_nascimento_erro;
                } else {
                    _('data_nascimento_erro').innerHTML = '';
                }

                if (responseData.data_cadastro_erro) {
                    _('data_cadastro_erro').innerHTML = responseData.data_cadastro_erro;
                } else {
                    _('data_cadastro_erro').innerHTML = '';
                }

                if (responseData.valor_doacao_erro) {
                    _('valor_doacao_erro').innerHTML = responseData.valor_doacao_erro;
                } else {
                    _('valor_doacao_erro').innerHTML = '';
                }

                if (responseData.endereco_erro) {
                    _('endereco_erro').innerHTML = responseData.endereco_erro;
                } else {
                    _('endereco_erro').innerHTML = '';
                }
            }

        });

    }

    function fetch_data(id) {
        var form_data = new FormData();

        form_data.append('id', id);

        form_data.append('action', 'fetch');

        fetch('action.php', {

            method: "POST",

            body: form_data

        }).then(function(response) {

            return response.json();

        }).then(function(responseData) {

            _('nome_completo').value = responseData.nome_completo;

            _('email').value = responseData.email;

            _('cpf').value = responseData.cpf;

            _('telefone').value = responseData.telefone;

            _('data_nascimento').value = responseData.data_nascimento;

            _('data_cadastro').value = responseData.data_cadastro;

            _('intervalo_doacao').value = responseData.intervalo_doacao;

            _('valor_doacao').value = responseData.valor_doacao;

            _('forma_pagamento').value = responseData.forma_pagamento;

            _('endereco').value = responseData.endereco;

            _('cliente_id').value = id;

            _('action').value = 'Atualizar';

            _('modal_title').innerHTML = 'Editar Cliente';

            _('action_button').innerHTML = 'Editar';

            open_modal();

        });
    }

    function delete_data(id) {
        if (confirm("Você tem certeza que quer deleta-lo?")) {
            var form_data = new FormData();

            form_data.append('id', id);

            form_data.append('action', 'delete');

            fetch('action.php', {

                method: "POST",

                body: form_data

            }).then(function(response) {

                return response.json();

            }).then(function(responseData) {

                _('success_message').innerHTML = responseData.success;

                table.update();

            });
        }
    }
</script>