<?php

require_once('Tag.class.php');

class TagTest extends UnitTestCase
{
  public function test_normalize()
  {
    $tests = array(
      'FOO'       => 'foo',
      '   foo'    => 'foo',
      'foo  '     => 'foo',
      ' foo '     => 'foo',
      'foo-bar'   => 'foobar',
    );

    foreach ($tests as $tag => $normalized_tag)
    {
      $this->assertEqual($normalized_tag, Tag::normalize($tag));
    }
  }
}

?>