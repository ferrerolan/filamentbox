<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BrandResource\Pages;
use App\Filament\Resources\BrandResource\RelationManagers;
use App\Models\Brand;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BrandResource extends Resource
{
    protected static ?string $model = Brand::class;

    protected static ?string $navigationIcon = 'heroicon-o-stop';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'Shop';

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Group::make()
                ->schema([
                    Forms\Components\Group::make()
                        ->schema([
                            Forms\Components\Section::make('Brand Details')
                                ->schema([
                               
                                    Forms\Components\TextInput::make('name')
                                        ->required()
                                        ->unique(),

                                    Forms\Components\TextInput::make('slug'),
        

                                    Forms\Components\TextInput::make('url')
                                        ->required()
                                        ->label('Website URL')
                                        ->unique()
                                        ->columnSpan('full'),

                                    Forms\Components\MarkdownEditor::make('description')
                                        ->columnSpan('full')
                                        ->columns(2),
                                ]),

                            Forms\Components\Group::make()
                                ->schema([
                                    Forms\Components\Toggle::make('is_visible')
                                        ->label('visibility')
                                        ->helperText('Enable or disable brand visibility')
                                        ->default(true)
                                        ->columnSpan('full'),
                                ]),
                            Forms\Components\Group::make()
                                ->schema([
                                    Forms\Components\Section::make('Color')
                                        ->schema([
                                            Forms\Components\ColorPicker::make('primary_hex')
                                                ->label('Primary Color')
                                        ])
                                ])
                        ]),
                ]),
        ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('url')
                    ->label('Website URL')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\IconColumn::make('primary_hex')
                    ->label('Primary Color'),

                Tables\Columns\IconColumn::make('is_visible')
                    ->label('Visibility')
                    ->boolean()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('updated_at')
                    ->date()
                    ->sortable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
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
            'index' => Pages\ListBrands::route('/'),
            'create' => Pages\CreateBrand::route('/create'),
            'edit' => Pages\EditBrand::route('/{record}/edit'),
        ];
    }    
}
