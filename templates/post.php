<?php $title = htmlspecialchars($post['title']); ?>
<?php ob_start(); 
/* var_dump($post);
die; */
?>



<p><a href="index.php">Retour à la liste des billets</a></p>

<div class="news">
    <h3>
        <?= htmlspecialchars($post['title']) ?>
        <em>le <?= $post['french_creation_date'] ?></em>
    </h3>

    <p>
        <?= nl2br(htmlspecialchars($post['content'])) ?>
    </p>
</div>

<h2>Commentaires</h2>

<div class='container mb-5'>
    <h3 class="my-3">Ajouter un commentaire</h3>
    <form action="index.php?action=addComment&id=<?= $post['identifier'] ?>" method="post">
        <div class="mb-3">
            <label for="author" class="form-label">Auteur</label>
            <input type="text" class="form-control" id="author" name="author">
        </div>
        <div class="mb-3">
            <label for="comment" class="form-label">Votre commentaire</label>
            <textarea class="form-control" id="comment" name="comment"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<?php

foreach ($comments as $comment) {
?>
    <p><strong><?= htmlspecialchars($comment['author']) ?></strong> le <?= $comment['french_creation_date'] ?></p>
    <p><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
<?php
}
?>
<?php $content = ob_get_clean(); ?>

<?php require('layout.php');
