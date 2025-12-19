<?php

namespace App\Filament\Resources\Invoices\Schemas;

use App\Models\Invoice;
use App\Models\Production;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

class InvoiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->schema([
                        TextInput::make('invoice_number')
                            ->label("Nomor Invoice")
                            ->default(function () {

                                $year = now()->year;

                                $lastInvoice = Invoice::query()
                                    ->whereYear('created_at', $year)
                                    ->orderBy('id', 'desc')
                                    ->first();

                                $lastNumber = 0;

                                if ($lastInvoice) {
                                    // ambil 4 digit terakhir
                                    $lastNumber = (int) substr($lastInvoice->invoice_number, -4);
                                }

                                $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

                                return "INV-{$year}-{$nextNumber}";
                            })
                            ->disabled()
                            ->dehydrated()
                            ->required(),

                        Select::make("customer_id")
                            ->relationship("customer", "name")
                            ->reactive()
                            ->searchable()
                            ->preload()
                            ->dehydrated()
                            ->required(),
                    ])
                    ->columnSpanFull(),
                DatePicker::make("invoice_date")
                    ->date()
                    ->label(fn() => new HtmlString(
                        '<span class="text-blue-600 font-semibold">Tanggal</span>'
                    ))
                    ->required()
                    ->default(now()),
                DatePicker::make("due_date")
                    ->date()
                    ->label("Tanggal Jatuh Tempo")
                    ->helperText("Boleh Kosong")
                    ->label(fn() => new HtmlString(
                        '<span class="text-blue-600 font-semibold">Tanggal Jatuh Tempo</span>'
                    ))
                    ->nullable(),
                Repeater::make('items')
                    ->relationship()
                    ->required()
                    ->columns(6)
                    ->schema([
                        TextInput::make('product_name')
                            ->required()
                            ->label("Nama Produk")
                            ->label(fn() => new HtmlString(
                                '<span class="text-blue-600 font-semibold">Nama Produk</span>'
                            )),
                        TextInput::make('color')
                            ->label(fn() => new HtmlString(
                                '<span class="text-blue-600 font-semibold">Warna</span>'
                            ))
                            ->helperText("Boleh Kosong")

                            ->nullable(),
                        TextInput::make('size')
                            ->label(fn() => new HtmlString(
                                '<span class="text-blue-600 font-semibold">Size/Ukuran</span>'
                            ))
                            ->helperText("Boleh Kosong")

                            ->nullable(),
                        TextInput::make('quantity')
                            ->numeric()
                            ->label(fn() => new HtmlString(
                                '<span class="text-blue-600 font-semibold">Quantity</span>'
                            ))
                            ->required()
                            ->live(onBlur: true),
                        TextInput::make('price')
                            ->label(fn() => new HtmlString(
                                '<span class="text-blue-600 font-semibold">Harga</span>'
                            ))
                            ->numeric()
                            ->live(onBlur: true)
                            ->required(),
                        TextInput::make('subtotal')
                            ->numeric()
                            ->placeholder(function (Get $get, Set $set) {
                                $quantity = $get("quantity");
                                $price = $get("price");

                                $set("subtotal", intval($price) * intval($quantity));
                            })
                            ->disabled()
                            ->reactive()
                            ->dehydrated(),
                    ])
                    ->columnSpanFull()
                    ->addActionLabel("+ Tambahkan Item")
                    ->label("Item"),

                Radio::make("status")
                    ->label(fn() => new HtmlString(
                        '<span class="text-blue-600 font-semibold">Pilih Status Nota</span>'
                    ))
                    ->options([
                        "draft" => "Draft",
                        "dp" => "DP",
                        "paid" => "Paid"
                    ])
                    ->default("draft"),
                Textarea::make("notes")
                    ->label(fn() => new HtmlString(
                        '<span class="text-blue-600 font-semibold">Catatan tambahan</span>'
                    ))
                    ->columnSpanFull()
                    ->helperText("Boleh Kosong")
                    ->string(),
                TextInput::make("grand_total")
                    ->label("Total")
                    ->numeric()
                    ->reactive()
                    ->placeholder(function (Get $get, Set $set) {

                        $items = $get("items");

                        if ($items) {
                            $subtotal = collect($items)->pluck("subtotal")->sum();
                            $set("grand_total", intval($subtotal));
                        }
                    })
                    ->disabled()
                    ->columnSpanFull()
                    ->dehydrated(),

            ]);
    }
}
