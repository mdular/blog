<?php

/**
 * This is the model class for table "{{post}}".
 *
 * The followings are the available columns in table '{{post}}':
 * @property integer $id
 * @property integer $permalink
 * @property string $title
 * @property string $content
 * @property string $tags
 * @property integer $status
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $publish_time
 * @property integer $author_id
 * @property integer $post_type
 *
 * The followings are the available model relations:
 * @property Comment[] $comments
 * @property User $author
 */
class Post extends CActiveRecord
{
    const STATUS_DRAFT = 1;
    const STATUS_PUBLISHED = 2;
    const STATUS_ARCHIVED = 3;

    const TYPE_HTML = 1;
    const TYPE_MARKDOWN = 2;

    private $_oldTags;
    private $_oldStatus;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Post the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{post}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {

        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, content, status', 'required'),
            array('permalink, title', 'length', 'max' => 128),
            array('status', 'in', 'range' => array(1, 2, 3)),
            array('tags', 'match', 'pattern' => '/^[\w\s,\.]+$/',
                'message' => 'Tags can only contain word characters and dots.',
            ),
            array('tags', 'normalizeTags'),
            array('post_type', 'in', 'range' => array(1, 2)),

        // The following rule is used by search().
        // Please remove those attributes that should not be searched.
        array('permalink, title, content, tags, status, create_time, update_time, publish_time, author_id, post_type', 'safe', 'on' => 'search'),);
    }

    /**
     * remove duplicate tags
     */
    public function normalizeTags($attribute, $params) {
        $this->tags = Tag::array2string(array_unique(Tag::string2array($this->tags)));
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        $relations = array(
            'author' => array(self::BELONGS_TO, 'User', 'author_id'),
        );

        if (Yii::app()->params['commentsEnabled']) {
            $relations['comments'] = array(self::HAS_MANY, 'Comment', 'post_id',
                'condition' => 'comments.status=' . Comment::STATUS_APPROVED,
                'order' => 'comments.create_time ASC'
            );

            $relations['commentCount'] = array(self::STAT, 'Comment', 'post_id',
                'condition' => 'status=' . Comment::STATUS_APPROVED
            );
        }

        return $relations;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'permalink' => 'Permalink',
            'title' => 'Title',
            'content' => 'Content',
            'tags' => 'Tags',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'publish_time' => 'Publish Time',
            'author_id' => 'Author',
            'post_type' => 'Post type',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {

        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('permalink', $this->permalink);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('tags', $this->tags, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('create_time', $this->create_time);
        $criteria->compare('update_time', $this->update_time);
        $criteria->compare('publish_time', $this->publish_time);
        $criteria->compare('author_id', $this->author_id);
        $criteria->compare('post_type', $this->post_type);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array('defaultOrder' => 'create_time DESC')
        ));
    }

    public function getUrl() {
        return Yii::app()->createUrl('post/index', array(
            'id' => $this->permalink
        ));
    }

    protected function beforeSave() {
        if (parent::beforeSave()) {

            // if new post, set create_time, author
            if ($this->isNewRecord) {
                $this->create_time = $this->update_time = time();
                $this->author_id = Yii::app()->user->id;
            } else {
                $this->update_time = time();
            }

            // if post status was STATUS_DRAFT and is published, set publish_time
            if ($this->_oldStatus == self::STATUS_DRAFT && $this->status != self::STATUS_DRAFT) {
                $this->publish_time = time();
            }

            // if post status was NOT STATUS_DRAFT and is unpublished, unset publish time
            if ($this->_oldStatus != self::STATUS_DRAFT && $this->status == self::STATUS_DRAFT) {
                $this->publish_time = '';
            }

            return true;
        } else {
            return false;
        }
    }

    protected function afterSave() {
        parent::afterSave();

        $newTags = $this->tags;
        $oldTags = $this->_oldTags;

        // if post status was STATUS_DRAFT and is published, force tag addition / frequency increment
        if ($this->_oldStatus == self::STATUS_DRAFT && $this->status != self::STATUS_DRAFT) {
            $oldTags = '';
        }

        // if post status was NOT STATUS_DRAFT and is unpublished, force tag decrement / removal
        if ($this->_oldStatus != self::STATUS_DRAFT && $this->status == self::STATUS_DRAFT) {
            $newTags = '';
        }

        //Tag::model()->updateFrequency($this->_oldTags, $this->tags);
        Tag::model()->updateFrequency($oldTags, $newTags);

        // generate permalink if not set
        if (empty($this->permalink)) {
            $this->permalink = $this->id . '-' . $this->toPermalink($this->title);
            $this->isNewRecord = false;
            $this->saveAttributes(array('permalink'));
        }
    }

    protected function afterFind() {
        parent::afterFind();
        $this->_oldTags = $this->tags;
        $this->_oldStatus = $this->status;
    }

    /**
     * method to process the tag frequency
     * note: for once-time use on empty tag-table
     */
    public function processTags() {
        Tag::model()->updateFrequency('', $this->tags);
    }

    /**
     * make string url-compatible
     */
    public function toPermalink($str) {
        if ($str !== mb_convert_encoding(mb_convert_encoding($str, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32')) {
            $str = mb_convert_encoding($str, 'UTF-8', mb_detect_encoding($str));
        }

        $str = htmlentities($str, ENT_NOQUOTES, 'UTF-8');
        $str = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\\1', $str);
        $str = html_entity_decode($str, ENT_NOQUOTES, 'UTF-8');
        $str = preg_replace(array('`[^a-z0-9]`i', '`[-]+`'), '-', $str);
        $str = strtolower(trim($str, '-'));

        return $str;
    }
}
