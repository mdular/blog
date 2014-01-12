<?php

/**
 * This is the model class for table "{{image}}".
 *
 * The followings are the available columns in table '{{image}}':
 * @property integer $id
 * @property string $title
 * @property string $file
 * @property integer $size
 * @property integer $create_time
 * @property integer $update_time
 */
class Image extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{image}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('file', 'required'),
			array('title, file', 'length', 'max'=>128),

			array('create_time, update_time', 'numerical', 'integerOnly'=>true),

			array('file', 'file', 
				'types' => 'gif, jpg, png', 'safe' => true,
				'allowEmpty' => true, 
				'maxSize' => 2 * 1048576, 'maxFiles'=>10,
				'on' => 'update'
			),
			array('file', 'file', 
				'types' => 'gif, jpg, png', 'safe' => true,
				//'allowEmpty' => false, 
				'allowEmpty' => true,
				'maxSize' => 2 * 1048576, 'maxFiles'=>10,
				'on' => 'insert'
			),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, file, size, create_time, update_time', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'file' => 'File',
			'size' => 'Size',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('file',$this->file,true);
		$criteria->compare('size',$this->file);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('update_time',$this->update_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'create_time DESC'),
		));
	}

	protected function beforeSave(){
	  	if(parent::beforeSave()){
	      if($this->isNewRecord){
	        $this->create_time = time();
	      }else{
	        $this->update_time = time();
	      }
	      return true;
	    }else{
	      return false;
	    }
	}

	/**
	 * Remove the image file from disk
	 */
	public function removeImage($fileName = null)
	{
		if (!$fileName) {
			$fileName = $this->file;
		}
		unlink(Yii::app()->basePath . Yii::app()->params['imagePath'] . $fileName);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Images the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
