<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PropertyResource\Pages;
use App\Filament\Resources\PropertyResource\RelationManagers;
use App\Models\Property;
use Faker\Extension\CountryExtension;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Tabs;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\TemporaryUploadedFile;
use Squire\Models\Country;

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static ?string $modelLabel = 'UnitBox';
    protected static ?string $pluralModelLabel = 'Unit - Box';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form->schema(
            Tabs::make('Heading')
                ->tabs([
                    Tabs\Tab::make('Profile')
                        ->columns(12)
                        ->schema([
                            Forms\Components\TextInput::make('title')
                                ->columnSpan(12)
                                ->required()
                                ->maxLength(255),
                            Forms\Components\RichEditor::make('description')
                                ->columnSpan(12)
                                ->required()
                                ->maxLength(65535),
                            Select::make('country')
                                ->label('Land')
                                ->options(Country::all()->pluck('name', 'name'))
                                ->searchable()
                                ->columnSpan(6)
                                ->required(),
                            Forms\Components\TextInput::make('city')
                                ->columnSpan(6)
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('address')
                                ->columnSpan(6)
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('price')
                                ->columnSpan(3)
                                ->required(),
                            Forms\Components\Toggle::make('slider')
                                ->columnSpan(2)
                                ->required(),
                            Forms\Components\Toggle::make('visible')
                                ->columnSpan(4)
                                ->required(),
                            Forms\Components\DatePicker::make('start_date')
                                ->columnSpan(2),
                            Forms\Components\DatePicker::make('end_date')
                                ->columnSpan(2),
                            Forms\Components\Toggle::make('active')
                                ->columnSpan(2),
                        ]),
                    Tabs\Tab::make('Website Images')
                        ->schema([
                            SpatieMediaLibraryFileUpload::make('Products')
                                ->image()
                                ->multiple()
                                ->enableReordering()
                                ->collection('hauptbilder')
                                ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                                    return (string) str($file->getClientOriginalName())->prepend('real-invest-');
                                })
                                ->columnSpan(6),
                            SpatieMediaLibraryFileUpload::make('Main Page')
                                ->image()
                                ->collection('slider')
                                ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                                    return (string) str($file->getClientOriginalName())->prepend('unit-box-');
                                })
                                ->columnSpan(6),
                        ])->columns(12),
                ])
        );




    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->sortable()->searchable()
                    ->limit(10)
                    ->tooltip(fn (Model $record): string => "{$record->title}"),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Changed')
                    ->sortable()
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->extraAttributes(['class' => 'bg-gray-200 dark:bg-primary-600']),
                Tables\Columns\SpatieMediaLibraryImageColumn::make('Hauptbild')
                    ->collection('hauptbilder')
                    ->conversion('thumb-hauptbild')
                    ->width(60)
                    ->height(80)
                    ->visibleFrom('sm'),
                Tables\Columns\TextColumn::make('country')
                    ->label('Land')
                    ->sortable()->searchable()
                    ->limit(15)
                    ->tooltip(fn (Model $record): string => "{$record->country}"),
                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
                    ->sortable()
                    ->alignRight(),
                Tables\Columns\BooleanColumn::make('slider')
                    ->visibleFrom('md'),
                Tables\Columns\SpatieMediaLibraryImageColumn::make('Sliderbild')
                    ->collection('slider')
                    ->conversion('thumb-slider')
                    ->width(140)
                    ->height(80)
                    ->visibleFrom('md')
                    ->visible('xl'),
            ])->defaultSort('updated_at', 'desc')
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProperties::route('/'),
            'create' => Pages\CreateProperty::route('/create'),
            'edit' => Pages\EditProperty::route('/{record}/edit'),
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