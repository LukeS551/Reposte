<?php require APPROOT . '/views/inc/header.php'; ?>
<a href="<?= URLROOT; ?>/posts" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
<br>
<h1><?= $data['post']->title; ?></h1>
<div class="bg-secondary text-white p-2 mb-3">
written by <?= $data['user']->name; ?> on <?= $data['post']->created_at; ?>
</div>
<p><?= $data['post']->body; ?></p>

<?php if($data['post']->user_id == $_SESSION['user_id']) : ?>
<a href="<?= URLROOT; ?>/posts/edit/<?= $data['post']->id; ?>" class="btn btn-dark m-1">Edit</a>
<form class="pull-right" action="<?= URLROOT; ?>/posts/delete/<?= $data['post']->id; ?>" method="post">
<input type="submit" value="Delete" class="btn btn-danger m-1">
</form>
<a href="<?= URLROOT; ?>/posts/printOne/<?= $data['post']->id; ?>" class="btn btn-primary pull-right m-1">
<i class="fa fa-print"></i> Print</a>
<?php endif; ?>
<?php require APPROOT . '/views/inc/footer.php'; ?>