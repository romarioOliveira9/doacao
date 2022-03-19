<?php

//action.php

include('function.php');

if(isset($_POST["action"]))
{
	if($_POST["action"] == 'Adicionar' || $_POST["action"] == 'Atualizar')
	{
		$output = array();
		$nome_completo = $_POST["nome_completo"];
		$email = $_POST["email"];
		$cpf = $_POST["cpf"];
		$telefone = $_POST["telefone"];
		$data_nascimento = $_POST["data_nascimento"];
		$data_cadastro = $_POST["data_cadastro"];
		$valor_doacao = $_POST["valor_doacao"];
		$endereco = $_POST["endereco"];

		$intervalo_doacao = $_POST["intervalo_doacao"];
		$forma_pagamento = $_POST["forma_pagamento"];

		if(empty($nome_completo))
		{
			$output['nome_completo_erro'] = 'Nome Completo é obrigatório';
		}

		if(empty($email))
		{
			$output['email_erro'] = 'Email é obrigatório';
		}
		else
		{
			if(!filter_var($email, FILTER_VALIDATE_EMAIL))
			{
				$output['email_erro'] = 'Formato de e-mail inválido';
			}
		}

		if(empty($cpf))
		{
			$output['cpf_erro'] = 'CPF é obrigatório';
		}

		if(empty($telefone))
		{
			$output['telefone_erro'] = 'Telefone é obrigatório';
		}

		if(empty($data_nascimento))
		{
			$output['data_nascimento_erro'] = 'Data de Nascimento é obrigatório';
		}

		if(empty($data_cadastro))
		{
			$output['data_cadastro_erro'] = 'Data do Cadastro é obrigatório';
		}

		if(empty($valor_doacao))
		{
			$output['valor_doacao_erro'] = 'Valor da doação é obrigatório';
		}

		if(empty($endereco))
		{
			$output['endereco_erro'] = 'Endereço é obrigatório';
		}

		if(count($output) > 0)
		{
			echo json_encode($output);
		}
		else
		{
			$data = array(
				':nome_completo'			=>	$nome_completo,
				':email'					=>	$email,
				':cpf'						=>	$cpf,
				':telefone'					=>	$telefone,
				':data_nascimento'			=>	$data_nascimento,
				':data_cadastro'			=>	$data_cadastro,
				':valor_doacao'				=>	$valor_doacao,
				':endereco'					=>	$endereco,
				':intervalo_doacao'			=>	$intervalo_doacao,
				':forma_pagamento'			=>	$forma_pagamento
			);
			
			if($_POST['action'] == 'Adicionar')
			{
				$query = "
				INSERT INTO tabela_doacao 
				(nome_completo, email, cpf, telefone, data_nascimento, data_cadastro, intervalo_doacao, valor_doacao, forma_pagamento, endereco) 
				VALUES (:nome_completo, :email, :cpf, :telefone, :data_nascimento, :data_cadastro, :intervalo_doacao, :valor_doacao, :forma_pagamento, :endereco)
				";

				$statement = $connect->prepare($query);

				if($statement->execute($data))
				{
					$output['success'] = '<div class="alert alert-success">Adcione Novo Cliente</div>';

					echo json_encode($output);
				}
			}

			if($_POST['action'] == 'Atualizar')
			{
				$query = "
				UPDATE tabela_doacao 
				SET nome_completo = :nome_completo, 
				email = :email, 
				cpf = :cpf,
				telefone = :telefone,
				data_nascimento = :data_nascimento,
				data_cadastro = :data_cadastro,
				valor_doacao = :valor_doacao,
				endereco = :endereco,
				intervalo_doacao = :intervalo_doacao,
				forma_pagamento = :forma_pagamento
				WHERE cliente_id = '".$_POST["cliente_id"]."'
				";

				$statement = $connect->prepare($query);

				if($statement->execute($data))
				{
					$output['success'] = '<div class="alert alert-success">Cliente Atualizado</div>';
				}

				echo json_encode($output);
			}
		}
	}

	if($_POST['action'] == 'fetch')
	{
		$query = "
		SELECT * FROM tabela_doacao 
		WHERE cliente_id = '".$_POST["id"]."'
		";

		$result = $connect->query($query);

		$data = array();

		foreach($result as $row)
		{

			$data['nome_completo'] = $row['nome_completo'];

			$data['email'] = $row['email'];

			$data['cpf'] = $row['cpf'];

			$data['telefone'] = $row['telefone'];

			$data['data_nascimento'] = $row['data_nascimento'];

			$data['data_cadastro'] = $row['data_cadastro'];

			$data['valor_doacao'] = $row['valor_doacao'];

			$data['endereco'] = $row['endereco'];

			$data['intervalo_doacao'] = $row['intervalo_doacao'];

			$data['forma_pagamento'] = $row['forma_pagamento'];

		}

		echo json_encode($data);
	}

	if($_POST['action'] == 'delete')
	{
		$query = "
		DELETE FROM tabela_doacao 
		WHERE cliente_id = '".$_POST["id"]."'
		";

		if($connect->query($query))
		{
			$output['success'] = '<div class="alert alert-success">Cliente Deletado</div>';

			echo json_encode($output);
		}
	}
}

?>