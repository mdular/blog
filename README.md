Installation:

- Run 'composer install' to install dependencies
- Create a server / vhost environment
- Ensure protected/runtime and public/img/uploads are writeable by the server
- Copy & adjust protected/config/example.com.php | replace example.com with the host name
- Run protected/data/schema.mysql.sql on the database configured above

Use:

- For local development, define APPLICATION_ENV = 'dev'
- Adjust protected/views/site/pages/about.php
- Edit protected/views/site/pages/imprint.php and populate it with your info
- Create additional pages
- Adjust the menu entries in protected/views/layouts/partial/header.php

In a browser, navigate to http://your-site/login
- Use 'user' and 'password' to log in (you can and should change these)

Updating styles:

- install the sass and compass rubygems
- in the command line, go into the 'protected' folder
- compile css & spritemap by running compass compile --config=config.rb --force
- or create a new stylesheet to replace the current one