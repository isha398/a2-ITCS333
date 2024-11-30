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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UOB Student Nationality Data</title>
    <!-- Include Pico CSS for styling -->
    <link rel="stylesheet" href="https://unpkg.com/@picocss/pico@latest/css/pico.min.css">
</head>
<body>
    <header>
        <h1>UOB Student Nationality Data</h1>
    </header>
    <main>
      
        <table>
            <thead>
                <tr>
                    <th>Nationality</th>
                    <th>Student Count</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Step 10: Display rows of data
                if (!empty($nationality_data)) {
                    foreach ($nationality_data as $nationality => $count) {
                        echo "<tr>";
                        echo "<td>{$nationality}</td>";
                        echo "<td>{$count}</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No data available</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </main>
    <footer>
        <p>Developed for University of Bahrain - PHP Assignment</p>
    </footer>
</body>
</html>

