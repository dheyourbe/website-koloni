<?php

namespace App\Services;

use App\Models\BilliardRental;
use Barryvdh\DomPDF\Facade\Pdf;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;

class ReceiptService
{
    public function generateReceipt(BilliardRental $rental): array
    {
        $pdfPath = $this->generatePdf($rental);
        $imagePath = $this->convertPdfToImage($pdfPath, $rental);

        // Update the rental with file paths
        $rental->update([
            'receipt_pdf_path' => $pdfPath,
            'receipt_image_path' => $imagePath,
        ]);

        return [
            'pdf_path' => $pdfPath,
            'image_path' => $imagePath,
        ];
    }

    private function generatePdf(BilliardRental $rental): string
    {
        $pdf = Pdf::loadView('billiard.receipt-pdf', compact('rental'));
        
        $filename = 'receipts/' . $rental->transaction_number . '.pdf';
        Storage::disk('public')->put($filename, $pdf->output());
        
        return $filename;
    }

    private function convertPdfToImage(string $pdfPath, BilliardRental $rental): string
    {
        try {
            // Create image manager with GD driver
            $manager = new ImageManager(new Driver());
            
            // For now, we'll create an image using HTML2Canvas-like approach
            // Since we don't have Imagick, we'll create a receipt image manually
            $image = $this->createReceiptImage($rental);
            
            $filename = 'receipts/' . $rental->transaction_number . '.png';
            Storage::disk('public')->put($filename, $image);
            
            return $filename;
        } catch (\Exception $e) {
            // Fallback to just using PDF if image conversion fails
            return $pdfPath;
        }
    }

    private function createReceiptImage(BilliardRental $rental): string
    {
        // Create a simple receipt image using GD
        $width = 400;
        $height = 600;
        $image = imagecreate($width, $height);
        
        // Colors
        $white = imagecolorallocate($image, 255, 255, 255);
        $black = imagecolorallocate($image, 0, 0, 0);
        $gray = imagecolorallocate($image, 128, 128, 128);
        
        // Background
        imagefill($image, 0, 0, $white);
        
        // Header
        imagestring($image, 5, 120, 20, 'BILLIARD RECEIPT', $black);
        imagestring($image, 3, 100, 50, 'Coffee Shop Billiard', $gray);
        
        // Transaction details
        $y = 100;
        imagestring($image, 3, 20, $y, 'Transaction: ' . $rental->transaction_number, $black);
        $y += 30;
        imagestring($image, 3, 20, $y, 'Customer: ' . $rental->customer_name, $black);
        $y += 30;
        imagestring($image, 3, 20, $y, 'Table: ' . $rental->billiardTable->table_number, $black);
        $y += 30;
        imagestring($image, 3, 20, $y, 'Duration: ' . $rental->duration_hours . ' hours', $black);
        $y += 30;
        imagestring($image, 3, 20, $y, 'Price/Hour: Rp ' . number_format($rental->price_per_hour), $black);
        $y += 30;
        imagestring($image, 3, 20, $y, 'Subtotal: Rp ' . number_format($rental->subtotal), $black);
        
        if ($rental->discount_amount > 0) {
            $y += 30;
            imagestring($image, 3, 20, $y, 'Discount: Rp ' . number_format($rental->discount_amount), $black);
        }
        
        $y += 30;
        imagestring($image, 4, 20, $y, 'Total: Rp ' . number_format($rental->total_amount), $black);
        
        $y += 50;
        imagestring($image, 3, 20, $y, 'Status: ' . ucfirst($rental->status), $black);
        $y += 30;
        imagestring($image, 3, 20, $y, 'Date: ' . $rental->created_at->format('d/m/Y H:i'), $black);
        
        // Convert to string
        ob_start();
        imagepng($image);
        $imageString = ob_get_clean();
        imagedestroy($image);
        
        return $imageString;
    }

    public function getReceiptUrl(BilliardRental $rental, string $type = 'pdf'): ?string
    {
        $path = $type === 'image' ? $rental->receipt_image_path : $rental->receipt_pdf_path;
        
        if (!$path) {
            return null;
        }
        
        return Storage::disk('public')->url($path);
    }
}
