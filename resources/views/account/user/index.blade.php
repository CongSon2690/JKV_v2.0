@extends('layouts.app')

@section('content')
    @if (Auth::user()->level == 9999)
        @include('basic.modal_request_destroy', ['route' => route('account.destroy')])
    @endif

    @if (Auth::user()->level == 9999)
        @include('basic.modal_reset_pass')
    @endif
    @include('basic.modal_table_history')

    <div class="card">
        <div class="card-header">
            <span class="text-bold" style="font-size: 23px">
                {{ __('Account') }}
            </span>
        </div>
        <div class="card-bordy p-3">
            <div class="h-space">
                <div class="form-group w-20">
                    <label>{{ __('Choose') }} {{ __('User Name') }}</label>
                    <select class="custom-select select2 username" name="Symbols">
                        <option value="">
                            {{ __('Choose') }} {{ __('User Name') }}
                        </option>
                        @foreach ($data as $value)
                            <option value="{{ $value->username }}">
                                {{ $value->username }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-info w-10 filter">{{ __('Filter') }}</button>
                @if (Auth::user()->level == 9999)
                    <a href="{{ route('account.show') }}" class="btn btn-success" style="width: 180px">
                        {{ __('Create') }} {{ __('Account') }}
                    </a>
                @endif
            </div>
            @include('basic.alert')
            </br>
            <table class="table table-striped table-hover" id="tableUser" width="100%"></table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var id_user = {{ Auth::user()->id }}
        var lvl_user = {{ Auth::user()->level }}
        console.log(id_user,lvl_user)
        $('.select2').select2()
        var route = `${window.location.origin}/api/settings/account`;
        var route_show = `${window.location.origin}/account/user/show`;
        console.log(route);
        const table = $('#tableUser').DataTable({
            scrollX: true,
            aaSorting: [],
            language: {
                lengthMenu: 'Number of records _MENU_',
                info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                paginate: {
                    previous: '‹',
                    next: '›'
                },
            },
            processing: true,
            dom: 'rt<"bottom"flp><"clear">',
            serverSide: true,
            ordering: false,
            searching: false,
            lengthMenu: [10, 15, 20, 25, 50],
            ajax: {
                url: route,
                dataSrc: 'data',
                data: d => {
                    delete d.columns
                    delete d.order
                    delete d.search
                    d.page = (d.start / d.length) + 1
                    d.username = $('.username').val()
                    d.id_user = id_user
                    d.lvl_user = lvl_user
                }
            },
            columns: [
                { data: 'name', defaultContent: '', title: '{{__('Name')}}' },
                { data: 'username', defaultContent: '', title: '{{__('User Name')}}' },
                { data: 'email', defaultContent: '', title: '{{__('Email')}}' },
                { data: 'created_at', defaultContent: '', title: '{{__('Time Created')}}' },
                { data: 'updated_at', defaultContent: '', title: '{{__('Time Updated')}}' },
                {
                    data:'id',
                    title: 'Action',
                    defaultContent: '',
                    render: function(data) {
                        if(id_user == data || lvl_user == 9999)
                        {
                            let a = ``;
                            if(id_user == data)
                            {
                                a = a + `<a href="` + route_show + `?id=` + data + `" class="btn btn-success" style=" width: 80px">
                                        ` + '{{__('Edit')}}' + `
                                    </a>`
                            }
                            if(lvl_user == 9999)
                            {
                                a = a + `<a href="` + route_show + `?id=` + data + `" class="btn btn-success" style=" width: 80px">
                                        ` + '{{__('Edit')}}' + `
                                    </a>
                                    <button id="del-` + data + `" class="btn btn-danger btn-delete" style="width: 80px">
                                    ` + '{{__('Delete')}}' + `
                                    </button>
                                    `
                            }
                            return a
                        }
                        else
                        {
                            return  ``
                        }
                        
                            
                    }
                }
            ]
        })
        $('table').on('page.dt', function() {
            console.log(table.page.info())
        })
        $('.filter').on('click', () => {
            table.ajax.reload()
        })
        $(document).on('click', '.btn-delete', function() {
            let id = $(this).attr('id');
            let name = $(this).parent().parent().children('td').first().text();
            
            $('#modalRequestDel').modal();
            $('#nameDel').text(name);
            $('#idDel').val(id.split('-')[1]);
        });


    </script>
@endpush
