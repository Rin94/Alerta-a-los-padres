<?php

/**
 * This is the model class for table "aviso".
 *
 * The followings are the available columns in table 'aviso':
 * @property integer $id
 * @property string $titulo
 * @property string $descripcion
 * @property string $fecha_publicacion
 * @property string $fecha_entrega
 * @property integer $materia_id
 * @property integer $grupo_id
 *
 * The followings are the available model relations:
 * @property Adjunto[] $adjuntos
 * @property Grupo $grupo
 * @property Materia $materia
 */
class Aviso extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'aviso';
    }

    public $adjunto;

    public static function getListMaterias() {
        return CHtml::listData(Materia::model()->findAll(), 'id', 'nombre');
    }

    public static function getListGrupo() {
        return CHtml::listData(Grupo::model()->findAll(), 'id', 'nombre');
    }
    
    public static function getListGrupoPerT() {
        $mas = Maestro::model()->findByAttributes(array('usuario_id' => $name = Yii::app()->user->getId()));
        $r=$mas->id;
        return CHtml::listData(Grupo::model()->findAll("maestro_id=$r"), 'id', 'nombre');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('titulo, descripcion, materia_id, grupo_id', 'required'),
            array('id, materia_id, grupo_id', 'numerical', 'integerOnly' => true),
            array('titulo', 'length', 'max' => 45),
            array('descripcion', 'length', 'max' => 255),
            array('adjunto',
                'file',
                //'types' => 'jpg,gif,png,pdf,docx',
                'wrongType' => 'Formatos permetidos jpg, gif, png, pdf, doc',
                'maxSize' => 500000,
                'tooLarge' => 'El archivo es muy largo',
                //'toLarge'=>'El tamaño permitido es de 5 megas',
                'allowEmpty' => true,
            ),
            array('fecha_entrega', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, titulo, descripcion, fecha_publicacion, fecha_entrega, materia_id, grupo_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'adjuntos' => array(self::HAS_MANY, 'Adjunto', 'aviso_id'),
            'grupo' => array(self::BELONGS_TO, 'Grupo', 'grupo_id'),
            'materia' => array(self::BELONGS_TO, 'Materia', 'materia_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'titulo' => 'Titulo',
            'descripcion' => 'Descripcion',
            'fecha_publicacion' => 'Fecha Inicial',
            'fecha_entrega' => 'Fecha Entrega',
            'materia_id' => 'Materia',
            'grupo_id' => 'Grupo',
            'adjunto' => 'Adjunto',
        );
    }

    public static function getFechaRegistro() {
        $connection = Yii::app()->db;
        //Indico mi consulta a obtener
        $command = $connection->createCommand("select now();");
        //Acciono el query del $command
        $dataReader = $command->query();
        return $dataReader;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('titulo', $this->titulo, true);
        $criteria->compare('descripcion', $this->descripcion, true);
        $criteria->compare('fecha_publicacion', $this->fecha_publicacion, true);
        $criteria->compare('fecha_entrega', $this->fecha_entrega, true);
        $criteria->compare('materia_id', $this->materia_id);
        $criteria->compare('grupo_id', $this->grupo_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Aviso the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function contarAdjuntos($id){
        $criteria= new CDbCriteria();
        //select count(id) from adjunto where aviso_id =16
        $criteria->select="count(t.id) from Adjunto";
        $criteria->condition="t.aviso_id=:value";
        $criteria->params=  array(":value"=>$id);
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
        
        
        
    }

    public function searchAvisoPorAlumno() {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $mas = Alumno::model()->findByAttributes(array('usuario_id' => $name = Yii::app()->user->getId()));
        $criteria = new CDbCriteria;
        $criteria->select="distinct t.*";
        $criteria->join = "JOIN grupo  on t.grupo_id=grupo.id"
                . " JOIN alumno_has_grupo on alumno_has_grupo.alumno_id=:value";
        $criteria->params = array(":value" => $mas->id);
        $criteria->compare('id', $this->id);
        $criteria->compare('titulo', $this->titulo, true);
        $criteria->compare('descripcion', $this->descripcion, true);
        $criteria->compare('fecha_publicacion', $this->fecha_publicacion, true);
        $criteria->compare('fecha_entrega', $this->fecha_entrega, true);
        $criteria->compare('materia_id', $this->materia_id);
        try{
        $criteria->compare('grupo_id', $this->grupo_id);
        } catch (ErrorException $error){
            
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
        public function searchAvisoPorProfesor() {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $mas = Maestro::model()->findByAttributes(array('usuario_id' => $name = Yii::app()->user->getId()));
        $criteria = new CDbCriteria;
        $criteria->select="distinct t.*";
        $criteria->join = "JOIN grupo  on t.grupo_id=grupo.id";
        $criteria->condition="grupo.maestro_id=:value";
                //. " JOIN alumno_has_grupo on alumno_has_grupo.alumno_id=:value";
        $criteria->params = array(":value" => $mas->id);
        $criteria->compare('id', $this->id);
        $criteria->compare('titulo', $this->titulo, true);
        $criteria->compare('descripcion', $this->descripcion, true);
        $criteria->compare('fecha_publicacion', $this->fecha_publicacion, true);
        $criteria->compare('fecha_entrega', $this->fecha_entrega, true);
        $criteria->compare('materia_id', $this->materia_id);
        try{
        $criteria->compare('grupo_id', $this->grupo_id);
        } catch (ErrorException $error){
            
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    
    public function searchAvisoPorGrupo($id){
        $criteria = new CDbCriteria;
        $criteria->select="t.*";
        $criteria->condition="t.grupo_id = :value";
        $criteria->params = array(":value" => $id);
        $criteria->compare('id', $this->id);
        $criteria->compare('titulo', $this->titulo, true);
        $criteria->compare('descripcion', $this->descripcion, true);
        $criteria->compare('fecha_publicacion', $this->fecha_publicacion, true);
        $criteria->compare('fecha_entrega', $this->fecha_entrega, true);
        $criteria->compare('materia_id', $this->materia_id);
        $criteria->order="t.fecha_publicacion desc";
        try{
            $criteria->compare('grupo_id', $this->grupo_id);
        } catch (ErrorException $error){
            
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
        
    }

}
