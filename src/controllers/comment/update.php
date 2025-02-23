<?php

namespace Application\Controllers\Comment\update;

require_once('src/model/comment.php');
require_once('src/model/post.php');

use Application\Model\Comment\CommentRepository;
use Application\Lib\Database\DatabaseConnection;



class updateComment
{
    
    public function getComment(string $id)
    {

        session_start();

        $CommentRepository = new CommentRepository;
        $CommentRepository->connection = new DatabaseConnection;

        $comment =  $CommentRepository->getComment($id);

        require('templates/updateComment.php');
    }

    public function updateComment(string $id, array $input)
    {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $CommentRepository = new CommentRepository;
        $CommentRepository->connection = new DatabaseConnection;


        // Vérification du token CSRF
        if (!isset($_SESSION['csrf_token']) || $_SESSION['csrf_token'] !== ($input['csrf_token'] ?? '')) {
            throw new \Exception('Requête invalide !');
        }

        // Vérification que $post est un ID valide
        if (!ctype_digit($id)) {
            throw new \Exception('post URL invalid');
        }

        // Nettoyage des entrées
        $author = isset($input['author']) ? trim($input['author']) : null;
        $comment = isset($input['comment']) ? trim($input['comment']) : null;
        $post_id = isset($input['post_id']) ? trim($input['post_id']) : null;




        // Vérification des champs
        if (empty($author) || empty($comment)) {
            throw new \Exception('input invalid');
        }

        // Ajout du commentaire en bdd
        $success = $CommentRepository->updateComment($id, $author, $comment);
        if (!$success) {
            throw new \Exception('Requête invalide !');
        }
        // Redirection 
        $_SESSION['success_message'] = 'Commentaire modifié';
        header("Location: index.php?action=post&id=$post_id&success=comment_update");
        exit;
    }
}
