<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

class UsuarioController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function actions() {
        return array(
            // ...
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
                // ...
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
             
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view','updateajax'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update','createPadre'),
                'users' => array('*'),
            ),
            array('allow', 'actions' => array('captcha'), 'users' => array('*')),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
           
            
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Usuario;
        $transaction = $model->dbConnection->beginTransaction();
        #$this->redirect(Yii::app()->homeUrl."site/login");
        
        
        
        try {
            if (isset($_POST['Usuario'])) {
                $model->attributes = $_POST['Usuario'];
                $model->tipo_id=1;
                $name = $model->name;
                $lastName = $model->ap_pat;
                $matName = $model->ap_mat;
                if ($model->save()) {
                    $newModel = $this->verificarUsuario(1, $name, $lastName, $matName, $model->id);
                    $newModel->save();
                    $transaction->commit();
                    $this->redirect(Yii::app()->homeUrl."site/login");
                }
            }
        } catch (Exception $ex) {
            echo TbHtml::alert(TbHtml::ALERT_COLOR_ERROR, 'No se pudo registrar ' . $ex);
            $transaction->rollBack();
        }
        #$data=array();
        #$data["myValue"]="Este va vacio";
        $this->render('create', array(
            'model' => $model,
        ));
    }

    
    public function actionCreatePadre(){
        $model= new Usuario;
        $transaction=$model->dbConnection->beginTransaction();
        try{
            if(isset($_POST['Usuario'])){
                $model->attributes = $_POST['Usuario'];
                $model->tipo_id=3;
                $name = $model->name;
                $lastName = $model->ap_pat;
                $matName = $model->ap_mat;
                
                if($model->save()){
                    $newModel = $this->verificarUsuario(3, $name, $lastName, $matName, $model->id);
                    $newModel->save();
                    $transaction->commit();
                    $this->redirect(Yii::app()->homeUrl."site/login");
                    
                }
            }
            
        } catch (Exception $ex) {
            echo TbHtml::alert(TbHtml::ALERT_COLOR_ERROR, 'No se pudo registrar ' . $ex);
            $transaction->rollBack();

        }
        $this->render('createpadre',array('model'=>$model));
    }
    public function verificarUsuario($tipo, $name, $lastName, $matName, $us_id) {

        if ($tipo == 1) {
            $profesor = new Maestro();
            $profesor->nombre = $name;
            $profesor->apellido_pat = $lastName;
            $profesor->apellido_mat = $matName;
            $profesor->usuario_id = $us_id;

            return $profesor;
        } else if ($tipo == 2) {
            $alumno = new Alumno();

            $alumno->nombre = $name;
            $alumno->apellido_pat = $lastName;
            $alumno->apellido_mat = $matName;
            $alumno->usuario_id = $us_id;

            return $alumno;
        } else if ($tipo == 3) {
            $padre = new Padre();

            $padre->nombre = $name;
            $padre->apellido_pat = $lastName;
            $padre->apellido_mat = $matName;
            $padre->usuario_id = $us_id;


            return $padre;
        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Usuario'])) {
            $model->attributes = $_POST['Usuario'];
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Usuario');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Usuario('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Usuario'])) {
            $model->attributes = $_GET['Usuario'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Usuario the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Usuario::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Usuario $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'usuario-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    
    
    public function actionUpdateAjax() {
        
        $data= array();
        $data["myValue"]="Content updated in AJAX";
       
        
        $this->renderPartial('_ajaxContent',$data,false,true);

    }


}
