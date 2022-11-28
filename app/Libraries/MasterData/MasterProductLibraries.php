<?php

namespace App\Libraries\MasterData;

use App\Models\MasterData\History\ProductHistory;
use Illuminate\Validation\Rule;
use App\Models\MasterData\MasterProduct;
use App\Models\MasterData\MasterMaterials;
use App\Models\MasterData\MasterUnit;
use App\Models\MasterData\MasterBOM;
use App\Models\MasterData\MasterMold;
use Validator;
use ExportLibraries;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Maatwebsite\Excel\Concerns\WithStyles;
use Illuminate\Support\Facades\Auth;
use App\Models\History\HistoriesImportFile;
use Carbon\Carbon;

class MasterProductLibraries
{
	public function get_all_list_product()
	{
		return MasterProduct::where('IsDelete', 0)
			->with([
				'user_created',
				'user_updated',
				'unit',
				'materials'
			])
			->get();
	}

	public function filter($request)
	{

		$id 	 = $request->ID;
		$name 	 = $request->Name;
		$symbols = $request->Symbols;

		$data 	 = MasterProduct::when($id, function ($query, $id) {
			return $query->where('ID', $id);
		})->when($name, function ($query, $name) {
			return $query->where('Name', $name);
		})->when($symbols, function ($query, $symbols) {
			return $query->where('Symbols', $symbols);
		})->where('IsDelete', 0)->get();

		return $data;
	}
	public function filter_one($request)
	{

		$id 	 = $request->ID;
		$name 	 = $request->Name;
		$symbols = $request->Symbols;

		$data 	 = MasterProduct::where('ID', $request->ID)->where('IsDelete', 0)->first();

		return $data;
	}
	public function check_product($request)
	{
		$id = $request->ID;
		$message = [
			'unique'   => $request->Symbols . ' ' . __('Already Exists') . '!',
		];
		Validator::make(
			$request->all(),
			[
				'Symbols' => [
					'required', 'max:20',
					Rule::unique('Master_Product')->where(function ($q) use ($id) {
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
		if (isset($id) && $id != '') {
			if (!Auth::user()->checkRole('update_master') && Auth::user()->level != 9999) {
				abort(401);
			}
			$product_find = MasterProduct::where('IsDelete', 0)->where('ID', $id)->first();
			$product = MasterProduct::where('ID', $id)->update([
				'Name'         => $request->Name,
				'Symbols'      => $request->Symbols,
				'Unit_ID'      => $request->Unit_ID,
				'Cycle_Time'   => $request->Cycle_Time,
				'CAV'		   => $request->CAV,
				'Materials_ID' => $request->Materials_ID,
				'Note'		   => $request->Note,
				'Quantity'	   => $request->Quantity,
				'User_Updated' => $user_updated
			]);

			return (object)[
				'status' => __('Update') . ' ' . __('Success'),
				'data'	 => $product
			];
		} else {
			if (!Auth::user()->checkRole('create_master') && Auth::user()->level != 9999) {
				abort(401);
			}

			$product = MasterProduct::create([
				'Name' 			=> $request->Name,
				'Symbols'		=> $request->Symbols,
				'Unit_ID'		=> $request->Unit_ID,
				'Materials_ID'  => $request->Materials_ID,
				'Cycle_Time'    => $request->Cycle_Time,
				'CAV'		    => $request->CAV,
				'Note'			=> $request->Note,
				'Quantity'	   	=> $request->Quantity,
				'User_Created'	=> $user_created,
				'User_Updated'	=> $user_updated,
				'IsDelete'		=> 0
			]);

			return (object)[
				'status' => __('Create') . ' ' . __('Success'),
				'data'	 => $product
			];
		}
	}

	public function destroy($request)
	{
		$user_created = Auth::user()->id;
		$user_updated = Auth::user()->id;
		$find = MasterProduct::where('ID', $request->ID)->first();
		$find->update([
			'IsDelete' 		=> 1,
			'User_Updated'	=> Auth::user()->id
		]);

		return __('Delete') . ' ' . __('Success');
	}

	public function return($request)
	{
		// dd($request);
		$user_updated = Auth::user()->id;
		$product_his = ProductHistory::where('ID', $request->ID)->first();
		ProductHistory::where('ID', $request->ID)->update([
			'Status' => 3,
			'User_Updated'	=> $user_updated,
		]);
		$product = MasterProduct::where('ID', $product_his->Product_ID)->update([
			'Name' 			=> $product_his->Name,
			'Symbols'		=> $product_his->Symbols,
			'Unit_ID'		=> $product_his->Unit_ID,
			'Materials_ID'  => $product_his->Materials_ID,
			'Cycle_Time'    => $product_his->Cycle_Time,
			'CAV'		    => $product_his->CAV,
			'Note'			=> $product_his->Note,
			'Quantity'	   	=> $product_his->Quantity,
			'User_Updated'	=> $user_updated,
		]);
	}

	private function read_file($request)
	{
		try {
			$user_created = Auth::user()->id;
			$user_updated = Auth::user()->id;
			$cvt     = Carbon::now()->isoFormat('YYMMDDhhmmss');
			$file     = request()->file('fileImport');
			$name     = $file->getClientOriginalName();
			$arr      = explode('.', $name);
			$fileName = strtolower(end($arr));

			if ($fileName != 'xlsx' && $fileName != 'xls') {
				return redirect()->back();
			} else if ($fileName == 'xls') {
				$reader  = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
			} else if ($fileName == 'xlsx') {
				$reader  = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			}
			try {
				$spreadsheet = $reader->load($file);
				$data        = $spreadsheet->getActiveSheet()->toArray();

				return $data;
			} catch (\Exception $e) {
				return ['danger' => __('Select The Standard ".xlsx" Or ".xls" File')];
			}
		} catch (\Exception $e) {
			return ['danger' => __('Error Something')];
		}
	}

	public function import_file($request)
	{
		$user_created = Auth::user()->id;
        $user_updated = Auth::user()->id;
        $err_mater = [];
        $err =[];
        
            $symbols ='';
            $name = '';
            $data       = $this->read_file_bom($request);
            $dem = 4;
            $arr = [];
            // dd($data);
            foreach($data as $key=>$value)
            {
                
                if($key > 3)
                {
                    
                    $dataBom = [];
                    if($value[1])
                    {
                        $pro1 = null;
                        $mater = null;
                        $pro = MasterProduct::where('Symbols',strval($value[1]))->where('IsDelete',0)->first();
                        if(!$pro)
                        {
                            // chưa khai báo sản phẩm trong product
                            //tạo mới để lấy ID
                            if($value[7])
                            {
                                $unit = MasterUnit::where('Symbols',$value[7])->where('IsDelete',0)->first();
                            
                                if(!$unit)
                                {
                                    // đã khai báo sản phẩm trong product
                                    $unit = MasterUnit::create([
                                        'Name'          => $value[7] ? $value[7] :'not name' ,
                                        'Symbols'       => $value[7],
                                        'User_Created'  => $user_created,
                                        'User_Updated'  => $user_updated,
                                        'IsDelete'      => 0
    
                                    ]);
                                }
                                $unit1 = $unit->ID; 
                            }
                            else
                            {
                                $unit1 = null;
                            }
                            if($value[9])
                            {
                                $parking = MasterUnit::where('Symbols',$value[9])->where('IsDelete',0)->first();
                                if(!$parking)
                                {
                                    // đã khai báo sản phẩm trong product
                                    $parking = MasterUnit::create([
                                        'Name'          => $value[9] ? $value[9] :'not name' ,
                                        'Symbols'       => $value[9],
                                        'User_Created'  => $user_created,
                                        'User_Updated'  => $user_updated,
                                        'IsDelete'      => 0
    
                                    ]);
                                }
                                $parking1 = $parking->ID;
                            }
                            else
                            {
                                $parking1 = null;
                            }
                           
                            $pro = MasterProduct::create([
                                'Name'             => $value[2] ? $value[2] :'not name' ,
                                'Symbols'          => $value[1],
                                'Parking_Standard' => $value[8],
                                'Parking_ID'       => $parking1,
                                'Unit_ID'          => $unit1,
                                'Stock_Min'        => $value[10],
                                'Stock_Max'        => $value[11],
                                'StorageTime_1'    => $value[12],
                                'StorageTime_2'    => $value[13],
                                'Special'          => $value[46],
                                'User_Created'  => $user_created,
                                'User_Updated'  => $user_updated,
                                'IsDelete'      => 0
                            ]);
                        }
                        $symbols = $value[2] ;
                        $name  = $value[3] ;
                        $dataBom['Product'] = $pro->ID;
                        if($value[3])
                        {
                            // dd(\Str::uuid());
                            $pro1 = MasterProduct::where('Symbols', strval($value[3]))->where('IsDelete',0)->first();
                            // dd($value[3]);
                            if(!$pro1)
                            {

                                // chưa khai báo sản phẩm trong product
                                //tạo mới để lấy ID
                                if($value[7])
                                {
                                    $unit = MasterUnit::where('Symbols',$value[7])->where('IsDelete',0)->first();
                                
                                    if(!$unit)
                                    {
                                        // đã khai báo sản phẩm trong product
                                        $unit = MasterUnit::create([
                                            'Name'          => $value[7] ? $value[7] :'not name' ,
                                            'Symbols'       => $value[7],
                                            'User_Created'  => $user_created,
                                            'User_Updated'  => $user_updated,
                                            'IsDelete'      => 0
        
                                        ]);
                                    }
                                    $unit1 = $unit->ID; 
                                }
                                else
                                {
                                    $unit1 = null;
                                }
                                if($value[9])
                                {
                                    $parking = MasterUnit::where('Symbols',$value[9])->where('IsDelete',0)->first();
                                    if(!$parking)
                                    {
                                        // đã khai báo sản phẩm trong product
                                        $parking = MasterUnit::create([
                                            'Name'          => $value[9] ? $value[9] :'not name' ,
                                            'Symbols'       => $value[9],
                                            'User_Created'  => $user_created,
                                            'User_Updated'  => $user_updated,
                                            'IsDelete'      => 0
        
                                        ]);
                                    }
                                    $parking1 = $parking->ID;
                                }
                                else
                                {
                                    $parking1 = null;
                                }
                                $pro1 = MasterProduct::create([
                                    'Name'             => $value[4] ? $value[4] :'not name' ,
                                    'Symbols'          => $value[3],
                                    'Parking_Standard' => $value[8],
                                    'Parking_ID'       => $parking1,
                                    'Unit_ID'          => $unit1,
                                    'Stock_Min'        => $value[10],
                                    'Stock_Max'        => $value[11],
                                    'StorageTime_1'    => $value[12],
                                    'StorageTime_2'    => $value[13],
                                    'Special'          => $value[46],
                                    'User_Created'  => $user_created,
                                    'User_Updated'  => $user_updated,
                                    'IsDelete'      => 0
                                ]);
                            }
                            $dataBom['Product1'] = $pro1->ID;
                            $dataBom['Quantity_Product1'] = $value[6];
                        }
                        if($value[20])
                        {
                            
                            $mater = MasterMaterials::where('Symbols',$value[20])->where('IsDelete',0)->first();
                            
                            if(!$mater)
                            {
                                if($value[33])
                                {
                                    $unit = MasterUnit::where('Symbols',$value[33])->where('IsDelete',0)->first();
                                
                                    if(!$unit)
                                    {
                                        // đã khai báo sản phẩm trong product
                                        $unit = MasterUnit::create([
                                            'Name'          => $value[33] ? $value[33] :'not name' ,
                                            'Symbols'       => $value[33],
                                            'User_Created'  => $user_created,
                                            'User_Updated'  => $user_updated,
                                            'IsDelete'      => 0
        
                                        ]);
                                    }
                                    $unit1 = $unit->ID; 
                                }
                                else
                                {
                                    $unit1 = null;
                                }
                                if($value[34])
                                {
                                    $parking = MasterUnit::where('Symbols',$value[34])->where('IsDelete',0)->first();
                                    if(!$parking)
                                    {
                                        // đã khai báo sản phẩm trong product
                                        $parking = MasterUnit::create([
                                            'Name'          => $value[34] ? $value[34] :'not name' ,
                                            'Symbols'       => $value[34],
                                            'User_Created'  => $user_created,
                                            'User_Updated'  => $user_updated,
                                            'IsDelete'      => 0
        
                                        ]);
                                    }
                                    $parking1 = $parking->ID;
                                }
                                else
                                {
                                    $parking1 = null;
                                }
                                if($value[22])
                                {
                                $supplier = MasterSupplier::where('Name',$value[22])->where('IsDelete',0)->first();
                                if(!$supplier)
                                {
                                    // đã khai báo sản phẩm trong product
                                        $supplier1 = null;
                                }
                                else
                                {
                                    $supplier1 = $supplier->ID;
                                }
                                }
                                else
                                {
                                    $supplier1 = null;
                                } 
                                // chưa khai báo sản phẩm trong product
                                //tạo mới để lấy ID
                               
                               
                                $mater = MasterMaterials::create([
                                    'Name'             => $value[21] ? $value[21] :'not name' ,
                                    'Symbols'          => $value[20],
                                    'Unit_ID'          => $unit1,
                                    'Parking_ID'       => $parking1,
                                    'Supplier_ID'       => $supplier1,
                                    'Stock_Min'        => $value[35],
                                    'Stock_Max'        => $value[36],
                                    'StorageTime_1'    => $value[37],
                                    'StorageTime_2'    => $value[38],
                                    'Lead_Time'        =>$value[31],
                                    'Forecast'         => $value[32],
                                    'Special'          => $value[39],
                                    'Price'            =>$value[40],
                                    'MOQ'              =>$value[41],
                                    'Norm'             =>$value[42],
                                    'Note'             =>$value[43],
                                    'Machining_Time'   =>$value[30],
                                    'height'           => $value[45],
                                    'Thickness'        => $value[44],
                                    'User_Created'  => $user_created,
                                    'User_Updated'  => $user_updated,
                                    'IsDelete'      => 0
                                ]);

                            }
                            else
                            {

                            }

                            if($value[24])
                            {
                                
                                    
                                $mater1 = MasterMaterials::where('Symbols',$value[24])->where('IsDelete',0)->first();
                                    
                                if(!$mater1)
                                {
                                    if($value[33])
                                    {
                                        $unit = MasterUnit::where('Symbols',$value[33])->where('IsDelete',0)->first();
                                
                                        if(!$unit)
                                        {
                                            // đã khai báo sản phẩm trong product
                                            $unit = MasterUnit::create([
                                                'Name'          => $value[33] ? $value[33] :'not name' ,
                                                'Symbols'       => $value[33],
                                                'User_Created'  => $user_created,
                                                'User_Updated'  => $user_updated,
                                                'IsDelete'      => 0
            
                                            ]);
                                        }
                                        $unit1 = $unit->ID; 
                                    }
                                    else
                                    {
                                        $unit1 = null;
                                    }
                                    if($value[34])
                                    {
                                        $parking = MasterUnit::where('Symbols',$value[34])->where('IsDelete',0)->first();
                                        if(!$parking)
                                        {
                                            // đã khai báo sản phẩm trong product
                                            $parking = MasterUnit::create([
                                                'Name'          => $value[34] ? $value[34] :'not name' ,
                                                'Symbols'       => $value[34],
                                                'User_Created'  => $user_created,
                                                'User_Updated'  => $user_updated,
                                                'IsDelete'      => 0
            
                                            ]);
                                        }
                                        $parking1 = $parking->ID;
                                        }
                                        else
                                        {
                                            $parking1 = null;
                                        }

                                        if($value[26])
                                        {

                                        $supplier = MasterSupplier::where('Name',$value[26])->where('IsDelete',0)->first();

                                        if(!$supplier)
                                        {
                                            // đã khai báo sản phẩm trong product
                                                $supplier1 = null;
                                        }
                                        else
                                        {
                                            $supplier1 = $supplier->ID;
                                        }
                                            
                                        }
                                        else
                                        {
                                            $supplier1 = null;
                                        } 
                                       
                                        $mater1 = MasterMaterials::create([
                                            'Name'             => $value[25] ? $value[25] :'not name' ,
                                            'Symbols'          => $value[24],
                                            'Parking_Standard' => $value[8],
                                            'Unit_ID'          => $unit1,
                                            'Parking_ID'       => $parking1,
                                            'Supplier_ID'      => $supplier1,
                                            'Stock_Min'        => $value[35],
                                            'Stock_Max'        => $value[36],
                                            'StorageTime_1'    => $value[37],
                                            'StorageTime_2'    => $value[38],
                                            'Lead_Time'        =>$value[31],
                                            'Forecast'         => $value[32],
                                            'Special'          => $value[39],
                                            'Price'            =>$value[40],
                                            'MOQ'              =>$value[41],
                                            'Norm'             =>$value[42],
                                            'Note'             =>$value[43],
                                            'Machining_Time'   =>$value[30],
                                            'height'           => $value[45],
                                            'Thickness'        => $value[44],
                                            'User_Created'  => $user_created,
                                            'User_Updated'  => $user_updated,
                                            'IsDelete'      => 0
                                        ]);
        
                                        
                                }
                                else
                                {    
                                }
                                    MasterMaterialsPO::updateOrCreate(
                                        [
                                            'Master_Materials_ID'   =>  $mater->ID, 
                                            'Materials_Replace_ID'  =>  $mater1->ID,
                                        ],
                                        [
                                            // 'Quantity_Product'   => $request[$key[$i+1]], 
                                            'User_Created'  => $user_created,
                                            'User_Updated'  => $user_updated,
                                            'IsDelete'      => 0
                                        ]
                                        );
                                     
                                
                            }
                                $dataBom['Materials'] = $mater->ID;
                                $dataBom['Quantity_Materials'] = $value[15];


                        }

                        if($pro1 == null && $mater == null )
                        {
                            $text = '1';
                            array_push($err,$text);

                        }
                        else
                        {
                            if($pro1 != null)
                            {
                                $check = MasterBom::where('IsDelete',0)->where('BOM_ID',$pro->ID)->where('Product_ID',$pro1->ID)->first();
                                if(!$check)
                                {
                                    MasterBom::create([
                                    'BOM_ID'            => $pro->ID,
                                    'Product_ID'        => $pro1->ID,
                                    'Quantity_Product'  => str_replace(',', '.', $value[5]),
                                    'User_Created'      => $user_created,
                                    'User_Updated'      => $user_updated,
                                    'IsDelete'          => 0
                                    ]);
                                }
                                else
                                {
                                   MasterBom::where('IsDelete',0)->where('BOM_ID',$pro->ID)->where('Product_ID',$pro1->ID)->update([
                                        'Quantity_Product'  => str_replace(',', '.', $value[17]),
                                    ]); 
                                }
                               
                            }
                            if($mater != null)
                            {
                                $check = MasterBom::where('IsDelete',0)->where('BOM_ID',$pro->ID)->where('Materials_ID',$mater->ID)->first();
                                if(!$check)
                                {
                                     MasterBom::create([
                                    'BOM_ID'                => $pro->ID,
                                    'Materials_ID'          => $mater->ID,
                                    'Quantity_Material'     => str_replace(',', '.', $value[17]),
                                    'User_Created'          => $user_created,
                                    'User_Updated'          => $user_updated,
                                    'IsDelete'              => 0
                                    ]);
                                }
                                else
                                {
                                    MasterBom::where('IsDelete',0)->where('BOM_ID',$pro->ID)->where('Materials_ID',$mater->ID)->update([
                                        'Quantity_Material'  => str_replace(',', '.', $value[17]),
                                    ]);

                                }
                               
                            }
                            array_push($arr,$key+1);
                        }
                    }
                }
            }
            return $arr;
	}
	public function get_id_bom_and_materials($request)
	{
		return MasterBOM::where('IsDelete', 0)->where('Product_BOM_ID', $request->ID)->with('materials','product','user_created', 'user_updated',)->get();
	}
	public function add_product_and_materials_to_bom($request)
	{
		// dd($request);
		$user_created = Auth::user()->id;
		$user_updated = Auth::user()->id;
		$product = $request->product;
		$materials = $request->materials;
		$mold = $request->mold;
		$Quantity_product = $request->Quantity_Product;
		$Quantity_materials = $request->Quantity_materials;
		// $Cavity = $request->Cavity;
		// $Cycle_Time = $request->Cycle_Time;
		$pro_his = null;
		if (!$request->Product_BOM_ID) {
			if (strlen($request->Symbols) <= 20) {
				$find_product = MasterProduct::where('IsDelete', 0)->where('Symbols', $request->Symbols)->first();
				if (!$find_product) {
					$product = MasterProduct::create([
						'Name' 			=> $request->Symbols,
						'Symbols'		=> $request->Symbols,
						'Note'			=> $request->Note,
						'User_Created'	=> $user_created,
						'User_Updated'	=> $user_updated,
						'IsDelete'		=> 0
					]);
					$request->Product_BOM_ID = $product->ID;
				} else {
					return (object)[
						'status' => __('Create') . ' ' . __('False'),
					];
				}
			} else {
				return (object)[
					'status' => __('Create') . ' ' . __('False'),
				];
			}
		} else {
			$product_update = MasterProduct::where('ID', $request->Product_BOM_ID)->update([
				'Name' 			=> $request->Symbols,
				'Symbols'		=> $request->Symbols,
				'Note'			=> $request->Note,
				'User_Updated'	=> $user_updated,
			]);
		}
		// if($product)
		// {
		// 	$find = MasterBOM::where('IsDelete',0)->where('Product_BOM_ID',$request->Product_BOM_ID)->where('Product_ID','>',0)->update([
		// 		'User_Updated'	=> $user_updated,
		// 		'IsDelete'		=> 1
		// 	]);
		// 	foreach($product as $key => $pro)
		// 	{
		// 		$find = MasterBOM::where('IsDelete',0)->where('Product_BOM_ID',$request->Product_BOM_ID)->where('Product_ID',$pro)->first();
		// 		if($find)
		// 		{
		// 			if($find->Quantity_Product != $Quantity_product[$key])
		// 			{
		// 				MasterBOM::where('ID',$find->ID)
		// 				->update([
		// 					'Quantity_Product' => $Quantity_product[$key],
		// 				]);
		// 			}
		// 		}
		// 		else
		// 		{
		// 			MasterBOM::create([
		// 				'Product_BOM_ID'=>$request->Product_BOM_ID,
		// 				'Product_ID'=>$pro, 
		// 				'Quantity_Product'=>$Quantity_product[$key],
		// 				'User_Created'	=> $user_created,
		// 				'User_Updated'	=> $user_updated,
		// 				'IsDelete'		=> 0
		// 			]);
		// 		}
		// 	}
		// }
		// else
		// {
		// 	$find = MasterBOM::where('IsDelete',0)->where('Product_BOM_ID',$request->Product_BOM_ID)->where('Product_ID','>',0)->update([
		// 		'User_Updated'	=> $user_updated,
		// 		'IsDelete'		=> 1
		// 	]);
		// }
		if ($materials) {
			$arr_mater = [];
			foreach ($materials as $key => $mater) {
				if (strlen($mater) <= 20 && is_numeric($Quantity_materials[$key]) && $Quantity_materials[$key] > 0) {
					$find_mater = MasterMaterials::where('IsDelete', 0)->where('Symbols', $mater)->first();
					if (!$find_mater) {
						$find_mater = MasterMaterials::create([
							'Name'             => $mater,
							'Symbols'          => $mater,
							'User_Created'     => $user_created,
							'User_Updated'     => $user_updated,
							'IsDelete'         => 0
						]);
						$find_mater = MasterMaterials::where('IsDelete', 0)->where('Symbols', $mater)->first();
					}
					$find_bom_mater = MasterBOM::where('IsDelete', 0)->where('Product_BOM_ID', $request->Product_BOM_ID)->where('Materials_ID', $find_mater->ID)->first();
					if ($find_bom_mater) {
						if ($find_bom_mater->Quantity_Material != $Quantity_materials[$key]) {
							MasterBOM::where('ID', $find_bom_mater->ID)->update([
								'Quantity_Material' => $Quantity_materials[$key],
								'User_Updated'	=> $user_updated,
							]);
						}
					} else {

						MasterBOM::create([
							'Product_BOM_ID' => $request->Product_BOM_ID,
							'Materials_ID'  => $find_mater->ID,
							'Quantity_Material' => $Quantity_materials[$key],
							'User_Created'	=> $user_created,
							'User_Updated'	=> $user_updated,
							'IsDelete'		=> 0
						]);
					}
					array_push($arr_mater, $find_mater->ID);
				} else {
					return (object)[
						'status' => __('Create') . ' ' . __('Materials') . ' : ' . $mater . ' ' . __('False'),
					];
				}
			}
			MasterBOM::where('IsDelete', 0)->where('Product_BOM_ID', $request->Product_BOM_ID)->where('Materials_ID', '>', 0)->whereNotIn('Materials_ID', $arr_mater)->update([
				'User_Updated'	=> $user_updated,
				'IsDelete'		=> 1
			]);
		} else {
			$find = MasterBOM::where('IsDelete', 0)->where('Product_BOM_ID', $request->Product_BOM_ID)->where('Product_ID', '>', 0)->update([
				'User_Updated'	=> $user_updated,
				'IsDelete'		=> 1
			]);
		}
		if ($mold) {
			$arr_mold = [];
			foreach ($mold as $key => $mol) {
				if (strlen($mol) <= 20 && is_numeric($Quantity_product[$key])  && $Quantity_product[$key] > 0) {
					$find_mold = MasterProduct::where('IsDelete', 0)->where('Symbols', $mol)->first();
					if (!$find_mold) {
						$mold_cre = MasterProduct::create([
							'Name' 			=> $mol,
							'Symbols'		=> $mol,
							'User_Created'	=> $user_created,
							'User_Updated'	=> $user_updated,
							'IsDelete'		=> 0
						]);
						$find_mold = MasterProduct::where('IsDelete', 0)->where('Symbols', $mol)->first();
					}
					$find_bom_mold = MasterBOM::where('IsDelete', 0)->where('Product_BOM_ID', $request->Product_BOM_ID)->where('Product_ID', $find_mold->ID)->first();
					if ($find_bom_mold) {
						if ($find_bom_mold->Quantity_Product != $Quantity_product[$key]) {
							MasterBOM::where('ID', $find_bom_mold->ID)->update([
								'Quantity_Product' 		=> $Quantity_product[$key],
								'User_Updated'	=> $user_updated,
							]);
						}
					} else {
						MasterBOM::create([
							'Product_BOM_ID' => $request->Product_BOM_ID,
							'Product_ID'		=> $find_mold->ID,
							'Quantity_Product' 		=> $Quantity_product[$key],
							'User_Created'	=> $user_created,
							'User_Updated'	=> $user_updated,
							'IsDelete'		=> 0
						]);
					}
					array_push($arr_mold, $find_mold->ID);
				} else {
					return (object)[
						'status' => __('Create') . ' ' . __('Product') . ' : ' . $mol . ' ' . __('False'),
					];
				}
			}
			MasterBOM::where('IsDelete', 0)->where('Product_BOM_ID', $request->Product_BOM_ID)->where('Product_ID', '>', 0)->whereNotIn('Product_ID', $arr_mold)->update([
				'User_Updated'	=> $user_updated,
				'IsDelete'		=> 1
			]);
		} else {
			$find = MasterBOM::where('IsDelete', 0)->where('Product_BOM_ID', $request->Product_BOM_ID)->where('Product_ID', '>', 0)->update([
				'User_Updated'	=> $user_updated,
				'IsDelete'		=> 1
			]);
		}
		return (object)[
			'status' => __('Create') . ' ' . __('Success'),
		];
	}

	public function get_list_materials_and_quantity($request)
	{
		$boms = 	MasterBOM::where('IsDelete', 0)->where('Product_BOM_ID', $request->Product_ID)->get();
		$array = [];
		foreach ($boms as $bom) {
			if ($bom->Product_ID) {
				$request->Product_ID = $bom->Product_ID;
				$data = $this->get_list_materials_and_quantity_next($request);
				$array = array_merge($array, $data->array);
				for ($i = 1; $i <= 1000; $i++) {
					if ($data->succ) {
						$request->Product_ID = $data->product;
						$data = $this->get_list_materials_and_quantity_next($request);
						$array = array_merge($array, $data->array);
					} else {
						$i = 1000;
					}
				}
			} else {
				$arr = (object)[
					'Materials' => $bom->Materials_ID,
					'Quantity'  => $request->Quantity * $bom->Quantity_Material,
				];
				array_push($array, $arr);
			}
		}
		return $array;
	}
	public function get_list_materials_and_quantity_next($request)
	{
		$boms = 	MasterBOM::where('IsDelete', 0)->where('Product_BOM_ID', $request->Product_ID)->get();
		$array = [];
		$succ = false;
		$product = null;
		foreach ($boms as $bom) {
			if ($bom->Product_ID) {
				$succ = true;
				$product = $bom->Product_ID;
			} else {
				$arr = (object)[
					'Materials' => $bom->Materials_ID,
					'Quantity'  => $request->Quantity * $bom->Quantity_Material,
				];
				array_push($array, $arr);
			}
		}
		return  (object)[
			'succ'  => $succ,
			'product' => $product,
			'array' => $array
		];
	}
}
