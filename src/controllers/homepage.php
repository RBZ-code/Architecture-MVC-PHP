<?php

require_once('src/model/post.php');

use Application\Model\post\PostRepository;
use Application\Lib\Database\DatabaseConnection;

function homepage() {
    $PostRepository = new PostRepository;
    $PostRepository->connection = new DatabaseConnection;
    $posts = $PostRepository->getPosts();

    require('templates/homepage.php');
}