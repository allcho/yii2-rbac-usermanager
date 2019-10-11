<?php

namespace allcho\rbac\console\controllers;

use Yii;

class InitRbacController extends \yii\console\Controller {

    public $modelClass = 'app\models\User';
    
    public function actionInit()
    {
        $auth = Yii::$app->getAuthManager();
        $auth->removeAll();

        $superadmin = $auth->createRole('superadmin');
        $superadmin->description = 'SuperAdmin';
        $auth->add($superadmin);
 
        $this->stdout('Role is created!' . PHP_EOL);
    }
    
    
    public function actionAdmin()
    {
        $username = $this->prompt('Username:', ['required' => true]);
        $email = $this->prompt('Email:', ['required' => true]);
        $password = $this->prompt('Password:', ['required' => true]);          
        $user = new $this->modelClass();
        $user->username = $username;
        $user->email = $email;
        $user->status = 10;
        $user->setPassword($password);
        $user->generateAuthKey();
        if($user->save())
        {
            $authManager = Yii::$app->getAuthManager();
            $role = $authManager->getRole('superadmin');
            $authManager->assign($role, $user->id);
            $this->stdout('SuperAdmin is created!' . PHP_EOL);
        }
        

    }

}