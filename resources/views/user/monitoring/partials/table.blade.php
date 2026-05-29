@forelse ($monitorings as $row)

@php
    $pagi  = $row->details->where('jenis_makan','pagi')->sum('total_kkal');
    $siang = $row->details->where('jenis_makan','siang')->sum('total_kkal');
    $malam = $row->details->where('jenis_makan','malam')->sum('total_kkal');
    $total = $pagi + $siang + $malam;

    $target = $row->target_kkal ?? 0;
    $persen = $target > 0 ? ($total / $target) * 100 : 0;
@endphp

<tr class="hover:bg-green-50 transition">

    <td class="border px-3 py-2 text-center">
        {{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') }}
    </td>

    <td class="border px-3 py-2">
        {{ auth()->user()->nama ?? '-' }}
    </td>

    <td class="border px-3 py-2 text-center">
        {{ auth()->user()->jenis_kelamin ?? '-' }}
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

    <td class="border px-3 py-2 text-center font-semibold
        {{ $persen > 100 ? 'text-red-600' : 'text-green-600' }}">
        {{ number_format($persen,1) }} %
    </td>

    <td class="border px-3 py-2 text-center">
        <div class="flex justify-center gap-2 flex-wrap">

            <a href="{{ route('user.monitoring.show',$row->id) }}"
               class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded-lg text-xs shadow font-semibold">
               👁 View
            </a>

            <a href="{{ route('user.monitoring.edit',$row->id) }}"
               class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg text-xs shadow font-semibold">
               ✏️ Edit
            </a>

            <form method="POST"
                  action="{{ route('user.monitoring.destroy',$row->id) }}"
                  onsubmit="return confirm('Hapus data hari ini?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg text-xs shadow font-semibold">
                    🗑 Delete
                </button>
            </form>

        </div>
    </td>

</tr>

@empty
<tr>
    <td colspan="9" class="text-center py-6 text-gray-500 italic">
        Data tidak ditemukan
    </td>
</tr>
@endforelse
