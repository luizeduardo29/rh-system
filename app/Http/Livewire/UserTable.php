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
        // return User::query()
        //     ->join('contacts', function ($contacts) {
        //         $contacts->on('users.id', '=', 'contacts.user_Id');
        //     })
        //     ->select([
        //         'users.id',
        //         'users.name',
        //         'contacts.typeContact as typeContact',
        //     ]);

        // dd(User::query()
        // ->leftJoin('contacts', function ($contacts) {
        //     $contacts->on('users.id', '=', 'contacts.user_id');
        // })
        // ->select([
        //     'users.id',
        //     'users.name',
        //     DB::raw('COALESCE(
        //         (SELECT MIN(id) FROM contacts WHERE user_id = users.id AND typeContact = "Telefone"),
        //         (SELECT MIN(id) FROM contacts WHERE user_id = users.id)
        //     ) AS contact_id'),
        //     'contacts.typeContact as typeContact',
        // ])->toSql());

        return User::query()
                ->leftJoin('contacts', function ($contacts) {
                    $contacts->on('users.id', '=', 'contacts.user_id');
                })
                ->select([
                    'users.id',
                    'users.name',
                    'users.email',
                    'users.initials',
                    DB::raw('COALESCE(
                        (SELECT MIN(id) FROM contacts WHERE user_id = users.id AND typeContact = "Telefone"),
                        (SELECT MIN(id) FROM contacts WHERE user_id = users.id)
                    ) AS contact_id'),
                    'contacts.typeContact',
                    'contacts.info',
                ]);



    }

    public function relationSearch(): array
    {
        return [];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            // ->addColumn('id')
            ->addColumn('name')
            ->addColumn('email')
            ->addColumn('initials');
            //->addColumn('photo')
            // ->addColumn('birth_formatted', fn (User $model) => Carbon::parse($model->birth)->format('d/m/Y'))
            // ->addColumn('nationality')
            // ->addColumn('naturalness')
            // ->addColumn('gender')
            // ->addColumn('maritalStatus');
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

            Column::make('Telefone', 'typeContact')
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
            //Filter::inputText('photo')->operators(['contains']),
            Filter::datepicker('birth'),
            Filter::inputText('nationality')->operators(['contains']),
            Filter::inputText('naturalness')->operators(['contains']),
            Filter::inputText('gender')->operators(['contains']),
            Filter::inputText('maritalStatus')->operators(['contains']),
            //Filter::datetimepicker('created_at'),
        ];
    }
}
