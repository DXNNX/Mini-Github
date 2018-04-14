<?php
$title="Inicio";
include ('core/getRelacionados.php'); 
	include ('ui/header.php'); 
?>
							
							<?php
							if(isset($_SESSION['user'])){
								echo '<li><a href="createproject.php">Crear Proyecto</a></li>';
								echo '<li><a href="subirarchivo.php">Subir Archivo</a></li>';
								echo '<li><a href="listaproyectos.php">Mis Proyectos</a></li>';
								echo '<li><a href="commitproyecto.php">Commit</a></li>';
								echo '<li><a href="crearbranch.php">Branch</a></li>';
								echo '<li><a href="mergebranch.php">Merge</a></li>';
								echo '<li><a href="rollbackproyecto.php">Rollback Proyecto</a></li>';
								echo '<li><a href="rollbackarchivo.php">Rollback Archivo</a></li>';
								echo '<li><a href="buscarproyectos.php">Ver Proyectos</a></li>';
								echo '<li><a href="suscripciones.php">Mis Suscripciones</a></li>';
								?>
								
								<?php
								//jaccard
								set_error_handler(function() { /* ignore errors */ });
								?>
								<div class="table-wrapper">
									<br><h3>Sugerencias</h3>
									<table>
										<thead>
											<tr>
												<th>Por Proyectos</th>
												<th>Por Suscripciones</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<?php
												echo "<td>";
												foreach(getPorProyecto($_SESSION['user']) as $row){
													echo "<li><a href='http://localhost/buscarproyectos.php?proyecto={$row[0]}&usuario={$row[1]}'>$row[0]</a></li>";
												}
												echo "</td>";
												
												echo "<td>";
												print("\n");
												foreach(getPorSuscripcion($_SESSION['user']) as $row){
													echo "<li><a href='http://localhost/buscarproyectos.php?proyecto={$row[0]}&usuario={$row[1]}'>$row[0]</a></li>";
												}
												echo "</td>";
												
													
												?>
											</tr>
										</tbody>
									</table>
								</div>
								
								
								<?php

							}else{
								echo '<li><a href="login.php">Iniciar Sesión</a></li>';
								echo '<li><a href="registro.php">Crear Cuenta</a></li>';
								echo '<li><a href="buscarproyectos.php">Ver Proyectos</a></li>';
							}
							?>
<?php
	include ('ui/footer.php'); 
?>