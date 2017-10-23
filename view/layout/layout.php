<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $title ?></title>
        <?php foreach ($stylesheets as $stylesheet) : ?>
            <link rel="stylesheet" type="text/css" href="<?= $this->asset($stylesheet) ?>">
        <?php endforeach; ?>
        <?php foreach ($javascripts as $javascript) : ?>
            <script src="<?= $this->asset($javascript) ?>"></script>
        <?php endforeach; ?>
    </head>
    <body>
        <?php if ($this->regionHasContent("navbar")) : ?>
        <div class="navbar">
            <div class="row-fluid">
                <div class="top-navbar">
                    <?php $this->renderRegion("navbar") ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="container-fluid">
            <div class="container mt-20">
                <div class="row-fluid">
                <?php if ($this->regionHasContent("main")) : ?>
                    <?php if ($this->regionHasContent("sidebar-right")) : ?>
                    <main id="main" class="col-xs-12 col-md-9 main mb-20">
                    <?php else : ?>
                    <main id="main" class="col-xs-12 col-md-12 main mb-20">
                    <?php endif; ?>
                        <?php $this->renderRegion("main") ?>
                        <?php if ($this->regionHasContent("under-main")) : ?>
                        <?php $this->renderRegion("under-main") ?>
                        <?php endif; ?>
                    </main>
                <?php endif; ?>

                <?php if ($this->regionHasContent("sidebar-right")) : ?>
                    <div class="col-xs-12 col-md-3 sidebar-right">
                        <?php $this->renderRegion("sidebar-right") ?>
                    </div>
                <?php endif; ?>
                </div>
            </div>
        </div>

        <div id="footer" class="footer">
            <?php if ($this->regionHasContent("footer")) : ?>
            <div class="row-fluid">
                <div class="col-xs-12">
                    <div class="center-block text-center">
                        <div class="block site-footer">
                            <?php $this->renderRegion("footer") ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        </div>
        <?php if ($this->regionHasContent("popup")) : ?>
            <?php $this->renderRegion("popup") ?>
        <?php endif; ?>
    </body>
</html>
