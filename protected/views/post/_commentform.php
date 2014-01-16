<h3><?php echo Yii::t('mdular', 'Add a new comment') ?>:</h3>

<?php 
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'comment-form',
	'action' => Yii::app()->createUrl('comment/create', array('postid' => $data->id)),
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); 
$model = new Comment;

// prefill author if user is logged in
if(!Yii::app()->user->isGuest){
	$model->author = Yii::app()->user->getName();
}

// when a comment.error flash was set (from comment/create redirect) set attributes and validate
if($commentError = Yii::app()->user->getFlash('comment.error')) {
	$model->attributes = $commentError['postData'];
	$model->validate();
}
?>

	<?php echo $form->errorSummary($model); ?>

	<fieldset>
		<?php echo $form->textField($model,'author', array('placeholder' => $model->getAttributeLabel('author'))); ?>
		<?php echo $form->error($model,'author'); ?>

		<?php /*echo $form->textField($model,'email', array('placeholder' => $model->getAttributeLabel('email'))); ?>
		<?php echo $form->error($model,'email'); */ ?>
	</fieldset>

	<fieldset>
		<?php echo $form->textArea($model,'content',array('rows'=>4,'placeholder' => $model->getAttributeLabel('content'))); ?>
		<?php echo $form->error($model,'content'); ?>
	</fieldset>

	<?php if(CCaptcha::checkRequirements()): ?>
	<fieldset class="captcha">
		<?php echo $form->textField($model,'verify_code', array('placeholder' => $model->getAttributeLabel('verifyCode'))); ?>
		<?php $this->widget('CCaptcha', array('captchaAction' => 'comment/captcha', 'clickableImage' => true)); ?>
		<?php echo $form->error($model,'verify_code'); ?>
		<?php /*
		<div class="hint">Please enter the letters as they are shown in the image.
		<br/>Letters are not case-sensitive.</div> */ ?>
	</fieldset>
	<?php endif; ?>

	<fieldset class="actions">
		<?php echo CHtml::submitButton('Submit'); ?>
	</fieldset>

<?php $this->endWidget(); ?>
