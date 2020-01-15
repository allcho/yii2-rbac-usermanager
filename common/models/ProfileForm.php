<?php

namespace allcho\rbac\common\models;

use yii\base\Model;
use common\models\User;
 
/**
 * Password reset form
 */
class ProfileForm extends Model
{

    public $currentPassword;
    public $newPassword;
    public $newPasswordRepeat;
    public $password;
    public $username;
    public $email;
    public $role;
    /**
     * @var User
     */
    private $_user;
 
    const SCENARIO_PROFILE = 'profile';   

    /**
     * @param User $user
     * @param array $config
     */
    public function __construct(User $user, $config = [])
    {
        $this->_user = $user;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->role = $user->role;
        parent::__construct($config);
    }
 
    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => ['password', 'username', 'role', 'email'],
            self::SCENARIO_PROFILE => ['currentPassword', 'newPassword', 'newPasswordRepeat', 'email'],
        ];
    }
    
    public function rules()
    {
        return [
            [['currentPassword', 'newPassword', 'newPasswordRepeat', 'username'], 'required'],
            ['currentPassword', 'currentPassword'],
            [['newPassword', 'password'], 'string', 'min' => 6],
            ['newPasswordRepeat', 'compare', 'compareAttribute' => 'newPassword'],

            ['username', 'match', 'pattern' => '#^[\w_-]+$#i'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'ERROR_USERNAME_EXISTS','filter' => ['<>', 'id', $this->_user->id]],
            ['username', 'string', 'min' => 3, 'max' => 255],
 
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'ERROR_EMAIL_EXISTS','filter' => ['<>', 'id', $this->_user->id]],
            ['email', 'string', 'max' => 255],
            
            ['role', 'string', 'max' => 64],
        ];
    }
 
    public function attributeLabels()
    {
        return [
            'newPassword' => 'New Password',
            'currentPassword' => 'Current Password',
            'newPasswordRepeat' => 'New Password Repeat',
        ];
    }
    
    /**
     * @param string $attribute
     * @param array $params
     */
    public function currentPassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (!$this->_user->validatePassword($this->$attribute)) {
                $this->addError($attribute, 'ERROR_WRONG_CURRENT_PASSWORD');
            }
        }
    }
 
    /**
     * @return boolean
     */
    
    public function updateUser()
    {
        if ($this->validate()) {
            $user = $this->_user;
            $user->username = $this->username;
            $user->email = $this->email;
            $user->role = $this->role;
            $user->setPassword($this->password);
            return $user->save();
        } else {
            return false;
        }
    }
}