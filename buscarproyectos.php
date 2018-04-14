<?php
$title="Ver Proyecto";

 include ('ui/header.php');include ('core/consultaCassandra.php'); ?>
									<h2>Ver Proyecto</h2>

									<form method="post" id="form" name="form" action="JavaScript:verArchivos()" class="alt" enctype="multipart/form-data">
										<div class="row uniform">
											<div class="12u$">
												<div class="select-wrapper">
													<select name="pb" id="pb">
														<?php
														$counter = 1;
														$rows = consultaPBFind($guser);
														foreach($rows as $row){
															echo "<option value='$counter'>{$row['owner']}->{$row['idproyecto']}->{$row['branch']}</option>";
																	print("\n");
															$counter+=1;
															echo "";
														}
														
														?>
														
													</select>
												</div>
												
											</div>
											<!-- Break -->
											<div class="12u$">
												<ul class="actions" id='actions'>
													<li><input type="submit" value="Ver Archivos" class="special" /></li>
												</ul>
											</div>
										</div>
									</form>

									<hr />
<div class="12u$" id="lista"></div>
<div class="row"><div class="12u$" id="mostrar"></div></div>
<script>
	var rama = "";
	var proyecto = "";
	
	
	function Suscripcion() {
		<?php
		echo 'var items = [';
		$strout = "";
		foreach($rows as $row){
			$strout=$strout."['".$row['idproyecto']."','".$row['branch']."','".$row['owner']."'],";
		}
		echo substr($strout,0,-1);
		echo "];";
		print("\n");
		?>

		var form_data = new FormData(); 
		proyecto = items[document.getElementById('pb').selectedIndex][0];
		rama = items[document.getElementById('pb').selectedIndex][1];
		form_data.append("pn",items[document.getElementById('pb').selectedIndex][0]);
		form_data.append("bn",'master');
		form_data.append("owner", items[document.getElementById('pb').selectedIndex][2]);
		form_data.append("user", '<?php echo $guser ?>');
		
   	 jQuery.ajax({

            url: 'core/suscripcion.php',
            data: form_data,
		 	cache: false,
			contentType: false,
         	processData: false,
            type: 'POST',

            });
		}
	
	
	
	function verArchivos() {
		<?php
		echo 'var items = [';
		$strout = "";
		foreach($rows as $row){
			$strout=$strout."['".$row['idproyecto']."','".$row['branch']."','".$row['owner']."'],";
		}
		echo substr($strout,0,-1);
		echo "];";
		print("\n");
		?>

		var form_data = new FormData(); 
		var input = document.getElementById("archivo");
		proyecto = items[document.getElementById('pb').selectedIndex][0];
		rama = items[document.getElementById('pb').selectedIndex][1];
		form_data.append("pn",items[document.getElementById('pb').selectedIndex][0]);
		form_data.append("bn",items[document.getElementById('pb').selectedIndex][1]);
		form_data.append("user", items[document.getElementById('pb').selectedIndex][2]);
		
   	 jQuery.ajax({

            url: 'core/listaproyectos.php',
            data: form_data,
		 	cache: false,
			contentType: false,
         	processData: false,
            type: 'POST',
         	success:function(data){
				$('#lista').html('<h2>'+proyecto+'</h2>'+data.status);
				$("#mostrar").empty();
				$('#actions').html('<li><input type="submit" value="Ver Archivos" class="special" /></li><li><a class="button" onclick="JavaScript:Suscripcion()">Suscribirme</a></li>');
         	}
            });}
			
			function verProyecto() {
				var form_data = new FormData(); 
				var input = document.getElementById("archivo");
				form_data.append("pn",proyecto);
				form_data.append("bn",rama);
				form_data.append("user", '<?php echo $_GET['usuario'];?>');		
		   	 jQuery.ajax({
		            url: 'core/listaproyectos.php',
		            data: form_data,
				 	cache: false,
					contentType: false,
		         	processData: false,
		            type: 'POST',
		         	success:function(data){
						$('#lista').html(<?php if(isset($_GET['proyecto']) && isset($_GET['usuario']) ) {echo "'<h2>{$_GET['proyecto']}</h2>'";}else{echo "''";} ?>+data.status);
						$("#mostrar").empty();
		         	}
		            });}
			
			function mostrarArchivo(selected) {
				var form_data = new FormData(); 
				var input = document.getElementById("archivo");
				form_data.append("pn",proyecto);
				form_data.append("bn",rama);
				form_data.append("file",selected);
				$("#mostrar").empty();
		   	 jQuery.ajax({

		            url: 'core/datosarchivo.php',
		            data: form_data,
				 	cache: false,
					contentType: false,
		         	processData: false,
		            type: 'POST',
		         	success:function(data){
						$('#mostrar').html(data.status);
		         	}
		            });}

/*
	
*/
</script>
<?php include ('ui/footer.php'); 
if(isset($_GET['proyecto']) && isset($_GET['usuario'])){
	echo "<script>proyecto='{$_GET['proyecto']}';rama='master';verProyecto();</script>";
}

?>