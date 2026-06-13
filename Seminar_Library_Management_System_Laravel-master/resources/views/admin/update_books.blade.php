@extends('layout.admin_layout')
@section('title', 'Mettre à jour livres')
@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Mettre à jour livres</h2>
        <p class="text-sm text-slate-500 mt-0.5">Select a book to edit its information</p>
    </div>
    <nav class="flex items-center gap-2 text-xs text-slate-400">
        <a href="{{ url('admin/dashboard') }}" class="hover:text-[#4F6FCD] transition-colors">Dashboard</a>
        <i class="fas fa-chevron-right text-[10px]"></i>
        <span class="text-slate-600 font-medium">Mettre à jour livres</span>
    </nav>
</div>

<div class="bg-white rounded-2xl shadow-md overflow-hidden">
    <div class="px-6 py-4 flex items-center gap-3" style="border-bottom:1px solid #E8EDF2;">
        <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background:rgba(79,111,205,0.09);">
            <i class="fas fa-pen-to-square" style="color:#4F6FCD;"></i>
        </div>
        <div>
            <h3 class="font-bold text-slate-800 text-sm">All Books</h3>
            <p class="text-xs text-slate-400">Click Edit on any book to update it</p>
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
                    <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">Category</th>
                    <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">Qté</th>
                    <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">Action</th>
                </tr>
            </thead>
            <tbody>
                @php $count = 1; @endphp
                @forelse($books as $row)
                <tr>
                    <td class="px-4 py-4 text-slate-400 font-semibold">{{ str_pad($count, 2, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-4 py-4 font-mono text-slate-500 text-xs">{{ $row->Book_ID }}</td>
                    <td class="px-4 py-4 font-bold text-slate-800">{{ $row->Book_Name }}</td>
                    <td class="px-4 py-4 text-slate-500 text-xs">{{ $row->Writer_Name }}</td>
                    <td class="px-4 py-4">
                        <span class="text-xs font-bold px-2.5 py-1 rounded-full" style="background:rgba(79,111,205,0.09); color:#4F6FCD;">{{ $row->Catagory }}</span>
                    </td>
                    <td class="px-4 py-4 text-slate-600 font-bold">{{ $row->Amounts }}</td>
                    <td class="px-4 py-4">
                        <a href="{{ url('admin/book/edit/'.$row->id) }}"
                           class="inline-flex items-center gap-1.5 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition-all duration-200 shadow-sm"
                           style="background:#4F6FCD;"
                           onmouseover="this.style.background='#1e40af';" onmouseout="this.style.background='#4F6FCD';">
                            <i class="fas fa-pen text-[10px]"></i> Edit
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
                            <p class="font-bold text-slate-500">Aucun livre found</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
