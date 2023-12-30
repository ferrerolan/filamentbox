<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Home;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Tabs;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\HomeResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\HomeResource\RelationManagers;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class HomeResource extends Resource
{
    protected static ?string $model = Home::class;

    protected static ?string $navigationGroup = 'Config';
    protected static ?string $navigationLabel = 'Edit Site';


    protected static ?string $navigationIcon = 'heroicon-o-document';

    public static function form(Form $form): Form
    {
        return $form->schema(
            Tabs::make('Home')
                ->tabs([
                    Tabs\Tab::make('title')
                        ->columns(12)
                        ->schema([
                            Forms\Components\TextInput::make('title')
                                ->columnSpan(12)
                                ->required()
                                ->maxLength(255),
                            Forms\Components\RichEditor::make('description')
                                ->columnSpan(12)
                                ->required()
                                ->maxLength(255),
                        ]),
                    Tabs\Tab::make('SEO')
                        ->columns(12)
                        ->schema([
                            Forms\Components\TextInput::make('seo_title')
                                ->columnSpan(12)
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('seo_description')
                                ->columnSpan(12)
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('seo_keywords')
                                ->columnSpan(12)
                                ->required()
                                ->maxLength(255),
                        ]),
                    Tabs\Tab::make('Media')
                        ->schema([
                            SpatieMediaLibraryFileUpload::make('image')
                                ->collection('homes')
                                ->columnSpan(06)
                                ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                                    return (string) str($file->getClientOriginalName())->prepend('home-page-');
                                })
                                ->collection('seo')
                                ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                                    return (string) str($file->getClientOriginalName())->prepend('box-unit-');
                                })
                        ])->columns(12),
                ])
        );
    }




    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('description'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListHomes::route('/'),
            'create' => Pages\CreateHome::route('/create'),
            'edit' => Pages\EditHome::route('/{record}/edit'),
        ];
    }
}
