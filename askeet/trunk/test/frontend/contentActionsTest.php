<?php

class contentActionsWebBrowserTest extends UnitTestCase
{
  private
    $browser = null;

  public function SetUp ()
  {
    // create a new test browser
    $this->browser = new sfTestBrowser();
    $this->browser->initialize('hostname');
  }

  public function tearDown ()
  {
    $this->browser->shutdown();
  }

  public function test_simple()
  {
    $url = '/content/index';
    $html = $this->browser->get($url);
    $this->assertWantedPattern('/content/', $html);
  }
}

?>