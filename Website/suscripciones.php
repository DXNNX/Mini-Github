<?php
$title="Ver Proyecto";

 include ('ui/header.php');include ('core/consultaCassandra.php'); ?>
									<h2>Mis Suscripciones</h2>
										<div class="row uniform">
											<div class="12u$">
														<?php
														$counter = 1;
														$rows = getSuscripciones($guser);
														foreach($rows as $row){
															echo "<li><a href='http://localhost/buscarproyectos.php?proyecto={$row['idproyecto']}&usuario={$row['owner']}'>{$row['idproyecto']}</a></li>";
															$counter+=1;
															echo "";
														}
														
														?>
														
												</div>
												
											</div>
										</div>

									<hr />

<?php include ('ui/footer.php'); ?>