<?php
namespace Anax\View;

$routes = $di->get("navbar")->routes();
?>

<nav class="navbar navbar-default">

    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?= url("") ?>">Qanda - Ramverk1</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
            <?php foreach ($routes as $route) : ?>
            <?php if (array_key_exists("submenu", $route)) : ?>
            <li class="<?= $di->get("navbar")->isActiveLink($route) ? "active" : "" ?> nav-item">
                <a
                    href="<?= $route['url'] ?>"
                    title="<?= $route['title'] ?>"
                    class="<?= $di->get("navbar")->isActiveLink($route) ? "active" : "" ?> nav-link dropdown-toggle"
                    data-toggle="dropdown"
                    role="button"
                    aria-haspopup="true"
                    aria-expanded="false"
                >
                    <i class="fa fa-<?= $route['icon'] ?>"></i> <?= $route['title'] ?> <span class="caret"></span>
                </a>
            <?php else : ?>
            <li class="<?= $di->get("navbar")->isActiveLink($route) ? "active" : "" ?> nav-item">
                <a
                    href="<?= $route['url'] ?>"
                    title="<?= $route['title'] ?>"
                    class="<?= $di->get("navbar")->isActiveLink($route) ? "active" : "" ?> nav-link"
                >
                    <i class="fa fa-<?= $route['icon'] ?>"></i> <?= $route['title'] ?>
                </a>
            <?php endif; ?>

                <!-- Submenu -->
                <?php if (array_key_exists("submenu", $route)) : ?>
                <ul class="dropdown-menu">
                    <?php foreach ($route["submenu"] as $submenu) : ?>
                    <li class="<?= $di->get("navbar")->isActiveLink($submenu) ? "active" : "" ?> nav-item">
                        <a
                            href="<?= $submenu['url'] ?>"
                            title="<?= $submenu['title'] ?>"
                            class="<?= $di->get("navbar")->isActiveLink($submenu) ? "active" : "" ?> nav-link"
                        >
                            <i class="fa fa-<?= $submenu['icon'] ?>"></i> <?= $submenu['title'] ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </li>
            <?php endforeach; ?>
        </ul>
    </div><!-- /.navbar-collapse -->
</nav>
