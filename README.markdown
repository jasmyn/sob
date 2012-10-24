sob - simple open blog (0.7)
============================

by Jasmyn Bianca (jasmynbianca@gmail.com)

Released under GPL version 3 or any later version.

*You have to set your own authentication on /admin or it won't be secure.*

#sob?

I needed a blog to plug into client's sites and all the ones I tried were more than I needed.
SOB is designed to be easily stylable to match your current site, and you can position the blog div how you like.
Short tags need not be turned on. You need MySQL up and running.

## Installation

### The MySql!

1. Create the main table and give it a test entry...
    ```sql
    create table blog (
        id int unsigned not null auto_increment primary key,
        title varchar(255) not null,
        copy varchar(255) not null,
        posted datetime not null,
        tags varchar(255)
    );
    ```

2. Give it a dummy entry so you have something to play with...
    ```sql
    insert into blog values (
        '',
        'Test Title One',
        'Test Entry One',
        'now()',
        ''
    );
    ```

3. Create comment table...
    ```sql
    create table comments (
        id int unsigned not null auto_increment primary key,
        postId int unsigned not null,
        author varchar(64),
        copy text not null,
        ip varchar(64),
        posted datetime not null
    );
    ```

4. Give it a dummy comment to play with...
    ```sql
    insert into comments values (
        '',
        1,
        'Author',
        'Comment',
        '192.168.1.1',
        ''
    );
    ```

5. Create banned IP table...
    ```sql
    create table banned (
        id int unsigned not null auto_increment primary key,
        ip varchar(64) not null
    );
    ```

### The sob!

1. Edit /includes/db_vars.inc to contain your actual db connect info.

2. Upload everything to your hosting server, leaving the directory/file structure intact.

### The page!

1. Make your page, calling the classes then sob. Here's one I did...
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

### The extra!

1. Style however you need to fit in with your site. /css/sob.css comes pre-loaded with the hooks.

2. *Secure /admin.* This part isn't really extra.

3. Tinker, curse, repeat...
