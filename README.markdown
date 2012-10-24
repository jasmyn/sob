# SOB - Simple Open Blog (0.7)

by Jasmyn Bianca (jasmynbianca@gmail.com)

Released under GPL version 3 or any later version.

*You have to set your own authentication on /admin or it won't be secure.*

## SOB?
I needed a blog to plug into client's sites and all the ones I tried were more than I needed.
SOB is designed to be easily stylable to match your current site, and you can position the blog div how you like.
Short tags need not be turned on. You need MySQL up and running.

## Installation
* Create the main table and give it a test entry...

create table blog (
id int unsigned not null auto_increment primary key,
title varchar(255) not null,
copy varchar(255) not null,
posted datetime not null,
tags varchar(255)
);

insert into blog values (
'',
'Test Title One',
'Test Entry One',
'now()',
''
);

* Create comment table...

create table comments (
id int unsigned not null auto_increment primary key,
postId int unsigned not null,
author varchar(64),
copy text not null,
ip varchar(64),
posted datetime not null
);

insert into comments values (
'',
1,
'Author',
'Comment',
'192.168.1.1',
''
);

* Create banned IP table...

create table banned (
id int unsigned not null auto_increment primary key,
ip varchar(64) not null
);

* Edit /includes/db_vars.inc to contain your actual db connect info.
* Up everything, leaving the file structure intact.

* Make your page, calling the classes then sob. Here's one I did...

```php
<?php
	include 'includes/header.inc';

	include 'includes/nav.inc';

	//load classes
	include 'blog/includes/classes.php';

	//load SOB
	include	'blog/sob/sob.php';

	include 'includes/footer.inc';
?>
```

...but then I like to split things up. Loading classes.php and sob.php is the important bit.

> Style however you need to fit in with your site. /css/sob.css comes pre-loaded with the hooks.
> Tinker, curse, repeat...
