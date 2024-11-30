<?php 
$api_url = "https://data.gov.bh/api/explore/v2.1/catalog/datasets/01-statistics-of-students-nationalities_updated/records?where=colleges%20like%20%22IT%22%20AND%20the_programs%20like%20%22bachelor%22&limit=100";

$response = file_get_contents($api_url);

if ($response === FALSE) {
    die("Error fetching API data.");
}
$data = json_decode($response, true);

$results = $data['results'] ?? [];

$nationality_data = [];

foreach ($results as $record) {
    $fields = $record['record']['fields'] ?? [];
    $nationality = $fields['nationality'] ?? 'Unknown';
    $count = $fields['number_of_students'] ?? 0;

    if (isset($nationality_data[$nationality])) {
        $nationality_data[$nationality] += $count;
    } else {
        $nationality_data[$nationality] = $count;
    }
}

arsort($nationality_data);
?>