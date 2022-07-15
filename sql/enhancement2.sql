/* N0.1 */
INSERT INTO clients (
        clientFirstname,
        clientLastname,
        clientEmail,
        clientPassword,
        comment
    )
VALUES (
        'Tony',
        'Stark',
        'tony@starkent.com',
        'Iam1ronM@n',
        'I am the real Ironman'
    );
/* N0.2 */
UPDATE clients
SET clientLevel = 3
WHERE clientId = 2;
/* N0.3 */
UPDATE inventory
SET invDescription = replace(
        invDescription,
        'small interiors',
        'spacious interior'
    )
WHERE invModel = 'Hummer';
/* N0.4 */
SELECT inventory.invModel,
    carclassification.classificationName
FROM inventory
    INNER JOIN carclassification ON inventory.classificationId = carclassification.classificationId
WHERE carclassification.classificationName = "SUV";
/* N0.5 */
DELETE FROM inventory
WHERE invId = 1;
/* N0.6 */
UPDATE inventory
SET invImage = concat("/phpmotors", invImage),
    invThumbnail = concat("/phpmotors", invThumbnail);