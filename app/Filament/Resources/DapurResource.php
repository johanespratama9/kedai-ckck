<?php
namespace App\Filament\Resources;

use App\Filament\Resources\DapurResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DapurResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon  = 'heroicon-o-fire';
    protected static ?string $navigationLabel = 'Dapur';
    protected static ?string $pluralLabel     = 'Pesanan Dapur';
    protected static ?string $navigationGroup = 'Operasional';

    public function getInfolistComponents(): array
    {
        return [
            ViewEntry::make('invoice')
                ->view('filament.resources.dapur-resource.invoice'),
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('customer_name')
                    ->label('Nama Konsumen')
                    ->disabled(),

                Forms\Components\TextInput::make('nomor_meja')
                    ->label('Nomor Meja')
                    ->disabled(),

                // Forms\Components\Textarea::make('note')
                //     ->label('Catatan')
                //     ->rows(2)
                //     ->disabled(),

                Forms\Components\Select::make('status_makanan')
                    ->label('Status Makanan')
                    ->options([
                        'pesanan sedang diproses' => 'pesanan sedang diproses',
                        'pesanan selesai'         => 'pesanan selesai',
                    ])
                    ->required(),
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
                    ->searchable(),

                Tables\Columns\TextColumn::make('nomor_meja')
                    ->label('Meja')
                    ->searchable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status'),

                Tables\Columns\BadgeColumn::make('status_makanan')
                    ->label('Status Makanan')
                    ->colors([
                        'primary' => 'pesanan diterima',
                        'warning' => 'pesanan sedang diproses',
                        'success' => 'pesanan selesai',
                    ])
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d-m-Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(fn(Order $record) => $record->status === 'paid'),
                Tables\Actions\Action::make('lihat_invoice')
                    ->label('Lihat Invoice')
                    ->icon('heroicon-o-document-text')
                    ->modalHeading(fn($record) => 'Invoice Order #' . $record->id)
                    ->modalContent(fn($record) => view('components.invoice', ['record' => $record]))
                    ->modalSubmitAction(false)
                    ->color('primary'),
            ])
            // Hilangkan DeleteBulkAction
            ->bulkActions([
                // Tidak ada DeleteBulkAction
            ]);
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->where('status', 'paid');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDapurs::route('/'),
            'edit'  => Pages\EditDapur::route('/{record}/edit'),
            // Hilangkan 'create' page
        ];
    }
}
