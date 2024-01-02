<?php

namespace App\Filament\Resources;

use App\Enums\ProductTypeEnum;
use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationGroup = 'Work';

    public static function form(Form $form): Form
    { 
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('')
                            ->schema([
                                Forms\Components\TextInput::make('name'),
                                Forms\Components\TextInput::make('slug'),
                                Forms\Components\MarkdownEditor::make('description')
                                    ->columnSpan('full')
                            ])->columns(2),

                            Forms\Components\Section::make('Pricing & Inventory')
                            ->schema([
                                Forms\Components\TextInput::make('sku'),
                                Forms\Components\TextInput::make('price'),
                                Forms\Components\TextInput::make('quantity'),
                                Forms\Components\Select::make('type')
                                    ->options([
                                        'downloadable' => ProductTypeEnum::DOWNLOADABLE->value,
                                        'deliverable' => ProductTypeEnum::DELIVERABLE->value,
                                    ]) 
                            ]),
                    ]),

                    Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('status')
                            ->schema([
                                Forms\Components\Toggle::make('is_visible'),
                                Forms\Components\Toggle::make('is_featured'),
                                Forms\Components\DatePicker::make('published_at'),
                            ]),
                        

                        Forms\Components\Section::make('Image')
                            ->schema([
                                Forms\Components\FileUpload::make('image')
                            ])->collapsible(),

                            Forms\Components\Section::make('Associations')
                            ->schema([
                                Forms\Components\Select::make('brand_id')
                                    ->relationship('brand', 'name')
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('brand.name'),
                Tables\Columns\IconColumn::make('is_visible')->boolean(),
                Tables\Columns\TextColumn::make('price'),
                Tables\Columns\TextColumn::make('quantity'),
                Tables\Columns\TextColumn::make('published_at'),
                Tables\Columns\TextColumn::make('type'),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }    
}
