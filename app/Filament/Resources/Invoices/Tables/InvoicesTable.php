<?php

namespace App\Filament\Resources\Invoices\Tables;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;

class InvoicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("invoice_number")
                    ->label("Nomor Invoice")
                    ->copyable()
                    ->searchable()
                    ->sortable(),
                TextColumn::make("status")
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'dp' => 'warning',
                        'draft' => 'info',
                        'paid' => 'success',
                    })
                    ->sortable(),
                TextColumn::make("customer.name")
                    ->label("Nama")
                    ->searchable(),
                TextColumn::make("invoice_date")
                    ->label("Tanggal")
                    ->sortable(),
                TextColumn::make("due_date")
                    ->label("Tgl. Jatuh Tempo"),

                TextColumn::make("notes")
                    ->label("catatan")
                    ->wrap(),
                TextColumn::make("grand_total")
                    ->label("Total")
                    ->sortable()
                    ->numeric()
                    ->money("IDR", 0, "id", 0),

            ])
            ->recordUrl(null)
            ->filters([
                SelectFilter::make("select_customer")
                    ->relationship("customer", "name")
                    ->preload()
            ])
            ->recordActions([
                Action::make("print")
                    ->label("PDF")
                    ->icon(Heroicon::Printer)
                    ->color("secondary")
                    ->action(function (Invoice $invoice) {
                        $pdf = Pdf::loadView('pdf.invoice', compact('invoice'))
                            ->setPaper('a4');

                        return response()->streamDownload(
                            function () use ($pdf) {
                                echo $pdf->output();
                            },
                            "invoice-{$invoice->invoice_number}.pdf"
                        );
                    }),
                Action::make("detail_invoice")
                    ->label("Detail")
                    ->color("success")
                    ->icon(Heroicon::Eye)
                    ->modalHeading('Detail Invoice')
                    ->modalContent(fn(Invoice $record): View => view(
                        'modal.modal-invoice',
                        ['invoice' => $record->load("customer")],
                    ))
                    ->closeModalByClickingAway(false)
                    ->closeModalByEscaping(true)
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup'),
                EditAction::make(),
                // DeleteAction::make()

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
