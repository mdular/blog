<?php

class CommentController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin';

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha' => Yii::app()->params['captchaConfig'],
		);
	}

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view', 'captcha'),
				'users'=>array('*'),
			),
			array('allow',
				'actions' => array('create'),
				'users'=>array(Yii::app()->params['commentsEnabled'] ? '*' : '@'), // only allow create access if comment feature enabled
 			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				//'users'=>array('admin'),
				'users' => array('@')
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
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
	public function actionCreate($postid)
	{
		$postid = filter_var($postid, FILTER_SANITIZE_NUMBER_INT);

		// Uncomment the following line if AJAX validation is needed
		// apparently it isn't needed... but working o.O

		// TODO: manage yii activeForm js asset
		//$this->performAjaxValidation($model);

		if(!empty($_POST['Comment']) && !empty($postid))
		{
			$postData = filter_var_array($_POST['Comment'], FILTER_SANITIZE_STRING);

			$model=new Comment;
			$model->attributes=$postData;
			//$model->content = nl2br($model->content);
			$model->post_id = $postid;
			$model->status = constant('Comment::' . Yii::app()->params['commentDefaultStatus']);
			$model->ip = $_SERVER['REMOTE_ADDR'];

			if($model->save()) {

				// success message
				if (Yii::app()->params['commentDefaultStatus'] == 'STATUS_PENDING') {
					Yii::app()->user->setFlash('comment.success',Yii::t('mdular', 'Comment successfully saved. It is now pending approval.'));
				} else {
					Yii::app()->user->setFlash('comment.success',Yii::t('mdular', 'Comment successfully published.'));
				}

				// email to admin
				$headers="From: " . Yii::app()->name;//\r\nReply-To: {$model->email}";
				mail(
					Yii::app()->params['adminEmail'],
					'New comment by ' . $model->author,
					$model->content,
					$headers
				);
			} else {
				Yii::app()->user->setFlash('comment.error', array(
					'postData' => $postData,
				));
			}
		}

		// redirect back to post
		// TODO: this should use the permalink!
		$this->redirect(array('post/index', 'id' => $postid));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$model->setRequireCaptcha(false);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model)

		if(isset($_POST['Comment']))
		{
			$model->attributes=$_POST['Comment'];

			if($model->save()) {
				//$this->redirect(array('view','id'=>$model->id));
			}
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

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Comment');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Comment('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Comment']))
			$model->attributes=$_GET['Comment'];

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
		$model=Comment::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='comment-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
