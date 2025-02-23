<?php

namespace Application\Model\Post;

use Application\Lib\Database\DatabaseConnection;

require_once('src/lib/database.php');

class Post
{
    public string $title;
    public string $content;
    public string $frenchCreationDate;
    public string $identifier;
}

class PostRepository
{

    public DatabaseConnection $connection;

    public function getPosts(): array
    {

        // On récupère les 5 derniers billets
        $statement = $this->connection->getConnection()->query(
            "SELECT id, title, content, DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS date_creation_fr FROM posts ORDER BY creation_date DESC LIMIT 0, 5"
        );

        $posts = [];

        while ($row = $statement->fetch()) {

            $post = new Post();
            $post->title = $row['title'];
            $post->content = $row['content'];
            $post->frenchCreationDate =  $row['date_creation_fr'];
            $post->identifier = $row['id'];

            $posts[] = $post;
        }

        return $posts;
    }

    public function getPost(string $id): Post
    {
        
        $statement = $this->connection->getConnection()->prepare("SELECT id, title, content, DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS date_creation_fr FROM posts WHERE id = :id");
        $statement->execute([
            'id' => $id,
        ]);
        $row = $statement->fetch();

        $post = new Post();
        $post->title = $row['title'];
        $post->content = $row['content'];
        $post->frenchCreationDate =  $row['date_creation_fr'];
        $post->identifier = $row['id'];

        return $post;
    }

}
