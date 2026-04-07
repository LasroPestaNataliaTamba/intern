<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<style>
body{
    font-family: Arial, sans-serif;
    font-size:14px;
}

.title{
    text-align:center;
    font-weight:bold;
    font-size:20px;
    margin-bottom:30px;
}

.right{
    text-align:right;
}

.section{
    margin-top:20px;
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:25px;
}

td, th{
    border:1px solid black;
    padding:8px;
    text-align:center;
}
</style>

</head>
<body>

<div class="title">
FORMULIR IZIN CUTI KARYAWAN
</div>

<div class="right">
Jakarta, {{ now()->format('d F Y') }}
</div>

<div class="section">
Kepada Yth,<br>
<b>Ibu Agustina Panjaitan</b><br>
Direktur<br>
PT. Arkamaya Guna Saharsa<br>
Di tempat
</div>

<div class="section">
Perihal: <b>Permohonan Cuti</b>
</div>

<div class="section">
Dengan Hormat,<br><br>

Saya yang bertanda tangan di bawah ini:
<br><br>

Nama : {{ $leave->user->name }} <br>
Jabatan : {{ $leave->user->position ?? 'Staff' }}
</div>

<div class="section">
Dengan ini mengajukan permohonan cuti kerja sebagai berikut:
<br><br>

Mulai Tanggal : {{ $leave->start_date }} <br>
Sampai Dengan Tanggal : {{ $leave->end_date }} <br>
Jumlah Hari Cuti : {{ \Carbon\Carbon::parse($leave->start_date)->diffInDays($leave->end_date)+1 }} Hari <br>
Sisa Cuti : - <br>
Untuk Keperluan : {{ $leave->reason }}
</div>

<div class="section">
Demikian permohonan cuti kerja ini saya ajukan.
</div>

<table>
<tr>
<th>Diajukan Oleh</th>
<th>Diizinkan Oleh</th>
<th>Disetujui Oleh</th>
</tr>

<tr>
<td height="100"></td>
<td></td>
<td></td>
</tr>

<tr>
<td>{{ $leave->user->name }}</td>
<td>Head Division</td>
<td>Agustina Panjaitan</td>
</tr>

<tr>
<td>Staff</td>
<td>Kepala Divisi</td>
<td>Direktur</td>
</tr>
</table>

</body>
</html>
