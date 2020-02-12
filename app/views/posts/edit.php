<?php require APPROOT . '/views/inc/header.php';?>
<a href="<?php echo URLROOT; ?>/posts" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
<div class="card card-body bg-light mt-5">
  <div class="row">
    <div class="col-8">
      <h2>Edit Post</h2>
      <p>Create a post with this form</p>
      <form action="<?php echo URLROOT; ?>/posts/edit/<?php echo $data['id'] ?>" method="post">
        <div class="form-group">
          <label for="title">Title: <sup>*</sup></label>
          <input type="text" name="title"
            class="form-control form-control-lg <?php echo (!empty($data['title_err'])) ? 'is-invalid' : ''; ?>"
            value="<?php echo $data['title']; ?>">
          <span class="invalid-feedback"><?php echo $data['title_err']; ?></span>
        </div>
        <div class="form-group">
          <label for="body">Content: <sup>*</sup></label>
          <textarea name="body"rows="5" class="form-control form-control-lg <?php echo (!empty($data['body_err'])) ? 'is-invalid' : ''; ?>"><?php echo $data['body']; ?></textarea>
          <span class="invalid-feedback"><?php echo $data['body_err']; ?></span>
        </div>
        <input type="submit" class="btn btn-success btn-success-nue" value="Submit">
      </form>
    </div>
  <div class="col-4">
    <div class="card-body">
      <h2>Add image</h2>
      <a href="https://www.youtube.com/watch?v=9oc8Fa7tb8c">
        <img src=<?=URLROOT?>/img/scoreThumb.png alt="HTML tutorial" style="width:256px;height:144px;border:0;">
      </a>
    </div>
  </div>
  </div>
</div>
<?php require APPROOT . '/views/inc/footer.php';?>