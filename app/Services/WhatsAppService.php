<?php

namespace App\Services;

use App\Models\BilliardRental;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    // Simplified - only use wa.me links

    /**
     * Generate WhatsApp wa.me link for receipt (no API integration)
     */
    public function sendReceipt(BilliardRental $rental, ReceiptService $receiptService): bool
    {
        $phoneNumber = $this->formatPhoneNumber($rental->customer_whatsapp);
        
        if (!$phoneNumber) {
            Log::warning('No WhatsApp number provided for rental: ' . $rental->transaction_number);
            return false;
        }

        try {
            // Just generate wa.me link - user will get it on success page
            $waLink = $this->generateWhatsAppLink($phoneNumber, $this->generateReceiptText($rental));
            Log::info('WhatsApp link generated: ' . $waLink);
            
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to generate WhatsApp link: ' . $e->getMessage());
            return false;
        }
    }


    /**
     * Generate WhatsApp link (wa.me) as fallback
     */
    public function generateWhatsAppLink(string $phoneNumber, string $message): string
    {
        $formattedNumber = $this->formatPhoneNumber($phoneNumber);
        $encodedMessage = urlencode($message);
        
        return "https://wa.me/{$formattedNumber}?text={$encodedMessage}";
    }

    /**
     * Format phone number for WhatsApp
     */
    private function formatPhoneNumber(?string $phoneNumber): ?string
    {
        if (!$phoneNumber) {
            return null;
        }
        
        // Remove all non-numeric characters
        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
        
        // Handle Indonesian phone numbers
        if (strpos($phoneNumber, '08') === 0) {
            $phoneNumber = '62' . substr($phoneNumber, 1);
        } elseif (strpos($phoneNumber, '8') === 0) {
            $phoneNumber = '62' . $phoneNumber;
        } elseif (strpos($phoneNumber, '0') === 0) {
            $phoneNumber = '62' . substr($phoneNumber, 1);
        }
        
        return $phoneNumber;
    }

    /**
     * Generate receipt text message
     */
    private function generateReceiptText(BilliardRental $rental): string
    {
        $message = "🎱 *BILLIARD RECEIPT* 🎱\n\n";
        $message .= "📋 Transaction: {$rental->transaction_number}\n";
        $message .= "👤 Customer: {$rental->customer_name}\n";
        $message .= "🎯 Table: {$rental->billiardTable->table_number}\n";
        $message .= "⏱️ Duration: {$rental->duration_hours} hours\n";
        $message .= "💰 Price/Hour: Rp " . number_format($rental->price_per_hour, 0, ',', '.') . "\n";
        $message .= "📊 Subtotal: Rp " . number_format($rental->subtotal, 0, ',', '.') . "\n";
        
        if ($rental->discount_amount > 0) {
            $message .= "🎁 Discount (10%): Rp " . number_format($rental->discount_amount, 0, ',', '.') . "\n";
        }
        
        $message .= "💳 *Total Amount: Rp " . number_format($rental->total_amount, 0, ',', '.') . "*\n\n";
        $message .= "📅 Date: " . $rental->created_at->format('d/m/Y H:i') . "\n";
        $message .= "📍 Status: " . ucfirst($rental->status) . "\n\n";
        $message .= "Thank you for choosing our billiard service! 🙏\n";
        $message .= "Coffee Shop Billiard";
        
        return $message;
    }

    /**
     * Get the wa.me link for manual sharing
     */
    public function getWhatsAppLinkForRental(BilliardRental $rental): string
    {
        $phoneNumber = $this->formatPhoneNumber($rental->customer_whatsapp);
        $message = $this->generateReceiptText($rental);
        
        return $this->generateWhatsAppLink($phoneNumber, $message);
    }
}
