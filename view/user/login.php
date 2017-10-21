<?php

namespace Anax\View;

/**
 * View to create a new comment.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

// Gather incoming variables and use default values if not set
$items = isset($items) ? $items : null;
$urlToCreate = url("user/create");

?><h1>Administration</h1>

<?= $form ?>
<a href="<?= $urlToCreate ?>">Skapa användare</a>
