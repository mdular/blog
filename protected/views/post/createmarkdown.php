<?php
$this->breadcrumbs=array(
	'Posts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Posts', 'url'=>array('index')),
	array('label'=>'Manage Posts', 'url'=>array('admin')),
);
?>

<h1>Create Mardown Post</h1>

<?php echo $this->renderPartial('_markdownform', array('model'=>$model)); ?>
