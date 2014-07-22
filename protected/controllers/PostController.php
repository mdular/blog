<?php

class PostController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin';

	private $_model;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
            // TODO: needs proper invalidation, or use fragment cache for view content
            /*array(
                'COutputCache + index',
                'duration'=>60,
                'varyByRoute'=>true,
            ),*/
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' actions
				'actions'=>array('index'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform all actions
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	* show post based on id or permalink
	*
	* TODO: use only permalink? different params for id / permalink?
	*
	* @param mixed $id the ID or permalink-url
	*/
	public function actionIndex($id = null)
	{
		$this->layout='//layouts/main';

		if (!isset($id)) {
			$this->redirect($this->createURL('site/index'), true, 301);
		}

		$id = filter_var($id, FILTER_SANITIZE_STRING);

		$postModel = $this->loadModel($id);
		$userModel = User::model()->findByPk($postModel->author_id);

		$this->pageTitle=Yii::app()->name . ' - ' . $postModel->title;

		$relatedPosts = $this->findRelatedPostsByTags($postModel)->getData();

		$this->render('index',array(
			'data'=>$postModel,
			'user'=>$userModel,
			'relatedPosts' => $relatedPosts,
		));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Post;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Post']))
		{
			$model->attributes=$_POST['Post'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Post']))
		{
			$model->attributes=$_POST['Post'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
  
	protected function afterDelete(){
		parent::afterDelete();
		Comment::model()->deletaAll('post_id = '.$this->id);
		Tag::model()->updateFrequency($this->tags, '');
	}

	/**
	 * Lists all models.
	 */
	public function actionList()
	{
		$criteria = new CDbCriteria(array(
			'condition' => 'status = ' . Post::STATUS_PUBLISHED,
			'order'     => 'create_time DESC',
			'with'      => 'commentCount'
		));

		if(isset($_GET['tag'])){
			$criteria->addSearchCondition('tags', $_GET['tag']);
		}

		$dataProvider=new CActiveDataProvider('Post', array(
			'pagination' => array(
				'pageSize' => 5,
			),
			'criteria' => $criteria,
		));

		$this->render('list',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	* regenerate tags for all posts
	*/
	public function actionRegenerateTags()
	{
		// clean tags
		Tag::model()->deleteAll();

		// find published posts
		$criteria = new CDbCriteria(array(
			'condition' => 'status <> 1'// . POST::STATUS_DRAFT
		));
		$models = Post::model()->findAll($criteria);

		echo "<pre>";
		echo "total: " . count($models) . PHP_EOL;

		$processed = 0;

		// process tags for loaded posts
		foreach ($models as $model) {
			$model->processTags();
			$processed++;
		}

		// TODO: send processed as message
		echo "processed: " . $processed;
		echo "</pre>";

		$this->redirect('/tags');
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Post('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Post']))
			$model->attributes=$_GET['Post'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		if($this->_model === null){
			if(isset($id)){
				if(Yii::app()->user->isGuest){
					$condition = 'status = '.Post::STATUS_PUBLISHED
						. ' OR status = ' . Post::STATUS_ARCHIVED;
				}else{
					$condition = '';
				}

				if (!is_numeric($id)) {
					$end = mb_strpos($id, '-', 0, 'UTF-8');
					$id = mb_substr($id, 0, $end, 'UTF-8');
				}

				$this->_model = Post::model()->findByPk($id, $condition);
			}
			if($this->_model===null){
				throw new CHttpException(404,'The requested page does not exist.');
			}
		}
		return $this->_model;
	}

	/**
	* return the data model based on the permalink key
	* @param string $id the link
	* @returns _model
	*/
	public function loadModelByPermalink($id)
	{
		if ($this->_model === null) {
			if(isset($id)) {

				// TODO: find by permalink field
				$this->_model = Post::model()->findByAttributes(array('title' => $id)); // TODO: use permalink field instead
			}
			if($this->_model===null) {
				throw new CHttpException(404,'The requested page does not exist.');
			}
		}
		return $this->_model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='post-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}


	/**
	* find other posts with similar tags
	* TODO: consider tag occurence scoring or some other kind of weight
	* TODO: RAND() is slow on big tables, create alternative
	* http://stackoverflow.com/questions/4329396/mysql-select-10-random-rows-from-600k-rows-fast
	*/
	protected function findRelatedPostsByTags($postModel) {
		$tags = explode(',', $postModel->tags);

		$criteria = new CDbCriteria(array(
			'select'=>'title, permalink, RAND() as rand',
			'limit'		=> 4,
			'condition' => 'status = ' . Post::STATUS_PUBLISHED,
			'order' => 'rand',
	    ));

	    $criteria->addCondition('id <> ' . $postModel->id);

	    $likeCondition = '';
	    foreach ($tags as $tag) {
	    	$likeCondition .= ($tags[0] === $tag ? '' : ' OR ') . '(tags LIKE \'%' . trim($tag) . '%\')';
	    }

	    $criteria->addCondition($likeCondition);
	    
		$dataProvider=new CActiveDataProvider('Post', array(
	      'criteria' => $criteria,
	      'pagination' => false
	    ));

	    return $dataProvider;
	}

	/**
	 * create permalinks for all posts
	 */
	public function actionCreateAllPermalinks() {
		// find published posts
		$criteria = new CDbCriteria();
		$models = Post::model()->findAll($criteria);

		echo "<pre>";
		echo "total: " . count($models) . PHP_EOL;

		$processed = 0;

		// process permalinks (via Post::afterSave) for loaded posts
		foreach ($models as $model) {
			$model->save();
			$processed++;
		}

		// TODO: send as message
		echo "processed: " . $processed;
		echo "</pre>";

		$this->redirect('/post/admin');

	}
}
