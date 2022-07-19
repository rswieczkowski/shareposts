<?php
require APP_ROOT . '/views/inc/header.php'; ?>

            <h1> <?= $data['title'] ?> </h1>
            <p><?= $data['description'] ?>  </p>
            <p>Version: <strong><?= APP_VERSION ?></strong></p>

<?php require APP_ROOT . '/views/inc/footer.php'; ?>