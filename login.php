<?php 
$title = "Iniciar Sesión";
include ('ui/header.php'); 
include ('core/login2.0.php'); 
$error = false;
if(isset($_POST['user'])){

	if (login($_POST['user'],$_POST['pass'])) {
		$_SESSION['user']=$_POST['user']; 
		header("Location: http://localhost/");
	} else {
		$error = true;
	}

}
?>

									<h2>Iniciar Sesión</h2>
									<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="alt">
										<div class="row uniform">
											<div class="6u 12u$(xsmall)">
												<input type="text" name="user" value="" placeholder="Usuario" maxlength="15" pattern="[a-zA-Z0-9_]{2,}$" required/>
											</div>
											<div class="6u$ 12u$(xsmall)">
												<input type="password" name="pass" value="" placeholder="Contraseña" rows="6" required>
											</div>
											<!-- Break -->
											<div class="12u$">
												<ul class="actions">
													<?php
													if($error){
														echo "<p style='color:red'>Usuario y/o Contraseña son incorrectos</p>";
													}
													?>
													<li><input type="submit" value="Iniciar Sesión" class="special" /></li>
													<li><input type="reset" value="Reset" /></li>
												</ul>
											</div>
										</div>
									</form>

									<hr />

<?php include ('ui/footer.php'); ?>