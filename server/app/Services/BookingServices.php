<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;

class BookingServices
{
    private array $data;

    private function generateBarcode()
    {
        $timestamp = round(microtime(true) * 1000);
        $randomPart = random_int(1000, 9999);
        $randomPart2 = random_int(1000, 9999);

        return $randomPart . substr($timestamp, 8, 5) . $randomPart2;
        //Обеспечивается полностью уникальный 13символьный BarCode. Т.к язык PHP синхронный,
        // мы не сможем для двух заказов присвоить один и тот же BarCode.
        //Безусловно, можно было barcode сделать более реальным и последние несколько меняющихся цифр сделать
        // зависимыми от id в базе, но наиболее простой метод описан выше. Я могу ошибаться и буду рад, если меня поправят.
    }

    private function calculateEquals($ticket_adult_price, $ticket_adult_quantity, $ticket_kid_price, $ticket_kid_quantity,
                                     $params)
    {
        $response = 0;
        switch ($params) {
            case 'equal':
                $response = $ticket_adult_price * $ticket_adult_quantity + $ticket_kid_price * $ticket_kid_quantity;
                break;
            case 'kidEqual': // Пример
                $response = $ticket_kid_quantity * $ticket_kid_price;
        }

        return $response;
        //Вынес в отдельную функцию, чтобы упростить визуально подсчет иных(не описанных в задании) сумм.

    }

    private function storeOrder()
    {
        $orderInfo = session()->get('orderInfo');
        $event_id = $orderInfo['event_id'];
        $event_date = $orderInfo['event_date'];
        $ticket_adult_price = $orderInfo['ticket_adult_price'];
        $ticket_kid_price = $orderInfo['ticket_kid_price'];
        $ticket_adult_quantity = $orderInfo['ticket_adult_quantity'];
        $ticket_kid_quantity = $orderInfo['ticket_kid_quantity'];
        $barcode = $orderInfo['barcode'];
        $equal = $this->calculateEquals($ticket_adult_price, $ticket_adult_quantity, $ticket_kid_price,
            $ticket_kid_quantity, 'equal');
        Order::create([
            'event_id' => $event_id,
            'event_date' => $event_date,
            'barcode' => $barcode,
            'ticket_adult_price' => $ticket_adult_price,
            'ticket_adult_quantity' => $ticket_adult_quantity,
            'ticket_kid_price' => $ticket_kid_price,
            'ticket_kid_quantity' => $ticket_kid_quantity,
            'user_id' => random_int(23, 230),
            'equal_price' => $equal,
            'created' => now()
        ]);
    }


    public function bookOrder($data)
    {


        do {
            $barcode = $this->generateBarcode();
            $response = Http::post('http://localhost:8000/book', [
                'event_id' => $data['event_id'],
                'event_date' => $data['event_date'],
                'ticket_adult_price' => $data['ticket_adult_price'],
                'ticket_adult_quantity' => $data['ticket_adult_quantity'],
                'ticket_kid_price' => $data['ticket_kid_price'],
                'ticket_kid_quantity' => $data['ticket_kid_quantity'],
                'barcode' => $barcode,
            ]);
            $answers = [
                ['message' => 'order successfully booked'],
                ['error' => 'barcode already exists']
            ];
            $result = $answers[random_int(0, 1)];

            if (isset($result['message']) && $result['message'] === 'order successfully booked') {
                $data += ['barcode' => $barcode];
                session()->put('orderInfo', $data);
//                dump(session()->get('orderInfo'));
                return $result;
            }
        } while (isset($result['error']) && $result['error'] === 'barcode already exists');

        return ['error' => 'Failed to book order after multiple attempts'];
    }

    public function approve($data)
    {
        $response = Http::post('http://localhost:8000/book', [
            'barcode' => $data['barcode']
        ]);


        $answers = [
            ['message' => 'order successfully approved'],
            ['error' => 'event cancelled'],
            ['error' => 'no tickets'],
            ['error' => 'no seats'],
            ['error' => 'fan removed'],
        ];
        $result = $answers[random_int(0, 1)];
        if (isset($result['message']) && $result['message'] === 'order successfully approved') {
            $this->storeOrder();
            return ['message' => 'order successfully approved'];
        }
        return $result;
    }


}
