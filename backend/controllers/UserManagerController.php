<?php
namespace allcho\rbac\backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use allcho\rbac\common\models\UserSearch;
use common\models\User;
use yii\data\ArrayDataProvider;
use allcho\rbac\common\models\SignupForm;
use allcho\rbac\common\models\ProfileForm;
use allcho\rbac\backend\models\RoleForm;

/**
 * UserManagerController implements the CRUD actions for User model.
 */
class UserManagerController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                      //  'actions' => ['index', 'role', 'update', 'create'],
                        'allow' => true,
                        'roles' => ['superadmin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'lock' => ['POST'],
                    'unlock' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Lists all Role models.
     * @return mixed
     */
    public function actionRole()
    {
        $roles = Yii::$app->authManager->roles;

        $dataProvider = new ArrayDataProvider([
        'allModels' => $roles,
        'pagination' => [
               'pageSize' => 25,
         ]
         
        ]);
        return $this->render('role', [
            'dataProvider' => $dataProvider,
        ]);
        
    }

    
        /**
     * Lists all Permission models.
     * @return mixed
     */
    public function actionPermission() {
        
        $permissions = Yii::$app->authManager->getPermissions();

        $dataProvider = new ArrayDataProvider([
            'allModels' => $permissions,
            'pagination' => [
                'pageSize' => 25,
            ]
        ]);
        return $this->render('permission', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SignupForm();
        $roles = Yii::$app->getAuthManager()->getRoles();
        
        if ($model->load(Yii::$app->request->post())) {
            $model->signup($model->role);
            Yii::$app->session->setFlash('success', 'Registration new User Done.');
            return $this->redirect('index');
        }

        return $this->render('create', [
            'model' => $model,
            'roles' => $roles,
        ]);
    }
    
    /**
     * Creates a new Role model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionRoleCreate()
    {
        $model = new RoleForm();
        $array_roles = Yii::$app->getAuthManager()->getRoles();
 
        $roles = [];
        foreach ($array_roles as $key => $value){
            $roles[] =   Yii::$app->getAuthManager()->getChildren($key);
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->createRole($model->role);
            Yii::$app->session->setFlash('success', 'Registration new Role Done.');
            return $this->redirect('role');
        }

        return $this->render('create_role', [
            'model' => $model,
            'roles' => $roles,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $roles = Yii::$app->getAuthManager()->getRoles();
        $profile = new ProfileForm($model);
        $model->scenario = ProfileForm::SCENARIO_DEFAULT;
        $role_user = $model->role;
        
        if ($profile->load(Yii::$app->request->post())) {
             if($role_user === 'superadmin' && $model->id !== Yii::$app->user->identity->id){
                Yii::$app->session->setFlash('success', "You cannot updated a superadmin this can do only superadmin byself");
                return $this->redirect('index');
             }elseif ($profile->role === 'superadmin' && Yii::$app->user->identity->role !== 'superadmin'){
                Yii::$app->session->setFlash('success', "You cannot assign a superadmin role to this user because you are not superadmin");
                return $this->redirect('index');
             }else{
                $profile->updateUser($profile->password, $profile->username, $profile->email, $profile->role);
                Yii::$app->session->setFlash('success', "User was updated");
                return $this->redirect('index');
             }
           
        }

        return $this->render('update', [
            'model' => $model,
            'profile' => $profile,
            'roles' => $roles,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if($model->role !== 'superadmin'){
            $model->delete();
            Yii::$app->session->setFlash('success', "User was delete");
            return $this->redirect(['index']);
        }
         
       Yii::$app->session->setFlash('success', "You cannot delete a superadmin");
       return $this->redirect(['index']);
        
    }
    
    public function actionUnlock($id)
    {
        $model = $this->findModel($id);
        $model->status = '10';
        $model->update();
        Yii::$app->session->setFlash('success', "User was unlock");
        return $this->redirect(Yii::$app->request->referrer);

    }
    public function actionLock($id)
    {
        $model = $this->findModel($id);
        if($model->role !== 'superadmin'){
             $model->status = '0';
             $model->update();
             Yii::$app->session->setFlash('success', "User was block");
             return $this->redirect(Yii::$app->request->referrer);
        }

       Yii::$app->session->setFlash('success', "You cannot block a superadmin");
       return $this->redirect(['index']);

    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {

        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}