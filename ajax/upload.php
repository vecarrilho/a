<?php 
	include "../conexao.php";

	$nome = $_POST['nome'];
	$email = $_POST['email'];
	$setor = $_POST['setor'];

	$sql = "SELECT MAX(idusuario) AS total FROM usuarios";
	$exe = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($exe);
	$total = $row['total'];

	if ($total==null) {
		$total = 1;
	}else{
		$total++;
	}
	$sql = "INSERT INTO usuarios (idusuario, nome, email, setor) VALUES ('$total', '$nome', '$email', '$setor')";
	$exe = mysqli_query($con, $sql);


	$sql = "SELECT descricao FROM setores WHERE idsetor = (SELECT setor FROM usuarios WHERE idusuario = '$total')";
	$exe = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($exe);
	$descricao = $row['descricao'];

	$array[] = array('total'=>$total, 'descricao'=>$descricao);
	echo json_encode($array);
?>