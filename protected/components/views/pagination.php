<?php 
	$currentPage = $pagination->getCurrentPage();
	$totalPages = $pagination->getPageCount();

	// TODO: implement showFirst, showLast
?>
<nav class="pagination">
	<?php if ($this->options['showPrev'] && $currentPage > 0) { // 'previous page'
		$label = Yii::t('mdular', 'Back to page %1s', array('%1s' => $currentPage));
		$url = $pagination->createPageUrl($this->getController(), $currentPage - 1);
		echo CHtml::link($label, $url, array('class' => 'prev'));
	} ?>

	<?php if ($this->options['showNext'] && $currentPage + 1 < $totalPages) { // 'next page'
		$label = Yii::t('mdular', 'More on page %1s', array('%1s' => $currentPage + 2));
		$url = $pagination->createPageUrl($this->getController(), $currentPage + 1);
		echo CHtml::link($label, $url, array('class' => 'next'));
	} ?>

	<?php if($this->options['showPages']): ?>
	<div class="items">
		<?php // create links to all pages
			for ($i = 0; $i < $totalPages; $i++) {
				// mark current page as active
				$htmlOptions = array();
				if ($i == $currentPage) {
					$htmlOptions['class'] = 'active';
				}
				echo CHtml::link($i + 1, $pagination->createPageUrl($this->getController(), $i), $htmlOptions);
			} ?>
	</div>
	<?php endif; ?>
</nav>
