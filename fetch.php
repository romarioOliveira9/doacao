<?php

//fetch.php

include('function.php');

$startGET = filter_input(INPUT_GET, "start", FILTER_SANITIZE_NUMBER_INT);

$start = $startGET ? intval($startGET) : 0;

$lengthGET = filter_input(INPUT_GET, "length", FILTER_SANITIZE_NUMBER_INT);

$length = $lengthGET ? intval($lengthGET) : 10;

$searchQuery = filter_input(INPUT_GET, "searchQuery", FILTER_SANITIZE_STRING);

$search = empty($searchQuery) || $searchQuery === "null" ? "" : $searchQuery;

$sortColumnIndex = filter_input(INPUT_GET, "sortColumn", FILTER_SANITIZE_NUMBER_INT);

$sortDirection = filter_input(INPUT_GET, "sortDirection", FILTER_SANITIZE_STRING);

$column = array("nome_completo", "email", "cpf", "telefone", "data_nascimento", "data_cadastro", "valor_doacao", "endereco", "intervalo_doacao", "forma_pagamento");

$query = "SELECT * FROM tabela_doacao ";

$query .= '
	WHERE cliente_id LIKE "%'.$search.'%" 
	OR nome_completo LIKE "%'.$search.'%" 
	OR email LIKE "%'.$search.'%" 
	OR cpf LIKE "%'.$search.'%" 
	OR telefone LIKE "%'.$search.'%" 
	OR data_nascimento LIKE "%'.$search.'%" 
	OR data_cadastro LIKE "%'.$search.'%" 
	OR valor_doacao LIKE "%'.$search.'%" 
	OR endereco LIKE "%'.$search.'%" 
	OR intervalo_doacao LIKE "%'.$search.'%" 
	OR forma_pagamento LIKE "%'.$search.'%"
	';


if($sortColumnIndex != '')
{
	$query .= 'ORDER BY '.$column[$sortColumnIndex].' '.$sortDirection.' ';
}
else
{
	$query .= 'ORDER BY cliente_id DESC ';
}

$query1 = '';

if($length != -1)
{
	$query1 = 'LIMIT ' . $start . ', ' . $length;
}

$statement = $connect->prepare($query);

$statement->execute();

$number_filter_row = $statement->rowCount();

$result = $connect->query($query . $query1);

$data = array();

foreach($result as $row)
{

	$sub_array = array();

	$sub_array[] = $row['nome_completo'];

	$sub_array[] = $row['email'];

	$sub_array[] = $row['cpf'];

	$sub_array[] = $row['telefone'];

	$sub_array[] = $row['data_nascimento'];

	$sub_array[] = $row['data_cadastro'];

	$sub_array[] = $row['valor_doacao'];

	$sub_array[] = $row['endereco'];

	$sub_array[] = $row['intervalo_doacao'];

	$sub_array[] = $row['forma_pagamento'];

	$sub_array[] = '<button type="button" onclick="fetch_data('.$row["cliente_id"].')" class="btn btn-warning btn-sm">Editar</button>&nbsp;<button type="button" class="btn btn-danger btn-sm" onclick="delete_data('.$row["cliente_id"].')">Deletar</button>';

	$data[] = $sub_array;
}



$output = array(
	"registrosTotal"		=>	count_all_data($connect),
	"registrosFiltrado"		=>	$number_filter_row,
	"data"					=>	$data
);

echo json_encode($output);

?>