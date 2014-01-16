<?php

Yii::import('zii.widgets.CPortlet');

class TagPortlet extends CPortlet
{
  public $tags;

  protected function renderContent(){

  	$tagData = explode(',', $this->tags);
    $tagOutput = array();
    $tagCount = count($tagData);

    for ($i = 0; $i < $tagCount; $i++) {
    	$label = CHtml::encode($tagData[$i]);
    	$url = Yii::app()->createUrl('site/tag', array('tag' => trim($tagData[$i])));

    	$tagOutput[] = CHtml::link($label, $url);
    }

    $this->render('tag', array('tagOutput' => $tagOutput));
  }
}