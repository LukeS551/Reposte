<?php require APPROOT . '/views/inc/header.php';?>
<a href="<?php echo URLROOT; ?>/posts" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
<br>
<!-- <div class="p-2 cover" style="background-image: url('<?=URLROOT?>/img/<?=$data['image']?>')">
<div class="test">
<h2>Add Post</h2>
</div>
</div>
<form class="test" action="<?php echo URLROOT; ?>/posts/add/<?php echo $data['id'] ?>" method="post" >
<div class="form-group">
          <input type="text" name="title" class="form-control form-control-lg <?php echo (!empty($data['title_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['title']; ?>">
          <span class="invalid-feedback"><?php echo $data['title_err']; ?></span>
</div>
<div class="form-group">
    <textarea name="body" rows="5" class="form-control form-control-lg <?php echo (!empty($data['body_err'])) ? 'is-invalid' : ''; ?>"><?php echo $data['body']; ?></textarea>
    <span class="invalid-feedback"><?php echo $data['body_err']; ?></span>
</div>
<div class="form-group">
        <label for="body">Image: <sup>*</sup></label>
        <!-- <div>
      <input type="file" name="image" class="form-control form-control-lg">
      </div>
      <br>
<input type="submit" class="btn btn-success btn-success-nue" value="Submit">
</form> -->
<div class="card card-body bg-light mt-5 account">
  <div class="row">
    <div class="col-8">
      <form action="<?php echo URLROOT; ?>/posts/add" method="post" enctype="multipart/form-data">
        <h2>Add Post</h2>
        <div class="form-group">
          <label for="title">Title: <sup>*</sup></label>
          <input type="text" name="title"
            class="form-control form-control-lg <?php echo (!empty($data['title_err'])) ? 'is-invalid' : ''; ?>"
            value="<?php echo $data['title']; ?>">
        </div>
        <div class="form-group">
          <label for="body">Content: <sup>*</sup></label>
          <textarea name="body"
            class="form-control form-control-lg <?php echo (!empty($data['body_err'])) ? 'is-invalid' : ''; ?>"><?php echo $data['body']; ?></textarea>
          <span class="invalid-feedback"><?php echo $data['body_err']; ?></span>
        </div>
        <div class="form-group">
        <label for="body">Image: <sup>*</sup></label>
        <div>
      <input type="file" name="image" class="form-control form-control-lg">
      </div>
      <br>
      </div>
        <input type="submit" class="btn btn-success-nue btn-success" value="Submit">
      </form>
    </div>
  </div>
</div>

<?php require APPROOT . '/views/inc/footer.php';?>