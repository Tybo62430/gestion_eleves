<?php

namespace AppBundle\FeriesApi;

/**
 * Description of FeriesApi
 *
 * @author busipart
 */
class FeriesApi {

    public function GetCurrent() {

        $curl = curl_init();
        
        $annee = \date('Y');

        $opts = [
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_URL => "https://calendrier.api.gouv.fr/jours-feries/metropole/". $annee .".json",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CONNECTTIMEOUT => 30
        ];

        curl_setopt_array($curl, $opts);

        $response = curl_exec($curl);

        $jourFeries = json_decode($response, true);

        $i = 0;
        $tab = [];

        foreach ($jourFeries as $jour => $value) {
            $tab[$i][] = $jour;
            $tab[$i][] = $value;
            $i++;
        }
        return $tab;
    }

}
