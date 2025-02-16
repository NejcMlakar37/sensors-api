<?php

namespace App\Services;

use App\Mail\BatteryLowMail;
use App\Mail\DeEscalationEmail;
use App\Mail\EscalationEmail;
use App\Models\Incident;
use App\Models\Sensor;
use Illuminate\Support\Facades\Mail;

class AlarmService
{
    /**
     * @param int $sensorId
     * @param float $temperature
     * @param float $humidity
     * @return void
     */
    public function handleSensorLimits(int $sensorId, float $temperature, float $humidity): void
    {
        $sensor = Sensor::query()->with(['limits', 'recipients'])
            ->findOrFail($sensorId);

        if($sensor->limits) {
            $minTemp = $sensor->limits['min_temp'];
            $maxTemp = $sensor->limits['max_temp'];
            $minHumidity = $sensor->limits['min_humidity'];
            $maxHumidity = $sensor->limits['max_humidity'];

            $tempOutOfBounds = $temperature > $maxTemp || $temperature < $minTemp;
            $humidityOutOfBounds = $humidity > $maxHumidity || $humidity < $minHumidity;

            // Temperature alarm check
            if ($tempOutOfBounds && !$sensor->active_temp_alarm) {
                $this->changeTempAlarmStatus($sensor, true);
                $this->createIncident($sensorId, 'temp', $temperature, $minTemp, $maxTemp);
                $this->sentEscalationEmail($sensor->recipients->pluck('email')->toArray(), $sensor->toArray(), 'temp', $temperature, $minTemp, $maxTemp);
            } elseif (!$tempOutOfBounds && $sensor->active_temp_alarm) {
                $this->changeTempAlarmStatus($sensor, false);
                $this->sentDeEscalationEmail($sensor->recipients->pluck('email')->toArray(), $sensor->toArray(), 'temp');
            }

            // Humidity alarm check
            if ($humidityOutOfBounds && !$sensor->active_humid_alert) {
                $this->createIncident($sensorId, 'humid', $humidity, $minHumidity, $maxHumidity);
                $this->changeHumidityAlarmStatus($sensor, true);
                $this->sentEscalationEmail($sensor->recipients->pluck('email')->toArray(), $sensor->toArray(), 'humidity', $humidity, $minHumidity, $maxHumidity);
            } elseif (!$humidityOutOfBounds && $sensor->active_humid_alert) {
                $this->changeHumidityAlarmStatus($sensor, false);
                $this->sentDeEscalationEmail($sensor->recipients->pluck('email')->toArray(), $sensor->toArray(), 'humidity');
            }
        }
    }

    public function handleBatteryStatus(int $sensorId, float $battery): void
    {
        if($battery <= 25.00)
        {
            $sensor = Sensor::query()->with('recipients')->findOrFail($sensorId);
            $recipients = $sensor->recipients->pluck('email')->toArray();
            $this->sendBatteryLowEmail($recipients, $sensor->toArray(), $battery);
        }
    }

    /**
     * @param $sensor
     * @param bool $status
     * @return void
     */
    private function changeTempAlarmStatus($sensor, bool $status): void
    {
        $sensor->active_temp_alarm = $status;
        $sensor->save();
    }

    /**
     * @param $sensor
     * @param bool $status
     * @return void
     */
    private function changeHumidityAlarmStatus($sensor, bool $status): void
    {
        $sensor->active_humid_alert = $status;
        $sensor->save();
    }

    /**
     * @param array $recipients
     * @param array $sensor
     * @param string $type
     * @param float $value
     * @param float $min
     * @param float $max
     * @return void
     */
    private function sentEscalationEmail(array $recipients, array $sensor, string $type, float $value, float $min, float $max): void
    {
        if(!empty($recipients)) {
            Mail::to($recipients)->send(new EscalationEmail($sensor, $type, $value, $min, $max));
        }
    }

    /**
     * @param array $recipients
     * @param array $sensor
     * @param string $type
     * @return void
     */
    private function sentDeEscalationEmail(array $recipients, array $sensor, string $type): void
    {
        if(!empty($recipients)) {
            Mail::to($recipients)->send(new DeEscalationEmail($sensor, $type));
        }
    }

    /**
     * @param array $recipients
     * @param array $sensor
     * @param float $battery
     * @return void
     */
    private function sendBatteryLowEmail(array $recipients, array $sensor, float $battery): void
    {
        if(!empty($recipients)) {
            Mail::to($recipients)->send(new BatteryLowMail($sensor, $battery));
        }
    }

    /**
     * @param int $sensorId
     * @param string $type
     * @param float $value
     * @param float $min
     * @param float $max
     * @return void
     */
    private function createIncident(int $sensorId, string $type, float $value, float $min, float $max): void
    {
        $incident = new Incident([
            'sensor_id' => $sensorId,
            'type' => $type,
            'value' => $value,
            'min' => $min,
            'max' => $max,
        ]);

        $incident->save();
    }
}
