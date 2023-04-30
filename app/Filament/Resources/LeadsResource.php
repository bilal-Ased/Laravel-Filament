<?php
namespace App\Filament\Resources;
use App\Filament\Resources\LeadsResource\Pages;
use App\Filament\Resources\LeadsResource\RelationManagers;
use App\Models\Customer;
use App\Models\Leads;
use App\Models\LeadSource;
use App\Models\LeadStage;
use App\Models\Products;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class LeadsResource extends Resource
{
    protected static ?string $model = Leads::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationGroup = 'Leads';


    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('customer_id')
                    ->label('select customer')
                    ->options(Customer::all()->pluck('name', 'id'))
                    ->searchable(),
                    Select::make('lead_source_id')
                    ->label('select Lead Source')
                    ->options(LeadSource::all()->pluck('name', 'id'))
                    ->searchable(),
                    Select::make('lead_stage_id')
                    ->label('select Lead Stage')
                    ->options(LeadStage::all()->pluck('name', 'id'))
                    ->searchable(),
                    Select::make('product_id')
                    ->label('select Product')
                    ->options(Products::all()->pluck('name', 'id'))
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make(name: 'id')->sortable(),
            Tables\Columns\TextColumn::make(name: 'customer.name')->label('Customer Name')->searchable(),
            Tables\Columns\TextColumn::make(name: 'leadSource.name')->searchable(),
            Tables\Columns\TextColumn::make(name: 'leadStage.name')->searchable(),
            Tables\Columns\TextColumn::make(name: 'product.name')->searchable(),
            Tables\Columns\TextColumn::make('created_at')->sortable(),
        ])->defaultSort(column: 'id', direction: 'asc')
            ->filters([
                Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),

                    Filter::make('Qualified')
                    ->query(fn (Builder $query): Builder => $query->where('lead_stage_id', 1)),

                    Filter::make('Pitched')
                    ->query(fn (Builder $query): Builder => $query->where('lead_stage_id', 2)),
                    
                    Filter::make('Closed')
                    ->query(fn (Builder $query): Builder => $query->where('lead_stage_id', 3)),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListLeads::route('/'),
            // 'create' => Pages\CreateLeads::route('/create'),
            // 'edit' => Pages\EditLeads::route('/{record}/edit'),
        ];
    }    
}
