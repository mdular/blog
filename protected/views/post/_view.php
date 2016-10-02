<a href="<?php echo Yii::app()->createUrl('post/update', array('id' => $data->id)); ?>">Edit Post #<?php echo $data->id; ?></a> |
<a href="<?php echo Yii::app()->createUrl('post/index', array('id' => $data->permalink)); ?>">Preview Post #<?php echo $data->id; ?></a>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$data,
	'attributes'=>array(
		'id',
		'permalink',
		'title',
		'content',
		'tags',
		'status',
		'create_time',
		'update_time',
		'publish_time',
		'author_id',
		'post_type',
	),
)); ?>
