<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeadStageResource\Pages;
use App\Filament\Resources\LeadStageResource\RelationManagers;
use App\Models\LeadStage;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LeadStageResource extends Resource
{
    protected static ?string $model = LeadStage::class;

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
            'index' => Pages\ListLeadStages::route('/'),
            // 'create' => Pages\CreateLeadStage::route('/create'),
            // 'edit' => Pages\EditLeadStage::route('/{record}/edit'),
        ];
    }    
}
