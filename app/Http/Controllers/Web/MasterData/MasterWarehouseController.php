<?php

namespace App\Http\Controllers\Web\MasterData;

// use App\Exports\Quality_Warehouses\StockMaterials;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libraries\MasterData\MasterWarehouseLibraries;
use App\Libraries\MasterData\MasterWarehouseDetailLibraries;
use App\Libraries\MasterData\MasterUnitLibraries;
use App\Libraries\MasterData\MasterMaterialsLibraries;
use App\Libraries\MasterData\MasterErrorLibraries;
use App\Libraries\MasterData\MasterMachineLibraries;
use App\Libraries\MasterData\MasterGroupMaterialsLibraries;
// use App\Libraries\WarehouseSystem\ExportLibraries;

class MasterWarehouseController extends Controller
{
    private $warehouse;
    private $unit;
    private $group;

    public function __construct(
        MasterWarehouseLibraries $masterWarehouseLibraries,
        MasterWarehouseDetailLibraries $masterWarehouseDetailLibraries,
        MasterUnitLibraries $masterUnitLibraries,
        MasterGroupMaterialsLibraries $masterGroupMaterialsLibraries,
        // ExportLibraries $ExportLibraries,
        MasterMachineLibraries $MasterMachineLibraries,
        MasterErrorLibraries $MasterErrorLibraries,
        // StockMaterials $stockMaterials,
        MasterMaterialsLibraries $MasterMaterialsLibraries
    ) {
        $this->warehouse        = $masterWarehouseLibraries;
        $this->warehouse_detail = $masterWarehouseDetailLibraries;
        $this->unit             = $masterUnitLibraries;
        $this->group            = $masterGroupMaterialsLibraries;
        // $this->export           = $ExportLibraries;
        $this->machine          = $MasterMachineLibraries;
        $this->error            = $MasterErrorLibraries;
        // $this->export_stock     = $stockMaterials;
        $this->materials        = $MasterMaterialsLibraries;
    }

    public function index(Request $request)
    {
        $data     = $this->warehouse->get_all_list_warehouse();
       
        $units    = $this->unit->get_all_list_unit();
        $groups   = $this->group->get_all_list_group_materials();
        $area     = $this->warehouse->get_area();
        return view(
            'masterData.warehouses.setting.index',
            [
                'warehouses' => $data->Where('Area', '>', '0'),
                'units'      => $units,
                'groups'     => $groups,
                'area'      => $area,
                'request'    => $request
            ]
        );
    }

    public function show(Request $request)
    {
        $units    = $this->unit->get_all_list_unit();
        // $packings = $this->packing->get_all_list_packing();
        $groups   = $this->group->get_all_list_group_materials();
        $data     = $this->warehouse->filter($request);
        // $type     = $this->type->get_all_type()->first();
        $area     = $this->warehouse->get_area();
        if ($request->ID) {
            if ($data->first()) {
                $warehouse = $data->first();
            } else {
                $warehouse = '';
            }
        } else {
            $warehouse = '';
        }
        // dd($warehouse);

        return view('masterData.warehouses.setting.add_or_update', [
            'warehouse' => $warehouse,
            'units'     => $units,
            'area'      => $area,
            // 'packings'  => $packings,
            'groups'    => $groups,
            // 'type'      => $type
        ]);
    }

    public function test_led()
    {
        $macs = $this->warehouse->get_all_list_warehouse();
        return view('masterData.warehouses.test_led.index', [
            'macs' => $macs
        ]);
    }
    public function filter_warehouse(Request $request)
    {
        $data = $this->warehouse->filter_with_transfer($request);
        $request->ID = $request->Export_ID;
        $data1      = $this->export->get_all_list_detail($request);
        return response()->json([
            'data' => $data,
            'list_Box' => $data1->where('Status', 1)
        ]);
    }


    public function location(Request $request)
    {
        
        $data1     = $this->warehouse->get_all_list_warehouse();
        $area      = $this->warehouse->get_area();
        $machine   = $this->machine->get_all_list_machine();
        $error     = $this->error->get_all_list_error();
        $materials     = $this->materials->get_all_list_materials();
        $location  = $this->warehouse->get_all_location();
        if ($request->Format == 1) {
            $data = $data1->where('Type', null);
            return view(
                'masterData.warehouses.location.index',
                [
                    'warehouses' => $data,
                    'request'    => $request
                ]
            );
        } else if ($request->Format == 2) {
            $data = $data1->where('Type', 'machine');
            return view(
                'masterData.warehouses.location.machine',
                [
                    'warehouses' => $data,
                    'request'    => $request
                ]
            );
        } else if ($request->Format == 3) {
            $data = $this->warehouse->get_list_stock_ng($request);
            return view(
                'masterData.warehouses.location.ng',
                [
                    'warehouses' => $data,
                    'location' => $location,
                    'materials' => $materials,
                    'error' => $error,
                    'request' => $request
                ]
            );
        }
    }

    public function add_or_update_type(Request $request)
    {
        $type = $this->type->add_or_update($request);

        return response()->json(['success' => __('Success')]);
    }

    public function filter_detail(Request $request)
    {
        $data = $this->warehouse_detail->filter($request);

        return response()->json([
            'data' => $data
        ]);
    }
    public function filter_detail1(Request $request)
    {
        $data = $this->warehouse_detail->filter1($request);

        return response()->json([
            'data' => $data
        ]);
    }
    public function filter_detail_one(Request $request)
    {
        $data = $this->warehouse_detail->filter_detail($request);

        return response()->json([
            'data' => $data
        ]);
    }

    public function history_location(Request $request)
    {
        $data = $this->warehouse_detail->history_location($request);
        // dd($data);
        return response()->json([
            'data' => $data
        ]);
    }

    public function add_or_update(Request $request)
    {
        $this->warehouse->check_warehouse($request);
        $data = $this->warehouse->add_or_update($request);

        return redirect()->route('masterData.warehouses')->with('success', $data->status);
    }

    public function add_or_update_detail(Request $request)
    {
        $errors = $this->warehouse_detail->check_detail($request);
        if (count($errors) != 0) {
            return response()->json([
                'data'   => array(),
                'errors' => $errors
            ]);
        }

        $data = $this->warehouse_detail->add_or_update($request);

        return response()->json([
            'data'   => $data,
            'errors' => array()
        ]);
    }

    public function turn_on_off_led(Request $request)
    {
        $errors = $this->warehouse_detail->check_led($request);

        if (count($errors) != 0) {
            return response()->json([
                'data'   => array(),
                'errors' => $errors
            ]);
        }

        $data = $this->warehouse_detail->turn_on_off_led($request);

        return response()->json([
            'data'   => $data,
            'errors' => array()
        ]);
    }

    public function destroy(Request $request)
    {
        $data = $this->warehouse->destroy($request);

        return redirect()->back()->with('danger', $data->status);
    }

    public function get_list_materials_in_warehouse(Request $request)
    {
        $data = $this->warehouse->get_list_materials_in_warehouse($request);
        if (count($data) > 0) {
            $suc = true;
        } else {
            $suc = false;
        }
        return response()->json([
            'success' => $suc,
            'data'   => $data,
        ]);
    }

    // public function export_file(Request $request)
    // {
        
    //     set_time_limit(9999999999);
    //     $data = $this->warehouse->get_stock($request);
    //     // dd($data);
    //     $this->export_stock->export_file_excel($data, $request);
    // }
}