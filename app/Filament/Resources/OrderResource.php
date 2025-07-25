<?php
namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon  = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'Pesanan';
    protected static ?string $pluralLabel     = 'Pesanan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('customer_name')
                    ->label('Nama Konsumen')
                    ->required(),

                Forms\Components\TextInput::make('nomor_meja')
                    ->label('Nomor Meja')
                    ->required(),

                Forms\Components\Textarea::make('note')
                    ->label('Catatan')
                    ->rows(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Nama Konsumen')
                    ->searchable(), // ✅ tambahkan searchable

                Tables\Columns\TextColumn::make('nomor_meja')
                    ->label('Meja')
                    ->searchable(), // ✅ tambahkan searchable

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->searchable(), // ✅ tambahkan searchable

                Tables\Columns\TextColumn::make('status_makanan')
                    ->label('Status Makanan')
                    ->searchable(),

                Tables\Columns\TextColumn::make('total_harga')
                    ->label('Total Harga')
                    ->money('IDR'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d-m-Y H:i')
                    ->sortable(), // ✅ tambahkan sortable
            ])
            ->defaultSort('created_at', 'desc') // ✅ tampilkan data terbaru di atas
            ->filters([
                // Tambahkan filter jika perlu
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

                // Tables\Actions\Action::make('submit_makanan'),
                // ->label('Submit Makanan')
                // ->icon('heroicon-o-check-circle')
                // ->color('success')
                // ->action(function (Order $record) {
                //     $record->status_makanan = 'pesanan diterima';
                //     $record->save();
                // })
                // ->requiresConfirmation()
                // ->visible(fn(Order $record) => $record->status_makanan !== 'pesanan diterima'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit'   => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
