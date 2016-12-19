<?php

/**
 * This is the model class for table "adjunto".
 *
 * The followings are the available columns in table 'adjunto':
 * @property integer $id
 * @property string $nombre
 * @property string $ruta
 * @property string $tipo
 * @property integer $aviso_id
 *
 * The followings are the available model relations:
 * @property Aviso $aviso
 */
class Adjunto extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'adjunto';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, nombre, ruta, tipo, aviso_id', 'required'),
			array('id, aviso_id', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>255),
			array('ruta', 'length', 'max'=>255),
			array('tipo', 'length', 'max'=>8),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombre, ruta, tipo, aviso_id', 'safe', 'on'=>'search'),
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
			'aviso' => array(self::BELONGS_TO, 'Aviso', 'aviso_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre' => 'Nombre',
			'ruta' => 'Ruta',
			'tipo' => 'Tipo',
			'aviso_id' => 'Aviso',
		);
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
		$criteria->compare('ruta',$this->ruta,true);
		$criteria->compare('tipo',$this->tipo,true);
		$criteria->compare('aviso_id',$this->aviso_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Adjunto the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
