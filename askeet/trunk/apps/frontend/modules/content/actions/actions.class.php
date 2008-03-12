<?php

/**
 * content actions.
 *
 * @package    askeet
 * @subpackage content
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 40 2005-12-16 09:09:27Z fabien $
 */
class contentActions extends sfActions
{
  public function executeAbout()
  {
    require_once('markdown.php');

    $this->html = markdown(file_get_contents(SF_ROOT_DIR.'/data/content/about.txt'));
  }
}

?>