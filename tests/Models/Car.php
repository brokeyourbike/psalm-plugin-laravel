<?php declare(strict_types=1);

namespace Tests\BrokeYourBike\LaravelPlugin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

final class Car extends Model {
    use HasFactory;
    protected $table = 'cars';
};
