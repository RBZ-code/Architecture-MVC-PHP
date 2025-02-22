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
        'identifier' =>  $row['id'],
    ];

    return $post;
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
