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
                    ->label('Status')
                    ->visible(false),

                Tables\Columns\BadgeColumn::make('approval_status')
                    ->label('Approval')
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

                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Metode Bayar')
                    ->formatStateUsing(fn($state) => $state ? strtoupper(str_replace('_', ' ', $state)) : '-')
                    ->badge()
                    ->color(fn($state) => $state ? 'success' : 'gray'),

                Tables\Columns\ImageColumn::make('bukti_transfer')
                    ->label('Bukti Transfer')
                    ->disk('public')
                    ->defaultImageUrl(fn($record) => !$record->bukti_transfer ? null : null)
                    ->visibility('public')
                    ->visible(fn() => auth()->user()->role === 'admin'),

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
                    ->visible(fn(Order $record) => 
                        $record->approval_status === 'pending_approval' && 
                        auth()->user()->role === 'admin'
                    ),
                
                Tables\Actions\Action::make('lihat_bukti')
                    ->label('Lihat Bukti')
                    ->icon('heroicon-o-photo')
                    ->color('info')
                    ->url(fn(Order $record) => $record->bukti_transfer ? asset('storage/' . $record->bukti_transfer) : null)
                    ->openUrlInNewTab()
                    ->visible(fn(Order $record) => 
                        $record->bukti_transfer !== null && 
                        auth()->user()->role === 'admin'
                    ),
                
                Tables\Actions\Action::make('lihat_invoice')
                    ->label('Lihat Invoice')
                    ->icon('heroicon-o-document-text')
                    ->url(fn(Order $record) => route('order.invoice', $record))
                    ->openUrlInNewTab()
                    ->color('primary'),

                // Dropdown Approval Actions - Hanya untuk Admin
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('approve_order')
                        ->label('✅ Setujui Order')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Setujui Order')
                        ->modalDescription('Anda yakin ingin menyetujui order ini?')
                        ->modalSubmitActionLabel('Ya, Setujui')
                        ->modalCancelActionLabel('Batal')
                        ->action(function (Order $record) {
                            $record->update([
                                'approval_status' => 'approved',
                                'approved_at'     => now(),
                                'approved_by'     => auth()->id(),
                                'status'          => 'paid',  // Set status ke paid saat diapprove
                                'paid_at'         => now(),
                                'status_makanan'  => 'pesanan diterima',
                            ]);
                        })
                        ->visible(fn(Order $record) => $record->approval_status === 'pending_approval'),

                    Tables\Actions\Action::make('reject_order')
                        ->label('❌ Tolak Order')
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
                ])
                    ->label('📋 Approval')
                    ->icon('heroicon-o-ellipsis-vertical')
                    ->color('warning')
                    ->visible(fn(Order $record) => 
                        $record->approval_status === 'pending_approval' && 
                        auth()->user()->role === 'admin'
                    ),
            ])
            // Hilangkan DeleteBulkAction
            ->bulkActions([
                // Tidak ada DeleteBulkAction
            ]);
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->where('status', '!=', 'pending')
            ->where('status', '!=', 'canceled')
            ->with(['orderItems.menu']);
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
