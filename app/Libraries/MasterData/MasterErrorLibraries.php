<?php

namespace App\Libraries\MasterData;

use Illuminate\Validation\Rule;
use App\Models\MasterData\MasterError;
use App\Models\MasterData\History\UnitHistory;
use Validator;
use ExportLibraries;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Maatwebsite\Excel\Concerns\WithStyles;
use Auth;

class MasterErrorLibraries
{
	public function get_all_list_error()
	{
		return MasterError::where('IsDelete', 0)
			->with([
				'user_created',
				'user_updated'
			])
			->get();
	}

	public function filter($request)
	{
		$id 	 = $request->ID;
		$name 	 = $request->Name;
		$symbols = $request->Symbols;

		$data 	 = MasterError::when($id, function ($query, $id) {
			return $query->where('ID', $id);
		})->when($name, function ($query, $name) {
			return $query->where('Name', $name);
		})->when($symbols, function ($query, $symbols) {
			return $query->where('Symbols', $symbols);
		})->where('IsDelete', 0)->get();

		return $data;
	}

	public function check_error($request)
	{
		$id = $request->ID;
		$message = [
			'unique'   => $request->Symbols . ' ' . __('Already Exists') . '!',
		];

		Validator::make(
			$request->all(),
			[
				'Name' => [
					'required', 'max:255',
				],
				'Symbols' => [
					'required', 'max:255',
					Rule::unique('Master_Error')->where(function ($q) use ($id) {
						$q->where('ID', '!=', $id)->where('IsDelete', 0);
					})
				]
			],
			$message
		)->validate();
	}

	public function add_or_update($request)
	{
		$id = $request->ID;
		$user_created = Auth::user()->id;
		$user_updated = Auth::user()->id;
		if (isset($id) && $id != '') 
        {
			if (!Auth::user()->checkRole('update_master') && Auth::user()->level != 9999) 
            {
				abort(401);
			}
			$error_check = MasterError::where('ID', $id)->first();
			$error = MasterError::where('ID', $id)->update([
				'Name' 			=> $request->Name,
				'Symbols'		=> $request->Symbols,
				'User_Updated'	=> $user_updated
			]);
			return (object)[
				'status' => __('Update') . ' ' . __('Success'),
				'data'	 => $error
			];
		} 
        else 
        {
			if (!Auth::user()->checkRole('create_master') && Auth::user()->level != 9999) 
            {
				abort(401);
			}

			$error = MasterError::create([
				'Name' 			=> $request->Name,
				'Symbols'		=> $request->Symbols,
				'User_Created'	=> $user_created,
				'User_Updated'	=> $user_updated,
				'IsDelete'		=> 0
			]);

			return (object)[
				'status' => __('Create') . ' ' . __('Success'),
				'data'	 => $error
			];
		}
	}

	public function destroy($request)
	{
		$user_created = Auth::user()->id;
		$user_updated = Auth::user()->id;
		$unit = MasterError::where('ID', $request->ID)->first();

		MasterError::where('ID', $request->ID)->update([
			'IsDelete' 		=> 1,
			'User_Updated'	=> Auth::user()->id
		]);

		return __('Delete') . ' ' . __('Success');
	}
}
