<?php

namespace Application\Controllers\Comment\add;

require_once('src/model/comment.php');
require_once('src/model/post.php');

use Application\Model\Comment\CommentRepository;
use Application\Lib\Database\DatabaseConnection;


class addComment {
    public function execute(string $post, array $input){
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
        if (!ctype_digit($post)) {
            throw new \Exception('post URL invalid');
        }

        // Nettoyage des entrées
        $author = isset($input['author']) ? trim($input['author']) : null;
        $comment = isset($input['comment']) ? trim($input['comment']) : null;


        // Vérification des champs remplis
        if (empty($author) || empty($comment)) {
            throw new \Exception('input invalid');
        }

        // Ajout du commentaire en bdd
        $success = $CommentRepository->createComment($post, $author, $comment);
        if (!$success) {
            throw new \Exception('Requête invalide !');
        }

        // Redirection
        $_SESSION['success_message'] = 'Commentaire ajouté';
        header("Location: index.php?action=post&id=$post&success=comment_added");
        exit;
    }
}