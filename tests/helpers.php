<?php

function test_count($total_inc = 0, $failed_inc = 0) {
  static $total = 0, $failed = 0;
  $total += $total_inc;
  $failed += $failed_inc;
  return array($total, $failed);
}

function test_summary() {
  list($total, $failed) = test_count();
  echo "--" . PHP_EOL;
  echo "<span style='color:blue'>{$total} tests, {$failed} failed".PHP_EOL;
}

function test_stack($name = null) {
  static $stack = array();
  if (!$name)
    return array_pop($stack);
  array_push($stack, $name);
}

function test($title, $cb) {
  test_stack($title);
  test_count(1, 0);
  try {
    call_user_func($cb);
    echo "<span style='color:green'>PASSED: {$title}".PHP_EOL;
  } catch (Exception $ex) {}
}

assert_options(ASSERT_BAIL, 0);

assert_options(ASSERT_WARNING, 1);

assert_options(ASSERT_QUIET_EVAL, 0);

assert_options(ASSERT_CALLBACK, function ($script, $line, $message) {
  $task = test_stack();
  echo "<span style='color:red'>FAILED: {$task}".PHP_EOL;
  test_count(0, 1);
  throw new Exception();
});

?>