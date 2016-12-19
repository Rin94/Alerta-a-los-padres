<?php
/* @var $this GrupoController */
/* @var $model Grupo */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'grupo-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

    <p class="help-block">Los campos con <span class="required">*</span> son obligatorios.</p>

    <?php 
    
    
    $mas=Maestro::model()->findByAttributes(array('usuario_id'=>$name=Yii::app()->user->getId()));
    #echo $mas->id;
    echo $form->errorSummary($model); ?>

            <?php echo $form->textField($model,'nombre',array('span'=>2,'maxlength'=>45, 'placeholder' => 'nombre', 'required'=>true)); ?>

            <?php echo $form->textField($model,'contrasenia',array('span'=>2,'maxlength'=>45, 'placeholder' =>'Pon una clave', 'required'=>true)); ?><br/>

            <?php echo $form->hiddenField($model,'maestro_id',array('span'=>2, 'readonly', 'value'=>$mas->id)); ?>

            <?php echo $form->dropDownListControlGroup($model,'grado_id',TbHtml::listData(Grado::model()->findAll(), 'id', 'rango'), array('span' => 2)); ?>

        <div class="form-actions">
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Crear' : 'Save',array(
		    'color'=>TbHtml::BUTTON_COLOR_SUCCESS,
		    'size'=>TbHtml::BUTTON_SIZE_LARGE,
		))." ".TbHtml::resetButton('Limpiar',array(
                        'color'=>  TbHtml::BUTTON_COLOR_INFO,
                        'size'=>  TbHtml::BUTTON_SIZE_LARGE
                    )); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->

