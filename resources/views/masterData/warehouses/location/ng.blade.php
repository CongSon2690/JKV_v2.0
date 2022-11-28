@extends('layouts.main')

@section('content')
    {{-- @if (Auth::user()->checkRole('delete_master') || Auth::user()->level == 9999)
        @include('basic.modal_request_destroy', ['route' => route('masterData.unit.destroy')])
    @endif --}}

  
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <span class="text-bold" style="font-size: 23px">
                            {{ __('Stock') }} NG
                        </span>
                        <div class="card-tools">
                            <a href="#" class="btn btn-warning btn-import" data-toggle="modal"
                                data-target=".bd-example-modal-lg">
                                {{ __('Import') }} {{ __('Warehouse') }} {{ __('NG') }}
                            </a>
                            <a href="{{route('warehousesystem.box_ng.export_file',['Materials_ID'=>$request->Materials_ID,'Error'=>$request->Error])}}" class="btn btn-success " style="width: 180px">
								{{__('Export By File Excel')}}
							</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{route('warehousesystem.import.location')}}" method="get">
                            <input type="text" class="hide" value="{{$request->Format}}" name="Format">
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label>{{ __('Choose') }} {{ __('Materials') }}</label>
                                    <select class="custom-select select2" name="Materials_ID">
                                        <option value="">
                                            {{ __('Choose') }} {{ __('Materials') }}
                                        </option>
                                        @foreach($materials as $value)
                                            <option value="{{ $value->ID }}"
                                                {{ $request->Materials_ID == $value->ID ? 'selected' : '' }}>
                                                {{ $value->Symbols }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>{{ __('Choose') }} {{ __('Name') }} {{ __('Error') }}</label>
                                    <select class="custom-select select2" name="Error">
                                        <option value="">
                                            {{ __('Choose') }} {{ __('Error') }}
                                        </option>
                                        @foreach ($error as $value)
                                            <option value="{{ $value->ID }}"
                                                {{ $request->Error == $value->ID ? 'selected' : '' }}>
                                                {{ $value->Name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-1">
                                <label>{{ __('From') }}</label>
                                <input type="date" value="" class="form-control from datetime"
                                    name="from">
                                </div>
                                <div class="form-group col-md-1">
                                    <label>{{ __('To') }}</label>
                                    <input type="date" value="" class="form-control to datetime"
                                        name="to">
                                </div>
                                <!-- <div class="form-group col-md-2">
                                    <label>{{ __('Choose') }} {{ __('Status') }}</label>
                                    <select class="custom-select select2" name="Name">
                                        <option value="0">
                                            {{ __('Choose') }} {{ __('Status') }}
                                        </option>
                                        <option value="1">
                                            {{ __('Waiting') }} {{ __('Handle') }}
                                        </option>
                                        <option value="2">
                                            {{ __('Are') }} {{ __('Handle') }}
                                        </option>
                                        <option value="3">
                                            {{ __('Handle') }} {{ __('Success') }}
                                        </option>
                                    </select>
                                </div> -->
                                <div class="col-md-2" style="margin-top: 33px">
                                    <button type="submit" class="btn btn-info">{{ __('Filter') }}</button>
                                    <a href="#" class="btn btn-success reuse-all" data-toggle="modal"
                                    data-target="#modalRequestReuseAll">
                                        {{ __('ReUse') }}
                                    </a>
                                    <a href="#" class="btn btn-danger  handle-all"data-toggle="modal"
                                        data-target="#modalRequestCancelAll">
                                        {{ __('Cancel') }}
                                    </a>
                                </div>
                               
                            </div>
                        </form>
                        @include('basic.alert')
                        </br>
                        <p>Tổng Số Lượng NG : <span style="color:red">{{$warehouses->sum('Quantity')}} ( Kg )</span></p>
                        <p>Tổng Số Lượng đã xử Lý : <span style="color:red">{{$warehouses->sum('Reuse') + $warehouses->sum('Cancel')}} ( Kg )</span></p>
                        <form action="{{ route('warehousesystem.box_ng.reuse_or_handle_all') }}" method="post">
                            @csrf
                            <table class="table table-bordered text-nowrap" id="tableUnit" width="100%">
                                <thead>
                                    <th>
                                        <div class="form-group pro1 col-2 style="text-align:center;">
                                            <div class="icheck-primary d-inline ">
                                                <input type="checkbox" id="checkboxPrimary" class="checkAllStock">
                                                <label for="checkboxPrimary">Chọn Hết</label>
                                            </div>
                                        </div>
                                    </th>
                                    <th>{{ __('Location') }}</th>
                                    <th>{{ __('Box_ID') }}</th>
                                    <th>{{ __('Materials') }}</th>
                                    <th>{{ __('Error') }}</th>
                                    <th>{{ __('Location') }} {{ __('Incurred') }}</th>
                                    <th>{{ __('Quantity') }}</th>
                                    <th>{{ __('ReUse') }}</th>
                                    <th>{{ __('Cancel') }}</th>
                                    <th>{{ __('Note') }}</th>
                                    <th>{{ __('User Created') }}</th>
                                    <th>{{ __('Time Created') }}</th>
                                    <th>{{ __('User Updated') }}</th>
                                    <th>{{ __('Time Updated') }}</th>
                                    <th>{{ __('Action') }}</th> 
                                </thead>
                                <tbody>
                                        @foreach ($warehouses as $value)
                                            <tr>
                                                <td>
                                                    <div class="form-group col-1" style=" text-align:center;padding-top: 2.5%;">
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" value="{{$value->ID}}" name="ID[]"  id="checkboxPrimaryQC-{{$value->ID}}">
                                                            <label for="checkboxPrimaryQC-{{$value->ID}}"></label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>NG-01</td>
                                                <td>{{ $value->Box_ID }}</td>
                                                <td>{{ $value->materials ? $value->materials->Symbols : '' }}</td>
                                                <td>{{ $value->error     ? $value->error->Name : '' }}</td>
                                                <td>{{ $value->location  ? $value->location->Symbols : '' }}</td>
                                                <td>{{ floatval($value->Quantity) }}</td>
                                                <td>{{ $value->Reuse }}</td>
                                                <td>{{ $value->Cancel }}</td>
                                                <td>{{ $value->Note }}</td>
                                                <td>
                                                    {{ $value->user_created ? $value->user_created->name : '' }}
                                                </td>
                                                <td>{{ $value->Time_Created }}</td>
                                                <td>
                                                    {{ $value->user_updated ? $value->user_updated->name : '' }}
                                                </td>
                                                <td>{{ $value->Time_Updated }}</td>
                                                {{-- @if ($value->Quantity == $value->Reuse || $value->Quantity == $value->Cancel) --}}
                                                {{-- <td></td> --}}
                                                {{-- @else --}}
                                                <td>
                                                    @if(Auth::user()->checkRole('accept_export') || Auth::user()->level == 9999)
                                                        <a id="reuse-{{ $value->ID }}"
                                                            class="btn btn-success btn-handle-reuse">
                                                            {{ __('ReUse') }}
                                                        </a>
                                                        <a id="del-{{ $value->ID }}"
                                                            class="btn btn-danger btn-handle">
                                                            {{ __('Cancel') }}
                                                        </a>
                                                    @endif
                                                </td>
                                                {{-- @endif --}}
                                            </tr>
                                        @endforeach
                                </tbody> 
                                {{ $warehouses->appends([
                                    'Materials_ID'=>$request->Materials_ID,
                                    'Error'=>$request->Error,
                                    'from'=>$request->from,
                                    'to'  => $request->to
                                    ])->links() }}
                            </table>
                            <input type="text" name="Type" class="type-handle hide">
                            <input type="text" name="Location" class="location-handle hide">
                        <button type="submit" class=" submit-all hide"></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
                                    
    <div class="modal fade  bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Import') }} {{ __('Warehouse') }}
                        {{ __('NG') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('warehousesystem.box_ng.add') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group col-12">
                            <label>{{ __('Choose') }} {{ __('Type') }} {{ __('To') }}</label>
                            <select class="custom-select select2 type" name="Type">
                                <option value="">
                                    {{ __('Choose') }} {{ __('Type') }} {{ __('To') }}
                                </option>
                                <option value="1">
                                    {{ __('Machine') }}
                                </option>
                                <option value="2">
                                    {{ __('Warehouse') }}       
                                </option>
                            </select>
                        </div>
                        <div class="form-group col-12">
                            <label>{{ __('Box_ID') }}</label>
                            <input type="Number" value="" class="form-control" name="Box_ID"
                                placeholder="{{ __('Enter') }} {{ __('Box_ID') }}">
                        </div>
                        <div class="form-group col-12">
                            <label>{{ __('Choose') }} {{ __('Error') }}</label>
                            <select class="custom-select select2" name="Error">
                                <option value="">
                                    {{ __('Choose') }} {{ __('Error') }}
                                </option>
                                @foreach ($error as $value)
                                    <option value="{{ $value->ID }}">
                                        {{ $value->Name }}  
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-12">
                            <label>{{ __('Quantity') }}</label>
                            <input type="Number" value="" class="form-control" name="Quantity"
                                placeholder="{{ __('Enter') }} {{ __('Quantity') }}">
                        </div>
                        <div class="form-group col-12">
                            <label>{{ __('Note') }}</label>
                            <input type="Text" value="" class="form-control" name="Note" placeholder="{{ __('Enter') }} {{ __('Note') }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-add float-right btn-warning ">{{ __('Export') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalHandleNG" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title">{{ __('Cancel') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('warehousesystem.box_ng.handle') }}" method="get">
                    @csrf
                    <div class="modal-body">
                        <strong style="font-size: 23px">{{ __('Bạn Có Muốn Hủy ') }} <span id="nameDel"
                                style="color: blue"></span> ?</strong>
                        <input type="text" id="handle_ng" name="ID" class="form-control hide">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-danger">{{ __('Hủy') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalRequestTa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title">{{ __('Tái Sử Dụng') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('warehousesystem.box_ng.ReUse_Ng')}}" method="get">
                    @csrf
                    <div class="modal-body body-reuse">
                        <input type="text" name="ID" id="handle_reuse" class="form-control hide">
                        <div class="form-group col">
                            <label>{{ __('Enter') }} {{ __('Quantity') }} {{ __('Tái Sử Dụng') }}</label>
                            <input type="number" name="Quantity" class="form-control quantity_reuse" min="0" step="0.1" required>
                        </div>
                        <div class="form-group col ware">
                            {{-- <label>{{ __('Choose') }} {{ __('Location') }} {{ __('Import') }}
                                {{ __('Warehouse') }}</label>
                            <select class="custom-select select2" name="Location">
                                @foreach ($location as $value)
                                    <option value="">{{ $value->Symbols }}</option>
                                @endforeach
                            </select> --}}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-success">{{ __('Tái Sử Dụng') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalRequestReuseAll" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title">{{__('ReUse')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <strong style="font-size: 23px">{{__('Do You Want To ReUse All')}} <span id="nameDes" style="color: blue"></span> ?</strong>
                    <input type="text" name="ID" id="idDes" class="form-control hide">
                    <label>{{ __('Choose') }} {{ __('Location') }} {{ __('Import') }}
                        {{ __('Warehouse') }}</label>
                        <div class="form-group col">
                            <select class="custom-select select2 Location-all" name="Location-all">
                                @foreach ($location as $value)
                                    <option value="{{$value->ID}}" >{{ $value->Symbols }}</option>
                                @endforeach
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                    <button type="submit" class="btn btn-success reuse-all-modal">{{__('ReUse')}}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalRequestCancelAll" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title">{{__('Cancel')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <strong style="font-size: 23px">{{__('Do You Want To Cancel All')}} <span id="nameDes" style="color: blue"></span> ?</strong>
                    <input type="text" name="ID" id="idDes" class="form-control hide">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                    <button type="submit" class="btn btn-danger reuse-all-modal">{{__('Cancel')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $('.checkAllStock').click(function(event) {   
            if(this.checked) {
                // Iterate each checkbox
                $(':checkbox').each(function() {
                    this.checked = true;                        
                });
            } else {
                $(':checkbox').each(function() {
                    this.checked = false;                       
                });
            }
        }); 
        $( ".reuse-all" ).click(function() {
            let b = $('.type-handle').val(1);
            $('.type-handle').val(b.val());
        });
        $('.reuse-all-modal').click(function(){
            $('.location-handle').val($('.Location-all').val())
            $('.submit-all').click();
        });
        $( ".handle-all" ).click(function() {
            let b = $('.type-handle').val(2);
            $('.type-handle').val(b.val());
        });
        $('.cancel-all-modal').click(function(){
            $('.submit-all').click();
        });
        $('.select2').select2()
        $('#tableUnit').DataTable({
            language: __languages.table,
            scrollX: '100%',
            scrollY: '100%',
            dom: '<"bottom">rt<"clear">',
        });

        $(document).on('click', '.btn-handle', function() {
            $('#modalHandleNG').modal();
            let id = $(this).attr('id');
            let name = $(this).parent().parent().children('td').first().text();
            let b = $('#handle_ng').val(id.split('-')[1]);
            // console.log(b);
        });

        $(document).on('click', '.btn-handle-reuse', function() {
            $('#modalRequestTa').modal();
            let id = $(this).attr('id');
            let name = $(this).parent().parent().children('td').first().text();
            let b = $('#handle_reuse').val(id.split('-')[1]);
            let c = b.val();
            // console.log(b.val())
            $.ajax({
                type: "GET",
                url: "{{ route('warehousesystem.box_ng.check_location_ng') }}",
                data: {
                    ID: c
                },
                success: function(data) {

                    console.log(data)
                    if(data.data && data.location.Machine_ID == null)
                    {
                        console.log('run')
                        $('.ware').append(`
                            <label>{{ __('Choose') }} {{ __('Location') }} {{ __('Import') }}
                                {{ __('Warehouse') }}</label>
                            <select class="custom-select select2" name="Location" readonly>
                                    <option value="`+data.location.ID+`"  selected>`+data.location.Symbols+`</option>
                            </select>
                        `)
                        let max = data.ng.Quantity - data.ng.Cancel - data.ng.Reuse
                        // let max = parseInt(data.ng.Quantity) - parseInt(data.ng.Cancel) - parseInt(data.ng.Reuse)
                        // console.log(max)
                        $('.quantity_reuse').val(max)
                        $('.quantity_reuse').attr('max',max)
						$('.select2').select2()
                        // $('.ware').remove()

                    }

                    else
                    {
                        $('.ware').append(`
                            <label>{{ __('Choose') }} {{ __('Location') }} {{ __('Import') }}
                                {{ __('Warehouse') }}</label>
                            <select class="custom-select select2" name="Location">
                                @foreach ($location as $value)
                                    <option value="{{$value->ID}}" >{{ $value->Symbols }}</option>
                                @endforeach
                            </select>
                        `)
                        let max = data.ng.Quantity - data.ng.Cancel - data.ng.Reuse
                        // let max = parseInt(data.ng.Quantity) - parseInt(data.ng.Cancel) - parseInt(data.ng.Reuse)
                        // console.log(max)
                        $('.quantity_reuse').val(max)
                        $('.quantity_reuse').attr('max',max)
						$('.select2').select2()
                    }
                },
                error: function(error) {
                    console.log(error)
                }
            });
        });

        $(document).on('change', '.type', function() {
            let type = $('.type').val()
            if (type == 1) {
                $('.mac').show()
                $('.loc').val('').change()
                $('.loc').hide()
            } else if (type == 2) {
                $('.mac').hide()
                $('.mac').val('').change()
                $('.loc').show()
            } else {
                $('.loc').val('').change()
                $('.mac').hide()
                $('.mac').val('').change()
                $('.loc').hide()
            }
        })
    </script>
@endpush
