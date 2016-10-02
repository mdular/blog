<?php
$this->breadcrumbs=array(
	'Posts'=>array('list'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Posts', 'url'=>array('list')),
	array('label'=>'Manage Posts', 'url'=>array('admin')),
	array('label'=>'Create Post', 'url'=>array('create')),
	array('label'=>'Create Markdown Post', 'url'=>array('createMarkdown')),
	array('label'=>'Update Post', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Post', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1>View Post #<?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_view', array('data' => $model)); ?>
