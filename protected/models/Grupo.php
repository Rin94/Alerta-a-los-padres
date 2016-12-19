<?php

/**
 * This is the model class for table "grupo".
 *
 * The followings are the available columns in table 'grupo':
 * @property integer $id
 * @property string $nombre
 * @property string $contrasenia
 * @property integer $maestro_id
 * @property integer $grado_id
 *
 * The followings are the available model relations:
 * @property Alumno[] $alumnos
 * @property Aviso[] $avisos
 * @property Maestro $maestro
 * @property Grado $grado
 */
class Grupo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'grupo';
	}

        public $registar;
        public $alumno_id;
        public $padre_id;

        private $gradoCompleto;

        public function getGradoCompleto() {
            $gradoCompleto=$this->nombre." ".Grado::model()->rango;
            return $gradoCompleto;
        }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        array('nombre, contrasenia, maestro_id, grado_id', 'required'),
                        array('id, constrasenia, alumno_id', 'required', 'on'=>'unir'),
                        array('id,contrasenia, alumno_id, padre_id','required', 'on'=>'relacionar'),
			array('maestro_id, grado_id, alumno_id', 'numerical', 'integerOnly'=>true),
			array('nombre, contrasenia', 'length', 'max'=>45),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombre, contrasenia, maestro_id, grado_id', 'safe', 'on'=>'search'),

		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'alumnos' => array(self::MANY_MANY, 'Alumno', 'alumno_has_grupo(grupo_id, alumno_id)'),
			'avisos' => array(self::HAS_MANY, 'Aviso', 'grupo_id'),
			'maestro' => array(self::BELONGS_TO, 'Maestro', 'maestro_id'),
			'grado' => array(self::BELONGS_TO, 'Grado', 'grado_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre' => 'Grupo',
			'contrasenia' => 'Clave',
			'maestro_id' => 'Maestro',
			'grado_id' => 'Grado escolar',
                        'alumno_id'=>'Alumno',
                        'padre_id'=>'Padre',
		);
	}

    public static function encontrarGrupo($maestro_id) {
        $criteria = new CDbCriteria;
        $criteria->select = 't.id, t.nombre, grado.rango';
        $criteria->join = "JOIN grado   ON t.grado_id = grado.id";
        $criteria->condition = "t.maestro_id = :value";
        $criteria->order = "t.nombre DESC";
        $criteria->params = array(":value" => $maestro_id);
        return $criteria;
    }
    
    public static function yaEstaUnido($grupo_id){
        $mas = Alumno::model()->findByAttributes(array('usuario_id' => $name = Yii::app()->user->getId()));
        $r=$mas->id;
        $criteria = new CDbCriteria;
        $criteria->select = 't.id, alumno.id';
        $criteria->join = "join alumno_has_grupo on t.id=alumno_has_grupo.grupo_id join alumno on alumno_has_grupo.alumno_id=alumno.id";
        $criteria->condition = "alumno.id = :value and t.id = :valor ";
        $criteria->params = array(":value" => $r, ":valor"=>$grupo_id);
        return Grupo::model()->count($criteria);
        
    }
    
    public static function encontrarGrupoPorGeneralAlumno(){
        //select grupo.nombre from grupo
        //join alumno_has_grupo on grupo.id=alumno_has_grupo.grupo_id
        //join alumno on alumno_has_grupo.alumno_id=alumno.id
        //where alumno.id=3
        $mas = Alumno::model()->findByAttributes(array('usuario_id' => $name = Yii::app()->user->getId()));
        $r=$mas->id;
        $criteria = new CDbCriteria;
        $criteria->select = 't.id, t.nombre';
        $criteria->join = "join alumno_has_grupo on t.id=alumno_has_grupo.grupo_id
         join alumno on alumno_has_grupo.alumno_id=alumno.id";
        $criteria->condition = "alumno.id = :value";
        $criteria->params = array(":value" => $r);
        return CHtml::listData(Grupo::model()->findAll($criteria), 'id', 'nombre');
        
        
    }

        public static function encontrarGrupoPorAlumno($maestro_id) {
        $criteria = new CDbCriteria;
        $criteria->select = 't.id, t.nombre, grado.rango';
        $criteria->join = "JOIN grado   ON t.grado_id = grado.id";
        $criteria->condition = "t.maestro_id = :value";
        $criteria->order = "t.nombre DESC";
        $criteria->params = array(":value" => $maestro_id);
        return $criteria;
    }

    public static function listarGrupos($maestro_id) {
        return TbHtml::listData(
                        Grupo::model()->findAll(Grupo::model()->encontrarGrupo($maestro_id))
                        , 'id', 'gradoCompleto');
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('contrasenia',$this->contrasenia,true);
		$criteria->compare('maestro_id',$this->maestro_id);
		$criteria->compare('grado_id',$this->grado_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

        public function searchPorMaestro()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
                $mas=Maestro::model()->findByAttributes(array('usuario_id'=>$name=Yii::app()->user->getId()));
		$criteria=new CDbCriteria;
                $criteria->compare("maestro_id",$mas->id);
		$criteria->compare('id',$this->id);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('contrasenia',$this->contrasenia,true);
		//$criteria->compare('maestro_id',$this->maestro_id);
		$criteria->compare('grado_id',$this->grado_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

         public function searchAvisoPorGrupo($id){
        $criteria = new CDbCriteria;
        $criteria->select="aviso.*";
        $criteria->condition="aviso.grupo_id = :value";
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

    public static function getListGrados() {
        return CHtml::listData(Grado::model()->findAll(), 'id', 'rango');
    }

    public function searchPorAlumno(){
		// @todo Please modify the following code to remove attributes that should not be searched.
                $mas= Alumno::model()->findByAttributes(array('usuario_id'=>$name=Yii::app()->user->getId()));
		$criteria=new CDbCriteria;
                $criteria->join="JOIN alumno_has_grupo on t.id=alumno_has_grupo.grupo_id";
                $criteria->condition="alumno_has_grupo.alumno_id = :value";
                $criteria->params = array(":value" => $mas->id);
		$criteria->compare('id',$this->id);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('contrasenia',$this->contrasenia,true);
		$criteria->compare('maestro_id',$this->maestro_id);
		$criteria->compare('grado_id',$this->grado_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Grupo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

        public static function comprobarContraseña($password){

        }
}
