<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
class AvisoController extends Controller {

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
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('@'),
                'expression' =>
                // 'isset(Yii::app()->user->role) && !in_array(Yii::app()->user->role,array("DIR"))',
                'isset(Yii::app()->user->role) && (Yii::app()->user->role == "Profesor")',
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('adminal', 'viewtask'),
                'users' => array('@'),
                'expression' =>
                'isset(Yii::app()->user->role) && (Yii::app()->user->role == "Alumno")',
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
    
  
    /***
     * Admin de alumnos
     */
   public function actionAdminal() {
        $model = new Aviso('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Grupo'])) {
            $model->attributes = $_GET['Grupo'];
        }

        $this->render('adminal', array(
            'model' => $model,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Aviso;
        if (isset($_POST['Aviso'])) {
            $model->attributes = $_POST['Aviso'];
            #$nombre = $model->titulo;
            $fecha = Aviso::model()->getFechaRegistro();
            $model->fecha_publicacion = $fecha->readColumn(0);
            $adjuntos = $_FILES;
            $temp=$adjuntos['adjunto']['tmp_name'];
            if ($model->save()) {
                if (count($adjuntos['adjunto']['name']) > 0) {  
                    $this->guardarAdjuntos($adjuntos['adjunto']['name'], $model,$temp);
                }
                $this->redirect(array('view', 'id' => $model->id));
            }
        }
        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function guardarAdjuntos($adjuntos, $model,$temp) {
        $i=0;
        foreach ($adjuntos as $var) {
            $adjunto = new Adjunto();
            $adjunto->nombre = $var;
            $adjunto->aviso_id=$model->id;
            $cadena = explode(".", $adjunto->nombre);
            $tipo = array_pop($cadena);
            $adjunto->tipo = $tipo;
            $adjunto->ruta = Yii::app()->basePath . "/../adjuntos/grupo A/" . $adjunto->nombre;
            $adjunto->save(false);
            
            move_uploaded_file($temp[$i], $adjunto->ruta);
            $i=$i+1;
              
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

        if (isset($_POST['Aviso'])) {
            $model->attributes = $_POST['Aviso'];
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
        if(Yii::app()->user->role == "Profesor"){
            $this->actionAdmin();
            
        }
        else if (Yii::app()->user->role == "Alumno"){
            $this->actionAdminal();
            
        }
        
    }

    /**
     * admin de maestro
     */
    public function actionAdmin() {
        $model = new Aviso('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Aviso'])) {
            $model->attributes = $_GET['Aviso'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Aviso the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Aviso::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Aviso $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'aviso-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
