<?php

namespace Hmreumann\ArgentinaAirports\Actions;

use Hmreumann\ArgentinaAirports\Enums\AirportCondition;
use Hmreumann\ArgentinaAirports\Enums\AirportControl;
use Hmreumann\ArgentinaAirports\Enums\AirportFir;
use Hmreumann\ArgentinaAirports\Enums\AirportTraffic;
use Hmreumann\ArgentinaAirports\Enums\AirportType;
use Hmreumann\ArgentinaAirports\Enums\AirportUse;
use Hmreumann\ArgentinaAirports\Enums\ElevationUOM;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use SplFileObject;

class GetAirportsData
{
    public function execute(): array
    {
        $csvFile = __DIR__ . '/../data/argentina_airports.csv';

        if (!file_exists($csvFile)) {
            throw new FileNotFoundException('The airports CSV data file was not found.');
        }

        $file = new SplFileObject(__DIR__. '/../data/argentina_airports.csv');
        $file->setFlags(SplFileObject::READ_CSV | SplFileObject::READ_AHEAD | SplFileObject::SKIP_EMPTY);

        $dataToInsert = [];

        foreach ($file as $index => $row) {
            if($index == 0){
                continue;
            }
            if(count($row) > 1){
                $row[0] = implode(',', $row);
            }

            // Skip empty rows
            if (empty($row)) {
                continue;
            }

            // Use ";" as the delimiter
            $data = str_getcsv($row[0], ';');

            $data = array_map(function($item){
                $item = trim($item);

                return empty($item) ? null : $item;
            }, $data);

            $dataToInsert[] = [
                "local" => $data[0],
                "oaci" => $data[1],
                "iata" => $data[2],
                "type" => $this->getAirportType($data[3]),
                "name" => $data[4],
                // "coordenadas" => $data[5],
                "latitude" => $data[7],
                "longitude" => $data[6],
                "elevation" => $data[8],
                "elevation_uom" => $this->getElevationUOM($data[9]),
                // "ref" => $data[10],
                // "distancia_ref" => $data[11],
                // "direccion_ref" => $data[12],
                "condition" => $this->getAirportCondition($data[13]),
                "control" => $this->getAirportControl($data[14]),
                // "region" => $data[15],
                "fir" => $this->getAirportFir($data[16]),
                "use" => $this->getAirportUse($data[17]),
                "traffic" => $this->getAirportTraffic($data[18]),
                // "sna" => $data[19],
                // "concesionado" => $data[20],
                // "provincia" => $data[21],
            ];

        }

        return $dataToInsert;
    }

    private function getAirportType($value): AirportType
    {
        return match($value){
            'Aeródromo' => AirportType::Aerodrome,
            'Helipuerto' => AirportType::Heliport,
        };
    }

    private function getElevationUOM($value): ElevationUOM
    {
        return match($value){
            'Metros' => ElevationUOM::Meter,
            'Pies' => ElevationUOM::Feet,
        };
    }

    private function getAirportCondition($value): AirportCondition
    {
        return match($value){
            'PUBLICO' => AirportCondition::Public,
            'PRIVADO' => AirportCondition::Private,
        };
    }

    private function getAirportControl($value): AirportControl
    {
        return match($value){
            'NOCONTROL' => AirportControl::NoControl,
            'AERADIO' => AirportControl::Aeradio,
            'CONTROL' => AirportControl::Control,
        };
    }

    private function getAirportFir($value): AirportFir
    {
        return match($value){
            'SAEF' => AirportFir::SAEF,
            'SAVF' => AirportFir::SAVF,
            'SACF' => AirportFir::SACF,
            'SAMF' => AirportFir::SAMF,
            'SARR' => AirportFir::SARR,
        };
    }

    private function getAirportUse($value): ?AirportUse
    {
        return match($value){
            'AEROAPP' => AirportUse::AEROAPP,
            'CIVIL' => AirportUse::CIVIL,
            'JOINT' => AirportUse::JOINT,
            'ULM' => AirportUse::ULM,
            'MIL' => AirportUse::MIL,
            null => null,
        };
    }

    private function getAirportTraffic($value): AirportTraffic
    {
        return match($value){
            'Nacional' => AirportTraffic::National,
            'Internacional' => AirportTraffic::International,
        };
    }
}
