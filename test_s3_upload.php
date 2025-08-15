<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Testing\File;
use App\UploadToS3;

class TestUpload {
    use UploadToS3;
}

try {
    // Create a fake file for testing
    $fakeFile = File::fake()->create('test_document.pdf', 100);
    
    $testUpload = new TestUpload();
    $result = $testUpload->uploadSelectionDocument($fakeFile, 123, 'portfolio');
    
    if ($result) {
        echo "Upload successful: " . $result . "\n";
    } else {
        echo "Upload failed\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}