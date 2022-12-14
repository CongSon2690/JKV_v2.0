@extends('layouts.app')

@section('content')
	<div class="card">
		<div class="card-header">
			<span class="text-bold" style="font-size: 23px">
				{{ __('Error') }}
			</span>
		</div>
		<form role="from" method="post" action="{{ route('masterData.error.addOrUpdate') }}">
			@csrf
			<div class="card-body">
				<div class="row">               
					<div class="form-group col-md-4 d-none">
						<label for="idUnit">{{__('ID')}}</label>
						<input type="text" value="{{old('ID') ? old('ID') : ($error ? $error->ID : '') }}" class="form-control" id="idUnit" name="ID" readonly>
					</div>
					<div class="form-group col-md-4">
						<label for="nameUnit">{{__('Name')}} {{ __('Unit') }}</label>
						<input type="text" value="{{old('Name')? old('Name') : ($error ? $error->Name : '') }}" class="form-control" id="nameUnit" name="Name" placeholder="{{__('Enter')}} {{__('Name')}}" required>
						@if($errors->any())
							<span role="alert">
								<strong style="color: red">{{$errors->first('Name')}}</strong>
							</span>
						@endif
					</div>
					<div class="form-group col-md-4">
						<label for="symbolsUnit">{{__('Symbols')}} {{ __('Unit') }}</label>
						<input type="text" value="{{old('Symbols') ? old('Symbols') : ($error ? $error->Symbols : '') }}" class="form-control" id="symbolsUnit" name="Symbols" placeholder="{{__('Enter')}} {{__('Symbols')}}" required>
						@if($errors->any())
							<span role="alert">
								<strong style="color: red">{{$errors->first('Symbols')}}</strong>
							</span>
						@endif
					</div>
					
				</div>         
			</div>
			<div class="card-footer">
				<a href="{{ route('masterData.unit') }}" class="btn btn-info" style="width: 80px">{{__('Back')}}</a>
				<button type="submit" class="btn btn-success float-right" style="width: 80px">{{__('Save')}}</button>
			</div>
		</form>
	</div>
@endsection

@push('scripts')
	<script>
		$('.select2').select2();
	</script>
@endpush