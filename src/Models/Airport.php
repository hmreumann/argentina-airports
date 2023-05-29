<?php

namespace Hmreumann\ArgentinaAirports\Models;

use Hmreumann\ArgentinaAirports\Enums\AirportCondition;
use Hmreumann\ArgentinaAirports\Enums\AirportControl;
use Hmreumann\ArgentinaAirports\Enums\AirportFir;
use Hmreumann\ArgentinaAirports\Enums\AirportTraffic;
use Hmreumann\ArgentinaAirports\Enums\AirportType;
use Hmreumann\ArgentinaAirports\Enums\AirportUse;
use Hmreumann\ArgentinaAirports\Enums\ElevationUOM;
use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    // use HasFactory;
    protected $fillable = [
        'local',
        'oaci',
        'iata',
        'name',
        'type',
        'latitude',
        'longitude',
        'elevation',
        'elevation_uom',
        'condition',
        'control',
        'fir',
        'use',
        'traffic',
    ];

    protected $casts = [
        'type' => AirportType::class,
        'elevation_uom' => ElevationUOM::class,
        'condition' => AirportCondition::class,
        'control' => AirportControl::class,
        'fir' => AirportFir::class,
        'use' => AirportUse::class,
        'traffic' => AirportTraffic::class,
    ];
}
