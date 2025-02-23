<?php

require_once('src/controllers/homepage.php');
require_once('src/controllers/post.php');
require_once('src/controllers/comment.php');
require_once('src/controllers/test.php');


try {
    if (isset($_GET['action']) && $_GET['action'] !== "") {

        if ($_GET['action'] === 'post') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $identifier = $_GET['id'];

                post($identifier);
            } else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        } elseif ($_GET['action'] === 'addComment') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $identifier = $_GET['id'];
                addComment($identifier, $_POST);
            } else {
                throw new Exception('Aucun identifiant de commentaire envoyé');
            }
        } else {
            throw new Exception('404 page not found');
        }
    } else {
        homepage();
    }
} catch (Exception $e) {
    $messageError = 'Error : ' . $e->getMessage();
    require('templates/messageError.php');
}
