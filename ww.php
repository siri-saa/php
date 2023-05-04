<?php
// Your OpenWeatherMap API key
$api_key = 'add api key here';

// URL for current weather API
$current_url = 'http://api.openweathermap.org/data/2.5/weather?q=Kathmandu&units=metric&appid=' . $api_key;

// URL for past 7 days weather API
$history_url = 'http://api.openweathermap.org/data/2.5/onecall/timemachine?lat=27.7172&lon=85.324&units=metric&dt=%d&appid=' . $api_key;

// Today's date and time
$current_timestamp = time();

// Array to store the weather data
$weather_data = array();

// Fetch current weather data
$current_data = json_decode(file_get_contents($current_url));

// Store current weather data in the array
$weather_data[] = array(
    'date' => date('Y-m-d H:i:s', $current_timestamp),
    'temp' => $current_data->main->temp,
    'description' => $current_data->weather[0]->description,
    'icon' => $current_data->weather[0]->icon
);

// Fetch past 7 days weather data
for ($i = 1; $i <= 7; $i++) {
    $timestamp = $current_timestamp - ($i * 24 * 60 * 60);
    $history_data = json_decode(file_get_contents(sprintf($history_url, $timestamp)));
    $weather_data[] = array(
        'date' => date('Y-m-d H:i:s', $timestamp),
        'temp' => $history_data->current->temp,
        'description' => $history_data->current->weather[0]->description,
        'icon' => $history_data->current->weather[0]->icon
    );
}

// Output the weather data
foreach ($weather_data as $data) {
    echo '<h2>' . $data['date'] . '</h2>';
    echo '<p>Temperature: ' . $data['temp'] . ' &#8451;</p>';
    echo '<p>Description: ' . $data['description'] . '</p>';
    echo '<img src="http://openweathermap.org/img/w/' . $data['icon'] . '.png">';
    echo '<hr>';
}
?>
