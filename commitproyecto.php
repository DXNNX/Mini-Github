<?php
$title="Nueva Version Proyecto";

 include ('ui/header.php');include ('core/consultaCassandra.php'); ?>
									<h2>Nueva Versión</h2>

									<form method="post" id="form" name="form" action="JavaScript:subirArchivo()" class="alt" enctype="multipart/form-data">
										<div class="row uniform">
											<div class="12u$">
												<div class="select-wrapper">
													<select name="pb" id="pb">
														<?php
														$counter = 1;
														$rows = consultaPB($guser);
														foreach($rows as $row){
															echo "<option value='$counter'>{$row['idproyecto']}->{$row['branch']}</option>";
																	print("\n");
															$counter+=1;
															echo "";
														}
														
														?>
														
													</select>
												</div>
												
											</div>
											<div class="6u 12u$(xsmall)">
												<input type="text" id="comentario" value="" placeholder="Comentario" />
											</div>
											<div class="6u$ 12u$(xsmall)">
												<input type="text" id="version" value="" placeholder="Version" required/>
											</div>
											<!-- Break -->
											<div class="12u$">
												<ul class="actions">
													<li><input type="submit" value="Crear versión" class="special" /></li>
													<li><input type="reset" id="reset" value="Reset" /></li>
												</ul>
											</div>
										</div>
									</form>

									<hr />

<script>
	function subirArchivo() {
		<?php
		echo 'var items = [';
		$strout = "";
		foreach($rows as $row){
			$strout=$strout."['".$row['idproyecto']."','".$row['branch']."'],";
		}
		echo substr($strout,0,-1);
		echo "];";
		print("\n");
		?>

		var form_data = new FormData(); 
		form_data.append("version", document.getElementById('version').value);
    	form_data.append("comentario", document.getElementById('comentario').value);  
		form_data.append("pn",items[document.getElementById('pb').selectedIndex][0]);
		form_data.append("bn",items[document.getElementById('pb').selectedIndex][1]);
		form_data.append("user", '<?php echo $guser;?>');
		
   	 jQuery.ajax({

            url: 'core/commitproyecto.php',
            data: form_data,
		 	cache: false,
			contentType: false,
         	processData: false,
            type: 'POST'
            });
			alert("se creó la nueva versión del repositorio");
	}

/*
	
*/
</script>
<?php include ('ui/footer.php'); ?>