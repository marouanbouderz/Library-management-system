@extends('layout.admin_layout')
@section('title', 'Modifier le profil')
@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Modifier le profil</h2>
        <p class="text-sm text-slate-500 mt-0.5">Update your admin account information</p>
    </div>
    <nav class="flex items-center gap-2 text-xs text-slate-400">
        <a href="{{ url('admin/dashboard') }}" class="hover:text-[#4F6FCD] transition-colors">Dashboard</a>
        <i class="fas fa-chevron-right text-[10px]"></i>
        <span class="text-slate-600 font-medium">Modifier le profil</span>
    </nav>
</div>

<div class="max-w-lg mx-auto">
    @foreach($admin as $row)
    <div class="bg-white rounded-2xl shadow-md overflow-hidden">
        <div class="px-6 py-5 flex items-center gap-4" style="border-bottom:1px solid #E8EDF2;">
            <div class="w-12 h-12 rounded-full flex items-center justify-center text-white text-xl font-bold shadow-sm"
                 style="background:linear-gradient(135deg,#3b82f6,#4F6FCD);">
                {{ strtoupper(substr($row->Identifiant, 0, 1)) }}
            </div>
            <div>
                <h3 class="font-bold text-slate-800 text-sm">{{ $row->Identifiant }}</h3>
                <p class="text-xs text-slate-400">{{ $row->Email }}</p>
            </div>
        </div>
        <form action="{{ url('admin/update-info/process') }}" method="POST" class="p-6 space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1.5">Identifiant <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-slate-400 text-sm"></i>
                    </div>
                    <input type="text" name="Identifiant" value="{{ $row->Identifiant }}" required
                           class="w-full pl-9 pr-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#4F6FCD]/30 focus:border-[#4F6FCD] bg-slate-50 transition-colors">
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1.5">Email Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-slate-400 text-sm"></i>
                    </div>
                    <input type="email" name="email" value="{{ $row->Email }}" readonly
                           class="w-full pl-9 pr-4 py-2.5 text-sm border border-slate-200 rounded-xl bg-slate-100 text-slate-400 cursor-not-allowed">
                </div>
                <p class="text-xs text-slate-400 mt-1">Email cannot be changed</p>
            </div>
            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="flex-1 text-white font-bold text-sm py-2.5 rounded-xl transition-all duration-200 shadow-sm flex items-center justify-center gap-2"
                        style="background:#4F6FCD;"
                        onmouseover="this.style.background='#1e40af';" onmouseout="this.style.background='#4F6FCD';">
                    <i class="fas fa-check"></i> Enregistrer
                </button>
                <a href="{{ url('admin/dashboard') }}"
                   class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm py-2.5 rounded-xl transition-colors duration-200 flex items-center justify-center gap-2">
                    <i class="fas fa-times"></i> Annuler
                </a>
            </div>
        </form>
    </div>
    @endforeach
</div>

@endsection
