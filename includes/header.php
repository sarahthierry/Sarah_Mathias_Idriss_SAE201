<?php
// includes/header.php
// Note: ces pages n’utilisent pas encore cette inclusion systématique.
// Placeholder pour structurer le projet.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function page_header(string $title = ''): void {
    // Optionnel: mettre en place des variables/HTML commun.
    // Pour l’instant, pas utilisé.
}

