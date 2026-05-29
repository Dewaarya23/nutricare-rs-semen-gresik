<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Rekap Monitoring Gizi Pasien</title>

<style>

/* MARGIN HALAMAN UNTUK DOMPDF */
@page{
    margin: 80px 40px 80px 40px;
}

body{
    font-family: sans-serif;
    font-size:12px;
}

/* HEADER */

.header-table{
    width:100%;
    margin-bottom:20px;
}

.logo{
    width:70px;
}

.title{
    font-size:18px;
    font-weight:bold;
}

.subtitle{
    font-size:13px;
}

/* TABLE */

table{
    width:100%;
    border-collapse:collapse;
}

thead{
    display: table-header-group;
}

tr{
    page-break-inside: avoid;
}

th,td{
    border:1px solid #000;
    padding:6px;
    text-align:center;
}

th{
    background:#f2f2f2;
}

/* FOOTER */

.footer{
    position: fixed;
    bottom:-50px;
    left:0;
    right:0;
    height:40px;
    font-size:11px;
}

.footer .left{
    float:left;
}

.footer .right{
    float:right;
}

.page-number:before{
    content: counter(page);
}

.page-count:before{
    content: counter(pages);
}

</style>

</head>

<body>

<!-- HEADER -->

<table class="header-table">
<tr>

<td style="text-align:center;">
<div style="text-align:center; margin-bottom:20px;">
<div style="font-size:18px; font-weight:bold;">
LAPORAN MONITORING GIZI PASIEN
</div>

<div style="font-size:13px;">
Rumah Sakit Cipta Nirmala
</div>
</div>
</td>

</tr>
</table>

<table>

<thead>

<tr>
<th>Tanggal</th>
<th>Nama</th>
<th>Pagi</th>
<th>Siang</th>
<th>Malam</th>
<th>Total</th>
<th>Target Kalori</th>
<th>Persen Kebutuhan (%)</th>
</tr>

</thead>

<tbody>

@foreach($monitorings as $m)

@php

$pagi = optional($m->details->where('jenis_makan','pagi')->first())->total_kkal ?? 0;
$siang = optional($m->details->where('jenis_makan','siang')->first())->total_kkal ?? 0;
$malam = optional($m->details->where('jenis_makan','malam')->first())->total_kkal ?? 0;

$total = $pagi + $siang + $malam;

$target = $m->target_kkal ?? 0;

$persen = $target > 0 ? ($total / $target) * 100 : 0;

@endphp

<tr>

<td>{{ \Carbon\Carbon::parse($m->tanggal)->format('d-m-Y') }}</td>

<td>{{ $m->user->nama ?? '-' }}</td>

<td>{{ number_format($pagi,0) }}</td>

<td>{{ number_format($siang,0) }}</td>

<td>{{ number_format($malam,0) }}</td>

<td>{{ number_format($total,0) }}</td>

<td>{{ number_format($target,0) }}</td>

<td>{{ number_format($persen,1) }} %</td>

</tr>

@endforeach

</tbody>

</table>

<div class="footer">

<div class="left">
Dicetak oleh Sistem Monitoring Gizi<br>
Tanggal Cetak : {{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}
</div>

<div class="right">
Halaman <span class="page-number"></span> / <span class="page-count"></span>
</div>

</div>

</body>
</html>
