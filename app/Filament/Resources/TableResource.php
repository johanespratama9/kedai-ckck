<?php
namespace App\Filament\Resources;

use App\Filament\Resources\TableResource\Pages;
use App\Models\Table;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table as TablesTable;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TableResource extends Resource
{
    protected static ?string $model          = Table::class;
    protected static ?string $navigationIcon = 'heroicon-o-table-cells';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nomor_meja')
                    ->required()
                    ->unique(ignoreRecord: true),
            ]);
    }

    public static function table(TablesTable $table): TablesTable
    {
        return $table
            ->columns([
                TextColumn::make('nomor_meja')->label('Nomor Meja'),
                ImageColumn::make('qr_code_path')
                    ->disk('public')
                    ->label('QR Code')
                    ->size(100),
            ])

            ->actions([
                Tables\Actions\EditAction::make(),

                Action::make('generate_qr')
                    ->label('Generate QR')
                // ->icon('heroicon-0-qrcode')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $url      = url('/order?meja=' . $record->nomor_meja);
                        $fileName = 'qrcodes/meja_' . $record->nomor_meja . '.svg';

                        Storage::disk('public')->put(
                            $fileName,
                            QrCode::format('svg')->size(300)->generate($url)
                        );

                        $record->qr_code_path = $fileName;
                        $record->save();

                    })
                    ->successNotificationTitle('QR Code berhasil dibuat!'),
                Action::make('download_qr')
                    ->action(function (Table $record) {
                        $url      = url('/order?meja=' . $record->nomor_meja);
                        $fileName = 'qrcodes/meja_' . $record->nomor_meja . '.svg';

                        Storage::disk('public')->put(
                            $fileName,
                            \QrCode::format('svg')->size(300)->generate($url)
                        );

                        $record->qr_code_path = $fileName;
                        $record->save();
                    }),

            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListTables::route('/'),
            'create' => Pages\CreateTable::route('/create'),
            'edit'   => Pages\EditTable::route('/{record}/edit'),
        ];
    }
}
