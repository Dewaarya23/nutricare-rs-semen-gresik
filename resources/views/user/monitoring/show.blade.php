@extends('layouts.user')

@section('title','Detail Monitoring')

@section('content')

<div class="bg-white p-6 rounded shadow">

    <h2 class="text-2xl font-bold mb-6 text-gray-800">
        {{ auth()->user()->name }} -
        {{ \Carbon\Carbon::parse($monitoring->tanggal)->format('d-m-Y') }}
    </h2>

    @php
        $label = [
            'pagi' => 'Makan Pagi',
            'siang' => 'Makan Siang',
            'malam' => 'Makan Malam'
        ];

        $grandTotal = 0;
    @endphp

    @foreach($monitoring->details as $detail)

        @php
            $grandTotal += $detail->total_kkal;
        @endphp

        <div class="mb-8">

            <h3 class="font-semibold text-lg text-green-700 mb-3">
                {{ $label[$detail->jenis_makan] }}
            </h3>

            <div class="overflow-x-auto">
                <table class="w-full border text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-3 py-2 text-left">Kode</th>
                            <th class="border px-3 py-2 text-left">Nama Menu</th>
                            <th class="border px-3 py-2 text-center">Gram</th>
                            <th class="border px-3 py-2 text-right">Kkal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($detail->items as $i)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-3 py-2">
                                {{ $i->kode_menu }}
                            </td>

                            <td class="border px-3 py-2">
                                {{ $i->menu->nama_menu ?? '-' }}
                            </td>

                            <td class="border px-3 py-2 text-center">
                                {{ $i->gram }}
                            </td>

                            <td class="border px-3 py-2 text-right">
                                {{ number_format($i->kkal,0,',','.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4"
                                class="border px-3 py-3 text-center italic text-gray-500">
                                Belum ada data
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="text-right mt-3 font-bold text-blue-700">
                Total {{ $label[$detail->jenis_makan] }} :
                {{ number_format($detail->total_kkal,0,',','.') }} kkal
            </div>

        </div>

    @endforeach

    <hr class="my-6">

    <div class="grid grid-cols-3 gap-4 mb-6">
    <div class="bg-green-50 p-4 rounded text-center">
        <strong>Karbo</strong><br>
        {{ $monitoring->details->sum('total_karbo') }} g
    </div>
    <div class="bg-green-50 p-4 rounded text-center">
        <strong>Protein</strong><br>
        {{ $monitoring->details->sum('total_protein') }} g
    </div>
    <div class="bg-green-50 p-4 rounded text-center">
        <strong>Lemak</strong><br>
        {{ $monitoring->details->sum('total_lemak') }} g
    </div>
</div>

    <div class="text-right text-xl font-bold text-green-700">
        Grand Total 1 Hari :
        {{ number_format($grandTotal,0,',','.') }} kkal
    </div>

</div>

@endsection
