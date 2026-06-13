<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library — Student Portal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['"Plus Jakarta Sans"','sans-serif'] }, colors: { emerald: { 50:'rgba(46,158,107,0.08)', 100:'rgba(46,158,107,0.12)', 200:'rgba(46,158,107,0.22)', 300:'#82c9a8', 400:'#52b68a', 500:'#2E9E6B', 600:'#2E9E6B', 700:'#1d7a53', 800:'#155c3f' } } } } }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .tab-active   { background: #059669; color: #fff; }
        .tab-inactive { background: transparent; color: #6b7280; }
        .tab-inactive:hover { color: #374151; }
    </style>
</head>
<body class="min-h-screen bg-slate-100 flex items-center justify-center p-4">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
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

<div class="w-full max-w-5xl bg-white rounded-3xl shadow-2xl overflow-hidden flex min-h-[600px]">

    {{-- ── Left panel — branding ── --}}
    <div class="hidden lg:flex lg:w-5/12 bg-gradient-to-br from-emerald-700 via-emerald-600 to-teal-600 flex-col justify-between p-10 relative overflow-hidden">

        {{-- Decorative circles --}}
        <div class="absolute w-72 h-72 bg-white/5 rounded-full -top-16 -right-16"></div>
        <div class="absolute w-48 h-48 bg-white/5 rounded-full bottom-20 -left-12"></div>
        <div class="absolute w-24 h-24 bg-white/10 rounded-full bottom-10 right-10"></div>

        {{-- Logo --}}
        <div class="relative">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-11 h-11 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur">
                    <i class="fas fa-book-open text-white text-lg"></i>
                </div>
                <div>
                    <p class="text-white font-bold text-lg leading-none">Library</p>
                    <p class="text-emerald-200 text-xs mt-0.5">Système de Gestion</p>
                </div>
            </div>
        </div>

        {{-- Centre content --}}
        <div class="relative space-y-6">
            <div class="w-20 h-20 bg-white/10 rounded-3xl flex items-center justify-center backdrop-blur mb-2">
                <i class="fas fa-graduation-cap text-white text-4xl"></i>
            </div>
            <div>
                <h2 class="text-white text-3xl font-bold leading-tight">Your Library,<br>Your Knowledge.</h2>
                <p class="text-emerald-200 text-sm mt-3 leading-relaxed">
                    Borrow books, track due dates, and manage your reading collection — all in one place.
                </p>
            </div>

            <div class="space-y-3">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-bookmark text-emerald-200 text-xs"></i>
                    </div>
                    <p class="text-emerald-100 text-sm">Browse & borrow from 5 categories</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-bell text-emerald-200 text-xs"></i>
                    </div>
                    <p class="text-emerald-100 text-sm">Get alerts before books expire</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-layer-group text-emerald-200 text-xs"></i>
                    </div>
                    <p class="text-emerald-100 text-sm">Explore shelves & availability</p>
                </div>
            </div>
        </div>

        <div class="relative">
            <p class="text-xs text-emerald-400 opacity-60">Système de Gestion de Bibliothèque &copy; {{ date('Y') }}</p>
        </div>
    </div>

    {{-- ── Right panel — forms ── --}}
    <div class="flex-1 flex flex-col justify-center p-8 sm:p-12 overflow-y-auto">

        {{-- Mobile logo --}}
        <div class="flex items-center gap-2 mb-8 lg:hidden">
            <div class="w-9 h-9 bg-emerald-600 rounded-xl flex items-center justify-center">
                <i class="fas fa-book-open text-white text-sm"></i>
            </div>
            <p class="font-bold text-slate-800">Library Portal</p>
        </div>

        {{-- Tab switcher --}}
        <div class="flex bg-slate-100 rounded-xl p-1 mb-8 w-full max-w-sm">
            <button onclick="switchTab('signin')" id="tab_signin"
                    class="flex-1 py-2 text-xs font-semibold rounded-lg transition-all duration-200 tab-active">
                <i class="fas fa-user-graduate mr-1"></i> Étudiant
            </button>
            <button onclick="switchTab('admin')" id="tab_admin"
                    class="flex-1 py-2 text-xs font-semibold rounded-lg transition-all duration-200 tab-inactive">
                <i class="fas fa-shield-halved mr-1"></i> Administrateur
            </button>
            <button onclick="switchTab('signup')" id="tab_signup"
                    class="flex-1 py-2 text-xs font-semibold rounded-lg transition-all duration-200 tab-inactive">
                <i class="fas fa-user-plus mr-1"></i> S'inscrire
            </button>
        </div>

        {{-- ── Étudiant sign-in form ── --}}
        <div id="panel_signin">
            <h3 class="text-xl font-bold text-slate-800 mb-1">Bienvenue</h3>
            <p class="text-sm text-slate-500 mb-7">Connectez-vous à votre espace étudiant</p>

            <form action="{{ url('/login/process') }}" method="POST" class="space-y-4">
                @csrf
                @if(Session::has('fail'))
                <div class="flex items-center gap-2 rounded-xl px-4 py-3 text-sm" style="background:#FEE2E2; color:#991B1B;">
                    <i class="fas fa-circle-exclamation flex-shrink-0"></i> {{ Session::get('fail') }}
                </div>
                @endif
                @if(Session::has('mess3'))
                <div class="flex items-center gap-2 rounded-xl px-4 py-3 text-sm" style="background:#FEF3C7; color:#92400E;">
                    <i class="fas fa-clock flex-shrink-0"></i> Votre compte est en attente de validation par l'administrateur.
                </div>
                @endif

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wide">Email ou identifiant</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="fas fa-user text-slate-400 text-sm"></i>
                        </span>
                        <input type="text" name="email" required
                               class="w-full pl-10 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none transition-all"
                               onfocus="this.style.borderColor='#2E9E6B'; this.style.boxShadow='0 0 0 3px rgba(46,158,107,0.15)';"
                               onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='';"
                               placeholder="email@example.com ou nom_utilisateur">
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wide">Mot de passe</label>
                        <a href="{{ url('student/forget-password') }}"
                           class="text-xs font-medium transition-colors" style="color:#2E9E6B;">Mot de passe oublié ?</a>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-slate-400 text-sm"></i>
                        </span>
                        <input type="password" name="password" id="si_password" required
                               class="w-full pl-10 pr-11 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none transition-all"
                               onfocus="this.style.borderColor='#2E9E6B'; this.style.boxShadow='0 0 0 3px rgba(46,158,107,0.15)';"
                               onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='';"
                               placeholder="Votre mot de passe">
                        <button type="button" onclick="toggleVis('si_password', this)"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                            <i class="fas fa-eye text-sm"></i>
                        </button>
                    </div>
                </div>

                <button type="submit"
                        class="w-full text-white font-bold py-3 rounded-xl transition-all duration-200 shadow-sm mt-2"
                        style="background:#2E9E6B;"
                        onmouseover="this.style.background='#1d7a53';" onmouseout="this.style.background='#2E9E6B';">
                    Se connecter
                </button>
            </form>

            <p class="text-center text-sm text-slate-500 mt-6">
                Pas encore de compte ?
                <button onclick="switchTab('signup')" class="font-bold transition-colors" style="color:#2E9E6B;">Créer un compte</button>
            </p>
        </div>

        {{-- ── Administrateur sign-in form ── --}}
        <div id="panel_admin" class="hidden">
            <h3 class="text-xl font-bold text-slate-800 mb-1">Espace Administrateur</h3>
            <p class="text-sm text-slate-500 mb-7">Connectez-vous à votre compte administrateur</p>

            <form action="{{ url('/login/process') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wide">Email ou identifiant</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="fas fa-shield-halved text-slate-400 text-sm"></i>
                        </span>
                        <input type="text" name="email" required
                               class="w-full pl-10 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none transition-all"
                               onfocus="this.style.borderColor='#2E9E6B'; this.style.boxShadow='0 0 0 3px rgba(46,158,107,0.15)';"
                               onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='';"
                               placeholder="admin@bibliotheque.com">
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wide">Mot de passe</label>
                        <a href="{{ url('admin/forget-password') }}"
                           class="text-xs font-medium transition-colors" style="color:#2E9E6B;">Mot de passe oublié ?</a>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-slate-400 text-sm"></i>
                        </span>
                        <input type="password" name="password" id="admin_password" required
                               class="w-full pl-10 pr-11 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none transition-all"
                               onfocus="this.style.borderColor='#2E9E6B'; this.style.boxShadow='0 0 0 3px rgba(46,158,107,0.15)';"
                               onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='';"
                               placeholder="Votre mot de passe">
                        <button type="button" onclick="toggleVis('admin_password', this)"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                            <i class="fas fa-eye text-sm"></i>
                        </button>
                    </div>
                </div>

                <button type="submit"
                        class="w-full text-white font-bold py-3 rounded-xl transition-all duration-200 shadow-sm mt-2"
                        style="background:#2E9E6B;"
                        onmouseover="this.style.background='#1d7a53';" onmouseout="this.style.background='#2E9E6B';">
                    Se connecter
                </button>
            </form>
        </div>

        {{-- ── S'inscrire form ── --}}
        <div id="panel_signup" class="hidden">
            <h3 class="text-xl font-bold text-slate-800 mb-1">Create an account</h3>
            <p class="text-sm text-slate-500 mb-7">Register to access the student library</p>

            <form action="{{ url('student/sign-up/process') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wide">Nom complet</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-slate-400 text-sm"></i>
                            </span>
                            <input type="text" name="name" required
                                   class="w-full pl-9 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#C9A84C] focus:border-transparent transition-all"
                                   placeholder="Nom complet">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wide">ID Étudiant</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-id-card text-slate-400 text-sm"></i>
                            </span>
                            <input type="text" name="student_id" required
                                   class="w-full pl-9 py-2.5 border border-slate-200 rounded-xl text-sm font-mono focus:outline-none focus:ring-2 focus:ring-[#C9A84C] focus:border-transparent transition-all"
                                   placeholder="e.g. STU-001">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wide">Promotion</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-calendar text-slate-400 text-sm"></i>
                            </span>
                            <input type="text" name="session" required
                                   class="w-full pl-9 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#C9A84C] focus:border-transparent transition-all"
                                   placeholder="e.g. 2023-24">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wide">Téléphone.</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-phone text-slate-400 text-sm"></i>
                            </span>
                            <input type="text" name="contact"
                                   class="w-full pl-9 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#C9A84C] focus:border-transparent transition-all"
                                   placeholder="Phone number">
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wide">Adresse email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-slate-400 text-sm"></i>
                        </span>
                        <input type="email" name="email" required
                               class="w-full pl-10 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#C9A84C] focus:border-transparent transition-all"
                               placeholder="you@example.com">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wide">Nom d'utilisateur</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-at text-slate-400 text-sm"></i>
                            </span>
                            <input type="text" name="username" required
                                   class="w-full pl-9 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#C9A84C] focus:border-transparent transition-all"
                                   placeholder="nom_utilisateur">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wide">Mot de passe</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-slate-400 text-sm"></i>
                            </span>
                            <input type="password" name="password" id="su_password" required
                                   class="w-full pl-9 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#C9A84C] focus:border-transparent transition-all"
                                   placeholder="Min 8 chars">
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wide">Confirmer le mot de passe</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock-open text-slate-400 text-sm"></i>
                        </span>
                        <input type="password" name="confirm_password" id="su_confirm_password" required
                               class="w-full pl-9 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#C9A84C] focus:border-transparent transition-all"
                               placeholder="Répéter le mot de passe">
                    </div>
                    <p id="su_match_msg" class="text-[11px] mt-1 ml-1 hidden"></p>
                </div>

                <button type="submit"
                        class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 rounded-xl transition-all duration-200 shadow-sm hover:shadow-md mt-1">
                    Créer mon compte
                </button>
            </form>

            <p class="text-center text-sm text-slate-500 mt-5">
                Vous avez déjà un compte ?
                <button onclick="switchTab('signin')" class="text-emerald-600 hover:text-emerald-700 font-semibold transition-colors">Se connecter</button>
            </p>
        </div>

    </div>
</div>

<script>
function switchTab(tab) {
    var tabs   = ['signin','admin','signup'];
    var panels = ['panel_signin','panel_admin','panel_signup'];
    tabs.forEach(function(t, i) {
        var active = t === tab;
        document.getElementById('tab_' + t).className = 'flex-1 py-2 text-xs font-semibold rounded-lg transition-all duration-200 ' + (active ? 'tab-active' : 'tab-inactive');
        document.getElementById(panels[i]).classList.toggle('hidden', !active);
    });
}

function toggleVis(id, btn) {
    var input = document.getElementById(id);
    var show = input.type === 'password';
    input.type = show ? 'text' : 'password';
    btn.querySelector('i').className = show ? 'fas fa-eye-slash text-sm' : 'fas fa-eye text-sm';
}

document.addEventListener('DOMContentLoaded', function() {
    var confirm = document.getElementById('su_confirm_password');
    if (confirm) {
        confirm.addEventListener('input', function() {
            var msg = document.getElementById('su_match_msg');
            var match = this.value === document.getElementById('su_password').value;
            msg.classList.remove('hidden');
            msg.textContent = match ? 'Mots de passe identiques' : 'Mots de passe différents';
            msg.className = 'text-[11px] mt-1 ml-1 ' + (match ? 'text-emerald-600' : 'text-red-500');
        });
    }
});
</script>

</body>
</html>
