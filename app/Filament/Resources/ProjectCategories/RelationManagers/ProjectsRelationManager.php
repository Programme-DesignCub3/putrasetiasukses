<?php

namespace App\Filament\Resources\ProjectCategories\RelationManagers;

use App\Models\Project;
use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProjectsRelationManager extends RelationManager
{
    protected static string $relationship = 'projects';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitle(fn (Project $record): string => $record->name)
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('client')
                    ->label('Klien')
                    ->searchable(),
                TextColumn::make('completion_date')
                    ->label('Selesai')
                    ->dateTime()
                    ->sortable(),
                IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean(),
            ])
            ->headerActions([
                AttachAction::make()
                    ->recordTitle(fn (Project $record): string => $record->name)
                    ->preloadRecordSelect(),
            ])
            ->actions([
                EditAction::make(),
                DetachAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                ]),
            ]);
    }
}
