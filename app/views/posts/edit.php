<?php require APPROOT . '/views/inc/header.php';?>
<a href="<?php echo URLROOT; ?>/posts" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
<div class="card card-body bg-light mt-5">
  <div class="row">
    <div class="col-8">
      <h2>Edit Post</h2>
      <p>Create a post with this form</p>
      <form action="<?php echo URLROOT; ?>/posts/edit/<?php echo $data['id'] ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label for="title">Title: <sup>*</sup></label>
          <input type="text" name="title" class="form-control form-control-lg <?php echo (!empty($data['title_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['title']; ?>">
          <span class="invalid-feedback"><?php echo $data['title_err']; ?></span>
        </div>
        <div class="form-group">
          <label for="body">Content: <sup>*</sup></label>
          <textarea name="body" rows="5" class="form-control form-control-lg <?php echo (!empty($data['body_err'])) ? 'is-invalid' : ''; ?>"><?php echo $data['body']; ?></textarea>
          <span class="invalid-feedback"><?php echo $data['body_err']; ?></span>
        </div>
        <div class="form-group">
      <h2>Add image</h2>
      <input type="file" name="image" class="form-control">
        <img src=<?=URLROOT?>/img/scoreThumb.png alt="HTML tutorial" style="width:256px;height:144px;border:0;">
    </div>
    <input type="submit" class="btn btn-success btn-success-nue" value="Submit">
      </form>
    </div>
  </div>
</div>
<?php require APPROOT . '/views/inc/footer.php';?>