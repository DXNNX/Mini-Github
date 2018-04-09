<?php
$cluster   = Cassandra::cluster()                 // connects to localhost by default
                 ->build();
$keyspace  = 'github';
$session   = $cluster->connect($keyspace);        // create session, optionally scoped to a keyspace

$createTable = <<<EOD
CREATE TABLE test (
  id INT,
  name varchar,
  PRIMARY KEY (id)
)
EOD;

$session->execute($createTable);

?>