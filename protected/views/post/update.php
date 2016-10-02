<?php
$this->breadcrumbs=array(
	'Posts'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Posts', 'url'=>array('list')),
	array('label'=>'Manage Posts', 'url'=>array('admin')),
	array('label'=>'Create Post', 'url'=>array('create')),
	array('label'=>'Create Markdown Post', 'url'=>array('createMarkdown')),
	array('label'=>'View Post', 'url'=>array('view', 'id'=>$model->id)),
);
?>

<h1>Update Post <?php echo $model->id; ?></h1>

<?php if ((int) $model->post_type === Post::TYPE_MARKDOWN): ?>
	<?php echo $this->renderPartial('_markdownform', array('model'=>$model)); ?>
<?php else: ?>
	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php endif; ?>
