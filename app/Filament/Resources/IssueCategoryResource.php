<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IssueCategoryResource\Pages;
use App\Filament\Resources\IssueCategoryResource\RelationManagers;
use App\Models\IssueCategory;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IssueCategoryResource extends Resource
{
    protected static ?string $model = IssueCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationGroup = 'System Settings';

    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->unique(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make(name: 'name')->label('Name')->searchable(),
                Tables\Columns\TextColumn::make(name: 'status')->label('Status')->searchable(),
                Tables\Columns\TextColumn::make('created_at')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListIssueCategories::route('/'),
            // 'create' => Pages\CreateIssueCategory::route('/create'),
            // 'edit' => Pages\EditIssueCategory::route('/{record}/edit'),
        ];
    }    
}
