<div class="header__hero">
    <img src="/phpmotors/images/site/logo.png" alt="PHP_Motors_Logo" id="logo">
    <?php
    if (isset($_SESSION['loggedin'])) {
        echo "<a href='/phpmotors/accounts/' class='loggedInUser'> Welcome " . $_SESSION['clientData']['clientFirstname'] . " | </a>"
            . "<a href='/phpmotors/accounts/index.php?action=logout' class='loggedInUser'>Logout</a>";
    } else {
        echo "<a href='/phpmotors/accounts/index.php?action=login' id='account'>My Account</a>";
    }
    echo '<a class="searchIcon" href="/phpmotors/search/index.php?action=searchPage">
        <img src="/phpmotors/images/site/search.png" alt="Search Icon">
    </a>';
    ?>
</div>