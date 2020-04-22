@extends('layout.header')

@section('title','Sistem Rekomendasi UNPAR')

@section('container')
<!-- bg-light untuk container -->
<br>
<br>

<div id="accordion" class="bg-light">
    <br>
    <form action="" method="post">
        @csrf
        <table align="center">
            <tr>
                <td colspan="2">
                    <h2 class="text-center"> Jurusan Saat SMA dan Metode Pengujian: </h2>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h5 class="text-center">
                                <input type="submit" value="IPA Basic" name="btn" class="btn btn-info">
                            </h5>
                        </div>
                </td>
                <td>
                    <div class="card-header" id="headingTwo">
                        <h5 class="text-center">
                            <input type="submit" value="IPS Basic" name="btn" class="btn btn-info">
                        </h5>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h5 class="text-center">
                                <input type="submit" value="IPA Kmeans" name="btn" class="btn btn-info">
                            </h5>
                        </div>
                </td>
                <td>
                    <div class="card-header" id="headingTwo">
                        <h5 class="text-center">
                            <input type="submit" value="IPS Kmeans" name="btn" class="btn btn-info">
                        </h5>
                    </div>
                </td>
            </tr>
        </table>
    </form>
</div>

<br>
<br>

<div style="width: 75%; margin: auto;" class="container">
    <table align="center" class="table table-striped table-bordered">
        <?php
        $status ?? '';
        if ($status ?? '') {
            if ($metode == 'Basic') {
                // UNTUK AKURASI
                echo "<tr>";
                echo "<th style=width: 5%>No</th>";
                echo "<th> MAE </th>";
                echo "<th> RMSE </th>";
                echo "<th> Time (Mic Sec) </th>";
                echo "</tr>";

                echo "<tr>";
                echo "<td>" . 1 . "</td>";
                echo "<td>" . $mae . "</td>";
                echo "<td>" . $rmse . "</td>";
                echo "<td>" . $times . "</td>";
                echo "</tr>";


                // UNTUK BAGIAN DETAIL
                //     print("MEAN ABSOLUTE ERROR = " . $mae);
                //     echo "<br>";
                //     echo "<br>";

                //     print("ROOT MEAN SQUARE ERROR = " . $rmse);
                //     echo "<br>";
                //     echo "<br>";

                //     print("EXECUTION TIME = " . $times);
                //     echo "<br>";
                //     echo "<br>";

                //     echo "<tr>";
                //     echo "<th style=width: 5%>No</th>";
                //     echo "<th>NPM</th>";
                //     echo "<th>Program Studi</th>";
                //     echo "<th>IPK</th>";
                //     echo "<th>Prediksi IPK</th>";
                //     echo "<th>Error MAE</th>";
                //     echo "<th>Error RMSE</th>";
                //     echo "</tr>";


                //     $i = 1;
                //     foreach ($result as $res) {
                //         echo "<tr>";
                //         echo "<td>" . $i . "</td>";
                //         echo "<td>" . $res[0] . "</td>";
                //         echo "<td>" . $res[1] . "</td>";
                //         echo "<td>" . $res[2] . "</td>";
                //         echo "<td>" . $res[3] . "</td>";
                //         echo "<td>" . $res[4] . "</td>";
                //         echo "<td>" . $res[5] . "</td>";
                //         echo "</tr>";
                //         $i++;
                //     }
            } else if ($metode == 'Kmeans') {
                echo "<tr>";
                echo "<th style=width: 5%>K</th>";
                echo "<th> MAE </th>";
                echo "<th> RMSE </th>";
                echo "<th> Time (Mic Sec) </th>";
                echo "</tr>";

                // print_r($maeArr);
                $k = 2;
                foreach ($maeArr as $idx => $value) {
                    echo "<tr>";
                    echo "<td>" . $k . "</td>";
                    echo "<td>" . $maeArr[$idx] . "</td>";
                    echo "<td>" . $rmseArr[$idx] . "</td>";
                    echo "<td>" . $timesArr[$idx] . "</td>";
                    echo "</tr>";
                    $k++;
                }
            }
        }
        ?>
    </table>
</div>

<br>
<br>
@endsection