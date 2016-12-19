<?php
/* @var $this UsuarioController */
/* @var $model Usuario */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'usuario-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => true,
    ));
    ?>

   

    <?php echo $form->errorSummary($model); ?>
    <?php echo $form->textField($model, 'nick', array('span' => 3, 'maxlength' => 45, 'placeholder' => 'Nombre Usuario', 'required'=>true)) ?>

    <?php echo $form->emailField($model, 'correo', array('span' => 4, 'maxlength' => 45, 'placeholder' => 'Correo', 'required'=>true)) ?>

    <?php echo $form->passwordField($model, 'contrasenia', array('span' => 2, 'maxlength' => 45, 'placeholder' => 'Contraseña','required'=>true))?>

    <?php #echo $form->dropDownListControlGroup($model, 'tipo_id', TbHtml::listData(Tipo::model()->findAll(), 'id', 'nombre'), array('span' => 2,'required'=>true)); ?>
    <br/>
    <div id="linea">  
    </div>
  
    <?php echo $form->textField($model, 'name', array('span' => 2, 'maxlength' => 45, 'placeholder' => 'Nombre','required'=>true)) ?>

    <?php echo $form->textField($model, 'ap_pat', array('span' => 3, 'maxlength' => 45, 'placeholder' => 'Apellido Paterno','required'=>true)) ?>

<?php echo $form->textField($model, 'ap_mat', array('span' => 3, 'maxlength' => 45, 'placeholder' => 'Apellido Materno',)); ?>
<?php echo $form->textFieldControlGroup($model, 'verifyCode', array(
  'help' => 'Por favor digite las letras como se ven en la imágen.',
  'controlOptions' => array('before' => $this->widget('system.web.widgets.captcha.CCaptcha', array(), true) . '<br/>'),
));?>

    <div class="form-actions">
        <?php
        echo TbHtml::submitButton($model->isNewRecord ? 'Confirmar' : 'Actualizar', array(
            'color' => TbHtml::BUTTON_COLOR_PRIMARY,
            'size' => TbHtml::BUTTON_SIZE_LARGE,
        ));
        ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">
    function getRequestObject(){
        if(window.XMLHttpRequest){
            return (new XMLHttpRequest());
            
        }
        else if(window.ActiveXObject){
            return (new ActiveXObject("Microsoft.XMLHTTP"));
        }
        else{
            return (null);
        }
    }
    
    function manejaRespuesta(request){
        if(request.readystate==4 && request.status==200){
            var seccion= document.getElementById("linea");
            seccion.innherHtml=request.responseText;
        }
    }
    
    function solicitarArchivo(nombreArch){
        var request=getRequestObject()
        if(request){
            request.onreadystatechange=
                    function(){
                        manejaRespuesta(request);}
                            request.open("POST",nombreach,true)
                            request.send(null);
                        
            }
        }
    
 </script>