<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Ramsey\Collection\Set;
use Illuminate\Support\Str;
use Filament\Resources\Form;
use Filament\Resources\Table;
use App\Enums\ProductTypeEnum;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductResource\RelationManagers;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationGroup = 'Work';

    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    { 
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->unique()
                                    ->afterStateUpdated(function(string $operation, $state, Set $set) {
                                        if ($operation === 'create') {
                                            return;
                                        }

                                        $set('slug', Str::slug($state));
                                    }),

                                Forms\Components\TextInput::make('slug')
                                    ->disabled()
                                    ->dehydrated()
                                    ->required(),

                                Forms\Components\MarkdownEditor::make('description')
                                    ->columnSpan('full')
                            ])->columns(2),

                            Forms\Components\Section::make('Pricing & Inventory')
                            ->schema([
                                Forms\Components\TextInput::make('sku')
                                    ->label( "SKU  (Stock Keeping Unit)")
                                    ->required()
                                    ->unique(),

                                Forms\Components\TextInput::make('price')
                                    ->numeric()
                                    ->required()
                                    ->rules('regex:/A\d{1,6} (\. \d{0,2})?$/'),

                                Forms\Components\TextInput::make('quantity')
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(100)
                                    ->required(),
                                    
                                Forms\Components\Select::make('type')
                                    ->options([
                                        'downloadable' => ProductTypeEnum::DOWNLOADABLE->value,
                                        'deliverable' => ProductTypeEnum::DELIVERABLE->value,
                                    ]) 
                            ]),
                    ]),

                    Forms\Components\Group::make()
                    ->schema([
                        // Forms\Components\Section::make('Status')
                        //     ->schema([
                        //         Forms\Components\Toggle::make('is_visible')
                        //             ->label('Visibility')
                        //             ->helperText('Enable or disable product visibility')
                        //             ->default(true),

                                Forms\Components\Toggle::make('is_featured')
                                    ->label('Featured')
                                    ->helperText('Enable or disable products features status'),

                                Forms\Components\DatePicker::make('published_at')
                                    ->label('Availability')
                                    ->default(now())
                            ]),
                        

                        Forms\Components\Section::make('Image')
                            ->schema([
                                Forms\Components\FileUpload::make('image')
                                    ->directory('form-attachments')
                                    ->preserveFilenames()
                                    ->image()
                            ])->collapsible(),

                            Forms\Components\Section::make('Associations')
                            ->schema([
                                Forms\Components\Select::make('brand_id')
                                    ->relationship('brand', 'name')
                            ]),
                   
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image'),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('brand.name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_visible')->boolean()
                    ->sortable()
                    ->toggleable()
                    ->label('Visibility')
                    ->boolean(),

                Tables\Columns\TextColumn::make('price')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('quantity')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('published_at')
                    ->date()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('type'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_visible')
                ->label('visibility')
                ->boolean()
                ->trueLabel('Only Visble Products')
                ->falseLabel('Only Hidden Products'),

                Tables\Filters\SelectFilter::make('brand')
                    ->relationship('brand', 'name'),

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
