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
    <title> Account Management | PHP Motors - World's No.1 Car Site</title>
</head>

<body>
    <header>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>
    </header>
    <nav>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/nav.php' ?>
    </nav>

    <main>
        <h1> Manage Account</h1>
        <p class="updatePage"> Update Account</p>
        <?php
        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
        }
        ?>
        <form name="regForm" action="../accounts/index.php" method="post">
            <div class="formPage">
                <label for="clientFirstname">First Name:</label>
                <input type="text" name="clientFirstname" id="clientFirstname" required value="<?php if (isset($_SESSION['clientData']['clientFirstname'])) {
                                                                                                    echo $_SESSION['clientData']['clientFirstname'];
                                                                                                } else if (isset($clientFirstname)) {
                                                                                                    echo $clientFirstname;
                                                                                                } ?>">
                <label for="clientLastname">Last Name:</label>
                <input type="text" name="clientLastname" id="clientLastname" required value="<?php if (isset($_SESSION['clientData']['clientLastname'])) {
                                                                                                    echo $_SESSION['clientData']['clientLastname'];
                                                                                                } else if (isset($clientLastname)) {
                                                                                                    echo $clientLastname;
                                                                                                } ?>">
                <label for="clientEmail">Email:</label>
                <input type="email" name="clientEmail" id="clientEmail" required value="<?php if (isset($_SESSION['clientData']['clientEmail'])) {
                                                                                            echo $_SESSION['clientData']['clientEmail'];
                                                                                        } else if (isset($clientEmail)) {
                                                                                            echo $clientEmail;
                                                                                        } ?>">

                <input type="submit" name="submit" value="Update Account">
                <input type="hidden" name="action" value="updateAccount">
                <input type="hidden" name="clientId" value="<?php echo $_SESSION['clientData']['clientId']; ?>">
            </div>
        </form>

        <h1>Update Password</h1>
        <?php
        if (isset($_SESSION['passwordMessage'])) {
            echo $_SESSION['passwordMessage'];
        }
        ?>
        <p class="updatePage">Passwords must be at least 8 characters and contain at least
            one number, one capital letter, and one special character.
        </p>
        <p class="updatePage">*Note your original password will be changed</p>
        <form name="regForm" action="../accounts/index.php" method="post">
            <div class="formPage">
                <label for="clientPassword">Password:</label>
                <input type="password" name="clientPassword" id="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">

                <input type="submit" name="submit" value="Update Password">
                <input type="hidden" name="action" value="updatePassword">
                <input type="hidden" name="clientId" value="<?php echo $_SESSION['clientData']['clientId']; ?>">
            </div>
        </form>
    </main>
    <footer>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
    </footer>
</body>

</html>