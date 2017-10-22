<div class="footer-author">Peder Tornberg - QandA Ramverk1</div>
<?php if ($this->regionHasContent("footer")) : ?>
<div class="navbar-wrap">
    <?php
    $routes = $di->get("navbar")->routes("social");
    ?>
    <div class="contact-nav">
        <ul>
            <?php foreach ($routes as $route) : ?>
            <li class="<?= $di->get("navbar")->isActiveLink($route) ? "active" : "" ?>">
                <a
                    href="<?= $route['url'] ?>"
                    title="<?= $route['title'] ?>"
                    class="<?= $di->get("navbar")->isActiveLink($route) ? "active" : "" ?>"
                >
                    <i class="fa fa-<?= $route['icon'] ?>"></i> <?= $route['title'] ?>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<?php endif; ?>
