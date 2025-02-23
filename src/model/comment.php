<?php
namespace Application\Model\Comment;

use Application\Lib\Database\DatabaseConnection;

require_once('src/lib/database.php');

class Comment
{
    public string $author;
    public string $frenchCreationDate;
    public string $comment;
}

class CommentRepository
{
    public DatabaseConnection $connection;

    public function getComments(string $id): array
    {


        $statement = $this->connection->getConnection()->prepare(
            "SELECT id, post_id, author, comment, DATE_FORMAT(comment_date, '%d/%m/%Y à %Hh%imin%ss') AS date_creation_fr FROM comments  WHERE post_id = :post_id ORDER BY comment_date DESC"
        );

        $statement->execute([
            'post_id' => $id,
        ]);



        $comments = [];

        while ($row = $statement->fetch()) {
            $comment = new Comment();
            $comment->author = $row['author'];
            $comment->comment = $row['comment'];
            $comment->frenchCreationDate =  $row['date_creation_fr'];


            $comments[] = $comment;
        }

        return $comments;
    }

    public function createComment(string $post, string $author, string $comment) : bool
    {

        $statement = $this->connection->getConnection()->prepare(
            "INSERT INTO comments(post_id, author, comment, comment_date)
        VALUES(?,?,?, NOW())
        "
        );
        $success = $statement->execute([
            $post,
            $author,
            $comment,
        ]);

        return ($success > 0);
    }

}
