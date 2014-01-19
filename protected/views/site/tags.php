<?php
$this->breadcrumbs=array(
	'Tags',
);
?>

<h1>All tags</h1>

<?php if ($dataProvider->getTotalItemCount() > 0) : ?>
<nav>
	<?php foreach($dataProvider->getData() as $data) :
		$label = CHtml::encode($data->name);
		$url = Yii::app()->createUrl('site/tag', array('tag' => $data->name)); ?>
		<?php echo CHtml::link($label, $url); ?><br>
	<?php endforeach; ?>
</nav>
<?php else: ?>
<p>No tags yet.</p>
<?php endif; ?>

<?php $this->widget('PaginationPortlet', array(
	'pagination' => $dataProvider->getPagination(),
	'options' => array('showPages' => false)
)); ?>
