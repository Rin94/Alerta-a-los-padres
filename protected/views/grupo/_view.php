<?php
/* @var $this GrupoController */
/* @var $data Grupo */
error_reporting(E_ALL);
ini_set('display_errors', '1');


#$master=Grupo::model()->findByAttributes(array('maestro_id'=>$mas->id));
#echo $master->id;
#Yii::app()->end();
?>


<div class="view">




    <b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
    <?php echo CHtml::encode($data->nombre); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('maestro_id')); ?>:</b>
    <?php echo CHtml::encode($data->maestro->nombre . " " . $data->maestro->apellido_pat); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('grado_id')); ?>:</b>
    <?php echo CHtml::encode($data->grado_id); ?>
    <br />

    <b><?php
     if(Yii::app()->user->role == "Alumno"){
         if ($data->yaEstaUnido($data->id)){
             echo "Ya está inscrito al grupo";
             
         }
         else{
             echo CHtml::link("Unirse A Este Grupo", array('unir', 'id' => $data->id));
             
         }
         
         
     }
     else if(Yii::app()->user->role == "Tutor"){
         echo CHtml::link("Relacionar", array('relacionar', 'id' => $data->id));
         
     }
            
        
             ?>
    

</div>
