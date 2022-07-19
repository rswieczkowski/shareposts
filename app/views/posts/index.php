<?php

require APP_ROOT . '/views/inc/header.php'; ?>
<?php flash('post_message') ?>
    <div class="row">
        <div class="col-md-6">
            <h1>Posts</h1>
        </div>
        <div class="cos-md-6">
            <a href="<?= URL_ROOT ?>/posts/add" class="btn btn-primary pull-right">
                <i class="fa fa-pencil"></i> Add Post
            </a>
        </div>
    </div>
<?php
foreach ($data['posts'] as $post) : ?>
    <div class="card card-body mb-3">
        <h4 class="title"><?= $post->title ?></h4>
        <div class="bg-light p-2 mb-3">
            Written by <?= $post->name ?> on <?= $post->post_created_at ?>
        </div>
        <p class="card-text"><?= $post->body ?></p>
        <a href="<?=URL_ROOT?>/posts/show/<?= $post->post_id; ?>" class="btn btn-dark">More</a>
    </div>
<?php
endforeach; ?>
<?php
require APP_ROOT . '/views/inc/footer.php'; ?>