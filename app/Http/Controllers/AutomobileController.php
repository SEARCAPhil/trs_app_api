<?php

namespace App\Http\Controllers;

use App\Automobile;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;

class AutomobileController
{
  public function lists () {
    return Automobile::paginate();
  }

  public function view(Request $request) {
    return Automobile::where('id', '=', $request->id)->get();
  }

  public function delete(Request $request) {
    return Automobile::where('id', '=', $request->id)->delete();
  }

  public function search (Request $request) {
    return Automobile::where('id', 'like', '%'.$request->param.'%')
    ->orWhere('plate_no', 'like', '%'.$request->param.'%')
    ->orWhere('manufacturer', 'like', '%'.$request->param.'%')
    ->orWhere('model', 'like', '%'.$request->param.'%')
    ->orWhere('year', 'like', '%'.$request->param.'%')
    ->orWhere('color', 'like', '%'.$request->param.'%')
    ->orWhere('conduction_no', 'like', '%'.$request->param.'%')->paginate(50);
  }  

  private function create ($plate_no, $manufacturer, $model, $year, $color, $conduction_no, $transmission_type, $date_acquired, $date_registered, $notes) {
    $automobile = new Automobile;
    # generate session
    $automobile->fill([
      'plate_no' => $plate_no, 
      'manufacturer' => $manufacturer, 
      'model' => $model, 
      'year' => $year, 
      'color' => $color, 
      'conduction_no' => $conduction_no, 
      'transmission_type' => $transmission_type, 
      'date_acquired' => $date_acquired, 
      'date_registered' => $date_registered, 
      'notes' => $notes]);
      $automobile->save();
    # return last_id
    return $automobile->id;
  }

  private function update ($id, $plate_no, $manufacturer, $model, $year, $color, $conduction_no, $transmission_type, $date_acquired, $date_registered, $notes) {
    return Automobile::where('id', '=', $id)->update([
      'plate_no' => $plate_no, 
      'manufacturer' => $manufacturer, 
      'model' => $model, 
      'year' => $year, 
      'color' => $color, 
      'conduction_no' => $conduction_no, 
      'transmission_type' => $transmission_type, 
      'date_acquired' => $date_acquired, 
      'date_registered' => $date_registered, 
      'notes' => $notes]);
  }

  public function createService (Request $request) {
    return self::create($request->plate_no, $request->manufacturer, $request->model, $request->year, $request->color, $request->conduction_no, $request->transmission_type, $request->date_acquired, $request->date_registered, $request->notes);
  }

  public function updateService (Request $request) {
    return self::update($request->id, $request->plate_no, $request->manufacturer, $request->model, $request->year, $request->color, $request->conduction_no, $request->transmission_type, $request->date_acquired, $request->date_registered, $request->notes);
  }

}
