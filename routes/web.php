<?php

use App\Models\OrderItem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\LazyCollection;
use League\Csv\Writer;

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
    return view('welcome');
});

Route::get('/phpinfo', function () {
    return phpinfo();
});

Route::get('/eloquent-count', function () {
    $count = OrderItem::count();
    return "Total order items: {$count}";
});

Route::get('/collection-count', function () {
    $count = OrderItem::get()->count();
    return "Total order items: {$count}";
});

Route::get('/eloquent-get', function () {
    $count = 0;
    foreach (OrderItem::get() as $item) {
        $count = $count + $item->quantity;
    }
    return "Total order item quantiry: {$count}";
});

Route::get('/eloquent-chunk-100', function () {
    $count = 0;
    OrderItem::chunk(100, function ($items) use (&$count) {
        foreach ($items as $item) {
            $count = $count + $item->quantity;
        }
    });
    return "Total order item quantiry: {$count}";
});

Route::get('/eloquent-chunk-1000', function () {
    $count = 0;
    OrderItem::chunk(1000, function ($items) use (&$count) {
        foreach ($items as $item) {
            $count = $count + $item->quantity;
        }
    });
    return "Total order item quantiry: {$count}";
});

Route::get('/eloquent-cursor', function () {
    $count = 0;
    foreach (OrderItem::cursor() as $item) {
        $count = $count + $item->quantity;
    }
    return "Total order item quantiry: {$count}";
});

Route::get('/collection-normal', function () {
    $logins = Collection::times(100000, fn () => [
        'user_id' => 24,
        'name' => 'Houdini',
        'logged_in_at' => now()->toIsoString(),
    ]);

    return response()->streamDownload(function () use ($logins) {
        $csvWriter = Writer::createFromFileObject(
            new SplFileObject('php://output', 'w+')
        );

        $csvWriter->insertOne(['User ID', 'Name', 'Login Time']);

        $csvWriter->insertAll($logins);
    }, 'logins.csv');
});

Route::get('/collection-lazy', function () {
    $logins = LazyCollection::times(100000, fn () => [
        'user_id' => 24,
        'name' => 'Houdini',
        'logged_in_at' => now()->toIsoString(),
    ]);

    return response()->streamDownload(function () use ($logins) {
        $csvWriter = Writer::createFromFileObject(
            new SplFileObject('php://output', 'w+')
        );

        $csvWriter->insertOne(['User ID', 'Name', 'Login Time']);

        $csvWriter->insertAll($logins);
    }, 'logins.csv');
});
