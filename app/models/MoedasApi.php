<?php
namespace app\models;

use app\models\Moeda;

class MoedasApi {

    private function request( $endpoint = '' ){
        $uri = "https://economia.awesomeapi.com.br/json/".$endpoint;

        $response = file_get_contents($uri);
        return json_decode($response);       
    } 

    public function getAllMoedas() {
        $array = [];
        $data = $this->request('all');

        if(!empty($data)) {
            foreach($data as $item) {
                $m = new Moeda();
                $m->name = $item->name;
                $m->code = $item->code.'-'.$item->codein;

                $array[] = $m;
            }

            return $array;
        } else {
            return false;
        }
    }

    public function getMoeda( $moeda ) {
        $endpoint = 'daily/'.$moeda.'/7';
        
        $data = $this->request($endpoint);

        if(!empty($data)) {
            $array = [];

            foreach($data as $item) {
                $date = date_create();
                date_timestamp_set($date, $item->timestamp);

                $array[] = [
                    'price' =>  $item->high,
                    'date' => date_format($date, 'M d H:i')
                ];
                      
            }

            $m = new Moeda();
            $m->name     = $data[0]->name;
            $m->code     = $data[0]->code.'-'.$data[0]->codein;
            $m->price    = $data[0]->high;
            $m->date     = date('d', strtotime($data[0]->create_date)).' de '.date('M', strtotime($data[0]->create_date));
            $m->hour     = date('h:i', strtotime($data[0]->create_date));
            $m->lastDays = $array;

            return $m;

        } else {
            return false;
        }
    }

}
