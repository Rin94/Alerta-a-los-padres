<?php
/* @var $this AvisoController */
/* @var $model Aviso */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'aviso-form',
        
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
)); ?>

    <p class="help-block">Los campos con <span class="required">*</span> son necesarios.</p>

    <?php 
    $mas=Maestro::model()->findByAttributes(array('usuario_id'=>$name=Yii::app()->user->getId()));
    echo $form->errorSummary($model); ?>

            <?php echo $form->textField($model,'titulo',array('span'=>5,'maxlength'=>45, 'placeholder'=>'Titulo','required'=>true )); ?><br/>

            <?php echo $form->textArea($model,'descripcion',
                    array(
                        'span'=>5,'maxlength'=>255,
                        'placeholder'=>'Describe de que se trata tu tarea'
                        ,
                        'rows'=>5,'required'=>true ));
            //TbHtml::$afterRequiredLabel." "
            ?><br/>


            <?php #echo $form->textFieldControlGroup($model,'fecha_publicacion',array('span'=>5)); ?>

            <?php echo $form->dateFieldControlGroup($model,'fecha_entrega',array('placeholder'=>'today')) ?>

            <?php echo $form->dropDownListControlGroup($model,'materia_id',TbHtml::listData(Materia::model()->findAll(), 'id', 'nombre'),
                    array(
                        'span'=>3,
                        'label' => 'Materia',
                        'placeholder'=>'Materia',
                        'required'=>true,
                        )); ?>

            <?php echo $form->dropDownListControlGroup($model,'grupo_id',  Grupo::model()->listarGrupos($mas->id),
                    array('placeholder'=>'today')); ?>
            
        
            <?php
                $this->widget("CMultiFileUpload",
                        array(
                            'model'=>$model,
                            'name'=>'adjunto',
                            'attribute'=>'adjunto',
                            'accept'=>'jpg|gif|png|pdf|docx',
                            'denied'=>'El tipo de archivo no está permitido',
                            'max'=>5,
                            'duplicate'=>'Archivo duplicado',                                
                        ));
                        echo $form->error($model,'adjunto');
                
                    
            
            ?>
        <div class="form-actions">
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Asignar' : 'Save',array(
		    'color'=>TbHtml::BUTTON_COLOR_SUCCESS,
                    
		    'size'=>TbHtml::BUTTON_SIZE_LARGE,
		))." ".TbHtml::resetButton('Limpiar',array(
                        'color'=>  TbHtml::BUTTON_COLOR_INFO,
                        'size'=>  TbHtml::BUTTON_SIZE_LARGE
                    )); ?>
    </div>

    <?php $this->endWidget(); ?>
    

</div><!-- form -->

