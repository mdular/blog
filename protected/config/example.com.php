<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
  'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
  'name'=>'mBlog',

  // preloading 'log' component
  //'preload'=>array('log'),

  // autoloading model and component classes
  'import'=>array(
    'application.models.*',
    'application.components.*',
    'application.helpers.*',
  ),

  'modules'=>array(
    // uncomment the following to enable the Gii tool
    /*
    'gii'=>array(
      'class'=>'system.gii.GiiModule',
      'password'=>'password',
      // If removed, Gii defaults to localhost only. Edit carefully to taste.
      'ipFilters'=>array('127.0.0.1','::1'),
    ),
    */
  ),

  // application components
  'components'=>array(
    'user'=>array(
      // enable cookie-based authentication
      'allowAutoLogin'=>true,
    ),

    'request'=>array(
      'enableCsrfValidation'=>true,
      'enableCookieValidation'=>true,
    ),

    // uncomment the following to enable URLs in path-format
    'urlManager'=>array(
      'urlFormat'=>'path',
      'showScriptName' => false,
      'rules'=>array(
        // http://www.yiiframework.com/doc/guide/1.1/en/topics.url

        // route pagination (must be before blank '' rule)
        'page/<Post_page:\d+>'=>'site/index',

        // route / to site/index
        '' => 'site/index',

        // route /post/0-post-permalink or /post/0 to /post/index?id=0
        'post/<id:\d+[-][-\w]+|\d+>'=>'post/index',

        // route /tag/mytag to /site/index?tag=mytag
        'tag/<tag:[ \t\w]+>'=>'site/tag',

        // a standard rule mapping site actions
        '<action:(login|logout|contact|tags)>' => 'site/<action>',

        // mapping static pages
        '<view:\w+>' => 'site/page',

        //'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
        //'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
      ),
    ),

    // SQLite database
    /*
    'db'=>array(
      'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/mdular.db',
      'tablePrefix' => 'tbl_'
    ),
    */

    // MySQL database
    'db'=>array(
      'connectionString' => 'mysql:host=localhost;dbname=your-db',
      'emulatePrepare' => true,
      'username' => 'root',
      'password' => '',
      'charset' => 'utf8',
      'tablePrefix' => 'tbl_',
      //'enableProfiling'=>true,
    ),

    'errorHandler'=>array(
      // use 'site/error' action to display errors
      'errorAction'=>'site/error',
    ),

    /*
    'log'=>array(
      'class'=>'CLogRouter',
      'routes'=>array(
        array(
          'class'=>'CFileLogRoute',
          'levels'=>'error, warning',
        ),
        // show log messages on web pages
        array(
          'class'=>'CWebLogRoute',
        ),
        // profile log
        array(
          // lists execution time of every marked code block
          // report can also be set to 'callstack'
          'class'=>'CProfileLogRoute',
          'report'=>'summary',
        ),
      ),
    ),
    */

    'clientScript'=>array(
      // move js to end of body tag
      'coreScriptPosition'=>CClientScript::POS_END,
      'defaultScriptPosition'=>CClientScript::POS_END,
      'defaultScriptFilePosition'=>CClientScript::POS_END,
      'packages'=>array(
        'jquery'=>array(
          'baseUrl'=>'/js/',
          'js'=>array('lib/jquery-1.10.2.min.js'),
        ),
        'jquery-migrate'=>array(
          'baseUrl'=>'/js/',
          'js'=>array('lib/jquery-migrate-1.2.1.min.js'),
          'depends'=>array('jquery')
        ),
        'mdular'=>array(
          'baseUrl'=>'/',
          'js'=>array(
            'js/plugins.js',
            'js/script.js'
          ),
          'css'=>array(
            'css/screen.css'
          ),
          'depends' => array('jquery')
        ),
        'mdular-admin'=>array(
          'baseUrl' => '/',
          'js' => array(
            'js/tinymce/tinymce.min.js',
            'js/admin.js'
          ),
        ),
        /*
        'bbq'=>array(
          'js'=>array(YII_DEBUG ? 'jquery.ba-bbq.js' : 'jquery.ba-bbq.min.js'),
          'depends'=>array('jquery', 'jquery-migrate'),
        ),
        */
      ),
    ),
  ),

  // application-level parameters that can be accessed
  // using Yii::app()->params['paramName']
  'params'=>array(
    'adminEmail'=>'example@your.domain', // this is used in contact page
    'siteOwner' => 'Your Name',
    'backgroundUrl' => '//play.mdular.com/webdungeons/webdungeons.js',
    'commentsEnabled' => true,
    'commentDefaultStatus' => 'STATUS_PENDING',
    'imagePath' => '/../public/img/upload/', // from Yii::app()->basePath
    'imageUrl' => '/img/upload/',
    'captchaConfig' => array(
        'class'=>'CCaptchaAction',
        'foreColor' => 0x1c79b1,
        'backColor'=>0xFFFFFF,
        'maxLength' => 4,
        'minLength' => 4,
        'width' => 70,
        //'height' => 40,
        //'padding' => 0,
    ),
    'postCutoffLength' => 400, // 0 to disable
    'GAid' => null, // Google Analytics id
    'GAdomain' => null // Google Analytics domain
  ),
);
