<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

/*
 * This initialize the SQLite database schema and records
 * It's using hard-coded commands and lists of records to generate the database
 */

//Include settings
$settings = include __DIR__ . '/../settings.php';

//Delete SQLite database file if exists
if (file_exists($settings['db']->file)) {
    unlink($settings['db']->file);
}

/*
 * Initialize a SQLite database adapter
 */
$adapter = new \Phramework\Database\SQLite($settings['db']);

/*
 * Create schema
 */
$adapter->execute(
    'CREATE TABLE article(
        `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
        `title` varchar(255),
        `body` TEXT,
        `creator-user_id` int,
        `status` int
    )'
);

$adapter->execute(
    'CREATE TABLE `tag`(
        `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
        `title` varchar(255),
        `status` int
    )'
);

$adapter->execute(
    'CREATE TABLE `article-tag`(
        `article_id` INTEGER,
        `tag_id` INTEGER,
        `status` int
    )'
);

$adapter->execute(
    'CREATE TABLE `user`(
        `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
        `username` varchar(255),
        `name` varchar(255),
        `status` int
    )'
);

$adapter->execute(
    'CREATE TABLE `session`(
        `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
        `date` int,
        `team_user_id` int,
        `patient_user_id` int,
        `confirmed` int,
        `role` int
    )'
);
/*
 * Define lists of records to be inserted
 */

$users = [
    [1, 'nohponex', 'Xenofon Spafaridis', 1, 1],
    [2, 'janedoe', 'Jane Doe Doc', 0, 2],
    [3, 'rudoctor', 'Doc Doct', 0, 2],
    [4, 'rupatient', 'Pat Pati', 0, 1],
    [4, 'rudietitian', 'Die Dieti', 0, 3]
];

$articles = [
    [1, 'Hello World', 'HELLO WORLD', 1, 1],
    [2, 'About us', 'We are...', 1, 1]
];

$tags = [
    [1, 'blog', 1],
    [2, 'programming', 1],
    [3, 'php', 1],
    [4, 'html', 0]
];

$articlesTags = [
    [1, 1, 1],
    [1, 2, 1],
    [2, 1, 1]
];

$sessions = [
    [1, 1477577616, 3, 4, 0, 2],
    [2, 1477577233, 3, 4, 0, 2],
    [3, 1477577100, 3, 4, 0, 2],
    [4, 1477577022, 3, 4, 0, 2],
    [5, 1477577540, 3, 4, 0, 2],
    [6, 1477577123, 3, 4, 1, 2],
    [7, 1477577534, 3, 4, 1, 2],
    [8, 1477577132, 3, 4, 2, 2]
];

/*
 * Insert user records
 */
foreach ($users as $user) {
    $adapter->execute(
        'INSERT INTO `user`
        (`id`, `username`, `name`, `status`)
        VALUES (?, ?, ?, ?)',
        $user
    );
}

/*
 * Insert article records
 */
foreach ($articles as $article) {
    $adapter->execute(
        'INSERT INTO `article`
        (`id`, `title`, `body`, `creator-user_id`, `status`)
        VALUES (?, ?, ?, ?, ?)',
        $article
    );
}

/*
 * Insert tag records
 */
foreach ($tags as $tag) {
    $adapter->execute(
        'INSERT INTO `tag`
         (`id`, `title`, `status`)
         VALUES (?, ?, ?)',
        $tag
    );
}

/*
 * Insert article-tag records
 */
foreach ($articlesTags as $articleTag) {
    $adapter->execute(
        'INSERT INTO `article-tag`
        (`article_id`, `tag_id`, `status`)
        VALUES (?, ?, ?)',
        $articleTag
    );
}

/*
 * Insert sessions records
 */
foreach ($sessions as $session) {
    $adapter->execute(
        'INSERT INTO `session`
        (`id`, `date`, `team_user_id`, `patient_user_id`, `confirmed`, `role`)
        VALUES (?, ?, ?, ?, ?, ?)',
        $session
    );
}

/*
 * Close connection
 */
$adapter->close();
