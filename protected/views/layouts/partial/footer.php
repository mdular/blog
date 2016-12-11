</div><!-- /#site -->
</div><!-- /#sitewrapper -->
<footer>
    &copy; <?php echo date('Y'); ?> <?php echo Yii::app()->params['siteOwner']; ?> &ndash; <a href="<?php echo $this->createUrl('site/page', array('view'=>'imprint')) ?>" title="Imprint" rel="nofollow">Imprint</a>
</footer>

<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->params['backgroundUrl'], CClientScript::POS_END, array(/*'async' => true, 'defer' => true TODO: fix jquery dep */)); ?>

<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.7.0/highlight.min.js"></script>
<script>hljs.initHighlightingOnLoad();</script>

<?php if(Yii::app()->user->isGuest && !empty(Yii::app()->params['GAid']) && !empty(Yii::app()->params['GAdomain'])): ?>
    <script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', '<?php echo Yii::app()->params['GAid'] ?>']);
    _gaq.push(['_setDomainName', '<?php echo Yii::app()->params['GAdomain'] ?>']);
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

<!-- Begin Cookie Consent plugin by Silktide - http://silktide.com/cookieconsent -->
<script type="text/javascript">
window.cookieconsent_options = {"message":"This website uses cookies","dismiss":"Got it!","learnMore":"More info","link":null,"theme":"light-bottom"};
</script>

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/1.0.10/cookieconsent.min.js"></script>
<!-- End Cookie Consent plugin -->

<script>var serverTime = <?php echo time(); ?></script>
</body>
</html>
