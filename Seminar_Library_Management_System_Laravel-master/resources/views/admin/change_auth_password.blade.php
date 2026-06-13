@extends('layout.admin_layout')
@section('title', 'Change Mot de passe')
@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Change Mot de passe</h2>
        <p class="text-sm text-slate-500 mt-0.5">Update your account Mot de passe</p>
    </div>
    <nav class="flex items-center gap-2 text-xs text-slate-400">
        <a href="{{ url('admin/dashboard') }}" class="hover:text-[#4F6FCD] transition-colors">Dashboard</a>
        <i class="fas fa-chevron-right text-[10px]"></i>
        <span class="text-slate-600 font-medium">Change Mot de passe</span>
    </nav>
</div>

<div class="max-w-lg mx-auto">
    <div class="bg-white rounded-2xl shadow-md overflow-hidden">
        <div class="px-6 py-5 flex items-center gap-3" style="border-bottom:1px solid #E8EDF2;">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background:rgba(79,111,205,0.09);">
                <i class="fas fa-lock" style="color:#4F6FCD;"></i>
            </div>
            <div>
                <h3 class="font-bold text-slate-800 text-sm">Update Mot de passe</h3>
                <p class="text-xs text-slate-400">Choose a strong Mot de passe with letters, numbers and symbols</p>
            </div>
        </div>
        <form action="{{ url('admin/change-password/process') }}" method="POST" class="p-6 space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-wide">Current Mot de passe</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i class="fas fa-key text-slate-400 text-sm"></i>
                    </span>
                    <input type="password" name="old_password" required
                           class="w-full pl-10 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#4F6FCD]/30 focus:border-[#4F6FCD] bg-slate-50 transition-colors"
                           placeholder="Enter current Mot de passe">
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-wide">New Mot de passe</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-slate-400 text-sm"></i>
                    </span>
                    <input type="password" name="new_password" id="new_password" required
                           class="w-full pl-10 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#4F6FCD]/30 focus:border-[#4F6FCD] bg-slate-50 transition-colors"
                           placeholder="Minimum 8 characters">
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-wide">Confirmer New Mot de passe</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i class="fas fa-lock-open text-slate-400 text-sm"></i>
                    </span>
                    <input type="password" name="confirm_password" id="confirm_password" required
                           class="w-full pl-10 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#4F6FCD]/30 focus:border-[#4F6FCD] bg-slate-50 transition-colors"
                           placeholder="Repeat new Mot de passe">
                </div>
                <p id="match_msg" class="text-[11px] mt-1.5 ml-1 hidden"></p>
            </div>
            <div class="flex items-center gap-3 pt-1">
                <button type="submit"
                        class="flex-1 text-white font-bold text-sm py-2.5 rounded-xl transition-all duration-200 shadow-sm flex items-center justify-center gap-2"
                        style="background:#4F6FCD;"
                        onmouseover="this.style.background='#1e40af';" onmouseout="this.style.background='#4F6FCD';">
                    <i class="fas fa-check-circle"></i> Update Mot de passe
                </button>
                <a href="{{ url('admin/dashboard') }}"
                   class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm py-2.5 rounded-xl transition-colors duration-200 flex items-center justify-center gap-2">
                    <i class="fas fa-times"></i> Annuler
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
@section('scripts')
<script>
document.getElementById('confirm_password').addEventListener('input', function() {
    var msg = document.getElementById('match_msg');
    var np = document.getElementById('new_password').value;
    msg.classList.remove('hidden');
    if (this.value === np) {
        msg.textContent = 'Mot de passes match'; msg.className = 'text-[11px] mt-1.5 ml-1 text-emerald-600';
    } else {
        msg.textContent = 'Mot de passes do not match'; msg.className = 'text-[11px] mt-1.5 ml-1 text-red-500';
    }
});
</script>
@endsection
