<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="/phpmotors/css/styles.css" type="text/css" media="screen">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search | PHP Motors - World's No.1 Car Site</title>
</head>

<body>
    <header>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>
    </header>
    <nav>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/nav.php' ?>
    </nav>
    <main>
        <h1>search</h1>
        <?php
        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
        }
        ?>
        <form name="searchForm" action="../search/index.php" method="post">
            <div class="formPage">
                <label for="searchTerm">What are you looking for today?</label>
                <input type="text" name="searchTerm" id="searchTerm" <?php if (isset($searchTerm)) {
                                                                            echo "value='$searchTerm'";
                                                                        }  ?>required>
                <input type="submit" value="Search">
                <input type="hidden" name="action" value="search">
            </div>
        </form>

        <?php
        if (isset($countSearch)) {
            echo "<h2>Returned $countSearch results for: $searchTerm</h2>";
        }

        if (isset($searchDisplay)) {
            echo $searchDisplay;
        }
        
        if (isset($pagi)) {
            echo $pagi;
        }
        ?>
    </main>
    <footer>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
    </footer>
</body>

</html>