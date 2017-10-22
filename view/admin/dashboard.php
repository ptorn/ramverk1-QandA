<?php
namespace Anax\View;

$items = isset($users) ? $users : null;
$editUrl = url("user/update/$user->id");
$logoutUrl = url("user/logout");
?>
<h1>Welcome to the Dashboard</h1>
<p>Du är inloggad som <?= $user->firstname . " " . $user->lastname; ?></p>
<img src="<?= $gravatarUrl; ?>">
<div class="User-info">
    <span>Förnamn: </span><?= $user->firstname; ?><br>
    <span>Efternamn: </span><?= $user->lastname; ?><br>
    <span>Epost: </span><?= $user->email; ?><br>
    <span>Aktiverad: </span><?= $user->enabled; ?><br>
    <span>Administrator: </span><?= $user->administrator; ?>
</div>
<a href="<?= $editUrl ?>">Uppdatera</a> | <a href="<?= $logoutUrl ?>">Logga Ut</a>

<?php if (!$users) {
    return;
} ?>


<table>
    <tr>
        <th>Id</th>
        <th>Användarnamn</th>
        <th>Epost</th>
        <th>Radera</th>
    </tr>
    <?php foreach ($users as $usr) : ?>
    <tr>
        <td>
            <a href="<?= url("user/update/{$usr->id}"); ?>"><?= $usr->id ?></a>
        </td>
        <td><?= $usr->username ?></td>
        <td><?= $usr->email ?></td>
        <td>
            <a href="<?= url("user/delete/{$usr->id}"); ?>">Radera</a>
        </td>

    </tr>
    <?php endforeach; ?>
</table>
