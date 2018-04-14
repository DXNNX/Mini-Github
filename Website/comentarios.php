<?php
$title="Comentarios";

include ('ui/header.php');
include ('core/consultaCassandra.php'); 
$proyecto = $_GET['proyecto'];
$usuario = $_GET['usuario'];

$doc = "";
if(isset($_GET['doc'])){ $doc = $_GET['doc'];}
 ?>
									<h2>Comentarios</h2>
<?php if(isset($_SESSION['user'])) { ?>
									<form method="post" id="form" name="form" action="JavaScript:crearComentario()" class="alt" enctype="multipart/form-data">
										<div class="row uniform">
											<div class="12u$">
												<div class="select-wrapper">
													<input type="text" id="comentario" value="" placeholder="Comentario" />												</div>
												
											</div>
											<!-- Break -->
											<div class="12u$">
												<ul class="actions">
													<li><input type="submit" value="Enviar" class="special" /></li>
													<li><input type="reset" id="reset" value="Reset" /></li>
												</ul>
											</div>
										</div>
									</form>
									<hr />
<div class="row uniform" id='comentarios'></div>
<?php }; ?>

<script>
	function getComents() {
		var form_data = new FormData(); 
		form_data.append("pn",'<?php echo $proyecto;?>');
		form_data.append("usuario", '<?php echo $usuario;?>');
 		form_data.append("doc", '<?php echo $doc;?>');
		
   	 jQuery.ajax({

            url: 'core/leerComentarios.php',
            data: form_data,
		 	cache: false,
			contentType: false,
         	processData: false,
            type: 'POST',
			success:function(data){
		 	$('#comentarios').html(data.status);
			reset.click();
		 }
            });
			
	}
	
	
	function crearComentario() {
		var form_data = new FormData(); 
		form_data.append("pn",'<?php echo $proyecto;?>');
		form_data.append("user", '<?php echo $guser;?>');
		form_data.append("owner", '<?php echo $usuario;?>');
		form_data.append("comentario", document.getElementById('comentario').value);
 		form_data.append("doc", '<?php echo $doc;?>');
		
   	 jQuery.ajax({

            url: 'core/crearcomentario.php',
            data: form_data,
		 	cache: false,
			contentType: false,
         	processData: false,
            type: 'POST'
            });
			getComents();
	}
	
	

/*
	
*/
</script>
<?php include ('ui/footer.php'); ?><script>getComents()</script>