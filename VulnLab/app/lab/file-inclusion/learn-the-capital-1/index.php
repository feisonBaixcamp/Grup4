<?php 
error_reporting(0); // Consider enabling error reporting in a development environment
require("../../../lang/lang.php");
$strings = tr();

$allowedCountries = ['france', 'germany', 'north_korea', 'turkey', 'england'];
$countryFiles = [
    'france' => 'france.php',
    'germany' => 'germany.php',
    'north_korea' => 'north_korea.php',
    'turkey' => 'turkey.php',
    'england' => 'england.php',
];

$selectedCountry = $_GET['country'] ?? null;
$includeFile = '';

if ($selectedCountry && in_array($selectedCountry, $allowedCountries)) {
    $includeFile = $countryFiles[$selectedCountry];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <title><?= $strings['title']; ?></title>
    <style>
        p{
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="container-wrapper">
            <div class="row pt-5">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <form action="index.php" method="GET">
                        <div class="mb-3">
                            <label for="country" class="form-label"><?= $strings['label']; ?></label>
                            <select name="country" id="country" class="form-select">
                                <?php foreach ($allowedCountries as $country): ?>
                                    <option value="<?= $country; ?>"><?= $strings[$country]; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary" type="submit"><?= $strings['button']; ?></button>
                        </div>
                    </form>
                </div>
                <div class="col-md-3"></div>
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="mb-3">
                    <p><?php if ($includeFile) { include($includeFile); } ?></p>
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </div>
    <script id="VLBar" title="<?= $strings['title'] ?>" category-id="6" src="/public/assets/js/vlnav.min.js"></script>
</body>
</html>
