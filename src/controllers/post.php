<?php

require_once('src/model.php');

function post(string $indentifier) {
    $post = getPost($indentifier);
    $comments = getComments($indentifier);

    require('templates/post.php');
}