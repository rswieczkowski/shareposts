<?php

declare(strict_types=1);

/*
 * This is a base Controller
 * Loads the models and views
 */

class Controller
{
    // Load model
    public function model(string $model): mixed
    {
        // Require model file
        require_once '../app/models/' . $model . '.php';

        // Instantiate model
        return new $model();
    }

    //
    public function view(string $view, array $data = []): void
    {
        $viewFile = '../app/views/' . $view . '.php';

        // Check for the view file
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die('View does not exists');
        }
    }

}
