<header class="clearfix">
  <div id="branding">
      <h2 id="logo" class="color_1_light">
        <a href="/" title="<?php echo CHtml::encode(Yii::app()->name); ?> - Home">
          <span class="color_2_dark">m</span><span class="color_3_dark">d</span><span class="color_4_dark">u</span><span class="color_5_dark">l</span><span class="color_5_dark">a</span><span class="color_6_dark">r</span>.com
        </a><!-- TODO: Use Yii app name to create spanned letters.. -->
        <!-- logo color variation via JS -->
        <sup id="logoactions">
          <a class="icon-about hide-text" href="<?php echo $this->createUrl('site/page', array ('view' => 'about')); ?>" title="About">About</a>
          <a class="icon-contact hide-text" href="<?php echo $this->createUrl('site/contact'); ?>" title="Contact">Contact</a>
        </sup>
      </h2>
      <h3 id="subtitle"><?php echo Yii::t('mdular', 'Now with more vitamins!'); ?></h3>
  </div>
  <nav>
    <?php if(!Yii::app()->user->isGuest): ?>
    <div>
      <h3>Admin</h3><!-- TODO: collapsible / accordion for RESS -->
      <?php /* TODO: user role admin */ ?>
      <?php 
        $this->widget('zii.widgets.CMenu',array(
          'items'=>array(
            array('label'=>'Post admin', 'url'=>array('post/admin')),
            array('label'=>'User admin', 'url'=>array('user/admin')),
            array('label'=>'Comment admin', 'url'=>array('comment/admin')),
            array('label'=>'Image admin', 'url'=>array('image/admin')),
            array('label'=>'Login', 'url'=>array('site/login'), 'visible'=>Yii::app()->user->isGuest),
            array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('site/logout'), 'visible'=>!Yii::app()->user->isGuest)
          ),
        ));
      ?>
    </div>
    <?php endif; ?>

    <div>
      <h3>Blog</h3><!-- TODO: collapsible / accordion for RESS -->
      <?php $this->widget('zii.widgets.CMenu',array(
        'items'=>array(
          array('label'=>'Home', 'url'=>array('site/index')),
          array('label' => 'Tags', 'url' => array('/site/tags')),
          //array('label' => 'Photos', 'url' => '#'),
          //array('label' => 'Picdump', 'url' => '#'),
          // TODO: disable these
          //array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
          //array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
        ),
      )); ?>
    </div>
    
    <div>
      <h3>Info</h3><!-- TODO: collapsible / accordion for RESS -->
      <?php $this->widget('zii.widgets.CMenu',array(
        'items'=>array(
          array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
          array('label'=>'Contact', 'url'=>array('/site/contact')),
          //array('label'=>'Meow Project', 'url'=>'#', 'linkOptions' => array('target' => '_blank')),
          //array('label'=>'LinkedIn', 'url'=>'#', 'linkOptions' => array('target' => '_blank')),
          //array('label'=>'Xing', 'url'=>'#', 'linkOptions' => array('target' => '_blank')),
        ),
      )); ?>
    </div>

    <div>
      <h3>Playground</h3><!-- TODO: collapsible / accordion for RESS -->
      <?php $this->widget('zii.widgets.CMenu',array(
        'items'=>array(
          array('label'=>'Webdungeons', 'url'=>'http://play.mdular.com/webdungeons/', 'linkOptions' => array('target' => '_blank')),
          //array('label'=>'Wallpapers', 'url'=>array('site/page', 'view' => 'wallpapers')),
        ),
      )); ?>
    </div>

    <div>
      <h3>Links</h3><!-- TODO: collapsible / accordion for RESS -->
      <?php $this->widget('zii.widgets.CMenu',array(
        'items'=>array(
          array('label' => 'Sui', 'url' => 'http://blog.sui.li/', 'linkOptions' => array('target' => '_blank')),
        ),
      )); ?>
    </div>

    <div>
      <h3>/opt/pile</h3><!-- TODO: collapsible / accordion for RESS -->
      <?php $this->widget('zii.widgets.CMenu',array(
        'items'=>array(
          array('label' => 'Linkdump', 'url' => '#'),
          array('label' => 'Tools', 'url' => '#'),
        ),
      )); ?>
    </div>

  </nav>
</header>