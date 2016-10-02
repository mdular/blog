<?php
$this->breadcrumbs=array(
	//'Posts'=>array('index'),
	$data->title,
);
?>

<article class="entry" id="entry-<?php echo $data->id; ?>">
	<h1 class="title"><?php echo CHtml::encode($data->title); ?></h1>
	<small class="postmeta">
		<?php echo $data->publish_time ? date('M jS, Y', $data->publish_time) : 'unpublished'; ?> by <?php echo $user->username; ?>
		<?php if (Yii::app()->user->id == $user->id): ?>
			- <a href="<?php echo Yii::app()->createUrl('post/update', array('id' => $data->id)) ?>">Edit Post</a>
		<?php endif; ?>
	</small>
	<?php echo $data->content; ?>
</article>

<div class="tags">
	<h3><?php echo Yii::t('mdular', 'Tags'); ?>:</h3>
	<p>
		<?php $this->widget('TagPortlet', array('tags' => $data->tags)) ?>
	</p>
</div>

<div class="suggestions">
	<h3><?php echo Yii::t('mdular', 'Suggested reads'); ?>:</h3>
	<p>
	<?php foreach($relatedPosts as $relatedPost): ?>
	<a href="<?php echo Yii::app()->createUrl('post/index', array('id' => $relatedPost->permalink)) ?>"><?php echo $relatedPost->title ?></a><br>
	<?php endforeach; ?>
	</p>
</div>

<?php if(Yii::app()->params['commentsEnabled']): ?>

	<?php if(Yii::app()->user->hasFlash('comment.success')): ?>
		<div class="alert-success">
			<?php echo Yii::app()->user->getFlash('comment.success'); ?>
		</div>
	<?php endif; ?>

	<?php if ($data->commentCount): ?>
		<h3><?php echo $data->commentCount . ' ' . ($data->commentCount == 1 ? Yii::t('mdular', 'Comment') : Yii::t('mdular', 'Comments')); ?>:</h3>

		<?php foreach($data->comments as $comment): ?>
			<article class="comment" id="comment-<?php echo $comment->id ?>">
				<h4><?php echo $comment->author ?></h4>
				<p><?php echo $comment->content ?></p>
			</article>
		<?php endforeach; ?>
	<?php endif; ?>

	<?php echo $this->renderPartial('_commentform', array('data' => $data)); ?>

<?php endif; ?>
