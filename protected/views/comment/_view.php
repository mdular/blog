<a href="<?php echo Yii::app()->createUrl('comment/update', array('id' => $data->id)); ?>">Edit Comment #<?php echo $data->id; ?></a>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$data,
	'attributes'=>array(
		'id',
		'content',
		'status',
		'create_time',
		'author',
		'ip',
		'url',
		'post_id',
	),
)); ?>