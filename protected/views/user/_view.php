<a href="<?php echo Yii::app()->createUrl('user/update', array('id' => $data->id)); ?>">Edit User #<?php echo $data->id; ?></a>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$data,
	'attributes'=>array(
		'id',
		'username',
		'password',
		'salt',
		'email',
		'profile',
	),
)); ?>