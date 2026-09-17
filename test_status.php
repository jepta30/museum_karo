<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$k = App\Models\Koleksi::find(3);
if($k) {
    $k->status = 'menunggu_persetujuan';
    $k->save();
    echo "Updated";
}
