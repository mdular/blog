<?php

/**
 * This is the model class for table "{{comment}}".
 *
 * The followings are the available columns in table '{{comment}}':
 * @property integer $id
 * @property string $content
 * @property integer $status
 * @property integer $create_time
 * @property string $author
 * @property string $ip
 * @property string $url
 * @property integer $post_id
 *
 * The followings are the available model relations:
 * @property Post $post
 */
class Comment extends CActiveRecord
{
  const STATUS_PENDING = 1;
  const STATUS_APPROVED = 2;

  protected $_requireCaptcha = true;

  public $verify_code;
  
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Comment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{comment}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		$rules = array(
			array('author, content', 'required'),
			array('status, create_time, post_id', 'numerical', 'integerOnly'=>true),
			array('author, ip, url', 'length', 'max'=>128),
			array('content', 'length', 'max' => 512),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, content, status, create_time, author, ip, url, post_id', 'safe', 'on'=>'search'),
		);

		// verifyCode needs to be entered correctly
		if ($this->_requireCaptcha) {
			$rules[] = array('verify_code', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements(), 'captchaAction' => 'comment/captcha');
		}

		return $rules;
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'post' => array(self::BELONGS_TO, 'Post', 'post_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'content' => 'Content',
			'status' => 'Status',
			'create_time' => 'Create Time',
			'author' => 'Author',
			'ip' => 'IP Address',
			'url' => 'Url',
			'post_id' => 'Post id',
			'verify_code'=>'Verification Code',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('author',$this->author,true);
		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('post_id',$this->post_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'create_time DESC')
		));
	}

	protected function beforeSave(){
	  	if(parent::beforeSave()){
	      if($this->isNewRecord){
	        $this->create_time = time();
	      }else{
	        //$this->update_time = time();
	      }
	      return true;
	    }else{
	      return false;
	    }
	}

	public function setRequireCaptcha($setting)
	{
		$this->_requireCaptcha = $setting;
	}
}