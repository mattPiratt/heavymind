<?php

/**
 * api actions.
 *
 * @package    askeet
 * @subpackage api
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 44 2005-12-17 09:07:41Z fabien $
 */
class apiActions extends sfActions
{
  public function preExecute()
  {
    $this->getRequest()->setAttribute('disable_web_debug', true, 'debug/web');
  }

  public function executeQuestion()
  {
    $user = $this->authenticateUser();
    if (!$user)
    {
      $this->error_code    = 1;
      $this->error_message = 'login failed';

      return array('api', 'errorSuccess');
    }

    if (!$this->getRequestParameter('stripped_title'))
    {
      $this->error_code    = 2;
      $this->error_message = 'the API returns answers to a specific question. Please provide a stripped_title parameter';

      return array('api', 'errorSuccess');
    }
    else
    {
      // get the question
      $question = QuestionPeer::getQuestionFromTitle($this->getRequestParameter('stripped_title'));

      if ($question->getUserId() != $user->getId())
      {
        $this->error_code    = 3;
        $this->error_message = 'You can only use the API for the questions you asked';

        return array('api', 'errorSuccess');
      }
      else
      {
        // get the answers
        $this->answers  = $question->getAnswers();
        $this->question = $question;
      }
    }
  }

  private function authenticateUser()
  {
    if (isset($_SERVER['PHP_AUTH_USER']))
    {
      if ($user = UserPeer::getAuthenticatedUser($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']))
      {
        $this->getContext()->getUser()->signIn($user);

        return $user;
      }
    }

    header('WWW-Authenticate: Basic realm="askeet API"');
    header('HTTP/1.0 401 Unauthorized');
  }

  public function executeError()
  {
  }
}

?>