<?php

namespace App\Http\Controllers\Web\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libraries\MasterData\MasterErrorLibraries;

class MasterErrorController extends Controller
{

	public function __construct(
		MasterErrorLibraries $masterErrorLibraries
	){
		$this->middleware('auth');
		$this->error = $masterErrorLibraries;
	}
    
    public function index(Request $request)
    {
    	$error 	= $this->error->get_all_list_error();
    	$errors 	= $error;
		// dd($unit);
    	return view('masterData.error.index', 
    	[
			'error'  => $error,
			'errors' => $errors,
            'request'    => $request
    	]);
    }

    public function filter(Request $request)
    {
		$name    = $request->Name;
		$symbols = $request->Symbols;
		$errors   = $this->error->get_all_list_unit();
		
		$error    = $errors->when($name, function($q, $name) 
		{
			return $q->where('Name', $name);

		})->when($symbols, function($q, $symbols) 
		{
			return $q->where('Symbols', $symbols);
			
		});

    	return view('masterData.error.index', 
    	[
			'error'  => $error,
			'errors' => $errors,
            'request' => $request
    	]);
    }

    public function show(Request $request)
    {
    	$error = $this->error->filter($request);
    	
    	if (!$request->ID) 
    	{
    		$error = collect([]);
    		// dd('1');
    	}

    	return view('masterData.error.add_or_update', 
    	[
    		'error' => $error->first(),
    		'show' => true
    	]);
    }

    public function add_or_update(Request $request)
    {
		$check = $this->error->check_error($request);
		$data  = $this->error->add_or_update($request);
    	
    	return redirect()->route('masterData.error')->with('success',$data->status);
    }

    public function destroy(Request $request)
    {
    	$data = $this->error->destroy($request);

    	return redirect()->route('masterData.error')->with('danger',$data);
    }

    public function import_file_excel(Request $request)
    {
        // get data in file excel
        // dd($request);
        $data  = $this->import->master_error($request);
        // dd($data);
        if(count($data) > 1)
        {
            return redirect()->back()
            ->with('danger', $data);
        } 
        else
        {
            return redirect()->back()
            ->with('success', __('Success'));
        }
    }

    public function export_file(Request $request)
    {
        $data = $this->error->filter($request);
        $this->export->export($data,$request); 
        
    }

	public function return(Request $request)
	{
		$data  = $this->error->return($request);
    	
    	return redirect()->route('masterData.error')->with('success',__('Return') .''.__('Success'));
	}
}
