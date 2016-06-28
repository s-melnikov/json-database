<?php

define('DEBUG', true);

require '../jdb.php';
require 'helpers.php';

echo "<pre>";

test('jdb_create()', function() {

  jdb_create('users');

  assert(file_exists('storage/users.json'));
});

$csv = array_map('str_getcsv', file('users.csv'));

array_walk($csv, function(&$a) use ($csv) {
  $a = array_combine($csv[0], $a);
});

array_shift($csv);

test('jdb_insert()', function() use ($csv) {
  foreach ($csv as $value) {
    assert(!!jdb_insert('users', $value));
  }
});

// test('jdb_drop()', function() {

//   jdb_drop('users');

//   assert(!file_exists('storage/users.json'));
// });

test_summary();

?>