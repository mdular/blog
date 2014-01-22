<?php
$this->pageTitle=Yii::app()->name . ' - About';
$this->breadcrumbs=array(
	'About',
);
?>
<h1>About</h1>

<p>
My name is Markus. I'm currently living in Berlin, where i enjoy the parks 
in summer and compensate the lack of sun in winter. 
</p>

<p>
Apart from working in IT at Rocket Internet i like getting into little side projects, 
and this personal space will serve as a platform.
</p>

<p>
At the moment i'm rather focused on the technical side of mdular.com, so please forgive 
the lack of polishing and sparse content ;)
</p>

<p>Feel free to <?php echo CHtml::link('drop me a line', $this->createUrl('site/contact')); ?>.</p>