<article class="entry" id="entry-<?php echo $data->id; ?>">

	<h2 class="title"><?php echo CHtml::link(CHtml::encode($data->title), $data->getUrl()); ?></h2>
	<?php /* <small class="postmeta"><?php echo date('M jS, Y', $data->create_time); ?></small> */ ?>

	<?php
	// show full content for short post, excerpt with link for longer ones
	$cutoffLength = Yii::app()->params['postCutoffLength'];
	if ($cutoffLength == 0 || strlen($data->content) < $cutoffLength): ?>
	<?php echo $data->content; ?>
	<?php else: ?>
	<p>
		<?php 
		// TODO: add excerpt field to post and default to it

		$excerpt = $data->content;
		// listitems with comma
		$excerpt = str_replace('</li>', '</li>, ', $excerpt);
		// breaks with space
		$excerpt = str_replace('<br>', ' ', $excerpt);
		$excerpt = str_replace('<br />', ' ', $excerpt);

		// TODO: stop at complete word
		echo StringHelper::limit(strip_tags($excerpt), $cutoffLength); ?>
		<a href="<?php echo $data->getUrl(); ?>" title="Continue reading <?php echo CHtml::encode($data->title); ?>">Continue reading</a>
	</p>
	<?php endif; ?>
</article>