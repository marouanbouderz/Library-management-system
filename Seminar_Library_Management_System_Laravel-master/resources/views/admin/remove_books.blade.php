@extends('layout.admin_layout')
@section('title', 'Supprimer livres')
@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Supprimer livres</h2>
        <p class="text-sm text-slate-500 mt-0.5">Permanently Supprimer a book from the library</p>
    </div>
    <nav class="flex items-center gap-2 text-xs text-slate-400">
        <a href="{{ url('admin/dashboard') }}" class="hover:text-[#4F6FCD] transition-colors">Dashboard</a>
        <i class="fas fa-chevron-right text-[10px]"></i>
        <span class="text-slate-600 font-medium">Supprimer livres</span>
    </nav>
</div>

<div class="mb-5 flex items-center gap-3 p-4 rounded-xl" style="background:#fff1f2; border:1px solid #fecdd3;">
    <i class="fas fa-triangle-exclamation text-lg flex-shrink-0" style="color:#DC2626;"></i>
    <p class="text-sm font-semibold" style="color:#991b1b;">Removing a book is permanent. Ensure no students currently have this book before removing it.</p>
</div>

<div class="bg-white rounded-2xl shadow-md overflow-hidden">
    <div class="px-6 py-4 flex items-center gap-3" style="border-bottom:1px solid #E8EDF2;">
        <div class="w-9 h-9 bg-red-50 rounded-xl flex items-center justify-center">
            <i class="fas fa-book text-red-500"></i>
        </div>
        <div>
            <h3 class="font-bold text-slate-800 text-sm">Book List</h3>
            <p class="text-xs text-slate-400">Select a book to remove permanently</p>
        </div>
    </div>
    <div class="overflow-x-auto p-4">
        <table id="dataTable" class="w-full text-sm">
            <thead>
                <tr style="background:#F8FAFC;">
                    <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">#</th>
                    <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">ID Livre</th>
                    <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">Titre du livre</th>
                    <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">Category</th>
                    <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">Actuellement emprunté</th>
                    <th class="text-left px-4 py-3 text-xs font-bold uppercase tracking-wider" style="color:#6B7280;">Action</th>
                </tr>
            </thead>
            <tbody>
                @php $count = 1; @endphp
                @forelse($books as $row)
                @php $available_student_copy = DB::table('records')->where('Book_ID',$row->Book_ID)->where('Submission_Status','No')->count(); @endphp
                <tr>
                    <td class="px-4 py-4 text-slate-400 font-semibold">{{ str_pad($count, 2, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-4 py-4 font-mono text-slate-500 text-xs">{{ $row->Book_ID }}</td>
                    <td class="px-4 py-4 font-bold text-slate-800">{{ $row->Book_Name }}</td>
                    <td class="px-4 py-4">
                        <span class="text-xs font-bold px-2.5 py-1 rounded-full" style="background:rgba(79,111,205,0.09); color:#4F6FCD;">{{ $row->Catagory }}</span>
                    </td>
                    <td class="px-4 py-4">
                        @if($available_student_copy > 0)
                            <span class="inline-flex items-center gap-1 text-xs font-bold px-2.5 py-1 rounded-full" style="background:#fee2e2; color:#dc2626;">
                                <i class="fas fa-exclamation-circle text-[10px]"></i> {{ $available_student_copy }} out
                            </span>
                        @else
                            <span class="text-xs font-bold px-2.5 py-1 rounded-full" style="background:#D1FAE5; color:#065F46;">All retournés</span>
                        @endif
                    </td>
                    <td class="px-4 py-4">
                        <a href="{{ url('admin/book/Supprimer/'.$row->id) }}"
                           onclick="return Confirmer('Permanently Supprimer \'{{ $row->Book_Name }}\'? This cannot be undone.')"
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
                    <td colspan="6" class="px-6 py-20 text-center">
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
