<?php
namespace App\Filament\Resources\DapurResource\Pages;

use App\Filament\Resources\DapurResource;
use Filament\Resources\Pages\EditRecord;

class EditDapur extends EditRecord
{
    protected static string $resource = DapurResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
