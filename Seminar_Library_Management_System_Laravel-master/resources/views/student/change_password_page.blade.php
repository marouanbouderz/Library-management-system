@extends('layout.student_layout')
@section('title', 'Change Mot de passe')
@section('content')

<div class="max-w-lg">

    {{-- Header --}}
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-1">
            <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-lock text-emerald-600 text-sm"></i>
            </div>
            <h2 class="text-2xl font-bold text-slate-800">Change Mot de passe</h2>
        </div>
        <p class="text-sm text-slate-500 ml-11">Keep your account secure with a strong Mot de passe</p>
    </div>

    {{-- Security tips --}}
    <div class="bg-white rounded-2xl shadow-md p-8">

        <div class="flex items-start gap-3 p-4 bg-emerald-50 border border-emerald-200 rounded-xl mb-7">
            <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                <i class="fas fa-shield-halved text-emerald-600 text-sm"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-emerald-800 mb-1">Mot de passe tips</p>
                <ul class="text-xs text-emerald-700 space-y-0.5">
                    <li class="flex items-center gap-1.5"><i class="fas fa-check text-[9px] text-emerald-500"></i> At least 8 characters</li>
                    <li class="flex items-center gap-1.5"><i class="fas fa-check text-[9px] text-emerald-500"></i> Mix letters, numbers and symbols</li>
                    <li class="flex items-center gap-1.5"><i class="fas fa-check text-[9px] text-emerald-500"></i> Avoid using your name or Student ID</li>
                </ul>
            </div>
        </div>

        <form action="{{ url('student/change-password/process') }}" method="POST" id="changePassForm">
            @csrf

            {{-- Current Mot de passe --}}
            <div class="mb-5">
                <label class="block text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wide">Current Mot de passe</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i class="fas fa-key text-slate-400 text-sm"></i>
                    </span>
                    <input type="password" name="old_password" id="old_password" required
                           class="w-full pl-10 pr-11 py-3 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#C9A84C] focus:border-transparent transition-all"
                           placeholder="Enter your current Mot de passe">
                    <button type="button" onclick="toggleVis('old_Mot de passe', this)"
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                        <i class="fas fa-eye text-sm"></i>
                    </button>
                </div>
            </div>

            {{-- Divider --}}
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-100"></div></div>
                <div class="relative flex justify-center">
                    <span class="bg-white px-3 text-[11px] text-slate-400 font-medium">New Mot de passe</span>
                </div>
            </div>

            {{-- New Mot de passe --}}
            <div class="mb-5">
                <label class="block text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wide">New Mot de passe</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-slate-400 text-sm"></i>
                    </span>
                    <input type="password" name="new_password" id="new_password" required
                           class="w-full pl-10 pr-11 py-3 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#C9A84C] focus:border-transparent transition-all"
                           placeholder="Minimum 8 characters"
                           oninput="checkStrength(this.value)">
                    <button type="button" onclick="toggleVis('new_Mot de passe', this)"
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                        <i class="fas fa-eye text-sm"></i>
                    </button>
                </div>
                {{-- Strength meter --}}
                <div class="mt-2 flex gap-1" id="strength_bars">
                    <div class="h-1 flex-1 rounded-full bg-slate-100" id="bar1"></div>
                    <div class="h-1 flex-1 rounded-full bg-slate-100" id="bar2"></div>
                    <div class="h-1 flex-1 rounded-full bg-slate-100" id="bar3"></div>
                    <div class="h-1 flex-1 rounded-full bg-slate-100" id="bar4"></div>
                </div>
                <p class="text-[11px] text-slate-400 mt-1 ml-0.5" id="strength_label"></p>
            </div>

            {{-- Confirmer Mot de passe --}}
            <div class="mb-8">
                <label class="block text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wide">Confirmer New Mot de passe</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i class="fas fa-lock-open text-slate-400 text-sm"></i>
                    </span>
                    <input type="password" name="confirm_password" id="confirm_password" required
                           class="w-full pl-10 pr-11 py-3 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#C9A84C] focus:border-transparent transition-all"
                           placeholder="Repeat new Mot de passe"
                           oninput="checkMatch()">
                    <button type="button" onclick="toggleVis('Confirmer_Mot de passe', this)"
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                        <i class="fas fa-eye text-sm"></i>
                    </button>
                </div>
                <p id="match_msg" class="text-[11px] mt-1.5 ml-0.5 hidden"></p>
            </div>

            <button type="submit" id="SoumettreBtn"
                    class="w-full text-white font-bold py-3 rounded-xl transition-all duration-200 shadow-sm flex items-center justify-center gap-2"
                    style="background:#2E9E6B;"
                    onmouseover="this.style.background='#1d7a53';" onmouseout="this.style.background='#2E9E6B';">
                <i class="fas fa-check-circle text-sm"></i> Update Mot de passe
            </button>
        </form>
    </div>

    {{-- Link to Mot de passe oublié --}}
    <p class="text-center text-xs text-slate-400 mt-5">
        Don't remember your current Mot de passe?
        <a href="{{ url('student/forget-password') }}" class="text-emerald-600 hover:text-emerald-700 font-semibold transition-colors">Réinitialiser via email</a>
    </p>

</div>

@endsection

@section('scripts')
<script>
function toggleVis(id, btn) {
    var input = document.getElementById(id);
    if (!input) return;
    var show = input.type === 'password';
    input.type = show ? 'text' : 'password';
    btn.querySelector('i').className = show ? 'fas fa-eye-slash text-sm' : 'fas fa-eye text-sm';
}

function checkStrength(val) {
    var score = 0;
    if (val.length >= 8) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    var colors = ['bg-red-400', 'bg-orange-400', 'bg-amber-400', 'bg-emerald-500'];
    var labels = ['Weak', 'Fair', 'Good', 'Strong'];
    var textColors = ['text-red-500', 'text-orange-500', 'text-amber-500', 'text-emerald-600'];

    for (var i = 1; i <= 4; i++) {
        var bar = document.getElementById('bar' + i);
        bar.className = 'h-1 flex-1 rounded-full ' + (i <= score && score > 0 ? colors[score - 1] : 'bg-slate-100');
    }

    var label = document.getElementById('strength_label');
    if (val.length === 0) { label.textContent = ''; return; }
    label.textContent = labels[score - 1] || 'Very weak';
    label.className = 'text-[11px] mt-1 ml-0.5 ' + (textColors[score - 1] || 'text-red-500');
}

function checkMatch() {
    var np = document.getElementById('new_password').value;
    var cp = document.getElementById('confirm_password').value;
    var msg = document.getElementById('match_msg');
    if (cp === '') { msg.classList.add('hidden'); return; }
    msg.classList.remove('hidden');
    if (cp === np) {
        msg.textContent = '✓ Mot de passes match';
        msg.className = 'text-[11px] mt-1.5 ml-0.5 text-emerald-600';
    } else {
        msg.textContent = '✗ Mot de passes do not match';
        msg.className = 'text-[11px] mt-1.5 ml-0.5 text-red-500';
    }
}
</script>
@endsection
