<?php require APPROOT . '/views/inc/header.php';?>

<br>
<a href="<?=URLROOT;?>/posts" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
<div class="p-2 cover" style="background-image: url('<?=URLROOT?>/img/<?=$data['post']->image?>')">
<div class="test">
    <h1><?=$data['post']->title;?></h1>
</div>
</div>
<div class="bg-secondary text-white p-2">
    written by <?=$data['user']->name;?> on <?=$data['post']->created_at;?>
</div>
<div class="test">
<p><?=$data['post']->body;?></p>


<?php if ($data['post']->user_id == $_SESSION['user_id']): ?>

<a href="<?=URLROOT;?>/posts/edit/<?=$data['post']->id;?>" class="btn btn-dark btn-dark-nue m-1"><i class="fa fa-pencil"></i> Edit</a>
<form class="pull-right" action="<?=URLROOT;?>/posts/delete/<?=$data['post']->id;?>" method="post">
    <button value="Delete" class="btn btn-danger btn-danger-nue m-1"><i class="fa fa-trash"></i> Delete</button>
</form>
<a href="<?=URLROOT;?>/posts/printOne/<?=$data['post']->id;?>" class="btn btn-primary btn-primary-nue pull-right m-1">
<i class="fa fa-print"></i> Print</a>
<?php endif;?>
<?php require APPROOT . '/views/inc/footer.php';?>
</div>