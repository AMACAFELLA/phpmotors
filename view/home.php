<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="/phpmotors/css/styles.css" type="text/css" media="screen">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | PHP Motors - World's No.1 Car Site </title>
</head>

<body>
    <header>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>
    </header>
    <nav>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/nav.php'; ?>
    </nav>
    <main>
        <div class="home__container">
            <h1>Welcome to PHP Motors</h1>
            <div class="landing_page">
                <h1>DMC Delorean</h1>
                <h2>3 Cup holders</h2>
                <h2>Superman doors</h2>
                <h2>Fuzzy dice!</h2>
            </div>
            <img src="/phpmotors/images/vehicles//1982-dmc-delorean.jpg" alt="DMC Delorean" id="delorean">
            <button type="button" id="ownToday_Btn" aria-label="Own Today">Own Today</button>
        </div>
        <div class="home__columns">
            <div class="review__column">
                <h2>DMC Delorean Reviews</h2>
                <ul class="reviews">
                    <li>"So fast its like traveling in time." (4/5)</li>
                    <li>"Coolest ride on the road." (4/5)</li>
                    <li>"I'm feeling Marty McFly!." (5/5)</li>
                    <li>"80's livin and I love it!." (4/5)</li>
                </ul>
            </div>
            <div class="Upgrade__column">
                <h2>Delorean Upgrades</h2>
                <div>
                    <div class="Upgrade__img">
                        <img src="/phpmotors/images/upgrades/flux-cap.png" alt="Flux Capacitor">
                    </div>
                    <a href="#">Flux Capacitor</a>
                </div>
                <div>
                    <div class="Upgrade__img">
                        <img src="/phpmotors/images/upgrades/flame.jpg" alt="Flame Decals">
                    </div>
                    <a href="#">Flame Decals</a>
                </div>
                <div>
                    <div class="Upgrade__img">
                        <img src="/phpmotors/images/upgrades/bumper_sticker.jpg" alt="Bumper Sticker">
                    </div>
                    <a href="#">Bumper Sticker</a>
                </div>
                <div>
                    <div class="Upgrade__img">
                        <img src="/phpmotors/images/upgrades/hub-cap.jpg" alt="Hub Caps">
                    </div>
                    <a href="#">Hub Caps</a>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
    </footer>
</body>

</html>