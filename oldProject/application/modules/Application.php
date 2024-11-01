<?php namespace application\modules;

use application\modules\DB\DB;
use application\modules\Order\Order;


class Application
{
    private Order $order;

    public function __construct()
    {
        $db = new DB();
        $this->order = new Order($db);
    }

    public function addOrder($params)
    {
        $event_id = $params['event_id'];
        $event_date = $params['event_date'];
        $ticket_adult_price = $params['ticket_adult_price'];
        $ticket_adult_quantity = $params['ticket_adult_quantity'];
        $ticket_kid_price = $params['ticket_kid_price'];
        $ticket_kid_quantity = $params['ticket_kid_quantity'];
        if ($event_id && $event_date && $ticket_adult_price &&
            $ticket_adult_quantity && $ticket_kid_price && $ticket_kid_quantity) {
            return $this->order->addOrder($event_id, $event_date, $ticket_adult_price, $ticket_adult_quantity,
                $ticket_kid_price, $ticket_kid_quantity);

        }
        return ['error' => 242];
    }
}