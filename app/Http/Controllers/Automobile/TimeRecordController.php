<?php

namespace App\Http\Controllers\Automobile;

use App\Automobile\TimeRecord;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;

class TimeRecordController
{
  public function __construct () {
    $this->user_id = 1;
  }

  public function lists () {
    return TimeRecord::with(['driverDetails', 'vehicleDetails'])->paginate();
  }

  public function view(Request $request) {
    return TimeRecord::where('id', '=', $request->id)->get();
  }

  public function delete(Request $request) {
    return TimeRecord::where('id', '=', $request->id)->delete();
  }

  public function search (Request $request) {
    return TimeRecord::select(['time_record.*', 'automobile.plate_no as automobile_plate_no'])->where('time_record.plate_no', 'like', '%'.$request->param.'%')
    ->where('date', '=', $request->date)->leftJoin('automobile', 'automobile.id', '=', 'time_record.vehicle_id')->with(['driverDetails'])->paginate(50);
  }  

  private function create ($date, $time, $mode, $mileage, $tt_number, $driver_id, $guard_id, $drivers_name, $vehicle_id, $plate_no, $remarks, $created_by) {
    $automobile = new TimeRecord;
    # generate session
    $automobile->fill([
      'date' => $date, 
      'time' => $time, 
      'mode' => $mode, 
      'mileage' => $mileage, 
      'tt_number' => $tt_number, 
      'driver_id' => $driver_id, 
      'guard_id' => $guard_id, 
      'drivers_name' => $drivers_name, 
      'vehicle_id' => $vehicle_id, 
      'plate_no' => $plate_no,
      'remarks' => $remarks,
      'created_by' => $created_by]);
      $automobile->save();
    # return last_id
    return $automobile->id;
  }

  private function update ($id, $date, $time, $mode, $mileage, $tt_number, $driver_id, $guard_id, $drivers_name, $vehicle_id, $plate_no, $remarks, $created_by) {
    return TimeRecord::where('id', '=', $id)->update([
      'date' => $date, 
      'time' => $time, 
      'mode' => $mode, 
      'mileage' => $mileage, 
      'tt_number' => $tt_number, 
      'driver_id' => $driver_id, 
      'guard_id' => $guard_id, 
      'drivers_name' => $drivers_name, 
      'vehicle_id' => $vehicle_id, 
      'plate_no' => $plate_no,
      'remarks' => $remarks
    ]);
  }

  public function createService (Request $request) {
    return self::create($request->date, $request->time, $request->mode, $request->mileage, $request->tt_number, $request->driver_id, $request->guard_id, $request->drivers_name, $request->vehicle_id, $request->plate_no, $request->remarks, $this->user_id);
  }

  public function updateService (Request $request) {
    return self::update($request->id, $request->date, $request->time, $request->mode, $request->mileage, $request->tt_number, $request->driver_id, $request->guard_id, $request->drivers_name, $request->vehicle_id, $request->plate_no, $request->remarks, $this->user_id);
  }

}
