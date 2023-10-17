<?php
$uploadDir = 'uploads/'; // Percorso alla cartella di upload

if ($_FILES['newImage'] && $_FILES['oldImage']) {
    $newImageFile = $_FILES['newImage'];
    $oldImageFile = $_FILES['oldImage'];

    $oldImageName = basename($oldImageFile['name']);
    $newImageName = basename($newImageFile['name']);

    // Rinomina l'immagine vecchia come oldversion1.1
    $oldImageNewName = 'oldversion1.1/' . $oldImageName;
    rename($uploadDir . $oldImageName, $uploadDir . $oldImageNewName);

    // Sposta la nuova immagine nella cartella di upload
    $newImagePath = $uploadDir . $newImageName;
    move_uploaded_file($newImageFile['tmp_name'], $newImagePath);

    $response = [
        'success' => true,
        'newImageSrc' => $newImagePath
    ];
} else {
    $response = [
        'success' => false
    ];
}

echo json_encode($response);
?>
