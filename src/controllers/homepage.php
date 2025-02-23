<?php

namespace Application\Controllers\Homepage;

require_once('src/model/post.php');

use Application\Model\post\PostRepository;
use Application\Lib\Database\DatabaseConnection;



class Homepage {
    public function execute() {

    $PostRepository = new PostRepository;
    $PostRepository->connection = new DatabaseConnection;
    $posts = $PostRepository->getPosts();

    require('templates/homepage.php');
}
}
