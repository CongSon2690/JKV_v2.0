@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <span class="text-bold" style="font-size: 23px">
                {{ __('Machine') }}
            </span>
            <div class="card-tools">
				<div>
					<p><span style="color:red"> * </span> <span>: {{__('Required information (maximum 20 characters)')}} </span> </p> 
				</div>
			</div>
        </div>
        <form role="from" method="post" action="{{ route('masterData.machine.addOrUpdate') }}">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-12 d-none">
                        <label for="idmachine">{{ __('ID') }}</label>
                        <input type="text" value="{{ old('ID') ? old('ID') : ($machine ? $machine->ID : '') }}"
                            class="form-control" id="idmachine" name="ID" readonly>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="Namemachine">{{ __('Name') }} {{ __('Machine') }}</label>
                        <div class="input-group">
                            <input type="text" maxlength="25"
                                value="{{ old('Name') ? old('Name') : ($machine ? $machine->Name : '') }}"
                                class="form-control" id="Namemachine" name="Name"
                                placeholder="{{ __('Enter') }} {{ __('Name') }}" required>
                            <div class="input-group-append">
								<span class="input-group-text" style="color:Red">*</span>
							</div>
						</div>
                        @if ($errors->any())
                            <span role="alert">
                                <strong style="color: red">{{ $errors->first('Name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-md-4">
                        <label for="symbolsmachine">{{ __('Symbols') }} {{ __('Machine') }}</label>
                        <div class="input-group">
                            <input type="text" maxlength="25"
                                value="{{ old('Symbols') ? old('Symbols') : ($machine ? $machine->Symbols : '') }}"
                                class="form-control" id="symbolsmachine" name="Symbols"
                                placeholder="{{ __('Enter') }} {{ __('Symbols') }}" required>
                            <div class="input-group-append">
								<span class="input-group-text" style="color:Red">*</span>
							</div>
						</div>
                        @if ($errors->any())
                            <span role="alert">
                                <strong style="color: red">{{ $errors->first('Symbols') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-md-4 ">
                        <label for="symbolsProduct">{{ __('Note') }}</label>
                        <textarea type="text" class="form-control" id="NoteProduct" name="Note"
                            placeholder="{{ __('Enter') }} {{ __('Note') }}">{{ old('Note') ? old('Note') : ($machine ? $machine->Note : '') }}</textarea>
                        @if ($errors->any())
                            <span role="alert">
                                <strong style="color: red">{{ $errors->first('Note') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('masterData.machine') }}" class="btn btn-info"
                    style="width: 80px">{{ __('Back') }}</a>
                <button type="submit" class="btn btn-success float-right" style="width: 80px">{{ __('Save') }}</button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        $('.select2').select2();
    </script>
@endpush