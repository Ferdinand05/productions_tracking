<?php

namespace App\Filament\Resources\Productions\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Illuminate\Support\Str;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

class ProductionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make()
                    ->columnSpanFull()
                    ->columns([
                        'sm' => 1,
                        'md' => 2
                    ])
                    ->schema([
                        Select::make('customer_id')
                            ->relationship('customer', 'name')
                            ->preload()
                            ->label('Pilih Customer/Client')
                            ->required(),
                        TextInput::make('production_code')
                            ->hiddenOn('edit')
                            ->label('Kode Produksi ')
                            ->helperText('Dibuat Otomatis')
                            ->readOnly()
                            ->unique('productions', 'production_code', ignoreRecord: true)
                            ->default(function () {
                                return "PROD-" . now('Asia/Jakarta')->format('dmy') . strtoupper(Str::random(5));
                            }),
                        TextInput::make('product_name')
                            ->label('Nama Produk')
                            ->required()
                            ->placeholder('Contoh : Mukena')
                            ->string(),
                        TextInput::make('quantity_product')
                            ->label('Jumlah Produk')
                            ->helperText('Estimasi Jumlah Produk Jadi')
                            ->required()
                            ->suffix('Pcs')
                            ->numeric(),

                        DatePicker::make('start_date')
                            ->label('Tgl. Mulai Produksi')
                            ->default(function () {
                                return now('Asia/Jakarta');
                            })
                            ->required()
                            ->date(),
                        DatePicker::make('estimated_end_date')
                            ->label('Tgl. Estimasi Selesai Produksi')
                            ->required()
                            ->date(),
                        Textarea::make('description')
                            ->label('Deskripsi Produksi')
                            ->placeholder('Jelaskan produksi ini')
                            ->nullable()
                            ->string()

                    ]),
                Repeater::make('material_item')
                    ->required()
                    ->relationship('materials')
                    ->label('Daftar Bahan')
                    ->columnSpanFull()
                    ->schema([
                        Grid::make()
                            ->columns([
                                'sm' => 1,
                                'xl' => 4
                            ])
                            ->schema([
                                TextInput::make('material_name')
                                    ->label('Nama Bahan/Barang Mentah')
                                    ->required()
                                    ->placeholder('Contoh : Benang'),
                                TextInput::make('quantity')
                                    ->label('Jumlah')
                                    ->numeric()
                                    ->required(),
                                TextInput::make('unit')
                                    ->label('Satuan')
                                    ->placeholder('Contoh : pcs,roll,meter')
                                    ->required(),
                                TextInput::make('note')
                                    ->label('Catatan')
                                    ->helperText('Opsional')
                                    ->nullable()
                            ])
                    ]),

                Repeater::make('detail_stage')
                    ->relationship('stages')
                    ->label('Urutan Produksi')
                    ->reorderable()
                    ->default([
                        [
                            'stage_name' => "Desain Pola",
                            'description' => "Membuat sketsa desain awal untuk memvisualisasikan ide",
                        ],
                        [
                            'stage_name' => "Pemotongan Bahan",
                            'description' => "Memotong bahan sesuai pola yang telah dibuat",
                        ],
                        [
                            'stage_name' => "Penjahitan",
                            'description' => "Menyatukan potongan-potongan kain menggunakan mesin jahit sesuai dengan pola untuk membentuk pakaian.",
                        ],
                        [
                            'stage_name' => "Finishing",
                            'description' => "proses akhir seperti merapikan sisa benang, menyetrika, dan memastikan semua detail sudah sesuai.",
                        ],
                    ])
                    ->columnSpanFull()
                    ->schema([
                        Grid::make()
                            ->columns([
                                'sm' => 1,
                                'xl' => 2
                            ])
                            ->schema([
                                TextInput::make('stage_name')
                                    ->label('Nama Bagian Produksi')
                                    ->placeholder('Contoh : Desain Pola')
                                    ->required()
                                    ->string()
                                    ->reactive(),
                                TextArea::make('description')
                                    ->helperText('Opsional')
                                    ->label('Deskripsi')
                                    ->nullable()
                                    ->reactive()
                                    ->placeholder('Contoh : Pemotongan bahan dengan menggunakan mesin pemotong'),
                            ])
                    ])


            ]);
    }
}
