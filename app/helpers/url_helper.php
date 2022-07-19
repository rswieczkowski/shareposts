<?php


// Simple page redirect
function redirect(string $location): void
{
    header('Location: ' . URL_ROOT . '/' . $location);
}

?>
