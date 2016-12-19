<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
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
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
                $userName=strtolower($this->username);
                $user= Usuario::model()->find('lower(nick)=?',array($userName));
                if($user===null)
                {
                    $this->errorCode=self::ERROR_USERNAME_INVALID;
                    
                }    
                else if(!$user->validatePassword($this->password,$user))
                {        
                        //echo $user->validatePassword($this->password,$user);
                    $this->errorCode=self::ERROR_PASSWORD_INVALID;
                }    
                else
                {
                    $this->_id=$user->id;
                    $user->tipo->nombre;
                    Yii::app()->user->setState('role', $user->tipo->nombre);
                    #echo Yii::app()->user->getState("role");
                    #Yii::app()->end();
                    
                    $this->username=$user->nick;
                    $this->errorCode=self::ERROR_NONE;
                    
                }
		return !$this->errorCode;
                
	}
        
        public function getId()
        {
            return $this->_id;
        }
}