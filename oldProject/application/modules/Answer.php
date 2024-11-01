<?php namespace application\modules;

class Answer
{
    static $CODES = array(

        '101' => 'param method not setted',
        '102' => 'method not found',
        '242' => 'params not set fully',
        '404' => 'not found',
        '9000' => 'unknown error',
        '1001' => 'failed to book order',
        '1002' => 'barcode already exists',
        '1003' => 'event cancelled',
        '1004' => 'no tickets',
        '1005' => 'no seats',
        '1006' => 'fan removed',
    );

    static function response($data)
    {
        if ($data) {
            if (!is_bool($data) && array_key_exists('error', $data)) {
                $code = $data['error'];
                return [
                    'result' => 'error',
                    'error' => [
                        'code' => $code,
                        'text' => self::$CODES[$code]
                    ]
                ];
            }
            return [
                'result' => 'ok',
                'data' => $data
            ];
        }
        $code = 9000;
        return [
            'result' => 'error',
            'error' => [
                'code' => $code,
                'text' => self::$CODES[$code]
            ]
        ];
    }
}
