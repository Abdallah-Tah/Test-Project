<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if (isset($location['location_name']))
                {{ __($location['location_name'] . ' Shoppers') }}
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <button href=""
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition"
                        data-toggle="modal" data-target="#exampleModal">
                        Create Shopper
                    </button>
                    @include('layouts.flash-message.flash-message')
                    <div class="card-body">
                        <div class="table-responsive-xl">
                            <table id="datatable" class="table table-striped" data-toggle="data-table">
                                <thead>
                                    <tr class="text-center">
                                        <th>
                                            Status
                                        </th>
                                        <th>
                                            Shopper Name
                                        </th>
                                        <th>
                                            Email
                                        </th>
                                        <th>
                                            Check-In
                                        </th>
                                        <th>
                                            Check-Out
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @if (isset($shoppers['active']) && is_iterable($shoppers['active']))
                                        @if (count($shoppers['active']) >= 1)
                                            @foreach ($shoppers['active'] as $shopper)
                                                <tr class="text-center">
                                                    <x-shopper.listing :shopper="$shopper" />
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endif
                                    @if (isset($shoppers['pending']) && is_iterable($shoppers['pending']))
                                        @if (count($shoppers['pending']) >= 1)
                                            @foreach ($shoppers['pending'] as $shopper)
                                                <tr class="text-center">
                                                    <x-shopper.listing :shopper="$shopper" />
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endif
                                    @if (isset($shoppers['completed']) && is_iterable($shoppers['completed']))
                                        @if (count($shoppers['completed']) >= 1)
                                            @foreach ($shoppers['completed'] as $shopper)
                                                <tr class="text-center">
                                                    <x-shopper.listing :shopper="$shopper" />
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Shopper</h5>
                    <i type="button" class="fa fa-close" data-dismiss="modal" aria-hidden="true"></i>
                </div>
                <div class="modal-body">
                    <form action="/create-shopper" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="location_id" value="{{$locaiton_id }}">
                        <input type="hidden" name="store_id" value="{{$store_id }}">
                        <div class="form-group">
                            <label>Firstname <span class="text-danger">*</span></label>
                            <div class="cal-icon">
                                <input type="text" class="form-control" id="first_name" name="first_name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Lastname<span class="text-danger">*</span></label>
                            <div class="cal-icon">
                                <input type="text" class="form-control" id="last_name" name="last_name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Email<span class="text-danger">*</span></label>
                            <div class="cal-icon">
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button class="btn btn-dark">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
