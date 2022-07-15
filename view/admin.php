<?php
if (!isset($_SESSION['loggedin'])) {
    header('Location: /phpmotors/');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="/phpmotors/css/styles.css" type="text/css" media="screen">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Admin | PHP Motors - World's No.1 Car Site</title>
</head>

<body>
    <header>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>
    </header>
    <nav>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/nav.php' ?>
    </nav>
    <main>
        <h1><?php echo $_SESSION['clientData']['clientFirstname'] . " " . $_SESSION['clientData']['clientLastname']; ?></h1>
        <h2 class="subHeading">You are logged in</h2>
        <?php if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
        } ?>
        <ul>
            <li><span class=li>First Name: <?php echo $_SESSION['clientData']['clientFirstname']; ?></span></li>
            <li><span class=li>Last Name: <?php echo $_SESSION['clientData']['clientLastname']; ?></span></li>
            <li><span class=li> Email: <?php echo $_SESSION['clientData']['clientEmail']; ?></span></li>
        </ul>
        <h3 class="subHeading">Account Management</h3>
        <p class="inventoryParagraph">Use this link to update account information</p>
        <p class="inventoryParagraph"><a href="/phpmotors/accounts/index.php?action=update">Update Account Information</a></p>

        <?php if ($_SESSION['clientData']['clientLevel'] > 1) { ?>
            <h3 class="subHeading">Inventory Management</h3>
            <p class="inventoryParagraph">Use this link to manage the inventory</p>
            <p class="inventoryParagraph">
                <a href="/phpmotors/vehicles/">Vehicle Management</a>
            </p>
        <?php } ?>
    </main>
    <footer>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
    </footer>
</body>

</html>