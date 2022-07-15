<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="/phpmotors/css/styles.css" type="text/css" media="screen">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Account Registration | PHP Motors - World's No.1 Car Site</title>
</head>

<body>
    <header>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>
    </header>
    <nav>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/nav.php' ?>
    </nav>
    <main>
        <h1>Register</h1>
        <?php
        if (isset($message)) {
            echo $message;
        }
        ?>
        <form name="regForm" action="../accounts/index.php" method="post">
            <div class="formPage">
                <label for="clientFirstname">First Name:</label>
                <input name="clientFirstname" id="clientFirstname" type="text" <?php if (isset($clientFirstname)) {
                                                                                    echo "value='$clientFirstname'";
                                                                                } ?> required>
                <label for="clientLastname">Last Name:</label>
                <input name="clientLastname" id="clientLastname" type="text" <?php if (isset($clientLastname)) {
                                                                                    echo "value='$clientLastname'";
                                                                                } ?> required>
                <label for="clientEmail">Email:</label>
                <input name="clientEmail" id="clientEmail" type="email" <?php if (isset($clientEmail)) {
                                                                            echo "value='$clientEmail'";
                                                                        } ?> required>
                <label for="clientPassword">Password:</label>
                <span class="formParagraph">Passwords must be at least 8 characters and contain at least
                    one number, one capital letter, and one special character.
                </span>
                <input name="clientPassword" id="clientPassword" type="password" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
                <input type="submit" name="submit" value="Register">
                <input type="hidden" name="action" value="registration">
            </div>
        </form>
    </main>
    <footer>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
    </footer>
</body>

</html>