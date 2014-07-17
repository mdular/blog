    </div><!-- /#site -->
  </div><!-- /#sitewrapper -->
  <footer>
    &copy; <?php echo date('Y'); ?> <?php echo Yii::app()->params['siteOwner']; ?> &ndash; <a href="<?php echo $this->createUrl('site/page', array('view'=>'imprint')) ?>" title="Imprint" rel="nofollow">Imprint</a>
  </footer>

  <?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->params['backgroundUrl'], CClientScript::POS_END, array(/*'async' => true, 'defer' => true TODO: fix jquery dep */)); ?>
  
  <?php if(Yii::app()->user->isGuest && !empty(Yii::app()->params['GAid']) && !empty(Yii::app()->params['GAdomain'])): ?>
  <script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', Yii::app()->params['GAid']]);
    _gaq.push(['_setDomainName', Yii::app()->params['GAdomain']]);
    _gaq.push(['_trackPageview']);

    var initGA = function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    };

    if (window.addEventListener) {
        window.addEventListener('load', initGA, false);
    } else if (window.attachEvent)  {
        window.attachEvent('onload', initGA);
    }
  </script>
  <?php endif; ?>

  <script>var serverTime = <?php echo ( time() ); ?>;</script>
</body>
</html>