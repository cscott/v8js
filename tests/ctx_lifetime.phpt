--TEST--
Test V8::executeString() : Testing lifespan of V8Js context objects
--SKIPIF--
<?php require_once(dirname(__FILE__) . '/skipif.inc'); ?>
--FILE--
<?php

class Foo
{
	function hello() {
		echo "Hello!\n";
	}
}

class Testing
{
	function onectx()
	{
		$v8js = new V8Js();
		$v8js->foo = new Foo;
		return $v8js->executeString("({ hello: function() { PHP.foo.__call('hello',[]); } })");
		// $v8js will be dereferenced here, but the result escapes.
	}
}

$t = new Testing();

$a = $t->onectx();
/* $a should still be alive here */
$a->hello();

$a = $t->onectx();
/* after reassignment, we can deref and free the original V8Js object */
$a->hello();

?>
===EOF===
--EXPECT--
Hello!
Hello!
===EOF===
