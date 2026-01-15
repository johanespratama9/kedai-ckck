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
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Nama Konsumen')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->copyable()
                    ->copyMessage('Nama tersalin')
                    ->icon('heroicon-o-user'),

                Tables\Columns\TextColumn::make('phone')
                    ->label('No. HP')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('No. HP tersalin')
                    ->icon('heroicon-o-phone'),

                Tables\Columns\TextColumn::make('nomor_meja')
                    ->label('Meja')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->searchable()
                    ->limit(30)
                    ->tooltip(fn($record) => $record->keterangan)
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\BadgeColumn::make('approval_status')
                    ->label('Status Approval')
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
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Metode Bayar')
                    ->badge()
                    ->colors([
                        'success' => 'qris',
                        'warning' => 'transfer',
                        'info'    => 'cash',
                    ])
                    ->formatStateUsing(fn($state) => match ($state) {
                        'qris' => 'QRIS',
                        'transfer' => 'Transfer Bank',
                        'cash' => 'Cash',
                        default => $state ?? '-'
                    })
                    ->sortable(),

                Tables\Columns\ImageColumn::make('bukti_transfer')
                    ->label('Bukti Transfer')
                    ->disk('public')
                    ->defaultImageUrl(fn($record) => !$record->bukti_transfer ? null : null)
                    ->visibility('public')
                    ->visible(fn() => auth()->user()->role === 'admin')
                    ->square()
                    ->size(40),

                Tables\Columns\TextColumn::make('total_harga')
                    ->label('Total')
                    ->money('IDR')
                    ->sortable()
                    ->weight('bold')
                    ->color('success'),

                Tables\Columns\TextColumn::make('approvedBy.name')
                    ->label('Disetujui Oleh')
                    ->default('-')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->icon('heroicon-o-user-circle'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Order')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('approval_status')
                    ->label('Status Approval')
                    ->options([
                        'pending_approval' => '⏳ Pending',
                        'approved' => '✅ Approved',
                        'rejected' => '❌ Rejected',
                    ]),
                
                Tables\Filters\SelectFilter::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->options([
                        'qris' => 'QRIS',
                        'transfer' => 'Transfer Bank',
                        'cash' => 'Cash',
                    ]),
            ])
            ->actions([
                // Lihat Invoice
                Tables\Actions\Action::make('lihat_invoice')
                    ->label('Invoice')
                    ->icon('heroicon-o-document-text')
                    ->color('primary')
                    ->url(fn(Order $record) => route('order.invoice', $record->id))
                    ->openUrlInNewTab(),

                // Lihat Bukti Transfer (Admin only)
                Tables\Actions\Action::make('lihat_bukti')
                    ->label('Bukti')
                    ->icon('heroicon-o-photo')
                    ->color('info')
                    ->url(fn(Order $record) => $record->bukti_transfer ? asset('storage/' . $record->bukti_transfer) : null)
                    ->openUrlInNewTab()
                    ->visible(fn(Order $record) => 
                        $record->bukti_transfer !== null && 
                        auth()->user()->role === 'admin'
                    ),

                // Approval Actions Group
                Tables\Actions\ActionGroup::make([
                    // Approve Action
                    Tables\Actions\Action::make('approve')
                        ->label('Setujui')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Setujui Order')
                        ->modalDescription('Anda yakin ingin menyetujui order ini?')
                        ->modalSubmitActionLabel('Ya, Setujui')
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
                        ->label('Tolak')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->form([
                            Forms\Components\Textarea::make('rejection_reason')
                                ->label('Alasan Penolakan')
                                ->placeholder('Jelaskan alasan penolakan order...')
                                ->required()
                                ->minLength(5)
                                ->maxLength(500)
                                ->rows(3),
                        ])
                        ->modalSubmitActionLabel('Tolak Order')
                        ->action(function (Order $record, array $data) {
                            $record->update([
                                'approval_status'  => 'rejected',
                                'rejection_reason' => $data['rejection_reason'],
                                'approved_by'      => auth()->id(),
                            ]);
                        })
                        ->visible(fn(Order $record) => $record->approval_status === 'pending_approval'),

                    // View Detail
                    Tables\Actions\ViewAction::make()
                        ->label('Detail'),
                ])
                ->label('Aksi')
                ->icon('heroicon-o-ellipsis-vertical')
                ->button()
                ->color('gray'),
            ])
            ->bulkActions([
                // Remove bulk delete
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
