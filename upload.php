<?php
// PackTrack Image Upload Proxy
// Lives on smartconfigurations.com/upload.php
// Proxies uploads to Nextcloud WebDAV

header('Access-Control-Allow-Origin: https://smartconfigurations.com');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Nextcloud credentials
$nc_user = 'ow9cg';
$nc_pass = 'k9KE?6a7m%66I';
$nc_base = 'https://smartconfigurations.com/nextcloud/remote.php/dav/files/ow9cg/packtrack_images';

// Get filename from POST
$filename = isset($_POST['filename']) ? preg_replace('/[^a-zA-Z0-9_\-]/', '', $_POST['filename']) : null;
if (!$filename) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing filename parameter']);
    exit;
}

// Handle file upload (from FormData multipart)
if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    $err = isset($_FILES['image']) ? $_FILES['image']['error'] : 'no file';
    http_response_code(400);
    echo json_encode(['error' => 'Upload error: ' . $err]);
    exit;
}

$tmpfile = $_FILES['image']['tmp_name'];
$filesize = $_FILES['image']['size'];

// Max 5MB
if ($filesize > 5 * 1024 * 1024) {
    http_response_code(400);
    echo json_encode(['error' => 'File too large (max 5MB)']);
    exit;
}

// Read the uploaded file
$image_data = file_get_contents($tmpfile);
if (!$image_data) {
    http_response_code(500);
    echo json_encode(['error' => 'Could not read uploaded file']);
    exit;
}

$target_url = $nc_base . '/' . $filename . '.jpg';

// PUT to Nextcloud via cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $target_url);
curl_setopt($ch, CURL_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURL_POSTFIELDS, $image_data);
curl_setopt($ch, CURL_USERPWD, $nc_user . ':' . $nc_pass);
curl_setopt($ch, CURL_HTTPHEADER, ['Content-Type: image/jpeg']);
curl_setopt($ch, CURL_RETURNTRANSFER, true);
curl_setopt($ch, CURL_TIMEOUT, 30);
curl_setopt($ch, CURL_SSL_VERIFYPEER, true);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curl_error = curl_error($ch);
curl_close($ch);

if ($http_code >= 200 && $http_code < 300) {
    echo json_encode(['success' => true, 'filename' => $filename]);
} else {
    http_response_code(502);
    echo json_encode([
        'error' => 'Nextcloud upload failed',
        'http_code' => $http_code,
        'curl_error' => $curl_error
    ]);
}
