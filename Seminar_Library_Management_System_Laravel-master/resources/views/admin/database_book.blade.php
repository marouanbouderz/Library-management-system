@extends('layout.admin_layout')
@section('title', 'Livres — Bases de données')
@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Livres — Bases de données</h2>
        <p class="text-sm text-slate-500 mt-0.5">Browse the database category collection</p>
    </div>
    <div class="flex items-center gap-3">
        <nav class="flex items-center gap-2 text-xs text-slate-400">
            <a href="{{ url('admin/dashboard') }}" class="hover:text-[#4F6FCD] transition-colors">Dashboard</a>
            <i class="fas fa-chevron-right text-[10px]"></i>
            <span class="text-slate-600 font-medium">Livres — Bases de données</span>
        </nav>
        <a href="{{ url('admin/add-book') }}"
           class="inline-flex items-center gap-1.5 text-white text-xs font-bold px-4 py-2 rounded-lg transition-all duration-200 shadow-sm ml-2"
           style="background:#4F6FCD;"
           onmouseover="this.style.background='#1e40af';" onmouseout="this.style.background='#4F6FCD';">
            <i class="fas fa-plus text-[10px]"></i> Ajouter livre
        </a>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-md overflow-hidden">
    <div class="px-6 py-4 flex items-center gap-3" style="border-bottom:1px solid #E8EDF2;">
        <div class="w-9 h-9 bg-violet-50 rounded-xl flex items-center justify-center">
            <i class="fas fa-database text-violet-600"></i>
        </div>
        <div>
            <h3 class="font-bold text-slate-800 text-sm">Database Collection</h3>
            <p class="text-xs text-slate-400">All database & data management books</p>
        </div>
    </div>
    <div class="overflow-x-auto p-4">
        <table id="dataTable" class="w-full text-sm">
            <thead>
                <tr style="background:#F8FAFC;">
                    <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">#</th>
                    <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">ID Livre</th>
                    <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">Titre du livre</th>
                    <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">Auteur</th>
                    <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">Disponible</th>
                    <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">Rayon</th>
                    <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">Action</th>
                </tr>
            </thead>
            <tbody>
                @php $count = 1; @endphp
                @forelse($book as $row)
                @php
                    $shelf_copy = DB::table('books')->where('Book_ID',$row->Book_ID)->sum('Amounts');
                    $student_copy = DB::table('records')->where('Book_ID',$row->Book_ID)->where('Submission_Status','No')->count();
                    $available = $shelf_copy - $student_copy;
                    $shelf = DB::table('shelfs')->where('Shelf_ID',$row->Shelf_ID)->first();
                @endphp
                <tr>
                    <td class="px-4 py-4 text-slate-400 font-semibold">{{ str_pad($count, 2, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-4 py-4 font-mono text-slate-500 text-xs">{{ $row->Book_ID }}</td>
                    <td class="px-4 py-4"><p class="font-bold text-slate-800">{{ $row->Book_Name }}</p></td>
                    <td class="px-4 py-4 text-slate-500 text-xs">{{ $row->Writer_Name }}</td>
                    <td class="px-4 py-4">
                        @if($available > 0)
                            <span class="text-xs font-bold px-2.5 py-1 rounded-full" style="background:#D1FAE5; color:#065F46;">{{ $available }} left</span>
                        @else
                            <span class="text-xs font-bold px-2.5 py-1 rounded-full" style="background:#fee2e2; color:#dc2626;">Out sur stock</span>
                        @endif
                    </td>
                    <td class="px-4 py-4 text-slate-500 text-xs">{{ $shelf ? $shelf->Shelf_Location : 'N/A' }}</td>
                    <td class="px-4 py-4">
                        <a href="{{ url('admin/book/details/'.$row->id) }}"
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
                    <td colspan="7" class="px-6 py-20 text-center">
                        <div class="flex flex-col items-center gap-4">
                            <div class="w-20 h-20 rounded-2xl flex items-center justify-center" style="background:#F4F6FA;">
                                <i class="fas fa-book text-4xl" style="color:#cbd5e1;"></i>
                            </div>
                            <p class="font-bold text-slate-500">No Livres — Bases de données found</p>
                            <a href="{{ url('admin/add-book') }}" class="text-xs font-semibold hover:underline" style="color:#4F6FCD;">Add a book</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
