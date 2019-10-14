<?php
namespace allcho\rbac\backend\controllers;

use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use allcho\rbac\common\models\UserSearch;
use common\models\User;
use allcho\rbac\common\models\PasswordChangeForm;
use yii\helpers\ArrayHelper;
use yii\data\ArrayDataProvider;

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
    
    
    public function actionRole()
    {
        $roles = Yii::$app->authManager->roles;
//        var_dump(Yii::$app->authManager->getPermissions());
//        die;
         $model = new ArrayDataProvider([
        'allModels' => $roles,
        'pagination' => [
               'pageSize' => 5,
         ]
         
        ]);
        return $this->render('role', [
            'model' => $model,
        ]);
        
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
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
        $password = new PasswordChangeForm($model);

        if ($model->load(Yii::$app->request->post()) && $password->load(Yii::$app->request->post())) {
            $password->newPassword($model);
            $model->save();
            return $this->redirect('index');
        }

        return $this->render('update', [
            'model' => $model,
            'password' => $password,
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
        if($model->getAuthRoleNames !== 'Администратор'){
            $auth = Yii::$app->authManager;
            $auth->revokeAll($id);
            $model->delete();
            Yii::$app->session->setFlash('success', "Пользователь удален");
            return $this->redirect(['index']);
        }
         
       Yii::$app->session->setFlash('success', "Нельзя удалить админа");
       return $this->redirect(['index']);
        
    }
    
    public function actionUnlock($id)
    {
        $model = $this->findModel($id);
        $model->status = '10';
        $model->update();
        Yii::$app->session->setFlash('success', "Пользователь разблокирован");
        return $this->redirect(Yii::$app->request->referrer);

    }
    public function actionLock($id)
    {
        $model = $this->findModel($id);
        if($model->userRole !== 'Администратор'){
             $model->status = '0';
             $model->update();
             Yii::$app->session->setFlash('success', "Пользователь заблокирован");
             return $this->redirect(Yii::$app->request->referrer);
        }

       Yii::$app->session->setFlash('success', "Нельзя заблокировать админа");
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