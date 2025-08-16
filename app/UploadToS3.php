<?php

namespace App;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

trait UploadToS3
{
    /**
     * Upload file to S3 bucket
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param string|null $filename
     * @return string|false
     */
    public function uploadToS3(UploadedFile $file, string $directory, string $filename = null)
    {
        try {
            // Generate filename if not provided
            if (!$filename) {
                $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            }

            // Ensure directory doesn't start with slash
            $directory = ltrim($directory, '/');
            
            // Create full path
            $path = $directory . '/' . $filename;

            // Upload to S3
            $uploaded = Storage::disk('s3')->put($path, file_get_contents($file));

            if ($uploaded) {
                return $path;
            }

            return false;
        } catch (\Exception $e) {
            Log::error('S3 Upload Error: ' . $e->getMessage(), [
                'file' => $file->getClientOriginalName(),
                'directory' => $directory,
                'options' => $options,
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * Upload file to S3 with custom options
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param array $options
     * @return string|false
     */
    public function uploadToS3WithOptions(UploadedFile $file, string $directory, array $options = [])
    {
        try {
            // Default options
            $defaultOptions = [
                'visibility' => 'private',
                'filename' => null,
                'prefix' => '',
            ];

            $options = array_merge($defaultOptions, $options);

            // Generate filename if not provided
            $filename = $options['filename'] ?? (time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension());
            
            // Add prefix if provided
            if ($options['prefix']) {
                $filename = $options['prefix'] . '_' . $filename;
            }

            // Ensure directory doesn't start with slash
            $directory = ltrim($directory, '/');
            
            // Create full path
            $path = $directory . '/' . $filename;

            // Upload to S3
            $uploaded = Storage::disk('s3')->putFileAs(
                $directory,
                $file,
                $filename
            );

            if ($uploaded) {
                // Set visibility if specified
                if ($options['visibility'] === 'public') {
                    Storage::disk('s3')->setVisibility($uploaded, 'public');
                }
                return $uploaded;
            }

            return false;
        } catch (\Exception $e) {
            Log::error('S3 Upload WithOptions Error: ' . $e->getMessage(), [
                'file' => $file->getClientOriginalName(),
                'directory' => $directory,
                'filename' => $filename ?? 'auto-generated',
                'options' => $options,
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * Get S3 file URL
     *
     * @param string $path
     * @param bool $temporary
     * @param int $expiration
     * @return string|null
     */
    public function getS3Url(string $path, bool $temporary = false, ?int $expiration = 3600)
    {
        try {
            if ($temporary) {
                // Generate temporary signed URL
                return Storage::disk('s3')->temporaryUrl($path, now()->addSeconds($expiration ?? 3600));
            } else {
                // Get permanent URL (for public files)
                return Storage::disk('s3')->url($path);
            }
        } catch (\Exception $e) {
            Log::error('S3 URL Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Delete file from S3
     *
     * @param string $path
     * @return bool
     */
    public function deleteFromS3(string $path)
    {
        try {
            return Storage::disk('s3')->delete($path);
        } catch (\Exception $e) {
            Log::error('S3 Delete Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Check if file exists in S3
     *
     * @param string $path
     * @return bool
     */
    public function existsInS3(string $path)
    {
        try {
            return Storage::disk('s3')->exists($path);
        } catch (\Exception $e) {
            Log::error('S3 Exists Check Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Upload selection document to S3
     *
     * @param UploadedFile $file
     * @param int $applicantId
     * @param string $stage
     * @return string|false
     */
    public function uploadSelectionDocument(UploadedFile $file, int $applicantId, string $stage)
    {
        $directory = "selections/applicant_{$applicantId}";
        // Use UUID for filename to ensure uniqueness and security
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        
        $path = $this->uploadToS3WithOptions($file, $directory, [
            'filename' => $filename,
            'visibility' => 'public'
        ]);
        
        if ($path) {
            // Return full URL with base domain
            return 'https://is3.cloudhost.id/utcareers/' . $path;
        }
        
        return false;
    }

    /**
     * Get selection document URL from stored path
     *
     * @param string $path
     * @param int $expiration
     * @return string|null
     */
    public function getSelectionDocumentUrl(string $path, int $expiration = 3600)
    {
        return $this->getS3Url($path, true, $expiration);
    }
}
