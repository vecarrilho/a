<?php
	include "conexao.php";
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Usuario</title>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"   integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="   crossorigin="anonymous"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container" style="padding: 20px; margin: 0;">
		<div class="row">
			<div class="col-lg-4" >
				<form method="POST" action="upload.php" >
					<label>Nome</label>
					<input type="text" class="form-control" name="nome" id="nome" style="margin-top: 10px; width: 55%;">
					<br>
					<label>Email</label>
					<input type="email" class="form-control" name="email" id="email" style="margin-top: 10px; width: 55%;">
					<br>
					<label>Setor</label>
					<select class="form-select" name="setor" id="setor" style="margin-top: 10px; width: 55%;">
						<option value="">Selecione um setor</option>
						<?php
							$sql = "SELECT * FROM setores ORDER BY descricao ASC";
							$exe = mysqli_query($con, $sql);
							while ($row=mysqli_fetch_array($exe)) {
								$idsetor = $row['idsetor'];
								$descricao = $row['descricao'];
								echo "<option value='".$idsetor."'>".$descricao."</option>";
							}
						?>
					</select>
					<br>
					<input type="button" class="btn btn-primary" onclick="upload()" name="btnSubmit" value="Salvar" style="margin-top: 20px;">
				</form>
			</div>
			<div class="col-lg-8">
				<table class="table table-striped" id="tabelaUsu">
					<tr id="cabecalhoTabela">
						<th>ID</th>
						<th>Nome</th>
						<th>Email</th>
						<th>Setor</th>
					</tr>
					<tbody id="corpoTabela">
						<?php 
							$sql = "SELECT u.idusuario, u.nome, u.email, s.descricao FROM usuarios u INNER JOIN setores s ON u.setor=s.idsetor ORDER BY u.idusuario ASC";
							$exe = mysqli_query($con, $sql);
							while ($row=mysqli_fetch_array($exe)) {
								echo '<tr>';
									echo '<td>';
										echo $row['idusuario'];
									echo '</td>';
									echo '<td>';
										echo $row['nome'];
									echo '</td>';
									echo '<td>';
										echo $row['email'];
									echo '</td>';
									echo '<td>';
										echo $row['descricao'];
									echo '</td>';
								echo '</tr>';
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</body>
	<script type="text/javascript">
		function upload(){
			let nome = $("#nome");
			let email = $("#email");
			let setor = $("#setor");
			$.ajax({
				type: "POST",
				dataType: "JSON",
				url: "ajax/upload.php",
				data: {'nome' : nome.val(), 'email' : email.val(), 'setor' : setor.val()},
				success: function(data){
					$("#corpoTabela").append("<tr><td>"+data[0]['total']+"</td><td>"+nome.val()+"</td><td>"+email.val()+"</td><td>"+data[0]['descricao']+"</td></tr>");
					nome.val(null);
					email.val(null);
					setor.val(null);
				}
			});
		}

		$( "#cabecalhoTabela" ).click(function() {
			let display = $("#corpoTabela").css("display");

			if (display == 'none') {
				$( "#corpoTabela" ).show( "slow");
			}else{
				$( "#corpoTabela" ).hide( "slow");
			}
		});
	</script>
</html>


