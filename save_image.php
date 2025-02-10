<?php
header('Content-Type: application/json');

// Ensure the image-download folder exists
$folder = 'image-download';
if (!is_dir($folder)) {
    mkdir($folder, 0777, true);
}

// Get the raw POST data
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['imageData']) && isset($data['imageName'])) {
    $imageData = $data['imageData'];
    $imageName = $data['imageName'];

    // Decode the base64 image data
    $imageData = base64_decode($imageData);

    // Save the image to the folder
    $filePath = $folder . '/' . $imageName;
    if (file_put_contents($filePath, $imageData)) {
        echo json_encode(['success' => true, 'filePath' => $filePath]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to save image.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request.']);
}
?>