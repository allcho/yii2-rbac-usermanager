Rbac and user manager
=====================
Control users and roles

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist allcho/yii2-rbac-usermanager "*"
```

or add

```
"allcho/yii2-rbac-usermanager": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Set component in your config:
```
'components' => [
    ...
    'authManager' => [
        'class' => 'allcho\rbac\common\extensions\hybridrbac\AuthManager',
        'modelClass' => 'common\models\User',
        'itemFile' => 'app/rbac/items.php',
        'assignmentFile' => 'app/rbac/assignments.php',
        'ruleFile' => 'app/rbac/rules.php',
    ],
],
```

Set controllerMap  in your console config:
```
'controllerMap' => [
        'initrbac' => [
            'class' => 'allcho\rbac\console\controllers\InitRbacController',
            'modelClass' => 'common\models\User',
            'path' => 'app/rbac',
         
            
        ]
  
]
```

Set controllerMap in your backend

```
    'controllerMap' => [
        'usermanager' => 'allcho\rbac\backend\controllers\UserManagerController',
            
    ],
```
And set controllerMap frontend config (options)
```
    'controllerMap' => [
        'profile' => 'allcho\rbac\frontend\controllers\ProfileController',
            
    ],
```


Add to backend component in your config 
```
        'view' => [
         'theme' => [
             'pathMap' => [
                '@app/views/usermanager' => '@vendor/allcho/yii2-rbac-usermanager/backend/views/user-manager'
                ],
            ],
        ],
```
OR copy and move to your backend views this /allcho/yii2-rbac-usermanager/backend/views/user-manager folder


Add to frontend  component in your config  (options)
```
        'view' => [
         'theme' => [
             'pathMap' => [
                '@app/views/profile' => '@vendor/allcho/yii2-rbac-usermanager/frontend/views/profile'
                ],
            ],
        ],
```
OR copy and move to your frontend views this /allcho/yii2-rbac-usermanager/frontend/views/profile folder

Add your layouts this Assets 
```
allcho\rbac\backend\assets\UsermanagerAsset::register($this);
```




Add rules in your model User 

```
['role', 'string', 'max' => 64]
```
And also this code 
```
namespace app\models;

use allcho\rbac\common\extensions\hybridrbac\AuthRoleModelInterface;

class User extends ActiveRecord implements IdentityInterface, AuthRoleModelInterface
{
    ...

    public static function findAuthRoleIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findAuthIdsByRoleName($roleName)
    {
        return static::find()->where(['role' => $roleName])->select('id')->column();
    }

    public function getAuthRoleNames()
    {
        return (array)$this->role;
    }

    public function addAuthRoleName($roleName)
    {
        $this->updateAttributes(['role' => $this->role = $roleName]);
    }

    public function removeAuthRoleName($roleName)
    {
        $this->updateAttributes(['role' => $this->role = null]);
    }

    public function clearAuthRoleNames()
    {
        $this->updateAttributes(['role' => $this->role = null]);
    }

    ...
}
```
Run migration 

```
php yii migrate/to m191010_144041_init_role --migrationPath=@allcho/rbac/migrations
```

Run InitRbac create superadmin role and signup superadmin account

```
php yii initrbac/init
```

```
php yii initrbac/admin
```

