<?php
$this->pageTitle=Yii::app()->name . ' - Drop me a message';
$this->breadcrumbs=array(
	'Contact',
);
?>

<h1><?php echo Yii::t('mdular', 'Drop me a line'); ?></h1>

<?php if(Yii::app()->user->hasFlash('contact')): ?>
<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('contact'); ?>
</div>
<?php else: ?>

<p>
	<?php echo Yii::t('mdular', "If you have questions, please feel free to contact me. I don't bite often.") ?>
</p>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contact-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<fieldset>
		<?php // echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name', array('placeholder' => $model->getAttributeLabel('name'))); ?>
		<?php echo $form->error($model,'name'); ?>

		<?php // echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email', array('placeholder' => $model->getAttributeLabel('email'))); ?>
		<?php echo $form->error($model,'email'); ?>
	</fieldset>

	<fieldset>
		<?php // echo $form->labelEx($model,'subject'); ?>
		<?php echo $form->textField($model,'subject',array('maxlength'=>128, 'placeholder' => $model->getAttributeLabel('subject'))); ?>
		<?php echo $form->error($model,'subject'); ?>

		<?php // echo $form->labelEx($model,'body'); ?>
		<?php echo $form->textArea($model,'body',array('rows'=>4,'placeholder' => $model->getAttributeLabel('body'))); ?>
		<?php echo $form->error($model,'body'); ?>
	</fieldset>

	<?php if(CCaptcha::checkRequirements()): ?>
	<fieldset class="captcha">
		<?php //echo $form->labelEx($model,'verifyCode'); ?>
		<?php echo $form->textField($model,'verifyCode', array('placeholder' => $model->getAttributeLabel('verifyCode'))); ?>
		<?php $this->widget('CCaptcha', array('clickableImage' => true)); ?>
		<?php echo $form->error($model,'verifyCode'); ?>
		<?php /*
		<div class="hint">Please enter the letters as they are shown in the image.
		<br/>Letters are not case-sensitive.</div> */ ?>
	</fieldset>
	<?php endif; ?>

	<fieldset class="actions">
		<?php echo CHtml::submitButton('Submit'); ?>
	</fieldset>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php endif; ?>