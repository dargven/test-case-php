<?php

namespace App\Services;
class MockBookingServices
{
    public function mockBookingResponse($validated)
    {
        $answers = [
            ['message' => 'order successfully booked'],
            ['error' => 'barcode already exists']
        ];
        return $answers[random_int(0, 1)];
    }

    public function mockApproveResponse($validated)
    {
        $answers = [
            ['message' => 'order successfully approved'],
            ['error' => 'event cancelled'],
            ['error' => 'no tickets'],
            ['error' => 'no seats'],
            ['error' => 'fan removed'],
        ];
        return $answers[random_int(0, 4)];
    }
}
