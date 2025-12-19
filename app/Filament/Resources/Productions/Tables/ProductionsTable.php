<?php

namespace App\Filament\Resources\Productions\Tables;

use App\Models\Production;
use App\Models\ProductionStage;
use Faker\Core\Color;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;

class ProductionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('production_code')
                    ->label("Kode")
                    ->copyable()
                    ->searchable(),
                TextColumn::make('customer.name')
                    ->label('Nama Customer')
                    ->copyable()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('product_name')
                    ->label('Produk')
                    ->searchable(),
                TextColumn::make('quantity_product')
                    ->label('Jumlah Produk')
                    ->suffix(' Pcs')
                    ->sortable(),
                TextColumn::make('description')
                    ->label('Deskripsi'),
                TextColumn::make('start_date')
                    ->label('Tgl. Mulai Produksi')
                    ->sortable()
                    ->date('d M, Y'),
                TextColumn::make('estimated_end_date')
                    ->label('Estimasi Selesai')
                    ->sortable()
                    ->date('d M, Y'),
                TextColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'draft' => 'gray',
                        'in_progress' => 'warning',
                        'completed' => 'success',
                    })
            ])
            ->recordUrl(null)
            ->filters([
                SelectFilter::make('customer_filter')
                    ->relationship('customer', 'name')

            ])
            ->recordActions([
                EditAction::make(),
                // open modal to show production stages
                Action::make('detail_tahap')
                    ->label('Tahap Produksi')
                    ->icon('heroicon-o-arrow-path')
                    ->color('success')
                    ->modalHeading('Tahap Produksi')
                    ->modalContent(fn(Production $record): View => view(
                        'filament.pages.tahap-produksi',
                        ['record' => $record->load('stages')],
                    ))
                    ->closeModalByClickingAway(false)
                    ->closeModalByEscaping(true)
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup'),
                // open modal to show production materials
                Action::make('detail_bahan')
                    ->label('Bahan')
                    ->icon('heroicon-o-cube')
                    ->color('warning')
                    ->modalHeading('Bahan Produksi')
                    ->modalContent(fn(Production $record): View => view(
                        'filament.pages.detail-bahan',
                        ['record' => $record->load('materials')]
                    ))->closeModalByClickingAway(false)
                    ->closeModalByEscaping(true)
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup'),

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
