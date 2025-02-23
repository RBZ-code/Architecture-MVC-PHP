<?php $title = "Le blog de l'AVBN, Page Error"; ?>

<div class="alert alert-danger" role="alert">
  <?= $messageError ?>
</div>
<?php $content = ob_get_clean(); ?>
<?php require('layout.php');