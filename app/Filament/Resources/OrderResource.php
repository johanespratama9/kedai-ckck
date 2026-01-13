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

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->check() && auth()->user()->name === 'admin';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('customer_name')
                    ->label('Nama Konsumen')
                    ->required(),

                Forms\Components\TextInput::make('phone')
                    ->label('No. HP')
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

                Tables\Columns\TextColumn::make('phone')
                    ->label('No. HP')
                    ->searchable(), // ✅ tambahkan searchable

                Tables\Columns\TextColumn::make('nomor_meja')
                    ->label('Meja')
                    ->searchable(), // ✅ tambahkan searchable
                Tables\Columns\TextColumn::make('keterangan')
                    ->label('keterangan')
                    ->searchable(), // ✅ tambahkan searchable

                Tables\Columns\BadgeColumn::make('approval_status')
                    ->label('Approval Status')
                    ->colors([
                        'warning' => 'pending_approval',
                        'success' => 'approved',
                        'danger'  => 'rejected',
                    ])
                    ->formatStateUsing(fn($state) => match ($state) {
                        'pending_approval' => '⏳ Pending',
                        'approved' => '✅ Approved',
                        'rejected' => '❌ Rejected',
                        default => $state
                    }),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status Pembayaran')
                    ->colors([
                        'primary' => 'submitted',
                        'danger'  => 'canceled',
                    ])
                    ->formatStateUsing(fn($state) => match ($state) {
                        'submitted' => 'Submitted',
                        'pending'   => 'Pending',
                        'canceled'  => 'Canceled',
                        'paid'      => null, // Hide paid status
                        default     => $state
                    })
                    ->visible(fn($record) => $record && $record->status && $record->status !== 'paid' && $record->status !== 'pending'),
                // Tables\Columns\BadgeColumn::make('status_makanan')
                //     ->label('Status Makanan')
                //     ->colors([
                //         'primary' => 'pesanan diterima',
                //         'warning' => 'pesanan sedang diproses',
                //         'success' => 'pesanan selesai',
                //     ]),

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

                // Approve Action
                Tables\Actions\Action::make('approve')
                    ->label('✅ Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Setujui Order')
                    ->modalDescription('Anda yakin ingin menyetujui order ini?')
                    ->action(function (Order $record) {
                        $record->update([
                            'approval_status' => 'approved',
                            'approved_at'     => now(),
                            'approved_by'     => auth()->id(),
                        ]);
                    })
                    ->visible(fn(Order $record) => $record->approval_status === 'pending_approval'),

                // Reject Action
                Tables\Actions\Action::make('reject')
                    ->label('❌ Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->form([
                        Forms\Components\Textarea::make('rejection_reason')
                            ->label('Alasan Penolakan')
                            ->placeholder('Jelaskan alasan penolakan order...')
                            ->required()
                            ->minLength(5)
                            ->maxLength(500),
                    ])
                    ->action(function (Order $record, array $data) {
                        $record->update([
                            'approval_status'  => 'rejected',
                            'rejection_reason' => $data['rejection_reason'],
                            'approved_by'      => auth()->id(),
                        ]);
                    })
                    ->visible(fn(Order $record) => $record->approval_status === 'pending_approval'),

                // Show status badge
                Tables\Actions\Action::make('view_status')
                    ->label(fn(Order $record) => match($record->approval_status) {
                        'approved' => '✅ Approved',
                        'rejected' => '❌ Rejected',
                        'pending_approval' => '⏳ Pending',
                        default => $record->approval_status
                    })
                    ->color(fn(Order $record) => match($record->approval_status) {
                        'approved' => 'success',
                        'rejected' => 'danger',
                        'pending_approval' => 'warning',
                        default => 'gray'
                    })
                    ->disabled()
                    ->icon(fn(Order $record) => match($record->approval_status) {
                        'approved' => 'heroicon-o-check-circle',
                        'rejected' => 'heroicon-o-x-circle',
                        'pending_approval' => 'heroicon-o-clock',
                        default => 'heroicon-o-question-mark-circle'
                    }),

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
