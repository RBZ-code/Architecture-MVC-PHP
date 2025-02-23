<?php
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Génération du token CSRF si absent
}

$title = 'Modifier un commentaire';
?>

<?php ob_start(); ?>
<p><a href="index.php">Retour à la liste des billets</a></p>

<h2 class="text-center my-5">Commentaires</h2>

<div class='container mb-5'>
    <h3 class="my-3">Modifier un commentaire</h3>
    <form action="index.php?action=update&id=<?= urlencode($comment->identifier) ?>" method="post" class="my-5">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
        <input type="hidden" name='post_id' value="<?= htmlspecialchars($comment->post_id)?>">

        <div class="mb-3">
            <label for="author" class="form-label">Auteur</label>
            <input type="text" class="form-control" id="author" name="author" value="<?= $comment->author ?>" required>
        </div>

        <div class="mb-3">
            <label for="comment" class="form-label">Votre commentaire</label>
            <textarea class="form-control" id="comment" name="comment" required><?= $comment->comment ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Modifer</button>
    </form>

    <?php $content = ob_get_clean(); ?>

<?php require('layout.php'); ?>