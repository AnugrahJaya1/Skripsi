@extends('layout.header')

@section('title','Sistem Rekomendasi UNPAR')

@section('container')



<div id="accordion" class="bg-light">
    <br>
    <h1 align="center">Silakan memilih jurusan Anda saat ini</h1>
    <br>
    <table align="center">
        <tr>
            <td colspan="2">
                <h2 class="text-center"> Jurusan Saat SMA : </h2>
            </td>
        </tr>
        <tr>
            <td>
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="text-center">
                            <button class="btn btn-info" onclick="window.location='/ipa'">
                                IPA
                            </button>
                        </h5>
                    </div>
            </td>
            <td>
                <div class="card-header" id="headingTwo">
                    <h5 class="text-center">
                        <button class="btn btn-info" onclick="window.location='/ips'">
                            IPS
                        </button>
                    </h5>
                </div>
            </td>
        </tr>
    </table>

    <br>
    <br>
</div>
@endsection