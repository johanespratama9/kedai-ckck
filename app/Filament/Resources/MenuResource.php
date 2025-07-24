<?php
namespace App\Filament\Resources;

use App\Filament\Resources\MenuResource\Pages;
use App\Models\Menu;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('foto')->directory('menus'),
                TextInput::make('nama')->required(),
                TextInput::make('kategori')->required(),
                TextInput::make('harga')->numeric()->required(),
                TextInput::make('stok')->numeric()->required(),
                Textarea::make('keterangan'),
                Toggle::make('status')->label('Aktif?')->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // ImageColumn::make('foto')
                //     ->disk('menus')
                //     ->size(80) // tambahkan ini agar thumbnail muncul
                //     ->url(fn($record) => $record->foto ? asset('storage/' . $record->foto) : null),

                TextColumn::make('foto')
                    ->label('Foto ')
                    ->html()
                    ->formatStateUsing(function ($state) {
                        return $state
                        ? '<img src="' . asset('storage/' . $state) . '" width="100"/>'
                        : '<span class="text-gray-400">Belum dibuat</span>';
                    }),

                TextColumn::make('nama')->searchable(),
                TextColumn::make('kategori'),
                TextColumn::make('harga'),
                TextColumn::make('stok'),
                ToggleColumn::make('status'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListMenus::route('/'),
            'create' => Pages\CreateMenu::route('/create'),
            'edit'   => Pages\EditMenu::route('/{record}/edit'),
        ];
    }
}
