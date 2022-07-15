<?php
/* 
This is the search model
*/
function searchInventory($searchTerm)
{
    // Create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    // The SQL statement to search the inventory table for the search term
    $sql = "SELECT * FROM inventory JOIN images ON inventory.invId = images.invId WHERE ((imgName LIKE '%-tn%') AND (imgPrimary = 1)) AND ((invMake LIKE :searchTerm) OR (invColor LIKE :searchTerm) OR (invModel LIKE :searchTerm) OR (invDescription LIKE :searchTerm));";
    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    // The next four lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
    // Execute the SQL
    $stmt->execute();
    // Return the result set
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $rows;
}