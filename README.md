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
        'class' => 'allcho\rbac\common\extensions\hybridrbac',
        //'modelClass' => 'common\models\User',
    ],
],
```

Set controllerMap  in your console config:
```
'controllerMap' => [
        'initrbac' => [
            'class' => 'allcho\rbac\console\controllers\InitRbacController',
            //'modelClass' => 'common\models\User',
            
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


Run migration 

```
php yii migrate/to m191010_144041_init_role --migrationPath=@allcho/rbac/migrations
```

Run InitRbac create superadmin role and signup superadmin account (superadmin can be only one)

```
php yii initrbac/iit
```

```
php yii initrbac/admin
```

