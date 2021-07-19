<?php
$status = false;
$msg = "";
$cityname = "";

if (isset($_POST['submit'])) {
    $cityname = $_POST['city'];
    $url = "api.openweathermap.org/data/2.5/weather?q=$cityname&appid=e3e22e0184a20065ecad8378dbb62043";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($result, true);
    if ($result['cod'] == 200) {
        $status = true;
    } else {
        $msg = $result['message'];
    }
    // echo '<pre>';
    // print_r($result);
    // die();
}


?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="index.css">
    <title>Live weather app </title>
</head>

<body>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-md-4 col-sm-12 col-xs-12">
                <div>
                    <form class="d-flex p-4" method="post">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="city" value=<?php echo $cityname ?>>
                        <button class="btn btn-outline-info" type="submit" name="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>

                </div>
                <?php
                if ($status == true) {
                ?>
                    <div class="card p-4">
                        <div class="d-flex">
                            <!-- city name  -->
                            <h6 class="flex-grow-1">
                                <?php echo $result['name'] ?>
                            </h6>
                            <!-- time  -->
                            <h6>
                                <?php
                                echo date('d M', $result['dt']) ?>
                            </h6>
                        </div>

                        <div class="d-flex flex-column temp mt-5 mb-3">
                            <!-- temp in celcius -->
                            <h1 class="mb-0 font-weight-bold" id="heading"> <?php echo round($result['main']['temp'] - 273.15)  ?>°C </h1>
                            <!-- weather type -->
                            <span class="small grey"><?php echo $result['weather'][0]['main'] ?></span>
                        </div>
                        <div class="d-flex">
                            <div class="temp-details flex-grow-1">
                                <!-- temperature high-->
                                <p class="my-1">
                                    <i class="fas fa-temperature-high"></i>
                                    <span style="padding-right: 40px;">
                                        <?php echo round($result['main']['temp_max'] - 273.15)  ?>°C
                                    </span>
                                    <!-- <br> -->
                                    <i class="fas fa-temperature-low"></i>
                                    <span>
                                        <?php echo round($result['main']['temp_min'] - 273.15)  ?>°C
                                    </span>
                                </p>
                                <!-- wind speed -->
                                <p class="my-1"> <i class="fas fa-wind"></i>
                                    <span>
                                        <?php echo $result['wind']['speed'] ?> m/s
                                    </span>
                                </p>
                                <!-- humidity -->
                                <p class="my-1"><i class="fas fa-humidity"></i>
                                    <span>
                                        <?php echo $result['main']['humidity'] ?>%
                                    </span>
                                </p>
                                <!-- sumlight
                            <p class="my-1"> <img src="https://i.imgur.com/wGSJ8C5.png" height="17px"> <span> 0.2h </span> </p> -->
                            </div>
                            <!-- weather logo -->
                            <div> <img src="http://openweathermap.org/img/wn/<?php echo $result['weather'][0]['icon'] ?>@2x.png" width="100px"> </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <p class="d-flex p-4 text-white"><?php echo $msg ?></p>
                <?php } ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>