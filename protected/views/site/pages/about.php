<?php
$this->pageTitle=Yii::app()->name . ' - About';
$this->breadcrumbs=array(
	'About',
);
?>
<h1>About</h1>

<p>
My name is Markus. I'm currently living in Berlin, where i enjoy the parks 
in summer and compensate the lack of sun in winter. This is my personal space.
</p>

<p>
Apart from working in IT I like getting into little side projects, and this 
personal space will serve as a platform of expression, which could be 
trivial or fictional.
</p>

<p>Feel free to <?php echo CHtml::link('drop me a line', $this->createUrl('site/contact')); ?>.</p>