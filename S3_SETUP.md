# Amazon S3 Integration Setup

This application has been refactored to use Amazon S3 for file storage instead of local storage. This document explains how to set up and configure S3 integration.

## Prerequisites

1. AWS Account with S3 access
2. AWS S3 bucket created
3. AWS IAM user with S3 permissions

## Configuration

### 1. Environment Variables

Update your `.env` file with the following AWS S3 configuration:

```env
# Set filesystem disk to S3
FILESYSTEM_DISK=s3

# AWS S3 Configuration
AWS_ACCESS_KEY_ID=your_access_key_id
AWS_SECRET_ACCESS_KEY=your_secret_access_key
AWS_DEFAULT_REGION=your_region
AWS_BUCKET=your_bucket_name
AWS_USE_PATH_STYLE_ENDPOINT=false
```

### 2. AWS IAM Permissions

Ensure your IAM user has the following S3 permissions:

```json
{
    "Version": "2012-10-17",
    "Statement": [
        {
            "Effect": "Allow",
            "Action": [
                "s3:GetObject",
                "s3:PutObject",
                "s3:DeleteObject",
                "s3:ListBucket"
            ],
            "Resource": [
                "arn:aws:s3:::your_bucket_name",
                "arn:aws:s3:::your_bucket_name/*"
            ]
        }
    ]
}
```

## Features Implemented

### UploadToS3 Trait

A reusable trait (`app/UploadToS3.php`) has been created with the following methods:

- `uploadToS3($file, $path)` - Basic file upload to S3
- `uploadToS3WithOptions($file, $path, $options)` - Upload with custom options
- `getS3Url($path)` - Get signed URL for private files
- `deleteFromS3($path)` - Delete file from S3
- `existsInS3($path)` - Check if file exists in S3
- `uploadSelectionDocument($file, $type, $applicationId)` - Specialized method for selection documents

### Controller Integration

The `PelamarApplicantController` has been refactored to:

- Use the `UploadToS3` trait
- Replace local storage operations with S3 operations
- Generate signed URLs for secure file access
- Handle file uploads for portfolio and medical documents

### View Updates

All view files have been updated to:

- Use `attachment_url` instead of `Storage::url()`
- Display signed S3 URLs for secure file access
- Handle cases where files might not be available

## File Structure

Uploaded files are organized in S3 with the following structure:

```
selection-documents/
├── portfolio/
│   └── {application_id}_{timestamp}.{extension}
└── medical_checkup/
    └── {application_id}_{timestamp}.{extension}
```

## Security

- All file URLs are signed with temporary access (1 hour expiration)
- Files are stored in private S3 buckets
- Access is controlled through Laravel's authentication system

## Usage

To use the S3 functionality in other parts of the application:

```php
use App\UploadToS3;

class YourController extends Controller
{
    use UploadToS3;
    
    public function uploadFile(Request $request)
    {
        $file = $request->file('document');
        $path = $this->uploadToS3($file, 'your-folder/');
        
        // Get signed URL for viewing
        $url = $this->getS3Url($path);
        
        return response()->json(['url' => $url]);
    }
}
```

## Troubleshooting

1. **File not found errors**: Ensure AWS credentials are correct and bucket exists
2. **Permission denied**: Check IAM user permissions
3. **Signed URL not working**: Verify AWS region and bucket configuration
4. **Upload failures**: Check file size limits and S3 bucket policies