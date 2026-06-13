@extends('layout.admin_layout')
@section('title', 'Supprimer rayon')
@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Supprimer rayon</h2>
        <p class="text-sm text-slate-500 mt-0.5">Permanently Supprimer a shelf from the library</p>
    </div>
    <nav class="flex items-center gap-2 text-xs text-slate-400">
        <a href="{{ url('admin/dashboard') }}" class="hover:text-[#4F6FCD] transition-colors">Dashboard</a>
        <i class="fas fa-chevron-right text-[10px]"></i>
        <span class="text-slate-600 font-medium">Supprimer rayon</span>
    </nav>
</div>

<div class="mb-5 flex items-center gap-3 p-4 rounded-xl" style="background:#fff1f2; border:1px solid #fecdd3;">
    <i class="fas fa-triangle-exclamation text-lg flex-shrink-0" style="color:#DC2626;"></i>
    <p class="text-sm font-semibold" style="color:#991b1b;">Removing a shelf is permanent. Ensure all books have been removed from the shelf first.</p>
</div>

<div class="bg-white rounded-2xl shadow-md overflow-hidden">
    <div class="px-6 py-4 flex items-center gap-3" style="border-bottom:1px solid #E8EDF2;">
        <div class="w-9 h-9 bg-red-50 rounded-xl flex items-center justify-center">
            <i class="fas fa-layer-group text-red-500"></i>
        </div>
        <div>
            <h3 class="font-bold text-slate-800 text-sm">All Shelves</h3>
            <p class="text-xs text-slate-400">Select a shelf to remove permanently</p>
        </div>
    </div>
    <div class="overflow-x-auto p-4">
        <table id="dataTable" class="w-full text-sm">
            <thead>
                <tr style="background:#F8FAFC;">
                    <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">#</th>
                    <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">ID Rayon</th>
                    <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">Emplacement</th>
                    <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">Books on Shelf</th>
                    <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">Action</th>
                </tr>
            </thead>
            <tbody>
                @php $count = 1; @endphp
                @forelse($shelf as $row)
                @php $book_count = DB::table('books')->where('Shelf_ID',$row->Shelf_ID)->count(); @endphp
                <tr>
                    <td class="px-4 py-4 text-slate-400 font-semibold">{{ str_pad($count, 2, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-4 py-4 font-mono text-slate-600 text-xs font-bold">{{ $row->Shelf_ID }}</td>
                    <td class="px-4 py-4 font-bold text-slate-800">{{ $row->Shelf_Location }}</td>
                    <td class="px-4 py-4">
                        @if($book_count > 0)
                            <span class="inline-flex items-center gap-1 text-xs font-bold px-2.5 py-1 rounded-full" style="background:#FEF3C7; color:#92400E;">
                                <i class="fas fa-exclamation-circle text-[10px]"></i> {{ $book_count }} books
                            </span>
                        @else
                            <span class="text-xs font-bold px-2.5 py-1 rounded-full" style="background:#D1FAE5; color:#065F46;">vide</span>
                        @endif
                    </td>
                    <td class="px-4 py-4">
                        <a href="{{ url('admin/shelf/Supprimer/'.$row->id) }}"
                           onclick="return Confirmer('Permanently Supprimer shelf \'{{ $row->Shelf_ID }}\'? This cannot be undone.')"
                           class="inline-flex items-center gap-1.5 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition-all duration-200 shadow-sm"
                           style="background:#DC2626;"
                           onmouseover="this.style.background='#b91c1c';" onmouseout="this.style.background='#DC2626';">
                            <i class="fas fa-trash text-[10px]"></i> Supprimer
                        </a>
                    </td>
                </tr>
                @php $count++; @endphp
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-20 text-center">
                        <div class="flex flex-col items-center gap-4">
                            <div class="w-20 h-20 rounded-2xl flex items-center justify-center" style="background:#F4F6FA;">
                                <i class="fas fa-layer-group text-4xl" style="color:#cbd5e1;"></i>
                            </div>
                            <p class="font-bold text-slate-500">No shelves found</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
