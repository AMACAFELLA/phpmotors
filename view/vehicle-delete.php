<?php
if ($_SESSION['clientData']['clientLevel'] < 2) {
    header('location: /phpmotors/');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="/phpmotors/css/styles.css" type="text/css" media="screen">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php if (isset($invInfo['invMake'])) {
                echo "Delete $invInfo[invMake] $invInfo[invModel]";
            } ?> | PHP Motors - World's No.1 Car Site</title>
</head>

<body>
    <header>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>
    </header>
    <nav>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/nav.php' ?>
    </nav>

    <main>
        <h1><?php if (isset($invInfo['invMake'])) {
                echo "Delete $invInfo[invMake] $invInfo[invModel]";
            } ?></h1>
        <?php
        if (isset($message)) {
            echo $message;
        }
        ?>
        <p>Confirm Vehicle Deletion. The delete is permanent.</p><br>
        <form name="regForm" action="../vehicles/index.php" method="post">
            <div class="formPage">
                <label for="invMake">Vehicle Make</label><br>
                <input type="text" readonly name="invMake" id="invMake" <?php
                                                                        if (isset($invInfo['invMake'])) {
                                                                            echo "value='$invInfo[invMake]'";
                                                                        } ?>><br>

                <label for="invModel">Vehicle Model</label><br>
                <input type="text" readonly name="invModel" id="invModel" <?php
                                                                            if (isset($invInfo['invModel'])) {
                                                                                echo "value='$invInfo[invModel]'";
                                                                            } ?>><br>

                <label for="invDescription">Vehicle Description</label><br>
                <textarea name="invDescription" readonly id="invDescription"><?php
                                                                                if (isset($invInfo['invDescription'])) {
                                                                                    echo $invInfo['invDescription'];
                                                                                }
                                                                                ?></textarea><br>

                <input type="submit" name="delete" value="Delete Vehicle">
                <input type="hidden" name="action" value="deleteVehicle">
                <input type="hidden" name="invId" value="<?php if (isset($invInfo['invId'])) {
                                                                echo $invInfo['invId'];
                                                            } ?>">
            </div>
        </form>
    </main>
    <footer>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
    </footer>
</body>

</html>