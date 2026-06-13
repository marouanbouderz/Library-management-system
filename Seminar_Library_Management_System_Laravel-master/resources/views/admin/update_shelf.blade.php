@extends('layout.admin_layout')
@section('title', 'Mettre à jour rayon')
@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Mettre à jour rayon</h2>
        <p class="text-sm text-slate-500 mt-0.5">Modifier rayon locations and details</p>
    </div>
    <a href="{{ url('admin/add-shelf') }}"
       class="inline-flex items-center gap-2 text-white text-sm font-bold px-4 py-2.5 rounded-xl transition-all duration-200 shadow-sm"
       style="background:#4F6FCD;"
       onmouseover="this.style.background='#1e40af';" onmouseout="this.style.background='#4F6FCD';">
        <i class="fas fa-plus text-xs"></i> Ajouter rayon
    </a>
</div>

<div class="bg-white rounded-2xl shadow-md overflow-hidden">
    <div class="px-6 py-4 flex items-center justify-between" style="border-bottom:1px solid #E8EDF2;">
        <p class="text-sm font-bold text-slate-700">
            <span class="text-slate-400 font-normal">Total:</span>
            {{ count($shelf) }} {{ Str::plural('shelf', count($shelf)) }}
        </p>
    </div>

    <div class="overflow-x-auto">
        <table id="dataTable" class="w-full text-sm">
            <thead>
                <tr style="background:#F8FAFC;">
                    <th class="text-left px-6 py-3.5 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">#</th>
                    <th class="text-left px-6 py-3.5 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">ID Rayon</th>
                    <th class="text-left px-6 py-3.5 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">Emplacement</th>
                    <th class="text-left px-6 py-3.5 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">Books</th>
                    <th class="text-right px-6 py-3.5 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($shelf as $i => $row)
                @php $book_count = DB::table('books')->where('Shelf_ID', $row->Shelf_ID)->count(); @endphp
                <tr>
                    <td class="px-6 py-4 text-slate-400 text-xs font-mono">{{ $i + 1 }}</td>
                    <td class="px-6 py-4">
                        <span class="font-mono font-bold text-slate-700 bg-slate-100 px-2 py-0.5 rounded text-xs">{{ $row->Shelf_ID }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-map-pin text-[10px]" style="color:#4F6FCD;"></i>
                            <span class="text-slate-700 font-bold">{{ $row->Shelf_Location }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-1 text-xs font-bold px-2.5 py-1 rounded-full" style="background:#F4F6FA; color:#6B7280;">
                            <i class="fas fa-book text-[10px] text-slate-400"></i>
                            {{ $book_count }} {{ Str::plural('book', $book_count) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ url('admin/shelf/edit/' . $row->id) }}"
                           class="inline-flex items-center gap-1.5 text-white text-xs font-bold px-3.5 py-2 rounded-lg transition-colors"
                           style="background:#4F6FCD;"
                           onmouseover="this.style.background='#1e40af';" onmouseout="this.style.background='#4F6FCD';">
                            <i class="fas fa-pen text-[10px]"></i> Edit
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-20 text-center">
                        <div class="flex flex-col items-center gap-4">
                            <div class="w-20 h-20 rounded-2xl flex items-center justify-center" style="background:#F4F6FA;">
                                <i class="fas fa-layer-group text-4xl" style="color:#cbd5e1;"></i>
                            </div>
                            <p class="font-bold text-slate-500">No shelves found</p>
                            <p class="text-slate-400 text-xs mt-1">Add a shelf to get started.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
