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
    return TimeRecord::where('id', '=', $request->id)->with(['driverDetailsInView', 'vehicleDetailsInView'])->first();
  }

  public function viewPerVehicleAndDAte(Request $request) {
    $date = (new \DateTime($request->date))->format('Y-m-d');
    $dateNoDay = (new \DateTime($request->date))->format('Y-m-');
    return TimeRecord::where('vehicle_id', '=', $request->id)->where('date', '>=', $date)->where('date', '<=', $dateNoDay.'31')->with(['driverDetailsInView', 'vehicleDetailsInView'])->paginate(5000);
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
    return json_encode(array('id' => $automobile->id));
  }

  private function update ($id, $date, $time, $mode, $mileage, $tt_number, $driver_id, $guard_id, $drivers_name, $vehicle_id, $plate_no, $remarks, $created_by) {
    $is_updated = TimeRecord::where('id', '=', $id)->update([
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
  
    return json_encode(array('status' => $is_updated));
  }

  public function createService (Request $request) {
    return self::create($request->date, $request->time, $request->mode, $request->mileage, $request->tt_number, $request->driver_id, $request->guard_id, $request->drivers_name, $request->vehicle_id, $request->plate_no, $request->remarks, $this->user_id);
  }

  public function updateService (Request $request) {
    return self::update($request->id, $request->date, $request->time, $request->mode, $request->mileage, $request->tt_number, $request->driver_id, $request->guard_id, $request->drivers_name, $request->vehicle_id, $request->plate_no, $request->remarks, $this->user_id);
  }

}
