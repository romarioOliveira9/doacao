<?php

//function.php

/*nome_completo
	email
	cpf
	telefone
	data_nascimento
	data_cadastro
	valor_doacao
	endereco

	intervalo_doacao
	forma_pagamento*/

$connect = new PDO("mysql:host=localhost;dbname=doacao", "root", "root");

function fetch_top_five_data($connect)
{
	$query = "
	SELECT * FROM tabela_doacao 
	ORDER BY cliente_id DESC 
	LIMIT 5";

	$result = $connect->query($query);

	$output = '';

	foreach($result as $row)
	{
		$output .= '
		
		<tr>
			<td>'.$row["nome_completo"].'</td>
			<td>'.$row["email"].'</td>
			<td>'.$row["cpf"].'</td>
			<td>'.$row["telefone"].'</td>
			<td>'.$row["data_nascimento"].'</td>
			<td>'.$row["data_cadastro"].'</td>
			<td>'.$row["valor_doacao"].'</td>
			<td>'.$row["endereco"].'</td>
			<td>'.$row["intervalo_doacao"].'</td>
			<td>'.$row["forma_pagamento"].'</td>
			<td><button type="button" onclick="fetch_data('.$row["cliente_id"].')" class="btn btn-warning btn-sm">Editar</button>&nbsp;<button type="button" class="btn btn-danger btn-sm" onclick="delete_data('.$row["cliente_id"].')">Deletar</button></td>
		</tr>
		';
	}
	return $output;
}

function count_all_data($connect)
{
	$query = "SELECT * FROM tabela_doacao";

	$statement = $connect->prepare($query);

	$statement->execute();

	return $statement->rowCount();
}

?>