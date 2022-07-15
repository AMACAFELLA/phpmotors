<?php
if ($_SESSION['clientData']['clientLevel'] < 2) {
    header('location: /phpmotors/');
}

$classifList = '<label for="classificationId" hidden>Classification</label><br>';
$classifList .= '<select id="classificationId" name="classificationId">';

foreach ($classifications as $classification) {
    $classifList .= "<option value='$classification[classificationId]'";

    if (isset($classificationId)) {
        if ($classification['classificationId'] === $classificationId) {
            $classifList .= ' selected ';
        }
    }
    $classifList .= ">$classification[classificationName]</option>";
}

$classifList .= '</select>';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="/phpmotors/css/styles.css" type="text/css" media="screen">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Vechicle | PHP Motors - World's No.1 Car Site</title>
</head>

<body>
    <header>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>
    </header>
    <nav>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/nav.php' ?>
    </nav>

    <main>
        <h1>Add Vechicle</h1>
        <?php
        if (isset($message)) {
            echo $message;
        }
        ?>
        <form name="regForm" action="../vehicles/index.php" method="post">
            <div class="formPage">
                <?php echo $classifList; ?>
                <label for="invMake">Make:</label>
                <input type="text" id="invMake" name="invMake" <?php if (isset($invMake)) {
                                                                    echo "value='$invMake'";
                                                                } ?> required>
                <label for="invModel">Model:</label>
                <input type="text" id="invModel" name="invModel" <?php if (isset($invModel)) {
                                                                        echo "value='$invModel'";
                                                                    } ?> required>
                <label for="invDescription">Description:</label>
                <textarea type="text" id="invDescription" name="invDescription" required><?php if (isset($invDescription)) {
                                                                                                echo $invDescription;
                                                                                            } ?></textarea>
                <label for="invImage">Image:</label>
                <input type="text" id="invImage" name="invImage" <?php if (isset($invImage)) {
                                                                        echo "value='$invImage'";
                                                                    } ?> required>
                <label for="invThumbnail">Thumbnail:</label>
                <input type="text" id="invThumbnail" name="invThumbnail" <?php if (isset($invThumbnail)) {
                                                                                echo "value='$invThumbnail'";
                                                                            } ?> required>
                <label for="invPrice">Price:</label>
                <input type="text" id="invPrice" name="invPrice" <?php if (isset($invPrice)) {
                                                                        echo "value='$invPrice'";
                                                                    } ?> required>
                <label for="invStock">Stock:</label>
                <input type="text" id="invStock" name="invStock" <?php if (isset($invStock)) {
                                                                        echo "value='$invStock'";
                                                                    } ?> required>
                <label for="invColor">Color:</label>
                <input type="text" id="invColor" name="invColor" <?php if (isset($invColor)) {
                                                                        echo "value='$invColor'";
                                                                    } ?> required>
                <input type="submit" name="AddInventory" value="Add Classification">
                <input type="hidden" name="action" value="addVehicle">
            </div>
        </form>
    </main>
    <footer>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
    </footer>
</body>

</html>