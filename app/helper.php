<?php

function getRZRResponse($url, $method, $params = null)
{

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJDb21wYW55SWQiOiIzMDIwNCIsIlVzZXJJZCI6IjciLCJuYmYiOjE2NjE5NjgxNDAsImV4cCI6MTc4MjA1NDU0MCwiaXNzIjoiUmF6b3IgdHN0LXByb2R1Y3Rpb24gQVBJIGVuZCB1c2VyIiwiYXVkIjoiUmF6b3IgdHN0LXByb2R1Y3Rpb24gQVBJIn0.Fy05Q3UxX-e5Cfc22YOkp-urquNS_6MFqoHk22KTlVI'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return $response;
}

function chart_colors()
{
    $colors = [
        '#FEC0CB', '#FF66FF', '#F36196', '#FE009A', '#DD85D8', '#FF058D', '#F0C0FE', '#DD85D8', '#F6909D', '#EC0ED9',
        '#FF01CC', '#EE6C8A', '#fe6c9e', '#de9dac', '#FD1593', '#C71585', '#f22952', '#C27E79', '#ff6ec7', '#ff0490',
        '#c8aca9', '#e0218a', '#ffd1dc', '#ff66cc', '#ffa6c9', '#de5d83', '#ff007f', '#ff1493', '#ffc1cc', '#D648D7',
        '#ffb7c5', '#ffd7e9', '#65000b', '#FFB6C1', '#ff00ff', '#f4c2c2', '#ff69b4', '#ffe5b4', '#e75480', '#F89880',
        '#f88379', '#a94064', '#ff9999', '#d5a499', '#fc8eac', '#fc6c85', '#ffd1dc', '#ff77ff'
    ];

    return $colors[array_rand($colors)];
}

