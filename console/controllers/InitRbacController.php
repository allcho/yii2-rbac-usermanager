<?php

namespace allcho\rbac\console\controllers;

use Yii;

class InitRbacController extends \yii\console\Controller {

    public $modelClass = 'app\models\User';
    public $path = "app\commands\rbac";
    
    public function actionInit()
    {
        
        \yii\helpers\FileHelper::createDirectory($this->path, $mode = 0777, $recursive = true);
        $auth = Yii::$app->getAuthManager();
        $auth->removeAll();
        
        $adminPanel = $auth->createPermission('adminPanel');
        $adminPanel->description = 'AdminPanel';
        $auth->add($adminPanel);

        $superadmin = $auth->createRole('superadmin');
        $superadmin->description = 'SuperAdmin';
        $auth->add($superadmin);
        
        $moderator = $auth->createRole('moderator');
        $moderator->description = 'Moderator';
        $auth->add($moderator);
 
        $user = $auth->createRole('user');
        $user->description = 'User';
        $auth->add($user);
        
        $auth->addChild($superadmin, $moderator);
        $auth->addChild($moderator, $user);
        $auth->addChild($moderator, $adminPanel);
        
        $this->stdout('Roles is created!' . PHP_EOL);
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