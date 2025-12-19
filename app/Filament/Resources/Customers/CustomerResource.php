<?php

namespace App\Filament\Resources\Customers;

use BackedEnum;
use App\Models\Customer;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Actions\DeleteAction;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\Customers\Pages\ManageCustomers;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Users;
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $navigationLabel = 'Data Customer';
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('customer_code')
                    ->hiddenOn('edit')
                    ->copyable()
                    ->default(function () {
                        $kode = "CST" . strtoupper(Str::random(6));
                        return $kode;
                    })
                    ->readOnly()
                    ->unique('customers', 'customer_code', ignoreRecord: true),
                TextInput::make('name')
                    ->required()
                    ->string(),
                TextInput::make('phone')
                    ->required()
                    ->maxLength(14)
                    ->minLength(4),
                TextInput::make('address')
                    ->nullable()
                    ->string(),
                TextInput::make('note')
                    ->string()
                    ->nullable(),
            ])
            ->record(null);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customer_code')
                    ->label('Kode Customer')
                    ->copyable()
                    ->searchable()
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                TextColumn::make('phone')
                    ->label('Telepon')
                    ->copyable(),
                TextColumn::make('address')
                    ->label('Alamat')
                    ->copyable(),
                TextColumn::make('note')
                    ->label('Catatan'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->recordUrl(null);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageCustomers::route('/'),
        ];
    }
}
