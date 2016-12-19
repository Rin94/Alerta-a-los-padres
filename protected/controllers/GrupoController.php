<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

class GrupoController extends Controller {

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

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
                'expression' =>
                // 'isset(Yii::app()->user->role) && !in_array(Yii::app()->user->role,array("DIR"))',
                'isset(Yii::app()->user->role) && (Yii::app()->user->role == "Profesor")',
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('unir', 'viewal','vertask'),
                'users' => array('@'),
                'expression' =>
                // 'isset(Yii::app()->user->role) && !in_array(Yii::app()->user->role,array("DIR"))',
                'isset(Yii::app()->user->role) && (Yii::app()->user->role == "Alumno")',
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('relacionar'),
                'users' => array('@'),
                'expression' =>
                // 'isset(Yii::app()->user->role) && !in_array(Yii::app()->user->role,array("DIR"))',
                'isset(Yii::app()->user->role) && (Yii::app()->user->role == "Tutor")',
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'myAction'),
                'users' => array('@'),
                'expression' =>
                // 'isset(Yii::app()->user->role) && !in_array(Yii::app()->user->role,array("DIR"))',
                'isset(Yii::app()->user->role) && (Yii::app()->user->role == "Profesor")',
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionMyAction() {
        if (Yii::app()->request->isAjaxRequest) {

// to avoid jQuery and other core scripts from loading when the fourth parameter of renderPartial() is TRUE.
// this is useful if you want another ajaxButton in the modal or anything with scripts.
// http://www.yiiframework.com/forum/index.php/topic/5455-creating-ajax-elements-from-inside-ajax-request/page__p__30114#entry30114
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;

            $body = $this->renderPartial('_form', array(
                new Grupo('create'),
                    ), true, true); // processOutput

            echo CJSON::encode(array(
// this will be used in the Modal header
                'header' => 'Success! Modal was opened',
                // this will be used in the Modal body
                'body' => $body,
            ));
            exit;
        } else
            throw new CHttpException('403', 'Forbidden access.');
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
    
     public function actionVertask($id){
       
       $this->render('vertask', array(
            'model' => $this->loadModel($id),
        ));
        
   }
   

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Grupo('create');

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['Grupo'])) {
            $model->attributes = $_POST['Grupo'];
            if ($model->save()) {
                $this->redirect(array('admin'));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
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

        if (isset($_POST['Grupo'])) {
            $model->attributes = $_POST['Grupo'];
            if ($model->save()) {
                $this->redirect(array('admin'));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionRelacionar($id) {
        $model = $this->loadModel($id);
        $model->scenario = "relacionar";
        $password = $model->contrasenia;
        if (isset($_POST['Grupo'])) {
            $model->attributes = $_POST['Grupo'];
            $model->validate();
            if (count($_POST['Grupo']) == 3 or $_POST['Grupo']['contrasenia'] == '') {
                Yii::app()->user->setFlash('noUnir', 'Le falta llenar un dato');
            } else {
                if ($model->contrasenia == $password) {
                    $alumnoHasPadre = new AlumnoHasPadre();
                    $transaction = $alumnoHasPadre->dbConnection->beginTransaction();
                    try {
                        $alumnoHasPadre->padre_id = $_POST['Grupo']['padre_id'];
                        $arreglo = $_POST['Grupo']['alumno_id'];
                        foreach ($arreglo as $ar) {
                            $alumnoHasPadre->alumno_id = $ar;
                            $alumnoHasPadre->save();
                        }
                        $transaction->commit();
                        $this->redirect(array('view', 'id' => $model->id));
                    } catch (Exception $ex) {
                        Yii::app()->user->setFlash('noUnir', 'Ya esta relacionado o no se puede inscribir');
                        $transaction->rollBack();
                    }
                } else {
                    Yii::app()->user->setFlash('noUnir', 'La constraseña es incorrecta');
                }
            }
        }
        $this->render('relacionar', array(
            'model' => $model,
        ));
    }

    public function actionUnir($id) {
        $model = $this->loadModel($id);
        $password = $model->contrasenia;
        if (isset($_POST['Grupo'])) {
            $model->attributes = $_POST['Grupo'];
            if ($model->contrasenia == $password) {
                $alumnoHasGrupo = new AlumnoHasGrupo();
                $alumnoHasGrupo->alumno_id = $_POST['Grupo']['alumno_id'];
                $alumnoHasGrupo->grupo_id = $model->id;
                $transaction = $alumnoHasGrupo->dbConnection->beginTransaction();
                try {
                    if ($alumnoHasGrupo->save()) {
                        $transaction->commit();
                        $this->actionViewal();
#$this->render('viewal', array(
#'model' => new Grupo('search'),
#));
                    }
                } catch (Exception $ex) {
                    Yii::app()->user->setFlash('noUnir', 'Ya esta inscrito al grupo o no se puede inscribir');
                    $transaction->rollBack();
                }
            } else {
                Yii::app()->user->setFlash('noUnir', 'La clave del grupo es incorrecta');
            }
        }

        $this->render('unir', array(
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
#public function actionIndex() {
# $dataProvider = new CActiveDataProvider('Grupo');
# $this->render('index', array(
#      'dataProvider' => $dataProvider,
#   ));
#}

    public function actionIndex() {
        $criteria = new CDbCriteria();

        if (isset($_GET['q'])) {
            $q = $_GET['q'];
            $criteria->compare('nombre', $q, true, 'OR');
            #$criteria->compare('attribute2', $q, true, 'OR');
        }

        $dataProvider = new CActiveDataProvider
                ("Grupo", array('criteria' => $criteria));

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Grupo('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Grupo'])) {
            $model->attributes = $_GET['Grupo'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionViewal() {
        $model = new Grupo('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Grupo'])) {
            $model->attributes = $_GET['Grupo'];
        }

        $this->render('viewal', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Grupo the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Grupo::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }
    
    

    /**
     * Performs the AJAX validation.
     * @param Grupo $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'grupo-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
