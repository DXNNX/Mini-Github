<?php
$title="Rollback Proyecto";

 include ('ui/header.php');include ('core/consultaCassandra.php'); ?>
									<h2>Rollback Proyecto</h2>

									<form method="post" id="form" name="form" action="JavaScript:rollbackProyecto()" class="alt" enctype="multipart/form-data">
										<div class="row uniform">

											<div class="12u$">
												<div class="select-wrapper">
													<select name="pb" id="pb" onchange="getVersiones()">
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
												<div class="select-wrapper" id="version">
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
		form_data.append("callp", '1');
   	 jQuery.ajax({

            url: 'core/consultaCassandra.php',
            data: form_data,
		 	cache: false,
			contentType: false,
	      	processData: false,
	        type: 'POST',
	      	success:function(data){
				$('#version').html(data.status);
	      	}
            });
	}
	function rollbackProyecto() {
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
		var input = document.getElementById("archivo");
		form_data.append("version", document.getElementById('select').value);
		form_data.append("pn",items[document.getElementById('pb').selectedIndex][0]);
		form_data.append("bn",items[document.getElementById('pb').selectedIndex][1]);
		form_data.append("user", '<?php echo $guser;?>');		
		
   	 jQuery.ajax({

            url: 'core/rollbackproyecto.php',
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
<?php include ('ui/footer.php'); ?><script>getVersiones();</script>