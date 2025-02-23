<?php $title = "Le blog de l'AVBN, Page Error"; ?>

<div class="alert alert-success" role="alert">
  <?= htmlspecialchars($_SESSION['success_message'])  ?>
</div>
<?php $content = ob_get_clean(); ?>
<?php require('layout.php');