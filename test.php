<?php 

class Comment {
    public string $author;
    public string $frenchCreationDate;
    public string $comment;
}

class Post {
    public string $author;
    public string $frenchCreationDate;
    public string $comment;
}

$comment = new Comment() ;
$comment->frenchCreationDate = '10/03/2024 à 15h09';