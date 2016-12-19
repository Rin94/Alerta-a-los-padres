<?php
/* @var $this GrupoController */
/* @var $model Grupo */
/* @var $form TbActiveForm */
?>

<?php if(Yii::app()->user->hasFlash('noUnir')){ ?>

<div class="flash-error">
	<?php echo Yii::app()->user->getFlash('noUnir'); 
}?>
</div>



<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'grupo-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>


    <?php 
    
    
    $mas=  Alumno::model()->findByAttributes(array('usuario_id'=>$name=Yii::app()->user->getId()));
    #echo $mas->id;
    echo $form->errorSummary($model); ?>

            <?php echo $form->hiddenField($model,'id',array('span'=>2,'maxlength'=>45,'value'=>$model->id, 'required')) ?>

            <?php echo $form->textField($model,'contrasenia',array('span'=>2,'maxlength'=>45, 'placeholder' =>'Clave de grupo', 'value'=>'','autocomplete'=>"off", 'required'=>true)); ?><br/>

            <?php echo $form->hiddenField($model,'alumno_id',array('span'=>2, 'readonly', 'value'=>$mas->id)); ?>

            

        <div class="form-actions">
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Create' : 'Unirse Al grupo',array(
		    'color'=>TbHtml::BUTTON_COLOR_SUCCESS,
		    'size'=>TbHtml::BUTTON_SIZE_LARGE,
		))." ".TbHtml::resetButton('Limpiar',array(
                        'color'=>  TbHtml::BUTTON_COLOR_INFO,
                        'size'=>  TbHtml::BUTTON_SIZE_LARGE
                    )); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->

