<?php

function getPosts()
{
    $database = dbConnect();

    // On récupère les 5 derniers billets
    $statement = $database->query(
        "SELECT id, title, content, DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS date_creation_fr FROM posts ORDER BY creation_date DESC LIMIT 0, 5"
    );

    $posts = [];

    while ($row = $statement->fetch()) {
        $post = [
            'title' => $row['title'],
            'content' => $row['content'],
            'french_creation_date' =>  $row['date_creation_fr'],
            'identifier' => $row['id'],
        ];

        $posts[] = $post;
    }

    return $posts;
}

function getPost($id)
{
    $database = dbConnect();
    $statement = $database->prepare("SELECT id, title, content, DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS date_creation_fr FROM posts WHERE id = :id");
    $statement->execute([
        'id' => $id,
    ]);
    $row = $statement->fetch();

    $post = [
        'title' => $row['title'],
        'content' => $row['content'],
        'french_creation_date' =>  $row['date_creation_fr'],
    ];

    return $post;
}

function getComments($id)
{



    $database = dbConnect();

    $statement = $database->prepare(
        "SELECT id, post_id, author, comment, DATE_FORMAT(comment_date, '%d/%m/%Y à %Hh%imin%ss') AS date_creation_fr FROM comments  WHERE post_id = :post_id ORDER BY comment_date DESC"
    );

    $statement->execute([
        'post_id' => $id,
    ]);

    $comments = [];

    while ($row = $statement->fetch()) {
        $comment = [
            'author' => $row['author'],
            'comment' => $row['comment'],
            'french_creation_date' =>  $row['date_creation_fr'],
        ];

        $comments[] = $comment;
    }

    return $comments;
}


function dbConnect()
{
    try {
        $database = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
        return $database;
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}
