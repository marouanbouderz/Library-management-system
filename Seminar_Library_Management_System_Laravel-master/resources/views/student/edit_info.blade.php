@extends('layout.student_layout')
@section('title', 'Modifier le profil')
@section('content')

<div class="max-w-2xl mx-auto">

    {{-- Header --}}
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-1">
            <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-user-pen text-emerald-600 text-sm"></i>
            </div>
            <h2 class="text-2xl font-bold text-slate-800">Modifier le profil</h2>
        </div>
        <p class="text-sm text-slate-500 ml-11">Update your account details</p>
    </div>

    @foreach($student as $s)

    {{-- Profile card --}}
    <div class="bg-white rounded-2xl shadow-md mb-5 p-5 flex items-center gap-4">
        <img src="{{ asset($s->Image ?: 'image/default.svg') }}" class="w-16 h-16 rounded-2xl object-cover border-2 border-emerald-100 flex-shrink-0" alt="" onerror="this.src='{{ asset('image/default.svg') }}'">
        <div>
            <p class="font-bold text-slate-800">{{ $s->Name }}</p>
            <p class="text-xs font-mono text-slate-400 mt-0.5">{{ $s->Student_ID }}</p>
        </div>
        <div class="ml-auto">
            <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 text-xs font-semibold px-3 py-1.5 rounded-full">
                <i class="fas fa-circle text-[8px]"></i> Active
            </span>
        </div>
    </div>

    {{-- Form --}}
    <div class="bg-white rounded-2xl shadow-md p-8">

        <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-6">Account Details</p>

        <form action="{{ url('student/edit-info/process/' . $s->id) }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">

                {{-- Name (readonly) --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-2 uppercase tracking-wide">Full Name</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="fas fa-user text-slate-300 text-sm"></i>
                        </span>
                        <input type="text" value="{{ $s->Name }}" disabled
                               class="w-full pl-10 py-3 border border-slate-100 bg-slate-50 rounded-xl text-sm text-slate-400 cursor-not-allowed">
                    </div>
                    <p class="text-[11px] text-slate-400 mt-1.5 ml-1">Contact admin to change your name.</p>
                </div>

                {{-- Student ID (readonly) --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-2 uppercase tracking-wide">ID Étudiant</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="fas fa-id-card text-slate-300 text-sm"></i>
                        </span>
                        <input type="text" value="{{ $s->Student_ID }}" disabled
                               class="w-full pl-10 py-3 border border-slate-100 bg-slate-50 rounded-xl text-sm text-slate-400 font-mono cursor-not-allowed">
                    </div>
                </div>

            </div>

            {{-- Divider --}}
            <div class="border-t border-slate-100 mb-5"></div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">

                {{-- Identifiant --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wide">Identifiant</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="fas fa-at text-slate-400 text-sm"></i>
                        </span>
                        <input type="text" name="username" value="{{ $s->Username }}" required
                               class="w-full pl-10 py-3 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#C9A84C] focus:border-transparent transition-all"
                               placeholder="your_username">
                    </div>
                </div>

                {{-- Contact --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wide">Numéro de téléphone</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="fas fa-phone text-slate-400 text-sm"></i>
                        </span>
                        <input type="text" name="contact" value="{{ $s->Contact_no }}"
                               class="w-full pl-10 py-3 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#C9A84C] focus:border-transparent transition-all"
                               placeholder="+1 234 567 8900">
                    </div>
                </div>

            </div>

            {{-- Email --}}
            <div class="mb-8">
                <label class="block text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wide">Email Address</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-slate-400 text-sm"></i>
                    </span>
                    <input type="email" name="email" value="{{ $s->Email }}" required
                           class="w-full pl-10 py-3 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#C9A84C] focus:border-transparent transition-all"
                           placeholder="you@example.com">
                </div>
                <p class="text-[11px] text-slate-400 mt-1.5 ml-1">Used for Mot de passe recovery and library notifications.</p>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3">
                <button type="submit"
                        class="flex-1 sm:flex-none text-white font-bold py-3 px-8 rounded-xl transition-all duration-200 shadow-sm flex items-center justify-center gap-2"
                        style="background:#2E9E6B;"
                        onmouseover="this.style.background='#1d7a53';" onmouseout="this.style.background='#2E9E6B';">
                    <i class="fas fa-check text-sm"></i> Enregistrer
                </button>
                <a href="{{ url('student/dashboard') }}"
                   class="flex-1 sm:flex-none text-center bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold py-3 px-8 rounded-xl transition-all duration-200 text-sm">
                    Annuler
                </a>
            </div>
        </form>
    </div>

    @endforeach

</div>

@endsection
