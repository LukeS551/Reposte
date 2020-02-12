<?php require APPROOT . '/views/inc/header.php';?>
<a href="<?php echo URLROOT; ?>/posts" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
<div class="card card-body bg-light mt-5 account">
  <div class="row">


    <div class="col-8">
      <form action="<?php echo URLROOT; ?>/posts/add" method="post">
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
        <input type="submit" class="btn btn-success-nue btn-success" value="Submit">
      </form>
    </div>
    <div class="col-4">
    <h2>Add image</h2>
    <br>
    <form action="<?php echo URLROOT; ?>/posts/upload" method="post" enctype="multipart/form-data">
      <div class="card card-body bg-light account">
          <input type="image" src =<?=URLROOT?>/img/scoreThumb.png alt="HTML tutorial" style="width:100%;border:0;">
      </div>
      </form>
    </div>
  </div>
</div>

<?php require APPROOT . '/views/inc/footer.php';?>