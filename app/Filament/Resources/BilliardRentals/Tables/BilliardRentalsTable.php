<?php

namespace App\Filament\Resources\BilliardRentals\Tables;

use Filament\Actions\Action;
use Filament\Tables\Contracts\HasTable; //
use Carbon\Carbon; //
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Illuminate\Support\Facades\App; //manggil pdf
use App\Models\BilliardRental; //model
use Filament\Actions\Action as ActionsAction;
use Filament\Actions\BulkActionGroup as ActionsBulkActionGroup;
use Filament\Actions\DeleteBulkAction as ActionsDeleteBulkAction;
use Filament\Actions\EditAction as ActionsEditAction;
use Filament\Actions\ViewAction as ActionsViewAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BilliardRentalsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('transaction_number')
                    ->label('Transaction')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('billiardTable.table_number')
                    ->label('Table')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('customer_name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('customer_whatsapp')
                    ->label('WhatsApp')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('rental_start')
                    ->label('Start Time')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('duration_hours')
                    ->label('Duration')
                    ->suffix(' hours')
                    ->sortable(),

                TextColumn::make('price_per_hour')
                    ->label('Rate/Hour')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('total_amount')
                    ->label('Total')
                    ->money('IDR')
                    ->sortable(),

                SelectColumn::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Menunggu',
                        'paid' => 'Lunas',
                        'rejected' => 'Ditolak',
                    ])
                    ->selectablePlaceholder(false)
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Menunggu Pembayaran',
                        'paid' => 'Lunas',
                        'rejected' => 'Ditolak',
                    ]),


                SelectFilter::make('billiard_table_id')
                    ->label('Table')
                    ->relationship('billiardTable', 'table_number')
                    ->searchable()
                    ->preload(),

                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from')
                            ->label('Dari Tanggal'),
                        DatePicker::make('created_until')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function ($query, array $data): void {
                        $query
                            ->when(
                                $data['created_from'],
                                fn($query, $date) => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn($query, $date) => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])

            ->recordActions([
                ActionsAction::make('download_invoice')
                    ->label('Invoice')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('success') // Warna tombol jadi hijau
                    ->action(function (BilliardRental $record) {

                        // 1. Muat relasi (pastikan data meja ada)
                        $record->loadMissing('billiardTable');

                        // 2. Buat PDF
                        $pdf = App::make('dompdf.wrapper');

                        // 3. Panggil template Anda di 'billiard.receipt-pdf'
                        $pdf->loadView('billiard.receipt-pdf', ['rental' => $record]);

                        // 4. Tentukan nama file
                        $fileName = 'invoice-' . $record->transaction_number . '.pdf';

                        // 5. Download file PDF di browser admin
                        return response()->streamDownload(
                            fn() => print($pdf->output()),
                            $fileName
                        );
                    })
                    // Hanya tampilkan tombol jika statusnya "paid" (Lunas)
                    ->visible(fn(BilliardRental $record): bool => $record->status === 'paid'),

                ActionsViewAction::make(),
                ActionsEditAction::make(),
            ])
            ->toolbarActions([
                ActionsBulkActionGroup::make([
                    ActionsDeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                Action::make('export_pdf')
                    ->label('Export Laporan (PDF)')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('danger')
                    ->action(function (HasTable $livewire) {

                        $query = $livewire->getFilteredTableQuery();

                        $rentals = $query->clone() // Clone query agar tidak bentrok
                            ->where('status', 'paid')
                            ->with('billiardTable')
                            ->get();

                        $grandTotal = $rentals->sum('total_amount');

                        // Cek jika filter tanggal ada
                        $filterData = $livewire->getTableFilterState('created_at');
                        $startDateRaw = $filterData['created_at']['created_from'] ?? null;
                        $endDateRaw = $filterData['created_at']['created_until'] ?? null;

                        $startDate = $startDateRaw ? Carbon::parse($startDateRaw)->format('d M Y') : 'Awal';
                        $endDate = $endDateRaw ? Carbon::parse($endDateRaw)->format('d M Y') : 'Hari Ini';

                        $pdf = App::make('dompdf.wrapper');

                        // Memanggil template laporan (pastikan Anda sudah buat file ini)
                        // Jika Anda menaruhnya di folder billiard, ganti jadi 'billiard.financial-report'
                        $pdf->loadView('billiard.financial-report', [
                            'rentals' => $rentals,
                            'grandTotal' => $grandTotal,
                            'startDate' => $startDate,
                            'endDate' => $endDate,
                        ]);

                        return response()->streamDownload(
                            fn() => print($pdf->output()),
                            'laporan-keuangan-' . $startDate . '-' . $endDate . '.pdf'
                        );
                    }),
            ]);
    }
}
