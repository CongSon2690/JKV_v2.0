@extends('layouts.app')

@section('content')

    @push('myCss')
        <link rel="stylesheet" href="{{ asset('my_setup/css/warehouse.css') }}">
    @endpush


    @include('basic.modal_detail_warehouse')
    @if (Auth::user()->checkRole('update_master') || Auth::user()->level == 9999)
        @include('basic.modal_request_destroy', ['route' => route('masterData.warehouses.destroy')])
    @endif

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <span class="text-bold col-md-3" style="font-size: 23px">
                                {{ __('Setting') }} {{ __('Warehouse') }}
                            </span>
                            <div class="col-md-3">
                                <button class="btn btn-info"
                                    style="width: 50px; height: 30px; background: #009787"></button>
                                {{ __('Have') }} {{ __('Materials') }}
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-light" style="width: 50px; height: 30px"></button>
                                {{ __('Position') }} {{ __('Null') }}
                            </div>
                        </div>
                        <div class="card-tools">
                            @if (!$request->Type)
                                @if (Auth::user()->checkRole('update_master') || Auth::user()->level == 9999)
                                    <a href="{{ route('masterData.warehouses.show') }}" class="btn btn-warning">
                                        {{ __('Create') }} {{ __('Warehouse') }}
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="form-group clearfix">
                            </div>
                        </div>
                        @include('basic.alert')
                        <br>
                      
                        @foreach ($warehouses as $value)
                            <table class="table table-bordered table-warehouse table-responsive" width="100%">
                                <thead>
                                    <th>{{ __('Warehouse') }}</th>
                                    <th>{{ __('Position') }}</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="col-10">
                                            <table class="table table-bordered col-12">
                                                <tbody>
                                                    @for ($i = 1; $i <= $value->Quantity_Rows; $i++)
                                                        <tr>
                                                            @if ($i == 1)
                                                                <td class="td-first"
                                                                    rowspan="{{ $value->Quantity_Rows }}">
                                                                    <span class="name-cell">
                                                                        {{ $value->Name }}
                                                                    </span><br>
                                                                    <span style="color: blue;">
                                                                        {{ $value->Symbols }}
                                                                    </span><br>{{ $value->Note }}<br>
                                                                    @if (!$request->Type)
                                                                        @if (Auth::user()->checkRole('update_master') || Auth::user()->level == 9999)
                                                                            <a href="{{ route('masterData.warehouses.show', ['ID' => $value->ID]) }}"
                                                                                class="btn btn-success my-btn">{{ __('Edit') }}</a> <br>
                                                                            <button name="{{ $value->Name }}"
                                                                                id="tower-{{ $value->ID }}"
                                                                                class="btn btn-danger btn-destroy my-btn">{{ __('Delete') }}</button>
                                                                        @endif
                                                                    @endif
                                                                </td>
                                                            @endif
                                                            @for ($j = 1; $j <= $value->Quantity_Columns; $j++)
                                                                @if (!$request->Type)
                                                                    <td
                                                                        class ="my-td  {{ $value->Symbols }}-{{ $i }}-{{ $j }}  my-tdd">
                                                                        {{ $value->Symbols }}-{{ $i }}-{{ $j }}
                                                                    </td>
                                                                @else
                                                                    <td
                                                                        class ="my-td  {{ $value->Symbols }}-{{ $i }}-{{ $j }}  my-tdd1">
                                                                        {{ $value->Symbols }}-{{ $i }}-{{ $j }}
                                                                    </td>
                                                                @endif
                                                            @endfor
                                                        </tr>
                                                    @endfor
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('.select2').select2();

        function filter_detail(dataDetail) {
            return $.ajax({
                method: 'get',
                url: '{{ route('masterData.warehouses.filterDetail') }}',
                data: dataDetail,
                dataType: 'json',
                beforeSend: function() {
                    $('.loading').show();
                    $('#idWarehouse').val('');
                    $('#mac').val('');
                    $('#positionLed').val('');
                    $('#quantityUnit').val('');
                    $('#unitID').val(0).select2();
                    $('#quantityPacking').val('');
                    $('#packingID').val(0).select2();
                    $('#groupMaterialsWare').val('').select2();
                    $('#Accept').val('').select2();
                    $('#Email').val('');
                    $('#Email2').val('');
                    $('#note').val('');
                }
            })
        }

        function add_or_update_detail(dataSave) {
            return $.ajax({
                method: 'get',
                url: "{{ route('masterData.warehouses.addOrUpdateDetail') }}",
                data: dataSave,
                dataType: 'json', 
                beforeSend: function() {
                    $('.loading').show();
                }
            })
        }

        function add_or_update_type(dataType) {
            return $.ajax({
                method: 'post',
                // method    : 'get',
                url: '{{ route('masterData.warehouses.addOrUpdateType') }}',
                data: dataType,
                dataType: 'json'
            })
        }

        function filter_import() {
            return $.ajax({
                method: 'get',
                url: '{{ route('masterData.warehouses.filterDetail') }}',
                data: {},
                dataType: 'json',
            })
        }

        function filter_warehouse() {
            clearTimeout(check);

            check = setTimeout(function() {
                filter();
            }, 30000);
        }

        function filter() {
            filter_import().done(function(data) {
                console.log(data)
                for (let dat of data.data) {
                    if (dat.inventory.length != 0) {
                        $('.' + dat.Symbols).addClass('green')
                    } else if (dat.inventory_null.length != 0 || dat.Group_Materials_ID != null) {
                        console.log('run')
                        $('.' + dat.Symbols).addClass('yellow')
                    } else {
                        $('.' + dat.Symbols).removeClass('green')
                        $('.' + dat.Symbols).removeClass('yellow')
                    }
                }
                filter_warehouse();
            }).fail(function(err) {
                console.log(err)
            })
        }

        let check;
        filter();

        let upType;

        $('#radioPrimary1').on('change', function() {
            if (this.checked) {
                dataType = {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'Type': 1,
                }

                clearTimeout(upType);
                upType = setTimeout(function() {
                    add_or_update_type(dataType);
                }, 500);
            }
        })

        $('#radioPrimary2').on('change', function() {
            if (this.checked) {
                dataType = {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'Type': 2
                }

                clearTimeout(upType);
                upType = setTimeout(function() {
                    add_or_update_type(dataType);
                }, 500);
            }
        })



        $('.my-tdd').on('click', function() {
            let name = $(this).attr('class').split(' ')[1]
            $('#modalDetailWarehouse').modal();
            $('#nameWarehouse').text(name);
            $('.hide').hide();
            let dataDetail = {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'ID': '',
                'Name': name,
                'Symbols': name
            }
            filter_detail(dataDetail).done(function(data) {
                console.log(dataDetail, data);
                let i = 1;
                for (let dat of data.data) {
                    $('#idWarehouse').val(dat.ID);
                    $('#mac').val(dat.MAC);
                    $('#positionLed').val(dat.Position_Led);
                    $('#quantityUnit').val(dat.Quantity_Unit);
                    $('#unitID').val(dat.Unit_ID).select2();
                    $('#quantityPacking').val(dat.Quantity_Packing);
                    $('#packingID').val(dat.Packing_ID).select2();
                    $('#Accept').val(dat.Accept).select2();
                    $('#Email').val(dat.Email);
                    $('#Email2').val(dat.Email2);
                    $('#groupMaterialsWare').val(dat.Group_Materials_ID).select2();
                    $('#are').val(dat.Area);
                    $('#note').val(dat.Note);
                }
                $('.loading').hide();
                $('.hide').hide();
            }).fail(function(err) {
                console.log(err);
            })
        });

        $('.btn-save-detail').on('click', function() {
            let dataSave = {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'ID': $('#idWarehouse').val(),
                'MAC': $('#mac').val(),
                'Position_Led': $('#positionLed').val(),
                'Quantity_Unit': $('#quantityUnit').val(),
                'Unit_ID': $('#unitID').val(),
                'Quantity_Packing': $('#quantityPacking').val(),
                'Packing_ID': $('#packingID').val(),
                'Group_Materials_ID': $('#groupMaterialsWare').val(),
                'Accept': $('#Accept').val(),
                'Email': $('#Email').val(),
                'Email2': $('#Email2').val(),
                'Note': $('#note').val(),
            }
            console.log(dataSave)
            if (dataSave.Quantity_Unit <= 0 && dataSave.Quantity_Unit != '') {
                $('.error-quantity-unit').show();
                $('strong.error-quantity-unit').text(__quantity.min + '1');
            } else if (dataSave.Quantity_Packing <= 0 && dataSave.Quantity_Packing != '') {
                $('.error-quantity-packing').show();
                $('strong.error-quantity-packing').text(__quantity.min + '1');
            } else {
                add_or_update_detail(dataSave).done(function(data) {
                    console.log(dataSave);
                    console.log(data);
                    $('.loading').hide();
                    $('.hide').hide();
                    if (data.data.length != 0) {
                        Toast.fire({
                            icon: 'success',
                            title: __update.success
                        });
                        $('#modalDetailWarehouse').modal('hide');
                    } else {
                        if (typeof data.errors.Position_Led !== 'undefined') {
                            $('.error-position-led').show();
                            $('strong.error-position-led').text(data.errors.Position_Led[0]);
                        }
                        if (typeof data.errors.Quantity_Unit !== 'undefined') {
                            $('.error-quantity-unit').show();
                            let text = '';
                            for (let err of data.errors.Quantity_Unit) {
                                if (text == '') {
                                    text = err;
                                } else {
                                    text = text + ' ' + __and + ' ' + err;
                                }
                            }

                            $('strong.error-quantity-unit').text(text);
                        }

                        if (typeof data.errors.Quantity_Packing !== 'undefined') {
                            $('.error-quantity-packing').show();
                            let text = '';
                            for (let err of data.errors.Quantity_Packing) {
                                if (text == '') {
                                    text = err;
                                } else {
                                    text = text + ' ' + __and + ' ' + err;
                                }
                            }
                            $('strong.error-quantity-packing').text(text);
                        }

                        if (typeof data.errors.Unit_ID !== 'undefined') {
                            $('.error-unit').show();
                            let text = '';
                            for (let err of data.errors.Unit_ID) {
                                if (text == '') {
                                    text = err;
                                } else {
                                    text = text + ' ' + __and + ' ' + err;
                                }
                            }
                            $('strong.error-unit').text(text);
                        }

                        if (typeof data.errors.Packing_ID !== 'undefined') {
                            $('.error-packing').show();
                            let text = '';
                            for (let err of data.errors.Packing_ID) {
                                if (text == '') {
                                    text = err;
                                } else {
                                    text = text + ' ' + __and + ' ' + err;
                                }
                            }
                            $('strong.error-packing').text(text);
                        }
                    }

                }).fail(function(err) {
                    console.log(err);
                })
            }
        });
        $(document).on('click', '.btn-destroy', function() {
            let id = $(this).attr('id');
            let name = $(this).parent().parent().children('td').first().children('.name-cell').text();
            $('#modalRequestDel').modal();
            $('#nameDel').text(name);
            $('#idDel').val(id.split('-').pop());
        });
        $('.btn-input').on('click',function(){
			$('.area_select').val('')
			$('.area_select').hide()
			$('.area_input').show()
			$('.btn-input').hide()
			$('.btn-select').show()	
		})
		$('.btn-select').on('click',function(){
			$('.area_input').val('')
			$('.area_select').show()
			$('.area_input').hide()
			$('.btn-input').show()
			$('.btn-select').hide()
		})
    </script>
@endpush
