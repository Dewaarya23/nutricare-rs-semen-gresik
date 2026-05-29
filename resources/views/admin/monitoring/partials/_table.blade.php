@forelse (($monitorings ?? collect()) as $row)

@php
    $pagi  = $row->details->where('jenis_makan','pagi')->sum('total_kkal');
    $siang = $row->details->where('jenis_makan','siang')->sum('total_kkal');
    $malam = $row->details->where('jenis_makan','malam')->sum('total_kkal');
    $total = $pagi + $siang + $malam;

    // TARGET PER TANGGAL (AMANKAN DATA LAMA)
    $target = $row->target_kkal ?? 0;
    $persen = $target > 0 ? ($total / $target) * 100 : 0;
@endphp

<tr class="hover:bg-green-50 transition">

    <td class="border px-3 py-2 text-center">
        {{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') }}
    </td>

    <td class="border px-3 py-2">
        {{ $row->user->nama ?? '-' }}
    </td>

    <td class="border px-3 py-2 text-center">
        {{ $row->user->jenis_kelamin ?? '-' }}
    </td>

    <td class="border px-3 py-2 text-right">
        {{ number_format($pagi,0,',','.') }}
    </td>

    <td class="border px-3 py-2 text-right">
        {{ number_format($siang,0,',','.') }}
    </td>

    <td class="border px-3 py-2 text-right">
        {{ number_format($malam,0,',','.') }}
    </td>

    <td class="border px-3 py-2 text-right font-bold text-blue-700">
        {{ number_format($total,0,',','.') }}
    </td>

    {{-- PERSEN KEBUTUHAN (FINAL & STABIL) --}}
    <td class="border px-3 py-2 text-center font-semibold
        {{ $persen > 100 ? 'text-red-600' : 'text-green-600' }}">
        {{ number_format($persen,1) }} %
    </td>

    {{-- AKSI --}}
    <td class="border px-3 py-2 text-center space-y-1">

        <a href="{{ route('admin.monitoring.show',$row->id) }}"
           class="block bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded-lg text-xs shadow">
           👁 View
        </a>

        <a href="{{ route('admin.monitoring.edit',$row->id) }}"
           class="block bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg text-xs shadow">
           ✏️ Edit
        </a>

        <form method="POST"
              action="{{ route('admin.monitoring.destroy',$row->id) }}"
              onsubmit="return confirm('Hapus SEMUA data makan hari ini?')">
            @csrf
            @method('DELETE')

            <button type="submit"
                    class="block w-full bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg text-xs shadow">
                🗑 Delete
            </button>
        </form>

    </td>

</tr>

@empty
<tr>
    <td colspan="9" class="text-center py-6 text-gray-500 italic">
        Data tidak ditemukan
    </td>
</tr>
@endforelse
