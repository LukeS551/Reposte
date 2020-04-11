<?php
require APPROOT . '/views/inc/header.php';?>

<div class="row mb-3">
  <div class="col-md-6">
    <?php flash('post_message');?>
    <h1>Posts <?php echo APPROOT ?></h1>
  </div>
  <div class="col-md-6">
    <a href="<?=URLROOT;?>/posts/printpost" class="btn btn-primary-nue btn-primary pull-right m-1">
      <i class="fa fa-print"></i> Print Record</a>
    <a href="<?=URLROOT;?>/posts/add" class="btn btn-primary-nue btn-primary pull-right m-1 ">
      <i class="fa fa-plus"></i> Add Post</a>
  </div>
</div>
<?php foreach ($data['posts'] as $post): ?>
<div class="card card-body mb-3 strech">
  <div class="padless row">

    <div class="full col-lg-4">
      <a href="https://www.youtube.com/watch?v=9oc8Fa7tb8c">
        <img src=<?=URLROOT?>/img/back.jpg alt="HTML tutorial" style="width:100%;border:0;">
      </a>
    </div>
    <div class=" text col-lg-8 col-sm-9">
      <h4 class="card-title"><?=$post->title;?></h4>
      <div class="bg-light p-2 mb-3">
        written by <?=$post->name;?> on <?=$post->postCreated;?>
      </div>
      <p class="card-text"><?=$post->body;?></p>
      <a href="<?=URLROOT;?>/posts/show/<?=$post->postId;?>" class="btn btn-dark-nue btn-dark"><i class="fa fa-mouse-pointer"></i> View</a>
    </div>
  </div>
</div>
<?php endforeach;?>
<?php require APPROOT . '/views/inc/footer.php';?>
<script src="http://localhost/riposte/js/main.js"></script>

