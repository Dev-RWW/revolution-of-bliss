<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Home'; ?> | <?php echo $SITE_NAME ?? 'Revolution of Bliss'; ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
</head>
<body>

    <header>
        <h1><?php echo $SITE_NAME ?? 'Ecosystem'; ?></h1>
        <p><em><?php echo $tagline ?? ''; ?></em></p>
    </header>

    <main>
        <h2><?php echo $title ?? 'Welcome'; ?></h2>
        <div class="content">
            <?php echo $content ?? 'No content loaded.'; ?>
        </div>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> <?php echo $SITE_NAME ?? 'Bliss'; ?></p>
    </footer>

</body>
</html>