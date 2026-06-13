@extends('layout.admin_layout')
@section('title', 'Liste des rayons')
@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Liste des rayons</h2>
        <p class="text-sm text-slate-500 mt-0.5">All shelves in the library</p>
    </div>
    <div class="flex items-center gap-3">
        <nav class="flex items-center gap-2 text-xs text-slate-400">
            <a href="{{ url('admin/dashboard') }}" class="hover:text-[#4F6FCD] transition-colors">Dashboard</a>
            <i class="fas fa-chevron-right text-[10px]"></i>
            <span class="text-slate-600 font-medium">Liste des rayons</span>
        </nav>
        <a href="{{ url('admin/add-shelf') }}"
           class="inline-flex items-center gap-1.5 text-white text-xs font-bold px-4 py-2 rounded-lg transition-all duration-200 shadow-sm ml-2"
           style="background:#4F6FCD;"
           onmouseover="this.style.background='#1e40af';" onmouseout="this.style.background='#4F6FCD';">
            <i class="fas fa-plus text-[10px]"></i> Ajouter rayon
        </a>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-md overflow-hidden">
    <div class="px-6 py-4 flex items-center gap-3" style="border-bottom:1px solid #E8EDF2;">
        <div class="w-9 h-9 bg-violet-50 rounded-xl flex items-center justify-center">
            <i class="fas fa-layer-group text-violet-600"></i>
        </div>
        <div>
            <h3 class="font-bold text-slate-800 text-sm">All Shelves</h3>
            <p class="text-xs text-slate-400">Library Emplacement du rayons and availability</p>
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
                @php $available_copy = DB::table('books')->where('Shelf_ID',$row->Shelf_ID)->sum('Amounts'); @endphp
                <tr>
                    <td class="px-4 py-4 text-slate-400 font-semibold">{{ str_pad($count, 2, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-4 py-4 font-mono text-slate-600 text-xs font-bold">{{ $row->Shelf_ID }}</td>
                    <td class="px-4 py-4">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 bg-violet-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-map-marker-alt text-violet-600 text-xs"></i>
                            </div>
                            <span class="font-bold text-slate-800">{{ $row->Shelf_Location }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-4">
                        <span class="text-xs font-bold px-2.5 py-1 rounded-full" style="background:rgba(79,111,205,0.09); color:#4F6FCD;">{{ $available_copy }} books</span>
                    </td>
                    <td class="px-4 py-4">
                        <a href="{{ url('admin/shelf/details/'.$row->id) }}"
                           class="inline-flex items-center gap-1.5 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition-all duration-200 shadow-sm"
                           style="background:#4F6FCD;"
                           onmouseover="this.style.background='#1e40af';" onmouseout="this.style.background='#4F6FCD';">
                            <i class="fas fa-eye text-[10px]"></i> Details
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
                            <a href="{{ url('admin/add-shelf') }}" class="text-xs font-semibold hover:underline" style="color:#4F6FCD;">Add first shelf</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
