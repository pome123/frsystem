<?php
// Facility.phpで定義したクラスを参照
use App\Facility;
// Illuminateにあるものを参照
use Illuminate\Http\Request;
use App\Reservation;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // データベースから値（facilities table）を持ってくる処理を$facilitiesに代入
    $facilities = Facility::orderBy('created_at', 'asc')->get();
    $reservations = Reservation::orderBy('created_at', 'asc')->get();
    // facilities.blade.phpに$facilitiesを渡して処理をし(facilities.blade.php)、ブラウザに返す
    return view('facilities', [
        'facilities' => $facilities,
        'reservations' => $reservations,
    ]);
});

// データを登録する
Route::post('/facilities', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'name' => 'required',
    ]);

    if ($validator->fails()) {
        return redirect('/')
            ->withInput()
            ->withErrors($validator);
    }

    // タスク作成
    // $facility = new Facility();
    // $facility->name = $request->name;
    // $facility->save();

    return redirect('/');
});

Route::post('/reservations', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'date' => 'required',
        'period' => 'required',
        'facility_id' => 'required',
        'reservation_user' => 'required',
    ]);

    if ($validator->fails()) {
        return redirect('/')
            ->withInput()
            ->withErrors($validator);
    }

    // 予約一覧作成
    $reservation = new Reservation();
    $reservation->date = $request->date;
    $reservation->period = $request->name;
    $reservation->facility_id = $request->facility_id;
    $reservation->reservation_user = $request->reservation_user;
    $reservation->save();

    return redirect('/');
});


// 削除ボタン
Route::delete('/facility/{id}', function ($id) {
    Facility::findOrFail($id)->delete();

    return redirect('/');
});

