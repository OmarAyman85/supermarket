<?php

namespace SuperMarket\Helpers;

trait Uploader {
    protected function uploadImage(string $field = 'image', string $folder = 'general') : ?string {
        $imagePath = null;

        if (isset($_FILES[$field]) && $_FILES[$field]['error'] == 0) {

            // Base directory for uploads
            $baseDir = __DIR__ . '/../../Storage/Uploads';
            $targetDir = $baseDir . '/' . $folder;

            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            // Unique filename
            date_default_timezone_set('Africa/Cairo');
            $fileName = time() . "_" . basename($_FILES[$field]['name']);
            $targetFile = $targetDir . '/' . $fileName;

            // Validate file type
            $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $allowed = ["jpg", "jpeg", "png", "gif"];

            if (in_array($fileType, $allowed)) {
                if (move_uploaded_file($_FILES[$field]["tmp_name"], $targetFile)) {
                    // Store relative path (cleaner for DB/frontend)
                    $imagePath = '/uploads/' . $folder . '/' . $fileName;
                }
            }
        }

        return $imagePath;
    }
}
