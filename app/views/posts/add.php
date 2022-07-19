<?php

require APP_ROOT . '/views/inc/header.php'; ?>

<a href="<?= URL_ROOT?>/posts" class="btn btn-light"><i class="fa fa-backward"> Back</i></a>
<div class="card card-body big-light mt-5">
  <h2>Add post</h2>
    <p>Create a post with this form</p>
    <form action="<?= URL_ROOT ?>/posts/add" method="post">
        <div class="form-group">
            <label for="title">Title:<sup>*</sup></label>
            <input type="text" name="title"
                   class="form-control form-control-lg <?= (!empty($data['title_error'])) ? 'is-invalid' : ''; ?>"
                   value="<?= $data['title'] ?>">
            <span class="invalid-feedback"> <?= $data['title_error'] ?><span/>
        </div>
        <div class="form-group">
            <label for="body">Body: <sup>*</sup></label>
            <textarea name="body"
                      class="form-control form-control-lg <?= (!empty($data['body_error'])) ? 'is-invalid' : ''; ?>"
            <?= $data['body'] ?>"></textarea>
            <span class="invalid-feedback"> <?= $data['body_error'] ?><span/>
        </div>
        <div class="col">
            <input type="submit" value="Submit" class="btn btn-success">
        </div>
    </form>
</div>


<?php
require APP_ROOT . '/views/inc/footer.php'; ?>
