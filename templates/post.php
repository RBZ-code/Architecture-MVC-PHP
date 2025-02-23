<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Génération du token CSRF si absent
}

$title = htmlspecialchars($post->title);
?>

<?php ob_start(); ?>
<?php
if (!empty($_SESSION['success_message'])) {
    require('messageSuccess.php');
    unset($_SESSION['success_message']); // Supprime le message après affichage
}

?>

<p><a href="index.php">Retour à la liste des billets</a></p>

<div class="news my-5">
    <h3>
        <?= htmlspecialchars($post->title) ?>
        <em>le <?= htmlspecialchars($post->frenchCreationDate) ?></em>
    </h3>

    <p>
        <?= nl2br(htmlspecialchars($post->content)) ?>
    </p>
</div>

<h2 class="text-center my-5">Commentaires</h2>

<div class='container mb-5'>
    <h3 class="my-3">Ajouter un commentaire</h3>
    <form action="index.php?action=addComment&id=<?= urlencode($post->identifier) ?>" method="post" class="my-5">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

        <div class="mb-3">
            <label for="author" class="form-label">Auteur</label>
            <input type="text" class="form-control" id="author" name="author" required>
        </div>

        <div class="mb-3">
            <label for="comment" class="form-label">Votre commentaire</label>
            <textarea class="form-control" id="comment" name="comment" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>
    <?php foreach ($comments as $comment): ?>
        <p><strong><?= htmlspecialchars($comment->author) ?></strong> le <?= htmlspecialchars($comment->frenchCreationDate) ?> (<a href="index.php?action=update&id=<?= urldecode($comment->identifier) ?>&post_id=<?= urldecode($post->identifier) ?>">modifier</a>)</p>
        <p><?= nl2br(htmlspecialchars($comment->comment)) ?></p>
    <?php endforeach; ?>
</div>


<?php $content = ob_get_clean(); ?>

<?php require('layout.php'); ?>