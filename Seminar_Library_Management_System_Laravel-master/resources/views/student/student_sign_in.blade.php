<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal — Library Management</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] }, colors: { emerald: { 50:'rgba(46,158,107,0.08)', 100:'rgba(46,158,107,0.12)', 200:'rgba(46,158,107,0.22)', 300:'#82c9a8', 400:'#52b68a', 500:'#2E9E6B', 600:'#2E9E6B', 700:'#1d7a53', 800:'#155c3f' } }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4" style="background:#F4F6FA;">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if(Session::has('mess'))
        swal("Account Created!", "Please wait for Admin Approval!", "success");
    @endif
    @if(Session::has('mess2'))
        swal("Congrats!", "Mot de passe Changed Successfully!", "success");
    @endif
    @if(Session::has('mess3'))
        swal("Not Yet Approuverd!", "Your account is still en attente admin approval.", "info");
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

<div class="w-full max-w-5xl bg-white rounded-3xl shadow-2xl overflow-hidden flex min-h-[600px]">

    {{-- Left panel — branding --}}
    <div class="hidden lg:flex lg:w-5/12 flex-col justify-between p-10 relative overflow-hidden" style="background:linear-gradient(135deg,#1d7a53,#2E9E6B,#059669);">
        <div class="absolute w-72 h-72 bg-white/5 rounded-full -top-16 -right-16"></div>
        <div class="absolute w-48 h-48 bg-white/5 rounded-full bottom-20 -left-12"></div>
        <div class="absolute w-24 h-24 bg-white/10 rounded-full bottom-10 right-10"></div>

        <div class="relative">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-11 h-11 rounded-2xl flex items-center justify-center" style="background:rgba(255,255,255,0.2);">
                    <i class="fas fa-book-open text-white text-lg"></i>
                </div>
                <div>
                    <p class="text-white font-extrabold text-lg leading-none">Library</p>
                    <p class="text-emerald-200 text-xs mt-0.5">Système de Gestion</p>
                </div>
            </div>
        </div>

        <div class="relative space-y-6">
            <div class="w-20 h-20 rounded-3xl flex items-center justify-center mb-2" style="background:rgba(255,255,255,0.1);">
                <i class="fas fa-graduation-cap text-white text-4xl"></i>
            </div>
            <div>
                <h2 class="text-white text-3xl font-extrabold leading-tight">Your Library,<br>Your Knowledge.</h2>
                <p class="text-emerald-200 text-sm mt-3 leading-relaxed">
                    Borrow books, track due dates, and manage your reading collection — all in one place.
                </p>
            </div>
            <div class="space-y-3">
                @foreach([['fa-bookmark','Browse & borrow from 5 categories'],['fa-bell','Get alerts before books expire'],['fa-layer-group','Explore shelves & availability']] as $f)
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0" style="background:rgba(255,255,255,0.1);">
                        <i class="fas {{ $f[0] }} text-emerald-200 text-xs"></i>
                    </div>
                    <p class="text-emerald-100 text-sm">{{ $f[1] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <div class="relative">
            <a href="{{ url('admin') }}" class="inline-flex items-center gap-2 text-xs text-emerald-300 hover:text-white transition-colors font-semibold">
                <i class="fas fa-shield-halved text-[10px]"></i> Admin Panel →
            </a>
        </div>
    </div>

    {{-- Right panel — forms --}}
    <div class="flex-1 flex flex-col justify-center p-8 sm:p-12 overflow-y-auto">

        <div class="flex items-center gap-2 mb-8 lg:hidden">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background:#2E9E6B;">
                <i class="fas fa-book-open text-white text-sm"></i>
            </div>
            <p class="font-extrabold text-slate-800">Library Portal</p>
        </div>

        {{-- Tab switcher --}}
        <div class="flex bg-slate-100 rounded-xl p-1 mb-8 w-full max-w-xs">
            <button onclick="switchTab('signin')" id="tab_signin"
                    class="flex-1 py-2 text-sm font-bold rounded-lg transition-all duration-200"
                    style="background:#2E9E6B; color:white;">
                Se connecter
            </button>
            <button onclick="switchTab('signup')" id="tab_signup"
                    class="flex-1 py-2 text-sm font-bold rounded-lg transition-all duration-200 text-slate-500">
                S'inscrire
            </button>
        </div>

        {{-- Se connecter form --}}
        <div id="panel_signin">
            <h3 class="text-xl font-extrabold text-slate-800 mb-1">Welcome back</h3>
            <p class="text-sm text-slate-500 mb-7">Se connecter to access your library account</p>

            <form action="{{ url('student/sign-in/process') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wide">Email or Identifiant</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="fas fa-user text-slate-400 text-sm"></i>
                        </span>
                        <input type="text" name="email" required
                               class="w-full pl-10 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none transition-all"
                               style="background:#f8fafc;"
                               onfocus="this.style.borderColor='#2E9E6B'; this.style.boxShadow='0 0 0 3px rgba(14,159,110,0.15)';"
                               onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='';"
                               placeholder="Enter email or Identifiant">
                    </div>
                </div>
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wide">Mot de passe</label>
                        <a href="{{ url('student/forget-password') }}" class="text-xs font-semibold transition-colors" style="color:#2E9E6B;">Mot de passe oublié ?</a>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-slate-400 text-sm"></i>
                        </span>
                        <input type="password" name="password" id="si_password" required
                               class="w-full pl-10 pr-11 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none transition-all"
                               style="background:#f8fafc;"
                               onfocus="this.style.borderColor='#2E9E6B'; this.style.boxShadow='0 0 0 3px rgba(14,159,110,0.15)';"
                               onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='';"
                               placeholder="Your Mot de passe">
                        <button type="button" onclick="toggleVis('si_Mot de passe', this)"
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
                Don't have an account?
                <button onclick="switchTab('signup')" class="font-bold transition-colors" style="color:#2E9E6B;">Créer un compte</button>
            </p>
        </div>

        {{-- S'inscrire form --}}
        <div id="panel_signup" class="hidden">
            <h3 class="text-xl font-extrabold text-slate-800 mb-1">Create an account</h3>
            <p class="text-sm text-slate-500 mb-7">Register to access the student library</p>

            <form action="{{ url('student/sign-up/process') }}" method="POST" class="space-y-4">
                @csrf

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wide">Full Name</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-slate-400 text-sm"></i>
                            </span>
                            <input type="text" name="name" required
                                   class="w-full pl-9 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none transition-all"
                                   style="background:#f8fafc;"
                                   onfocus="this.style.borderColor='#2E9E6B'; this.style.boxShadow='0 0 0 3px rgba(14,159,110,0.15)';"
                                   onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='';"
                                   placeholder="Full name">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wide">ID Étudiant</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-id-card text-slate-400 text-sm"></i>
                            </span>
                            <input type="text" name="student_id" required
                                   class="w-full pl-9 py-2.5 border border-slate-200 rounded-xl text-sm font-mono focus:outline-none transition-all"
                                   style="background:#f8fafc;"
                                   onfocus="this.style.borderColor='#2E9E6B'; this.style.boxShadow='0 0 0 3px rgba(14,159,110,0.15)';"
                                   onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='';"
                                   placeholder="e.g. STU-001">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wide">Promotion</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-calendar text-slate-400 text-sm"></i>
                            </span>
                            <input type="text" name="session" required
                                   class="w-full pl-9 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none transition-all"
                                   style="background:#f8fafc;"
                                   onfocus="this.style.borderColor='#2E9E6B'; this.style.boxShadow='0 0 0 3px rgba(14,159,110,0.15)';"
                                   onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='';"
                                   placeholder="e.g. 2023-24">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wide">Téléphone.</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-phone text-slate-400 text-sm"></i>
                            </span>
                            <input type="text" name="contact"
                                   class="w-full pl-9 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none transition-all"
                                   style="background:#f8fafc;"
                                   onfocus="this.style.borderColor='#2E9E6B'; this.style.boxShadow='0 0 0 3px rgba(14,159,110,0.15)';"
                                   onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='';"
                                   placeholder="Phone number">
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wide">Adresse email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-slate-400 text-sm"></i>
                        </span>
                        <input type="email" name="email" required
                               class="w-full pl-10 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none transition-all"
                               style="background:#f8fafc;"
                               onfocus="this.style.borderColor='#2E9E6B'; this.style.boxShadow='0 0 0 3px rgba(14,159,110,0.15)';"
                               onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='';"
                               placeholder="you@example.com">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wide">Identifiant</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-at text-slate-400 text-sm"></i>
                            </span>
                            <input type="text" name="Identifiant" required
                                   class="w-full pl-9 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none transition-all"
                                   style="background:#f8fafc;"
                                   onfocus="this.style.borderColor='#2E9E6B'; this.style.boxShadow='0 0 0 3px rgba(14,159,110,0.15)';"
                                   onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='';"
                                   placeholder="Identifiant">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wide">Mot de passe</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-slate-400 text-sm"></i>
                            </span>
                            <input type="password" name="password" id="su_password" required
                                   class="w-full pl-9 pr-9 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none transition-all"
                                   style="background:#f8fafc;"
                                   onfocus="this.style.borderColor='#2E9E6B'; this.style.boxShadow='0 0 0 3px rgba(14,159,110,0.15)';"
                                   onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='';"
                                   placeholder="Min 8 chars">
                            <button type="button" onclick="toggleVis('su_Mot de passe', this)"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                                <i class="fas fa-eye text-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <button type="submit"
                        class="w-full text-white font-bold py-3 rounded-xl transition-all duration-200 shadow-sm mt-1"
                        style="background:#2E9E6B;"
                        onmouseover="this.style.background='#1d7a53';" onmouseout="this.style.background='#2E9E6B';">
                    Create Account
                </button>
            </form>

            <p class="text-center text-sm text-slate-500 mt-5">
                Already have an account?
                <button onclick="switchTab('signin')" class="font-bold transition-colors" style="color:#2E9E6B;">Se connecter</button>
            </p>
        </div>

    </div>
</div>

<script>
function switchTab(tab) {
    var isSignin = tab === 'signin';
    document.getElementById('panel_signin').classList.toggle('hidden', !isSignin);
    document.getElementById('panel_signup').classList.toggle('hidden',  isSignin);
    document.getElementById('tab_signin').style.cssText = isSignin ? 'background:#2E9E6B; color:white;' : 'background:transparent; color:#6b7280;';
    document.getElementById('tab_signup').style.cssText = !isSignin ? 'background:#2E9E6B; color:white;' : 'background:transparent; color:#6b7280;';
}
function toggleVis(id, btn) {
    var input = document.getElementById(id);
    var show = input.type === 'password';
    input.type = show ? 'text' : 'password';
    btn.querySelector('i').className = show ? 'fas fa-eye-slash text-sm' : 'fas fa-eye text-sm';
}
</script>
</body>
</html>
