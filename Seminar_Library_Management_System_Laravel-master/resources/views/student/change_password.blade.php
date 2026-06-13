<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialiser Mot de passe — Library</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { theme: { extend: { fontFamily: { sans: ['"Plus Jakarta Sans"','sans-serif'] }, colors: { emerald: { 50:'rgba(46,158,107,0.08)', 100:'rgba(46,158,107,0.12)', 200:'rgba(46,158,107,0.22)', 300:'#82c9a8', 400:'#52b68a', 500:'#2E9E6B', 600:'#2E9E6B', 700:'#1d7a53', 800:'#155c3f' } } } } }</script>
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-100 to-emerald-50 flex items-center justify-center p-4">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if(Session::has('mess2'))
        swal("Done!", "Mot de passe changed successfully!", "success");
    @endif
    @if(Session::has('message'))
        var type = "{{ Session::get('alert-type','info') }}";
        var msg  = "{{ Session::get('message') }}";
        if      (type === 'success') toastr.success(msg);
        else if (type === 'error')   toastr.error(msg);
        else if (type === 'warning') toastr.warning(msg);
        else                         toastr.info(msg);
    @endif
});
</script>

<div class="w-full max-w-md">

    {{-- Logo --}}
    <div class="flex items-center justify-center gap-3 mb-8">
        <div class="w-10 h-10 bg-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
            <i class="fas fa-book-open text-white"></i>
        </div>
        <span class="font-bold text-slate-800 text-lg">Library Portal</span>
    </div>

    <div class="bg-white rounded-2xl shadow-xl border border-slate-100 p-8">

        {{-- Icon header --}}
        <div class="flex flex-col items-center mb-7">
            <div class="w-16 h-16 bg-emerald-100 rounded-2xl flex items-center justify-center mb-4">
                <i class="fas fa-lock-open text-emerald-600 text-2xl"></i>
            </div>
            <h2 class="text-xl font-bold text-slate-800">Set new Mot de passe</h2>
            <p class="text-sm text-slate-500 text-center mt-2 leading-relaxed">
                Choose a strong Mot de passe you haven't used before.
            </p>
        </div>

        <form action="{{ url('student/recover-password/process') }}" method="POST">
            @csrf

            <div class="mb-5">
                <label class="block text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wide">New Mot de passe</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-slate-400 text-sm"></i>
                    </span>
                    <input type="password" name="new_password" id="new_password" required autofocus
                           class="w-full pl-10 pr-11 py-3 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#C9A84C] focus:border-transparent transition-all"
                           placeholder="Minimum 8 characters"
                           oninput="checkStrength(this.value)">
                    <button type="button" onclick="toggleVis('new_Mot de passe', this)"
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                        <i class="fas fa-eye text-sm"></i>
                    </button>
                </div>
                {{-- Strength bars --}}
                <div class="flex gap-1 mt-2">
                    <div class="h-1 flex-1 rounded-full bg-slate-100" id="b1"></div>
                    <div class="h-1 flex-1 rounded-full bg-slate-100" id="b2"></div>
                    <div class="h-1 flex-1 rounded-full bg-slate-100" id="b3"></div>
                    <div class="h-1 flex-1 rounded-full bg-slate-100" id="b4"></div>
                </div>
                <p id="strength_label" class="text-[11px] text-slate-400 mt-1 ml-0.5"></p>
            </div>

            <div class="mb-8">
                <label class="block text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wide">Confirmer Mot de passe</label>
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

            <button type="submit"
                    class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 rounded-xl transition-all duration-200 shadow-sm hover:shadow-md flex items-center justify-center gap-2">
                <i class="fas fa-check-circle text-sm"></i> Réinitialiser Mot de passe
            </button>
        </form>

        <div class="mt-6 pt-5 border-t border-slate-100 text-center">
            <a href="{{ url('/') }}"
               class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-emerald-600 font-medium transition-colors">
                <i class="fas fa-arrow-left text-xs"></i> Retour à la connexion
            </a>
        </div>
    </div>
</div>

<script>
function toggleVis(id, btn) {
    var input = document.getElementById(id);
    var show  = input.type === 'password';
    input.type = show ? 'text' : 'password';
    btn.querySelector('i').className = show ? 'fas fa-eye-slash text-sm' : 'fas fa-eye text-sm';
}

function checkStrength(val) {
    var score = 0;
    if (val.length >= 8)            score++;
    if (/[A-Z]/.test(val))          score++;
    if (/[0-9]/.test(val))          score++;
    if (/[^A-Za-z0-9]/.test(val))   score++;
    var colors = ['bg-red-400','bg-orange-400','bg-amber-400','bg-emerald-500'];
    var labels = ['Weak','Fair','Good','Strong'];
    var tclass = ['text-red-500','text-orange-500','text-amber-500','text-emerald-600'];
    for (var i = 1; i <= 4; i++) {
        document.getElementById('b'+i).className = 'h-1 flex-1 rounded-full ' +
            (i <= score && score > 0 ? colors[score-1] : 'bg-slate-100');
    }
    var lbl = document.getElementById('strength_label');
    lbl.textContent = val.length === 0 ? '' : (labels[score-1] || 'Very weak');
    lbl.className   = 'text-[11px] mt-1 ml-0.5 ' + (tclass[score-1] || 'text-red-500');
}

function checkMatch() {
    var np  = document.getElementById('new_password').value;
    var cp  = document.getElementById('confirm_password').value;
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

</body>
</html>
