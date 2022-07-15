<?php
if ($_SESSION['clientData']['clientLevel'] < 2) {
    header('location: /phpmotors/');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="/phpmotors/css/styles.css" type="text/css" media="screen">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Car Classification | PHP Motors - World's No.1 Car Site</title>
</head>

<body>
    <header>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>
    </header>
    <nav>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/nav.php' ?>
    </nav>
    <main>
        <h1>Add Car Classification</h1>
        <?php
        if (isset($message)) {
            echo $message;
        }
        ?>
        <form name="regForm" action="../vehicles/index.php" method="post">
            <div class="formPage">
                <label for="classificationName">classification Name</label>
                <input name="classificationName" id="classificationName" type="text" maxlength="30" <?php if (isset($classificationId['classificationName'])) {
                                                                                                        echo "value='$classificationId[classificationName]'";
                                                                                                    } ?> required>
                <input type="submit" name="AddClassification" value="Add Classification">
                <input type="hidden" name="action" value="addClass">
            </div>
        </form>
    </main>
    <footer>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
    </footer>
</body>

</html>