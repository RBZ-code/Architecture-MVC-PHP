<?php

namespace Application\Controllers\Post;

require_once('src/model/post.php');
require_once('src/model/comment.php');




use Application\Model\Post\PostRepository;
use Application\Model\Comment\CommentRepository;
use Application\Lib\Database\DatabaseConnection;





class Post
{
    public function execute(string $identifier)
    {
        session_start();

        $database = new DatabaseConnection;

        $PostRepository = new PostRepository;
        $PostRepository->connection = $database;

        $CommentRepository = new CommentRepository;
        $CommentRepository->connection = $database;

        $post = $PostRepository->getPost($identifier);
        $comments = $CommentRepository->getComments($identifier);

        require('templates/post.php');
    }
}
