<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Faker\Core\Number;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;



    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'Customers';
    protected static ?string $recordTitleAttribute = 'name';



    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }




    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            TextInput::make('name'),
            TextInput::make('email'),
            TextInput::make('phone_number'),
            TextInput::make('location'),
            FileUpload::make('path'),

            
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([

            Tables\Columns\TextColumn::make(name: 'id')->sortable(),
            Tables\Columns\TextColumn::make(name: 'name')->searchable(),
            Tables\Columns\TextColumn::make(name: 'email')->searchable(),
            Tables\Columns\TextColumn::make(name: 'phone_number')->searchable(),
            Tables\Columns\TextColumn::make('created_at')->sortable(),
            ImageColumn::make('path')
        ])->defaultSort(column: 'id', direction: 'asc')



            ->filters([
                Filter::make('is_featured')->toggle(),

                Tables\Filters\Filter::make(name:'start')->query(fn (Builder $query): Builder => $query->where(column:'id',operator:1))
                
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                ExportBulkAction::make() 
                ->deselectRecordsAfterCompletion(),   

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
            'index' => Pages\ListCustomers::route('/'),
            // 'create' => Pages\CreateCustomer::route('/create'),
            // 'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }    
}
