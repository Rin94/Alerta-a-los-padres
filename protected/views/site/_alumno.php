<?php

 echo TbHtml::carousel(array(
    array('image' => 'https://eticanegociosenron.files.wordpress.com/2013/05/enron.png', 'label' => TbHtml::link('Inscribete a un grupos',"/VeranoCientifico/grupo/index"), 'caption' => 'Crea un grupo, administra tu clase'),
    array('image' => 'http://negocioshoteles.com/wp-content/uploads/2016/01/HACER-ANUNCIOS.jpg', 'label' => TbHtml::link('Ver tareas',"/VeranoCientifico/aviso/create"), 'caption' => 'Publica una tarea en un grupo'),
   // array('image' => 'http://www.yumeki.org/wp-content/uploads/2013/12/tobitateakb48.jpg', 'label' => 'Alumnos', 'caption' => 'Mantente enterado de tus estudiantes'),
    )); 

?>