<?php 
Yii::app()->clientScript->registerCoreScript('mdular');
Yii::app()->clientScript->registerCoreScript('mdular-admin');
$this->renderPartial('/layouts/partial/html_header');
$this->renderPartial('/layouts/partial/header');
?>

<section id="main" role="main" class="clearfix">

<?php if(isset($this->breadcrumbs)):?>
	<?php $this->widget('zii.widgets.CBreadcrumbs', array(
		'links'=>$this->breadcrumbs,
	)); ?><!-- breadcrumbs -->
<?php endif?>

<aside>
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>'Operations',
		));
		$this->widget('zii.widgets.CMenu', array(
			'items'=>$this->menu,
			'htmlOptions'=>array('class'=>'operations'),
		));
		$this->endWidget();
	?>
</aside>

<?php echo $content; ?>

</section><!-- /#main -->

<?php $this->renderPartial('/layouts/partial/footer'); ?>