
<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name;
?>



<h1>Bienvenido a <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>

<?php
$url = Yii::app()->baseURL;
#echo Yii::app()->user->getState("role");
if (Yii::app()->user->getIsGuest()) {
    $this->renderPartial('_guest');
} else if (Yii::app()->user->getState("role") == "Profesor") {
    $this->renderPartial('_profe');
}
else if (Yii::app()->user->getState("role") == "Alumno") {
    $this->renderPartial('_alumno');
}
else if (Yii::app()->user->getState("role") == "Tutor") {
    $this->renderPartial('_tutor');
}
?>

        <div class="row">
            <div class="col-lg-4">
                <h2>Maestros</h2>

                <p>Está página web ofrece la posibilidad de mandar mensajes
                    a los padres de familia de tus alumnos.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Padres</h2>

                <p>Incribe a tus hijos a un grupo, para que te mantengas
                    enterado de todas las tareas y actividades de tus hijos.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Comunicación objetiva</h2>

                <p>Deja de batallar por no saber cual es la tarea de verdad, entra ahora.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
            </div>
 </div>



