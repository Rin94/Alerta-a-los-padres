<?php
/* @var $this AlumnoController */
/* @var $model Alumno */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'alumno-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	
        
	<?php 
            $mas=  Padre::model()->findByAttributes(array('usuario_id'=>Yii::app()->user->getId()));
            echo $form->errorSummary($model); 
        ?>

	<div class="row">
		
		<?php echo $form->textField($model,'nombre',
                        array('size'=>45,'maxlength'=>45,'placeholder'=>'nombre')); ?>
		<?php echo $form->error($model,'nombre'); ?>
                <?php echo $form->hiddenField
                        ($model,'padre_id',array('span'=>2,'maxlength'=>45,'value'=>$mas->id, 'required')) ?>
	</div>

	<div class="row">
		
		<?php echo $form->textField($model,'apellido_pat',
                        array('size'=>45,
                            'maxlength'=>45,
                            'placeholder'=>'apellido paterno',
                            'required'=>true,
                            )); ?>
		<?php echo $form->error($model,'apellido_pat'); ?>
	</div>

	<div class="row">
		<?php echo $form->textField($model,'apellido_mat',
                        array('size'=>45,
                            'maxlength'=>45,
                            'placeholder'=>'apellido materno',
                            'required'=>true,
                            )); ?>
		<?php echo $form->error($model,'apellido_mat'); ?>
	</div>

	<div class="row">
		
		<?php echo $form->hiddenField($model,'usuario_id'); ?>
		<?php echo $form->error($model,'usuario_id'); ?>
	</div>

	<div class="row buttons">
	       <?php echo TbHtml::submitButton($model->isNewRecord ? 'Crear' : 'Modificar',array(
		    'color'=>TbHtml::BUTTON_COLOR_SUCCESS,
		    'size'=>TbHtml::BUTTON_SIZE_LARGE,
		))." ".TbHtml::resetButton('Limpiar',array(
                        'color'=>  TbHtml::BUTTON_COLOR_INFO,
                        'size'=>  TbHtml::BUTTON_SIZE_LARGE
                    )); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->