<?php
$title="Rollback Archivo";

 include ('ui/header.php');include ('core/consultaCassandra.php'); ?>
									<h2>Rollback Archivo</h2>

									<form method="post" id="form" name="form" action="JavaScript:rollbackArchivo()" class="alt" enctype="multipart/form-data">
										<div class="row uniform">

											<div class="12u$">
												<div class="select-wrapper">
													<select name="pb" id="pb" onchange="getArchivos()">
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
											<div class="12u$">
												<div class="select-wrapper" id="archivodiv">
												</div>
											</div>
											
											<div class="12u$">
												<div class="select-wrapper" id="versionesdiv">
												</div>
											</div>
											
											
											<!-- Break -->
											<div class="12u$">
												<ul class="actions">
													<li><input type="submit" value="Rollback" class="special" /></li>
													<li><input type="reset" id="reset" value="Reset" /></li>
												</ul>
											</div>
										</div>
									</form>

									<hr />

<script>
	function getArchivos() {
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
		form_data.append("project",items[document.getElementById('pb').selectedIndex][0]);
		form_data.append("branch",items[document.getElementById('pb').selectedIndex][1]);
		form_data.append("user", '<?php echo $guser;?>');	
		form_data.append("callarchivop", '<?php echo $guser;?>');	
		
   	 jQuery.ajax({

            url: 'core/consultaCassandra.php',
            data: form_data,
		 	cache: false,
			contentType: false,
	      	processData: false,
	        type: 'POST',
	      	success:function(data){
				$('#archivodiv').html(data.status);
				getVersiones();
	      	}
            });
	}
	
	
	function getVersiones() {
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
		form_data.append("project",items[document.getElementById('pb').selectedIndex][0]);
		form_data.append("branch",items[document.getElementById('pb').selectedIndex][1]);
		form_data.append("user", '<?php echo $guser;?>');
		form_data.append("archivo", document.getElementById('archivo').value);
		form_data.append("callarchivov", '<?php echo $guser;?>');
		
   	 jQuery.ajax({

            url: 'core/consultaCassandra.php',
            data: form_data,
		 	cache: false,
			contentType: false,
	      	processData: false,
	        type: 'POST',
	      	success:function(data){
				$('#versionesdiv').html(data.status);
	      	}
            });
	}
	
	
	
	function rollbackArchivo() {
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
		form_data.append("pn",items[document.getElementById('pb').selectedIndex][0]);
		form_data.append("bn",items[document.getElementById('pb').selectedIndex][1]);
		form_data.append("archivo", document.getElementById('archivo').value);
		form_data.append("user", '<?php echo $guser;?>');		
   	 jQuery.ajax({

            url: 'core/rollbackarchivo.php',
            data: form_data,
		 	cache: false,
			contentType: false,
         	processData: false,
            type: 'POST'
            });
			alert("Se completó el rollback");
	}

/*
	
*/
</script>
<?php include ('ui/footer.php'); ?><script>getArchivos();</script>