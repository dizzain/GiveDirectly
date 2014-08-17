<?php defined('SYSPATH') or die;

    class Dealroom_SimilarWeb {

        //Default key for SimilarWeb, actual key is in init.php
        const USER_KEY = '3cb10ba530bb3d35e073ccf1d0f8fb8d';

        /**
        * Get the traffic data from the database
        *
        * @param Integer $business_objects_id       DB id of the company
        * @param Boolean $last_result               Get only the last result
        *
        * return array
        */
        public static function traffic_data_db($business_objects_id, $last_result = true) {
            $result = null;
            $last_row = null;
            $data = ORM::factory('CompanySimilarWeb')
                    ->where('business_objects_id', '=', $business_objects_id)
                    ->order_by('traffic_year', 'DESC')
                    ->order_by('traffic_month', 'DESC')
                    ->find_all();

            if(count($data)){
                $result = json_decode($data{0}->traffic_reach_json, 1);
                $last_row = json_decode($data{count($data)-1}->traffic_users);
            }

            if (!empty($last_row) and is_numeric($last_row) and is_array($result)) {
                $result = array_merge($result, array('InitialVisitors' => $last_row));
            }

            return $result;
        } 


        /**
        * Get traffic data from SimilarWeb api
        *
        * @param String $site       domain of the site to search
        *
        * return array              Results from SimilarWeb or an empty array if no info
        *
        */
        public static function traffic_data($site) {


            $result = array();

            if (empty($site)) {
                return $result;
            }

            // Get the API Key
            if (defined('SIMILAR_WEB_API_KEY')) {
                $api_key = SIMILAR_WEB_API_KEY;
            }
            else {
                $api_key = self::USER_KEY;
            }


            //Format site

            $site = str_replace('http://', null, $site);
            $site = str_replace('https://', null, $site);
            $site = str_replace('www.', null, $site);  
            $site = trim($site, '/');


            // api call for estimated visits

            $call_request = "http://api.similarweb.com/Site/{$site}/v1/EstimatedTraffic?Format=JSON&UserKey=" . $api_key;
            $visitors     = self::get_data($call_request);
            $visitors     = json_decode($visitors, 1);

            if (is_array($visitors)) {
                $result = array_merge($result, $visitors);
            }



            // api call for traffic reach

            $call_request = "http://api.similarweb.com/Site/{$site}/v1/traffic?Format=JSON&UserKey=" . $api_key;
            $traffic      = self::get_data($call_request);
            $traffic      = json_decode($traffic, 1);


            // get top 4 countries

            $top_countries = array();
            if (!empty($traffic['TopCountryShares'])) {
                $limit = count($traffic['TopCountryShares']) < 4 ? count($traffic['TopCountryShares']) -1 : 3;

                for ($index = 0; $index <= $limit; $index++) {
                    $country = self::convert_iso_codes_into_country($traffic['TopCountryShares'][$index]['CountryCode']);
                    $top_countries[$country] = $traffic['TopCountryShares'][$index]['TrafficShare'] * 100;

                }
            }

            $result = array_merge($result, array('TopCountries' => $top_countries));


            // get traffic sources
            $sources =  array();

            if (!empty($traffic['TrafficShares']) and is_array($traffic['TrafficShares'])) {
                foreach ($traffic['TrafficShares'] as $source) {
                    $sources[$source['SourceType']] = $source['SourceValue'] * 100;
                }
            }

            $result = array_merge($result, array('TrafficSources' => $sources));
 

            // get the date of the source

            $date = isset($traffic['Date']) ? $traffic['Date'] : array();
            $result = array_merge($result, array('Date' => $date));

            return $result;

        }


        public static function traffic_data_historic($site) {
            $result = array();

            if (empty($site)) {
                return $result;
            }

            // Get the API Key
            if (defined('SIMILAR_WEB_API_KEY')) {
                $api_key = SIMILAR_WEB_API_KEY;
            }
            else {
                $api_key = self::USER_KEY;
            }


            //Format site

            $site = str_replace('http://', null, $site);
            $site = str_replace('https://', null, $site);
            $site = str_replace('www.', null, $site);  
            $site = trim($site, '/');


            // api call for estimated visits

            $start = date('m-Y', strtotime('-12 months'));
            $end   = date('m-Y', strtotime("-2 months"));
            $call_request = "http://api.similarweb.com/Site/{$site}/v1/visits?gr=monthly&start={$start}&end={$end}&md=true&Format=JSON&UserKey=" . $api_key;
            $visitors     = self::get_data($call_request);
            $visitors     = json_decode($visitors, 1);

            return $visitors;


        }

        /**
        * Get data from a URL using cURL
        *
        * String $url
        *
        * return Strng
        */
        private static function get_data($url)
        {
            $ch = curl_init();
            $timeout = 2;
            curl_setopt($ch,CURLOPT_URL, $url);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, $timeout);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
        }


        /**
        * Convert ISO-3166-1 codes into country names
        *
        * String $iso_code      3-digit ISO code (might have leading zeroes)
        *
        * return String         The country name or 'Unknown' if not found
        */
        private static function convert_iso_codes_into_country($iso_code) {
            $countries = array(
                "248" => "Åland Islands",
                "004" => "Afghanistan",
                "008" => "Albania",
                "012" => "Algeria",
                "016" => "American Samoa",
                "020" => "Andorra",
                "024" => "Angola",
                "660" => "Anguilla",
                "010" => "Antarctica",
                "028" => "Antigua and Barbuda",
                "032" => "Argentina",
                "051" => "Armenia",
                "533" => "Aruba",
                "036" => "Australia",
                "040" => "Austria",
                "031" => "Azerbaijan",
                "044" => "Bahamas",
                "048" => "Bahrain",
                "050" => "Bangladesh",
                "052" => "Barbados",
                "112" => "Belarus",
                "056" => "Belgium",
                "084" => "Belize",
                "204" => "Benin",
                "060" => "Bermuda",
                "064" => "Bhutan",
                "068" => "Bolivia",
                "070" => "Bosnia and Herzegovina",
                "072" => "Botswana",
                "074" => "Bouvet Island",
                "076" => "Brazil",
                "086" => "British Indian Ocean Territory",
                "096" => "Brunei",
                "100" => "Bulgaria",
                "854" => "Burkina Faso",
                "108" => "Burundi",
                "116" => "Cambodia",
                "120" => "Cameroon",
                "124" => "Canada",
                "132" => "Cabo Verde",
                "136" => "Cayman Islands",
                "140" => "Central African Republic",
                "148" => "Chad",
                "152" => "Chile",
                "156" => "China",
                "162" => "Christmas Island",
                "166" => "Cocos (Keeling) Islands",
                "170" => "Colombia",
                "174" => "Comoros",
                "178" => "Congo",
                "180" => "Congo, D.R.",
                "184" => "Cook Islands",
                "188" => "Costa Rica",
                "384" => "Côte d'Ivoire",
                "191" => "Croatia",
                "192" => "Cuba",
                "531" => "Curaçao",
                "196" => "Cyprus",
                "203" => "Czech Republic",
                "208" => "Denmark",
                "262" => "Djibouti",
                "212" => "Dominica",
                "214" => "Dominican Republic",
                "218" => "Ecuador",
                "818" => "Egypt",
                "222" => "El Salvador",
                "226" => "Equatorial Guinea",
                "232" => "Eritrea",
                "233" => "Estonia",
                "231" => "Ethiopia",
                "238" => "Falkland Islands (Islas Malvinas)",
                "234" => "Faroe Islands",
                "242" => "Fiji",
                "246" => "Finland",
                "250" => "France",
                "254" => "French Guiana",
                "258" => "French Polynesia",
                "260" => "French Southern Territories",
                "266" => "Gabon",
                "270" => "Gambia",
                "268" => "Georgia",
                "276" => "Germany",
                "288" => "Ghana",
                "292" => "Gibraltar",
                "300" => "Greece",
                "304" => "Greenland",
                "308" => "Grenada",
                "312" => "Guadeloupe",
                "316" => "Guam",
                "320" => "Guatemala",
                "831" => "Guernsey",
                "324" => "Guinea",
                "624" => "Guinea-Bissau",
                "328" => "Guyana",
                "332" => "Haiti",
                "334" => "Heard Island and McDonald Islands",
                "336" => "Vatican City",
                "340" => "Honduras",
                "344" => "Hong Kong",
                "348" => "Hungary",
                "352" => "Iceland",
                "356" => "India",
                "360" => "Indonesia",
                "364" => "Iran",
                "368" => "Iraq",
                "372" => "Ireland",
                "833" => "Isle of Man",
                "376" => "Israel",
                "380" => "Italy",
                "388" => "Jamaica",
                "392" => "Japan",
                "832" => "Jersey",
                "400" => "Jordan",
                "398" => "Kazakhstan",
                "404" => "Kenya",
                "296" => "Kiribati",
                "408" => "North Korea",
                "410" => "South Korea",
                "414" => "Kuwait",
                "417" => "Kyrgyzstan",
                "418" => "Laos",
                "428" => "Latvia",
                "422" => "Lebanon",
                "426" => "Lesotho",
                "430" => "Liberia",
                "434" => "Libya",
                "438" => "Liechtenstein",
                "440" => "Lithuania",
                "442" => "Luxembourg",
                "446" => "Macao",
                "807" => "Macedonia",
                "450" => "Madagascar",
                "454" => "Malawi",
                "458" => "Malaysia",
                "462" => "Maldives",
                "466" => "Mali",
                "470" => "Malta",
                "584" => "Marshall Islands",
                "474" => "Martinique",
                "478" => "Mauritania",
                "480" => "Mauritius",
                "175" => "Mayotte",
                "484" => "Mexico",
                "583" => "Micronesia",
                "498" => "Moldova",
                "492" => "Monaco",
                "496" => "Mongolia",
                "499" => "Montenegro",
                "500" => "Montserrat",
                "504" => "Morocco",
                "508" => "Mozambique",
                "104" => "Myanmar",
                "516" => "Namibia",
                "520" => "Nauru",
                "524" => "Nepal",
                "528" => "Netherlands",
                "540" => "New Caledonia",
                "554" => "New Zealand",
                "558" => "Nicaragua",
                "562" => "Niger",
                "566" => "Nigeria",
                "570" => "Niue",
                "574" => "Norfolk Island",
                "580" => "Northern Mariana Islands",
                "578" => "Norway",
                "512" => "Oman",
                "586" => "Pakistan",
                "585" => "Palau",
                "275" => "Palestine",
                "591" => "Panama",
                "598" => "Papua new Guinea",
                "600" => "Paraguay",
                "604" => "Peru",
                "608" => "Philippines",
                "612" => "Pitcairn Island",
                "616" => "Poland",
                "620" => "Portugal",
                "630" => "Puerto Rico",
                "634" => "Qatar",
                "638" => "Réunion",
                "642" => "Romania",
                "643" => "Russia",
                "646" => "Rwanda",
                "654" => "Saint Helena",
                "659" => "Saint Kitts And Nevis",
                "662" => "Saint Lucia",
                "663" => "Saint Martin",
                "666" => "Saint Pierre and Miquelon",
                "670" => "Saint Vincent and the Grenadines",
                "882" => "Samoa",
                "674" => "San Marino",
                "678" => "Sao Tome and Principe",
                "682" => "Saudi Arabia",
                "686" => "Senegal",
                "688" => "Serbia",
                "690" => "Seychelles",
                "694" => "Sierra Leone",
                "702" => "Singapore",
                "534" => "Sint Maarten",
                "703" => "Slovakia",
                "705" => "Slovenia",
                "090" => "Solomon Islands",
                "706" => "Somalia",
                "710" => "South Africa",
                "239" => "South Georgia and the South Sandwich Islands",
                "724" => "Spain",
                "144" => "Sri Lanka",
                "729" => "Sudan",
                "740" => "Suriname",
                "744" => "Svalbard and Jan Mayen Islands",
                "748" => "Swaziland",
                "752" => "Sweden",
                "756" => "Switzerland",
                "760" => "Syria",
                "158" => "Taiwan",
                "762" => "Tajikistan",
                "834" => "Tanzania",
                "764" => "Thailand",
                "628" => "Timor-Leste",
                "768" => "Togo",
                "772" => "Tokelau",
                "776" => "Tonga",
                "780" => "Trinidad And Tobago",
                "788" => "Tunisia",
                "792" => "Turkey",
                "795" => "Turkmenistan",
                "796" => "Turks and Caicos Islands",
                "798" => "Tuvalu",
                "800" => "Uganda",
                "804" => "Ukraine",
                "784" => "United Arab Emirates",
                "826" => "United Kingdom",
                "840" => "United States",
                "581" => "United States Minor Outlying Islands",
                "858" => "Uruguay",
                "860" => "Uzbekistan",
                "548" => "Vanuatu",
                "862" => "Venezuela",
                "704" => "Vietnam",
                "092" => "British Virgin Islands",
                "850" => "US Virgin Islands",
                "876" => "Wallis and Fortuna",
                "732" => "Western Sahara",
                "887" => "Yemen",
                "894" => "Zambia",
                "716" => "Zimbabwe"
            );

            if (!empty($countries[$iso_code])) {
                return $countries[$iso_code];
            }
            else {
                $iso_code = str_pad($iso_code, 3, '0', STR_PAD_LEFT);
                if (isset($countries[$iso_code])) {
                    return $countries[$iso_code];
                }
                else {
                    return 'Unknown';
                }
            }
        }

    }


