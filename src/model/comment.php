<?php

function getComments($id)
{



    $database = dbConnects();

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

function createComment(string $post, string $author, string $comment)
{
    $database = dbConnects();

    $statement = $database->prepare(
        "INSERT INTO comments(post_id, author, comment, comment_date)
        VALUES(?,?,?, NOW())
        "
    );
    $success = $statement->execute([
        $post,
        $author,
        $comment,
    ]);

    return($success > 0);
}


function dbConnects()
{
    try {
        $database = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
        return $database;
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}
