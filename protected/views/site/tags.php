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

<?php 
// TODO: make into widget
$pagination = $dataProvider->getPagination();
$currentPage = $pagination->getCurrentPage();
$totalPages = $pagination->getPageCount();
if ($totalPages > 1) :
?>
<nav class="pagination">
	<?php if ($currentPage > 0) { // 'previous page'
		$label = Yii::t('mdular', 'Back to page %1s', array('%1s' => $currentPage));
		$url = $pagination->createPageUrl($this, $currentPage - 1);
		echo CHtml::link($label, $url, array('class' => 'prev'));
	} ?>

	<?php if ($currentPage + 1 < $totalPages) { // 'next page'
		$label = Yii::t('mdular', 'More on page %1s', array('%1s' => $currentPage + 2));
		$url = $pagination->createPageUrl($this, $currentPage + 1);
		echo CHtml::link($label, $url, array('class' => 'next'));
	} ?>
<?php /*
	<div class="items">
		<?php // create links to all pages
			for ($i = 0; $i < $totalPages; $i++) {
				// mark current page as active
				$htmlOptions = array();
				if ($i == $currentPage) {
					$htmlOptions['class'] = 'active';
				}
				echo CHtml::link($i + 1, $pagination->createPageUrl($this, $i), $htmlOptions);
			} ?>
	</div>
*/ ?>	
</nav>
<?php endif; ?>