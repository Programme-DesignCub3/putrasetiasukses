<?php

namespace App\Filament\Resources\ContactMessages\Tables;

use App\Models\ContactMessage;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ContactMessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('admin.table.contact_message.name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->label(__('admin.table.contact_message.phone'))
                    ->searchable(),
                TextColumn::make('subject')
                    ->label(__('admin.table.contact_message.subject'))
                    ->searchable()
                    ->limit(48)
                    ->wrap(),
                IconColumn::make('read_at')
                    ->label(__('admin.table.contact_message.read'))
                    ->boolean()
                    ->state(fn ($record): bool => filled($record->read_at)),
                TextColumn::make('created_at')
                    ->label(__('admin.table.contact_message.received'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                TernaryFilter::make('read_at')
                    ->label(__('admin.table.contact_message.status'))
                    ->nullable()
                    ->trueLabel(__('admin.table.contact_message.read_true'))
                    ->falseLabel(__('admin.table.contact_message.read_false')),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                Action::make('toggleRead')
                    ->label(fn (ContactMessage $record): string => filled($record->read_at)
                        ? __('admin.table.contact_message.mark_unread')
                        : __('admin.table.contact_message.mark_read'))
                    ->icon(fn (ContactMessage $record): string => filled($record->read_at)
                        ? 'heroicon-o-envelope'
                        : 'heroicon-o-envelope-open')
                    ->action(fn (ContactMessage $record) => $record->update([
                        'read_at' => filled($record->read_at) ? null : now(),
                    ])),
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
