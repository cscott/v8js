--TEST--
Test V8::executeString() : default parameters
--SKIPIF--
<?php require_once(dirname(__FILE__) . '/skipif.inc'); ?>
--FILE--
<?php

$script=<<<EOT
PHP.sql.exec('CREATE TABLE foo(bar STRING)');
PHP.sql.exec('INSERT INTO foo(bar) VALUES("test")');
var result=PHP.sql.query('SELECT bar FROM foo');
while(data=result.fetchArray()) {
    print(data.bar, "\\n");
}

EOT;

$dom=new DomDocument();
$sql=new SQLite3(':memory:');

$v8=new V8Js();
$v8->sql=$sql;
$v8->executeString($script);
?>
===EOF===
--EXPECT--
===EOF===
