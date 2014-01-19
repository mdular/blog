<?php
if ($dataProvider->getTotalItemCount() > 0) :
	foreach($dataProvider->getData() as $data) :
		$this->renderPartial('_entry', array('data' => $data));
	endforeach;
else: ?>
<p>No entries yet.</p>
<?php endif; ?>

<?php $this->widget('PaginationPortlet', array(
	'pagination' => $dataProvider->getPagination(),
	'options' => array('showPages' => false)
)); ?>
