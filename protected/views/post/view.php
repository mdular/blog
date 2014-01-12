<?php
$this->breadcrumbs=array(
	'Posts'=>array('list'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Post', 'url'=>array('list')),
	array('label'=>'Create Post', 'url'=>array('create')),
	array('label'=>'Update Post', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Post', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Post', 'url'=>array('admin')),
);
?>

<h1>View Post #<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_view', array('data' => $model)); ?>