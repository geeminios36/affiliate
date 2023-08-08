<?php

namespace App\Http\Controllers;

use App\ConfigCommission;
use Illuminate\Http\Request;

class ConfigCommissionController extends Controller
{
    public function index() {
        $configsCommission = ConfigCommission::all();
        return view('backend.config_commission.index', compact('configsCommission'));
    }

    public function create() {
        return view('backend.config_commission.create');
    }

    public function store(Request $request) {
        $input = $request->all();
        $configCommission = new ConfigCommission();
        $configCommission->name = $input['name'];
        $configCommission->seller_commission = $input['seller_commission'];
        $configCommission->customer_commission = $input['customer_commission'];
        $configCommission->factory_commission = $input['factory_commission'];
        $configCommission->remunerate_commission = $input['remunerate_commission'];
        $configCommission->stock_commission = $input['stock_commission'];
        $configCommission->created_by = auth()->id();
        $configCommission->updated_by = auth()->id();
        $configCommission->save();

        flash(translate('Config Commission inserted successfully'))->success();
        
        return redirect()->to(route('config_commission.index'));
    }

    public function edit($id) {
        $configCommission = ConfigCommission::find($id);
        
        return view('backend.config_commission.edit', compact('configCommission'));
    }

    public function show($id) {

    }

    public function update(Request $request, $id) {
        $input = $request->all();
        $configCommission = ConfigCommission::find($id);

        if (empty($configCommission)) {
            flash(translate('Config Commission update error'))->error();
        
            return redirect()->to(route('config_commission.index'));
        }

        $configCommission->name = $input['name'];
        $configCommission->seller_commission = $input['seller_commission'];
        $configCommission->customer_commission = $input['customer_commission'];
        $configCommission->factory_commission = $input['factory_commission'];
        $configCommission->remunerate_commission = $input['remunerate_commission'];
        $configCommission->stock_commission = $input['stock_commission'];
        $configCommission->created_by = auth()->id();
        $configCommission->updated_by = auth()->id();
        $configCommission->save();

        flash(translate('Config Commission updated successfully'))->success();
        
        return redirect()->to(route('config_commission.index'));
    }


    public function destroy($id) {
        $configCommission = ConfigCommission::find($id);

        if (empty($configCommission)) {
            flash(translate('Config Commission update error'))->error();
        
            return redirect()->to(route('config_commission.index'));
        }

        $configCommission->delete();
     
        flash(translate('Config Commission deleted successfully'))->success();
        
        return redirect()->to(route('config_commission.index'));
    }
}
