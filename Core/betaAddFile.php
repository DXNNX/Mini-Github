<?php
$cluster   = Cassandra::cluster()                 // connects to localhost by default
                 ->build();
$keyspace  = 'github';
$session   = $cluster->connect($keyspace);        // create session, optionally scoped to a keyspace

$statement = new Cassandra\SimpleStatement("SELECT secuencia FROM proyecto where idproyecto='P1' and branch='master' ALLOW FILTERING;");	

$result = $session->execute($statement);
foreach($result as)
?>