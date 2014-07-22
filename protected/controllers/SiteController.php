<?php

class SiteController extends Controller
{
    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            // cache homepage + static pages
            // TODO: needs proper invalidation, or use fragment cache for view content
            /*
            array(
                'COutputCache + page, index',
                'duration'=>60,
                'varyByRoute'=>true,
            ),
            */
        );
    }

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>Yii::app()->params['captchaConfig'],
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$this->pageTitle=Yii::app()->name . ' - Home';

		$criteria = new CDbCriteria(array(
			'condition' => 'status = ' . Post::STATUS_PUBLISHED,
			'order'     => 'create_time DESC',
			//'with'      => 'commentCount'
    	));
    
		$dataProvider=new CActiveDataProvider('Post', array(
			'pagination' => array(
				'pageSize' => 5,
			),
			'criteria' => $criteria,
		));
    
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	* show entries for tag
	*/
	public function actionTag($tag = null)
	{
		if(!$tag){
			throw new CHttpException(404,'The requested page does not exist.');
		}

		$tag = filter_var($tag, FILTER_SANITIZE_STRING);

		$criteria = new CDbCriteria(array(
			'condition' => 'status = ' . Post::STATUS_PUBLISHED,
			'order'     => 'create_time DESC',
			//'with'      => 'commentCount'
    	));
		$criteria->addSearchCondition('tags', $tag);

		$this->pageTitle=Yii::app()->name . ' - Tag: ' . $tag;
    
		$dataProvider=new CActiveDataProvider('Post', array(
			'pagination' => array(
				'pageSize' => 5,
			),
			'criteria' => $criteria,
		));
    
		$this->render('tag',array(
			'dataProvider'=>$dataProvider,
			'tagName' => $tag,
		));
	}

	/**
	* show all tags
	*/
	public function actionTags()
	{
		$criteria = new CDbCriteria(array(
			'condition' => 'frequency > ' . 0,
			'order'     => 'frequency DESC',
    	));

    	$dataProvider=new CActiveDataProvider('Tag', array(
			'pagination' => array(
				'pageSize' => 50,
			),
			'criteria' => $criteria,
		));

		$this->render('tags',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$postData = filter_var_array($_POST['ContactForm'], FILTER_SANITIZE_STRING);
			
			$model->attributes=$postData;
			
			if($model->validate())
			{
				$model->subject = Yii::app()->name . ' ' . $model->subject;
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you, your message was successfully sent.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}