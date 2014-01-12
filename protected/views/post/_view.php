<a href="<?php echo Yii::app()->createUrl('post/update', array('id' => $data->id)); ?>">Edit Post #<?php echo $data->id; ?></a>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$data,
	'attributes'=>array(
		'id',
		'title',
		'content',
		'tags',
		'status',
		'create_time',
		'update_time',
		'author_id',
	),
)); ?>