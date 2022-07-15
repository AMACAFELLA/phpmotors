<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="/phpmotors/css/styles.css" type="text/css" media="screen">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo "$vehicleDetail[invMake] $vehicleDetail[invModel]" ?> | PHP Motors - World's No.1 Car Site</title>
</head>

<body>
    <header>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>
    </header>
    <nav>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/nav.php' ?>
    </nav>
    <main>
        <h1><?php echo "$vehicleDetail[invMake] $vehicleDetail[invModel]" ?></h1>
        <?php if (isset($message)) {
            echo $message;
        }
        ?>
        <div class="displayView">
            <?php
            if (isset($displayDetails)) {
                echo $thumbnailsImg;
                echo $displayDetails;
            }
            ?>
        </div>
        <h1>Price: $<?php echo number_format($vehicleDetail['invPrice'], 2) ?></h1>
    </main>
    <footer>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
    </footer>
</body>

</html>