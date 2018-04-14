<?php include ('ui/header.php'); ?>
									<h2>Registro</h2>

									<form method="post" action="JavaScript:crearUsuario()" class="alt">
										<div class="row uniform">
											
											<div class="12u$">
												<input type="text" name="nombre" value="" placeholder="Nombre Completo" rows="6" required>
											</div>
											<div class="6u 12u$(xsmall)">
												<input type="text" name="user" value="" placeholder="Usuario" maxlength="15" pattern="[a-zA-Z0-9_]{2,}$" required/>
											</div>
											<div class="6u$ 12u$(xsmall)">
												<input type="email" name="email" value="" placeholder="Email" required/>
											</div>
											<div class="12u$">
												<input type="password" name="password" value="" placeholder="Contraseña" rows="6" required>

											</div>
											<!-- Break -->
											<div class="12u$">
												<ul class="actions">
													<li><input type="submit" value="Registrarse" class="special" /></li>
													<li><input type="reset" value="Reset" /></li>
												</ul>
											</div>
										</div>
									</form>

									<hr />

<script>
	
	function crearUsuario() {
	    var nombre = document.getElementsByName('nombre')[0].value;
		var user = document.getElementsByName("user")[0].value;
		var pass = document.getElementsByName("password")[0].value;
		var email = document.getElementsByName("email")[0].value;
   	 jQuery.ajax({

            url: 'core/createuser.php',
            data: {'user':user,'pass':pass,'nombre':nombre,'email':email},
            dataType: 'JSON',
            type: 'POST',
            success:function(data){
   			 if(data.status == 'success'){
   			     alert("La creación fue exitosa!");
				 window.location.replace('http://localhost/');
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