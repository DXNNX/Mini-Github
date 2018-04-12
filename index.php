<?php
$title="Inicio";
	include ('ui/header.php'); 
?>
							
							<?php
							if(isset($_SESSION['user'])){
								echo '<li><a href="createproject.php">Crear Proyecto</a></li>';
								echo '<li><a href="subirarchivo.php">Subir Archivo</a></li>';
								echo '<li><a href="subirarchivo.php">Mis Proyectos</a></li>';
								echo '<li><a href="registro.php">Crear Cuenta</a></li>';
								echo '<li><a href="registro.php">Commit</a></li>';
								echo '<li><a href="crearbranch.php">Branch</a></li>';
								echo '<li><a href="mergebranch.php">Merge</a></li>';
								echo '<li><a href="rollbackproyecto.php">Rollback Proyecto</a></li>';
							}else{
								echo '<li><a href="login.php">Iniciar Sesión</a></li>';
								echo '<li><a href="registro.php">Crear Cuenta</a></li>';
							}
							?>
<?php
	include ('ui/footer.php'); 
?>