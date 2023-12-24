<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PropertyResource\Pages;
use App\Models\Property;
use Filament\Forms;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\FormsComponent;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->maxLength(65535),
                Forms\Components\TextInput::make('country')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('city')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('address')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('slider')
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->sortable()->searchable()->limit(12),
                Tables\Columns\TextColumn::make('country')->sortable()->searchable()->limit(12),
                Tables\Columns\TextColumn::make('city')->sortable()->searchable()->limit(12),
                Tables\Columns\TextColumn::make('address')->sortable()->searchable()->limit(12),
                Tables\Columns\TextColumn::make('status')->sortable()->searchable()->limit(12),
                Tables\Columns\TextColumn::make('type')->sortable()->searchable()->limit(12),
                Tables\Columns\TextColumn::make('created_at')->sortable()->searchable()->limit(12),
                Tables\Columns\TextColumn::make('updated_at')->sortable()->searchable()->limit(12),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
            ]);
    }

    public static function tableColumns(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->sortable()->searchable()->limit(12),
                Tables\Columns\TextColumn::make('country')->sortable()->searchable()->limit(12),
                Tables\Columns\TextColumn::make('city')->sortable()->searchable()->limit(12),
                Tables\Columns\TextColumn::make('address')->sortable()->searchable()->limit(12),
                Tables\Columns\TextColumn::make('status')->sortable()->searchable()->limit(12),
                Tables\Columns\TextColumn::make('type')->sortable()->searchable()->limit(12),
                Tables\Columns\TextColumn::make('created_at')->sortable()->searchable()->limit(12),
                Tables\Columns\TextColumn::make('updated_at')->sortable()->searchable()->limit(12),
                Tables\Columns\TextColumn::make('deleted_at')->sortable()->searchable()->limit(12),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProperties::route('/'),
            'create' => Pages\CreateProperty::route('/create'),
            'edit' => Pages\EditProperty::route('/{record}/edit'),
        ];
    }
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
