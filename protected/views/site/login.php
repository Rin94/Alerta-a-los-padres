<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>

<h2>Iniciar Sesion</h2>

<p></p>

<div class="form">
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	

	<div class="row">
		
		<?php echo $form->textField($model,'username', array('placeholder'=>'Nombre de Usuario / Correo','required'=>true)); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		
		<?php echo $form->passwordField($model,'password',array('placeholder'=>'contraseña','required'=>true)); ?>
		<?php echo $form->error($model,'password'); ?>
		
	</div>

	<div class="row rememberMe">
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		<?php echo $form->label($model,'rememberMe'); ?>
		<?php echo $form->error($model,'rememberMe'); ?>
	</div>

	<div class="row buttons">
		<?php echo TbHtml::submitButton('Ingresar',array(
		    'color'=>TbHtml::BUTTON_COLOR_SUCCESS,
		    'size'=>TbHtml::BUTTON_SIZE_LARGE,
		))."  ".TbHtml::resetButton('Limpiar',array(
                        'color'=>  TbHtml::BUTTON_COLOR_INFO,
                        'size'=>  TbHtml::BUTTON_SIZE_LARGE
                    )); ?> 
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
