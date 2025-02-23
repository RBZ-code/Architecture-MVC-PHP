<?php


require_once('src/controllers/homepage.php');
require_once('src/controllers/post.php');
require_once('src/controllers/comment/add.php');
require_once('src/controllers/comment/update.php');
require_once('src/controllers/test.php');

use Application\Controllers\Homepage\Homepage;
use Application\Controllers\Post\Post;
use Application\Controllers\Comment\add\addComment;
use Application\Controllers\Comment\update\updateComment;

try {
    if (isset($_GET['action']) && $_GET['action'] !== "") {

        if ($_GET['action'] === 'post') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $identifier = $_GET['id'];
                $postRepository = new post;
                $postRepository->execute($identifier);
            } else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        } elseif ($_GET['action'] === 'addComment') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $identifier = $_GET['id'];
                $addCommentRepository = new addComment;
                $addCommentRepository->execute($identifier, $_POST);

                $messageSuccess = 'Commentaire ajouté';
                require('templates/messageSuccess.php');
            } else {
                throw new Exception('Aucun identifiant de commentaire envoyé');
            }
        } elseif ($_GET['action'] === 'update') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $identifier = $_GET['id'];

                $updateCommentRepository = new updateComment;
                $updateCommentRepository->getComment($identifier);

                $input = null;

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                    $input = $_POST;

                    $updateCommentRepository = new updateComment;
                    $updateCommentRepository->updateComment($identifier, $input);
                }
            } else {
                throw new Exception('Aucun identifiant de commentaire envoyé');
            }
        } else {
            throw new Exception('404 page not found');
        }
    } else {
        $homepageRepository = new Homepage;
        $homepageRepository->execute();
    }
} catch (Exception $e) {
    $messageError = 'Error : ' . $e->getMessage();
    require('templates/messageError.php');
}
