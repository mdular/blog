<?php 
Yii::app()->clientScript->registerCoreScript('mdular');
$this->renderPartial('/layouts/partial/html_header');
$this->renderPartial('/layouts/partial/header');
?>

<section id="main" role="main" class="clearfix">

<?php if(isset($this->breadcrumbs)):?>
	<?php $this->widget('zii.widgets.CBreadcrumbs', array(
		'links'=>$this->breadcrumbs,
	)); ?><!-- breadcrumbs -->
<?php endif?>

<?php echo $content; ?>

</section><!-- /#main -->

<?php $this->renderPartial('/layouts/partial/footer'); ?>