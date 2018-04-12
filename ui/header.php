
<?php include 'ui/global.php';?>
<?php
if(isset($_GET['end'])){
	session_destroy();
	header("Location:http://localhost/");
}
?>
<!DOCTYPE HTML>
<!--
	Massively by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->


<html>
	<head>
		<title><?php echo "$title | Mini-Github" ?></title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
	<body class="is-loading">

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Header -->
					<header id="header">
						<a href="index.php" class="logo">Mini-GitHub</a>
					</header>

				<!-- Nav -->
					<nav id="nav">
						<ul class="links">
							<?php
							if(!isset($_SESSION['user'])){
								echo '<li><a href="login.php">Iniciar Sesión</a></li>';
								echo '<li><a href="registro.php">Crear Cuenta</a></li>';
							}
							?>
						</ul>
						<ul class="icons">
							<?php
							if(isset($_SESSION['user'])){
								echo '<li><a href="index.php?end=bye"><span class="label">'.$guser.'</span></a</li>';
							}
							?>
							<li><a href="http://twitter.com/d4nnyc87" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
							<li><a href="http://fb.com/DXNNXCH" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
							<li><a href="http://instagram.com/dxnnx" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
							<li><a href="http://github.com/dxnnx" class="icon fa-github"><span class="label">GitHub</span></a></li>
						</ul>
					</nav>

				<!-- Main -->
					<div id="main">

						<!-- Post -->
							<section class="post">

