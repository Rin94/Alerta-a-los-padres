<?php

 echo TbHtml::carousel(array(
    array('image' => 'https://eticanegociosenron.files.wordpress.com/2013/05/enron.png', 'label' => TbHtml::link('Crea Grupos',"/VeranoCientifico/grupo/create"), 'caption' => 'Crea un grupo, administra tu clase'),
    array('image' => 'http://negocioshoteles.com/wp-content/uploads/2016/01/HACER-ANUNCIOS.jpg', 'label' => TbHtml::link('Publicar una tarea',"/VeranoCientifico/aviso/create"), 'caption' => 'Publica una tarea en un grupo'),
    array('image' => 'http://www.yumeki.org/wp-content/uploads/2013/12/tobitateakb48.jpg', 'label' => 'Alumnos', 'caption' => 'Mantente enterado de tus estudiantes'),
    )); 
 
 ?>

