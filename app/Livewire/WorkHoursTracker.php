<?php

namespace App\Livewire;

use Livewire\Component;

class WorkHoursTracker extends Component
{
    // public $days = [
    //     'monday' => ['input' => '', 'hours' => 0, 'minutes' => 0, 'leave' => false],
    //     'tuesday' => ['input' => '', 'hours' => 0, 'minutes' => 0, 'leave' => false],
    //     'wednesday' => ['input' => '', 'hours' => 0, 'minutes' => 0, 'leave' => false],
    //     'thursday' => ['input' => '', 'hours' => 0, 'minutes' => 0, 'leave' => false],
    //     'friday' => ['input' => '', 'hours' => 0, 'minutes' => 0, 'leave' => false],
    // ];

    public $days = [
        'monday' => ['input' => '', 'hours' => 0, 'minutes' => 0, 'leave' => false, 'half_day' => false],
        'tuesday' => ['input' => '', 'hours' => 0, 'minutes' => 0, 'leave' => false, 'half_day' => false],
        'wednesday' => ['input' => '', 'hours' => 0, 'minutes' => 0, 'leave' => false, 'half_day' => false],
        'thursday' => ['input' => '', 'hours' => 0, 'minutes' => 0, 'leave' => false, 'half_day' => false],
        'friday' => ['input' => '', 'hours' => 0, 'minutes' => 0, 'leave' => false, 'half_day' => false],
    ];

    public $totalHours = 0, $totalMinutes = 0;
    public $message = '';

    // public function updatedDays($value, $key)
    // {
    //     [$day, $field] = explode('.', $key);

    //     if ($field === 'leave' && $value) {
    //         $this->days[$day]['hours'] = 0;
    //         $this->days[$day]['minutes'] = 0;
    //         $this->days[$day]['input'] = '';
    //     }

    //     if ($field === 'input' && !empty($value)) {
    //         $parsedTime = $this->parseTimeInput($value);
    //         $this->days[$day]['hours'] = $parsedTime['hours'];
    //         $this->days[$day]['minutes'] = $parsedTime['minutes'];
    //         $this->days[$day]['input'] = '';
    //     }

    //     $this->calculateTotalTime();
    // }

    public function updatedDays($value, $key)
    {
        [$day, $field] = explode('.', $key);

        if ($field === 'leave' && $value) {
            // If leave is checked, reset hours, minutes, and half-day
            $this->days[$day]['hours'] = 0;
            $this->days[$day]['minutes'] = 0;
            $this->days[$day]['input'] = '';
            $this->days[$day]['half_day'] = false;
        }

        if ($field === 'half_day' && $value) {
            // If half-day is checked, leave user's entered time and add 5 hours
            $this->days[$day]['leave'] = false;
        }

        if ($field === 'input' && !empty($value)) {
            $parsedTime = $this->parseTimeInput($value);
            $this->days[$day]['hours'] = $parsedTime['hours'];
            $this->days[$day]['minutes'] = $parsedTime['minutes'];
            $this->days[$day]['input'] = '';
        }

        $this->calculateTotalTime();
    }

    public function updateTime()
    {
        $this->calculateTotalTime();
    }

    public function parseTimeInput($input)
    {
        $input = strtolower(trim($input));
        preg_match('/(\d+)\s*h\s*(\d*)\s*m*/', $input, $matches);

        $hours = isset($matches[1]) ? (int)$matches[1] : 0;
        $minutes = isset($matches[2]) && $matches[2] !== '' ? (int)$matches[2] : 0;

        return ['hours' => $hours, 'minutes' => $minutes];
    }

    public function calculateTotalTime()
    {
        $totalMinutes = 0;
    
        foreach ($this->days as $day) {
            if ($day['leave']) {
                $totalMinutes += (8 * 60) + 30; // Full day leave = 8h 30m
            } elseif ($day['half_day']) {
                $totalMinutes += (5 * 60); // Half day = 5h
                $totalMinutes += ((int)$day['hours'] * 60) + (int)$day['minutes']; // Add user-entered time
            } else {
                $totalMinutes += ((int)$day['hours'] * 60) + (int)$day['minutes'];
            }
        }
    
        $this->totalHours = intdiv($totalMinutes, 60);
        $this->totalMinutes = $totalMinutes % 60;
    
        $targetMinutes = 2550;
    
        if ($totalMinutes >= $targetMinutes) {
            $this->message = "✅ You can enjoy your weekend!";
        } else {
            $remainingMinutes = $targetMinutes - $totalMinutes;
            $remainingHours = intdiv($remainingMinutes, 60);
            $remainingMinutes %= 60;
            $this->message = "⏳ You need $remainingHours hours and $remainingMinutes minutes more.";
        }
    }

    public function render()
    {
        return view('livewire.work-hours-tracker', [
            'styled' => true
        ]);
    }
}
