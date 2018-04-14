<?php 
$title = "Crear Projecto";
include ('ui/header.php'); ?>
									<h2>Crear Proyecto</h2>

									<form method="post" action="JavaScript:crearProyecto()" class="alt">
										<div class="row uniform">
											
											<div class="12u$">
												<input type="text" name="np" value="" placeholder="Nombre Proyecto" rows="6" maxlength="15" required>
												<input type="hidden" name="user" value="<?php echo $guser?>" placeholder="Nombre Proyecto" rows="6" required>
											</div>
											<div class="6u 12u$(xsmall)">
												<input type="text" id="comentario" value="Versión Inicial" placeholder="Comentario" />
											</div>
											<div class="6u$ 12u$(xsmall)">
												<input type="text" id="version" value="1.0" placeholder="Version" required/>
											</div>
											<div class="12u$">
												<input type="text" id="tags" value="" placeholder="Etiquetas (Separe con una coma ej: ave,fauna,zoo)" rows="6" required>
											</div>
											<div class="6u$ 12u$(small)">
												<input type="checkbox" id="demo-copy" name="privado">
												<label for="demo-copy">Privado?</label></br>
											</div>
											</div>
											<!-- Break -->
											<div class="12u$">
												<ul class="actions">
													<li><input type="submit" value="Crear Proyecto" class="special" /></li>
													<li><input type="reset" value="Reset" /></li>
												</ul>
											</div>
										</div>
									</form>

									<hr />

<script>
	
	function crearProyecto() {
		var privado = 0;
		if(document.getElementsByName('privado')[0].checked){
			privado=1;
		}
	    var nombre = document.getElementsByName('np')[0].value;
		var version = document.getElementById('version').value;
		var comentario = document.getElementById('comentario').value;
		var user = '<?php echo $guser?>';
		var tags = document.getElementById('tags').value;
		var branch = 'master';
		   	 
		jQuery.ajax({

            url: 'core/createProject.php',
            data: {'user':user,'np':nombre,'tipo':privado,'branch':branch,'comentario':comentario,'version':version,'tags':tags},
            dataType: 'JSON',
            type: 'POST',
            success:function(data){
   			 if(data.status == 'success'){
   			     alert("La creación fue exitosa!");
				 reset.click();
   			  }else{
   			     alert(data.status);
   			  }
            }

        });
	}

/*
	
*/
</script>
<?php include ('ui/footer.php'); ?>