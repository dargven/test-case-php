<?php namespace application\modules\Order;


class Order
{
    private $db;

    function __construct($db)
    {
        $this->db = $db;

    }

    private function generateBarCode()
    {

        $timestamp = round(microtime(true) * 1000);
        $randomPart = random_int(1000, 9999);
        $randomPart2 = random_int(1000, 9999);

        return $randomPart . substr($timestamp, 11, 5) . $randomPart2;
    }

    private function apiBook()//$event_id, $event_date, $ticket_adult_price, $ticket_adult_quantity,
        //$ticket_kid_price, $ticket_kid_quantity, $barcode)
    {
        #Возвращаемые данные в рандомном порядке
        $answers = [
            ['message' => 'order successfully booked'],
            ['error' => 'barcode already exists']
        ];
        return $answers[random_int(0, 1)];
    }

    private function apiApprove($barcode)
    {
        $answers = [
            ['message' => 'order successfully approved'],
            ['error' => 1003],
            ['error' => 1004],
            ['error' => 1005],
            ['error' => 1006],
        ];
        return $answers[random_int(0, 4)];
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
                $response = $ticket_adult_quantity * $ticket_kid_price;
        }

        return $response;
        //Вынес в отдельную функцию, чтобы упростить визуально подсчет иных(не описанных в задании) сумм.

    }

//    После проверки кода очень хочу обсудить эту проверку. Могу ошибаться, но я считаю ее излишней, поскольку microtime и синхронность
//     PHP(не учитывая многопоточности) и так позволяют сгенерировать уникальный barcode. Но я могу ошибаться, буду рад анализу кода.
//     На всякий случай моя почта: dargven@yandex.ru

    public function addOrder($event_id, $event_date, $ticket_adult_price, $ticket_adult_quantity,
                             $ticket_kid_price, $ticket_kid_quantity)
    {
        $barcode = $this->checkBarCode();
//        var_dump($barcode);
        if ($barcode) {
            $user_id = random_int(2, 15);
            $equalPrice = $this->calculateEquals($ticket_adult_price, $ticket_adult_quantity,
                $ticket_kid_price, $ticket_kid_quantity, 'equal');
            $response = $this->apiApprove($barcode);
//            var_dump($response);
            if (isset($response['message']) && $response['message'] === 'order successfully approved') {
                $this->db->addOrder($event_id, $event_date, $ticket_adult_price,
                    $ticket_adult_quantity, $ticket_kid_price, $ticket_kid_quantity, $barcode, $equalPrice, $user_id);
                return true;
            
            }
            return $response;
        }
        return ['error' => 1001];

    }

}
