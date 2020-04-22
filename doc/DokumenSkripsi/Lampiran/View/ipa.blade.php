@extends('layout.header')

@section('title','Sistem Rekomendasi UNPAR')

@section('container')

<br>
<br>

<h1 align="center">Silakan mengisi nilai sesuai dengan nilai rapor</h1>
<br>

<div class="card bg-light border-0 ">
    <form action="/result" method="post">
        @csrf
        <table align="center" class="table table-striped table-bordered text-center w-75">
            <tr>
                <th rowspan="2" style="vertical-align: middle;">Mata Pelajaran</th>
                <th colspan="2">Kelas X</th>
                <th colspan="2">Kelas XI</th>
            </tr>
            <tr>
                <th>Semester 1</th>
                <th>Semester 2</th>
                <th>Semester 1</th>
                <th>Semester 2</th>
            </tr>
            <tr>
                <th>Matematika</th>
                <td>
                    <input type="number" name="mtk101" min="0" max="100" step="any" required><br>
                </td>
                <td>
                    <input type="number" name="mtk102" min="0" max="100" step="any" required><br>
                </td>
                <td>
                    <input type="number" name="mtk111" min="0" max="100" step="any" required><br>
                </td>
                <td>
                    <input type="number" name="mtk112" min="0" max="100" step="any" required><br>
                </td>
            </tr>
            <tr>
                <th>Indonesia</th>
                <td>
                    <input type="number" name="ind101" min="0" max="100" step="any" required><br>
                </td>
                <td>
                    <input type="number" name="ind102" min="0" max="100" step="any" required><br>
                </td>
                <td>
                    <input type="number" name="ind111" min="0" max="100" step="any" required><br>
                </td>
                <td>
                    <input type="number" name="ind112" min="0" max="100" step="any" required><br>
                </td>
            </tr>
            <tr>
                <th>Inggris</th>
                <td>
                    <input type="number" name="ing101" min="0" max="100" step="any" required><br>
                </td>
                <td>
                    <input type="number" name="ing102" min="0" max="100" step="any" required><br>
                </td>
                <td>
                    <input type="number" name="ing111" min="0" max="100" step="any" required><br>
                </td>
                <td>
                    <input type="number" name="ing112" min="0" max="100" step="any" required><br>
                </td>
            </tr>
            <tr>
                <th>Fisika</th>
                <td>
                    <input type="number" name="fsk101" min="0" max="100" step="any" required><br>
                </td>
                <td>
                    <input type="number" name="fsk102" min="0" max="100" step="any" required><br>
                </td>
                <td>
                    <input type="number" name="fsk111" min="0" max="100" step="any" required><br>
                </td>
                <td>
                    <input type="number" name="fsk112" min="0" max="100" step="any" required><br>
                </td>
            </tr>
            <tr>
                <th>Kimia</th>
                <td>
                    <input type="number" name="kma101" min="0" max="100" step="any" required><br>
                </td>
                <td>
                    <input type="number" name="kma102" min="0" max="100" step="any" required><br>
                </td>
                <td>
                    <input type="number" name="kma111" min="0" max="100" step="any" required><br>
                </td>
                <td>
                    <input type="number" name="kma112" min="0" max="100" step="any" required><br>
                </td>
            </tr>
        </table>
        <div class="bottom split text-right">
            <input type="submit" value="Submit" name="btnIPA" class="btn bg-success">
        </div>
    <form>
</div>

<br>
<br>
<br>

@endsection