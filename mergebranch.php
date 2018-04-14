<?php
$title="Merge Branch";
include ('ui/header.php');
include ('core/consultaCassandra.php'); 
?>
									<h2>Merge Branch</h2>

									<form method="post" id="form" name="form" action="JavaScript:crearBranch()" class="alt" enctype="multipart/form-data">
										<div class="row uniform">
											<div class="12u$">
												<div class="select-wrapper">
													<select name="pb" id="pb">
														<?php
														$counter = 1;
														$rows = consultaPBMerge($guser);
														foreach($rows as $row){
															if(strcmp($row['branch'],"master")!=0){
															echo "<option value='$counter'>{$row['idproyecto']}->{$row['parentbranch']}<-{$row['branch']}</option>";
																	print("\n");
																	print_r($row);
															$counter+=1;
															echo "";}
														}
														
														?>
														
													</select>
												</div>
												
											</div>
											<div class="12u$">
												<ul class="actions">
													<li><input type="submit" value="Merge Branch" class="special" /></li>
													<li><input type="reset" id="reset" value="Reset" /></li>
												</ul>
											</div>
										</div>
									</form>

									<hr />

<script>
	function crearBranch() {
		<?php
		echo 'var items = [';
		$strout = "";
		foreach($rows as $row){
			if(strcmp($row['branch'],"master")!=0){
				$strout=$strout."['".$row['idproyecto']."','".$row['branch']."'],";
			}
		}
		echo substr($strout,0,-1);
		echo "];";
		print("\n");
		?>

		var form_data = new FormData(); 
		form_data.append("pn",items[document.getElementById('pb').selectedIndex][0]);
		form_data.append("nb",items[document.getElementById('pb').selectedIndex][1]);
		form_data.append("user", '<?php echo $guser;?>');		
		
   	 jQuery.ajax({

            url: 'core/mergeProyecto.php',
            data: form_data,
		 	mimeType: "multipart/form-data",
		 	cache: false,
			contentType: false,
         	processData: false,
            type: 'POST'
            });
			alert("Merge Realizado");
			//window.location.replace('<?php echo $_SERVER['PHP_SELF']; ?>');
	}

/*
	
*/
</script>
<?php include ('ui/footer.php'); ?>