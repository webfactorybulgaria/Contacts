@extends('core::admin.master')

@section('title', trans('contacts::global.name'))

@section('main')

<div ng-app="typicms" ng-cloak ng-controller="ListController" ng-show="!initializing">

    @include('core::admin._button-create', ['module' => 'contacts'])

    <h1>
        <span>@{{ totalModels }} @choice('contacts::global.contacts', 2)</span>
    </h1>

    <div class="btn-toolbar">
        @include('core::admin._lang-switcher')
    </div>

    <div class="table-responsive">

        <table st-persist="contactsTable" st-table="displayedModels" st-order st-sort-default="email" st-pipe="callServer" st-filter class="table table-condensed table-main">
            <thead>
                <tr>
                    <td colspan="6" st-items-by-page="itemsByPage" st-pagination="" st-template="/views/partials/pagination.custom.html"></td>
                </tr>
                <tr>
                    <th class="delete"></th>
                    <th class="edit"></th>
                    <th st-sort="first_name" class="first_name st-sort">First name</th>
                    <th st-sort="last_name" class="last_name st-sort">Last name</th>
                    <th st-sort="email" class="email st-sort">Email</th>
                    <th st-sort="message" class="message st-sort">Message</th>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td>
                        <input st-search="first_name" class="form-control input-sm" placeholder="@lang('global.Search')…" type="text">
                    </td>
                    <td>
                        <input st-search="last_name" class="form-control input-sm" placeholder="@lang('global.Search')…" type="text">
                    </td>
                    <td>
                        <input st-search="email" class="form-control input-sm" placeholder="@lang('global.Search')…" type="text">
                    </td>
                    <td>
                        <input st-search="message" class="form-control input-sm" placeholder="@lang('global.Search')…" type="text">
                    </td>
                </tr>
            </thead>

            <tbody ng-class="{'table-loading':isLoading}">
                <tr ng-repeat="model in displayedModels">
                    <td typi-btn-delete action="delete(model, model.title + ' ' + model.first_name + ' ' + model.last_name)"></td>
                    <td>
                        @include('core::admin._button-edit', ['module' => 'contacts'])
                    </td>
                    <td>@{{ model.first_name }}</td>
                    <td>@{{ model.last_name }}</td>
                    <td>@{{ model.email }}</td>
                    <td>@{{ model.message }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" st-items-by-page="itemsByPage" st-pagination="" st-template="/views/partials/pagination.custom.html"></td>
                    <td>
                        <div ng-include="'/views/partials/pagination.itemsPerPage.html'"></div>
                    </td>
                </tr>
            </tfoot>
        </table>

    </div>

</div>

@endsection
