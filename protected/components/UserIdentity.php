<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
  private $_id;
  
	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
	  $username = strtolower($this->username);
    $user = User::model()->find('LOWER(username) = ?', array($username));
    /*
    echo "<pre>";
    print_r($this);
    echo "<hr>";
    print_r($user->attributes);
    */
    
    if($user === null){
      $this->errorCode=self::ERROR_USERNAME_INVALID;
    }elseif(!$user->validatePassword($this->password)){
      $this->errorCode=self::ERROR_PASSWORD_INVALID;
    }else{
      $this->_id = $user->id;
      $this->username = $user->username;
      $this->errorCode = self::ERROR_NONE;
    }
    return $this->errorCode == self::ERROR_NONE;
	}
  
  public function getId(){
    return $this->_id;
  }
  
}