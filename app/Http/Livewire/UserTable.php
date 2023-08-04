<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Contact;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\{ActionButton, WithExport};
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridColumns};

final class UserTable extends PowerGridComponent
{
    use ActionButton;
    use WithExport;

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage(25)
                ->showRecordCount(mode:'full'),
        ];
    }

    public function datasource(): Builder
    {
        return User::query()
        ->leftJoin('contacts', function ($contacts) {
            $contacts->on('users.id', '=', 'contacts.user_id');
        })
        ->select([
            'users.id',
            'users.name',
            'users.email',
            'users.initials',
            'contacts.typeContact',
            DB::raw('CASE
                WHEN contacts.typeContact = "Telefone" THEN contacts.info
                ELSE "Telefone não informado"
            END AS contact_info'),
        ])
        ->where(function ($query) {
            $query->whereNull('contacts.id')
                  ->orWhereIn('contacts.id', function ($subquery) {
                      $subquery->select(DB::raw('COALESCE(
                          (SELECT MIN(id) FROM contacts WHERE user_id = users.id AND typeContact = "Telefone"),
                          (SELECT MIN(id) FROM contacts WHERE user_id = users.id)
                      )'))
                      ->from('contacts')
                      ->whereColumn('user_id', 'users.id');
                  });
        });
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('name')
            ->addColumn('email')
            ->addColumn('initials');
            // ->addColumn('birth_formatted', fn (User $model) => Carbon::parse($model->birth)->format('d/m/Y'))
            //->addColumn('created_at_formatted', fn (User $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),

            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),

            Column::make('Email', 'email')
                ->sortable()
                ->searchable(),

            Column::make('Initials', 'initials')
                ->sortable()
                ->searchable(),

            Column::make('Telefone', 'contact_info')
                ->sortable()
                ->searchable(),

            // Column::make('Photo', 'photo')
            //     ->sortable()
            //     ->searchable(),

            // Column::make('Birth', 'birth_formatted', 'birth')
            //     ->sortable(),

            // Column::make('Nationality', 'nationality')
            //     ->sortable()
            //     ->searchable(),

            // Column::make('Naturalness', 'naturalness')
            //     ->sortable()
            //     ->searchable(),

            // Column::make('Gender', 'gender')
            //     ->sortable()
            //     ->searchable(),

            // Column::make('MaritalStatus', 'maritalStatus')
            //     ->sortable()
            //     ->searchable(),

                // Column::make('Created at', 'created_at_formatted', 'created_at')
                // ->sortable(),

        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('name')->operators(['contains']),
            Filter::inputText('email')->operators(['contains']),
            Filter::inputText('initials')->operators(['contains']),
            Filter::inputText('info')->operators(['contains']),
            Filter::datepicker('birth'),
        ];
    }

    public function actions(): array
    {
       return [
            Button::add('view')
               ->caption('Index')
               ->class('bg-indigo-500 hover:bg-indigo-600 cursor-pointer text-white px-3 py-2 text-sm rounded-md')
               ->target('_self')
               ->route('index', ['id' => 'id']),
            Button::add('view')
               ->caption('Edit')
               ->class('bg-indigo-500 hover:bg-indigo-600 cursor-pointer text-white px-3 py-2 text-sm rounded-md')
               ->target('_self')
               ->route('edit', ['id' => 'id']),
        ];
    }
}
