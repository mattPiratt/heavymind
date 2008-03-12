<?php

/**
 * mail actions.
 *
 * @package    askeet
 * @subpackage mail
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 29 2005-12-12 11:33:22Z fabien $
 */
class mailActions extends sfActions
{
  public function executeSendPassword()
  {
    $mail = new sfMail();
    $mail->addAddress($this->getRequestParameter('email'));
    $mail->setFrom('Askeet <askeet@symfony-project.com>');
    $mail->setSubject('Askeet password recovery');

    $mail->setPriority(1);

    $mail->addEmbeddedImage(SF_WEB_DIR.'/images/askeet_logo.gif', 'CID1', 'Askeet Logo', 'base64', 'image/gif');

    $this->mail = $mail;

    $this->nickname = $this->getRequest()->getAttribute('nickname');
    $this->password = $this->getRequest()->getAttribute('password');
  }
}

?>