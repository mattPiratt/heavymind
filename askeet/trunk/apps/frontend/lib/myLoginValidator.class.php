<?php

/**
 * login validator.
 *
 * @package    askeet
 * @subpackage user
 * @author     Your name here
 * @version    SVN: $Id: myLoginValidator.class.php 16 2005-12-06 08:28:05Z fabien $
 */
 class myLoginValidator extends sfValidator
 {    
   public function initialize ($context, $parameters = null)
   {
     // initialize parent
     parent::initialize($context);

     // set defaults
     $this->getParameterHolder()->set('login_error', 'Invalid input');

     $this->getParameterHolder()->add($parameters);

     return true;
   }

   /**
    * Execute this validator.
    *
    * @param mixed A file or parameter value/array.
    * @param error An error message reference.
    *
    * @return bool true, if this validator executes successfully, otherwise
    *              false.
    */
   public function execute (&$value, &$error)
   {
     $password_param = $this->getParameterHolder()->get('password');
     $password = $this->getContext()->getRequest()->getParameter($password_param);

     $login = $value;

     // anonymous is not a real user
     if ($login == 'anonymous')
     {
       $error = $this->getParameterHolder()->get('login_error');
       return false;
     }

     $c = new Criteria();
     $c->add(UserPeer::NICKNAME, $login);
     $user = UserPeer::doSelectOne($c);

     // nickname exists?
     if ($user)
     {
       // password is OK?
       if (sha1($user->getSalt().$password) == $user->getSha1Password())
       {
         $this->getContext()->getUser()->signIn($user);

         return true;
       }
     }

     $error = $this->getParameterHolder()->get('login_error');
     return false;
   }
}

?>
