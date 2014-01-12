<?php
$this->breadcrumbs=array(
	//'Posts'=>array('index'),
	$data->title,
);
?>

<article class="entry" id="entry-<?php echo $data->id; ?>">
	<h1 class="title"><?php echo CHtml::encode($data->title); ?></h1>
	<small class="postmeta"><?php echo date('M jS, Y', $data->create_time); ?> by <?php echo $user->username; ?></small>

	<?php echo $data->content; ?>
</article>

<div class="tags">
	<h3><?php echo Yii::t('mdular', 'Tags'); ?>:</h3>
	<p>
		<?php 
		$tagData = explode(',', $data->tags);
		$tagOutput = array();
		$tagCount = count($tagData);

		for ($i = 0; $i < $tagCount; $i++) {
			$label = CHtml::encode($tagData[$i]);
			$url = Yii::app()->createUrl('site/tag', array('tag' => trim($tagData[$i])));

			$tagOutput[] = CHtml::link($label, $url);
		}
		?>
		<?php echo implode(',', $tagOutput); ?>
	</p>
</div>

<?php /* TODO: suggested posts
<div class="suggestions">
	<h3><?php echo Yii:t('mdular', 'Suggested reads'); ?>:</h3>
	## read other posts (short list with headlines)
	# random posts for now, later based on tag similarity / popularity from cached data / scoring
</div>
*/ ?>

<?php if(Yii::app()->params['commentsEnabled']): ?>

<?php if(Yii::app()->user->hasFlash('comment.success')): ?>
<div class="alert-success">
	<?php echo Yii::app()->user->getFlash('comment.success'); ?>
</div>
<?php endif; ?>

<?php if ($data->commentCount): ?>
<h3><?php echo $data->commentCount . ' ' . ($data->commentCount == 1 ? Yii::t('mdular', 'Comment') : Yii::t('mdular', 'Comments')); ?>:</h3>

	<?php foreach($data->comments as $comment): ?>
		<article class="comment" id="comment-<?php echo $comment->id ?>">
			<h4><?php echo $comment->author ?></h4>
			<p><?php echo $comment->content ?></p>
		</article>
	<?php endforeach; ?>
<?php endif; ?>

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
<?php endif; ?>