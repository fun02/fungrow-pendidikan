<!doctype html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>FunGrow Pendidikan - Platform Pembelajaran</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-firestore.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        html, body { height: 100%; margin: 0; font-family: 'Space Grotesk', sans-serif; overflow-x: hidden; overscroll-behavior-y: none; }
        * { box-sizing: border-box; -webkit-tap-highlight-color: transparent; }
        :root {
            --bg: #0f172a; --surface: rgba(30,41,59,0.7); --card: rgba(51,65,85,0.4);
            --text: #e2e8f0; --text2: #94a3b8; --accent: #6366f1; --accent2: #a78bfa;
            --glow: rgba(99,102,241,0.3); --border: rgba(148,163,184,0.3);
            --input-bg: rgba(30,41,59,0.8); --bubble-theirs: #1e293b;
        }
        .light {
            --bg: #f0f4ff; --surface: rgba(255,255,255,0.75); --card: rgba(255,255,255,0.6);
            --text: #1e293b; --text2: #475569; --accent: #4f46e5; --accent2: #7c3aed;
            --glow: rgba(79,70,229,0.15); --border: rgba(148,163,184,0.4);
            --input-bg: rgba(255,255,255,0.9); --bubble-theirs: #ffffff;
        }
        .glass { background: var(--surface); backdrop-filter: blur(20px); border: 1px solid var(--border); border-radius: 16px; }
        .card-3d { transform: perspective(800px) rotateX(0) rotateY(0); transition: transform 0.4s ease, box-shadow 0.4s ease; }
        .card-3d:hover { transform: perspective(800px) rotateX(-3deg) rotateY(3deg) translateY(-8px); box-shadow: 0 20px 40px var(--glow); }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes slideUp { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes slideUpAttachment { from { opacity: 0; transform: translateY(100%); } to { opacity: 1; transform: translateY(0); } }
        @keyframes pulse { 50% { opacity: 0.5; } }
        @keyframes spin-slow { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        @keyframes slide-up-full { from { transform: translateY(100%); } to { transform: translateY(0); } }
        
        .animate-fade { animation: fadeIn 0.3s ease both; }
        .animate-slide { animation: slideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) both; }
        .animate-slide-attachment { animation: slideUpAttachment 0.3s cubic-bezier(0.16, 1, 0.3, 1) both; }
        .animate-spin-slow { animation: spin-slow 8s linear infinite; }
        .animate-slide-up { animation: slide-up-full 0.5s cubic-bezier(0.16, 1, 0.3, 1) both; }
        .pulse { animation: pulse 1.5s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
        
        .bubble-left { border-radius: 4px 16px 16px 16px; }
        .bubble-right { border-radius: 16px 4px 16px 16px; }
        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 2px; }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .voice-note-player { display: flex; align-items: center; gap: 8px; width: 100%; min-width: 150px; }
        .voice-note-player audio { width: 0; height: 0; visibility: hidden; position: absolute; }
        .voice-note-progress { flex: 1; height: 4px; border-radius: 2px; background: rgba(255,255,255,0.3); position: relative; }
        .voice-note-progress-fill { position: absolute; left: 0; top: 0; height: 100%; border-radius: 2px; background: #fff; width: 0%; transition: width 0.1s linear; }
        
        .modal-background { background: rgba(0, 0, 0, 0.7); backdrop-filter: blur(8px); position: fixed; inset: 0; z-index: 1000; opacity: 0; pointer-events: none; transition: opacity 0.3s ease; }
        .modal-background.show { opacity: 1; pointer-events: auto; }
        .msg-active { filter: brightness(0.8); transform: scale(0.98); transition: all 0.2s ease; }
        
        .banner-swiper { padding-bottom: 25px !important; }
        .swiper-pagination-bullet { background: var(--text2) !important; opacity: 0.4; transition: all 0.3s ease; }
        .swiper-pagination-bullet-active { background: #2563eb !important; opacity: 1; width: 24px; border-radius: 12px; }
    </style>
</head>
<body class="h-full overflow-hidden flex flex-col" style="background:var(--bg);color:var(--text)">

<div id="app" class="h-full flex flex-col overflow-hidden"></div>

<div id="promo-modal" class="fixed inset-0 z-[100] hidden items-center justify-center p-5 transition-opacity duration-300 opacity-0">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closePromoModal()"></div>
    <div class="relative w-full max-w-sm mx-auto transform scale-95 transition-transform duration-300" id="promo-content">
        <button onclick="closePromoModal()" class="absolute -top-4 -right-4 w-10 h-10 bg-white text-slate-800 rounded-full flex items-center justify-center shadow-xl border border-slate-200 z-10 active:scale-90 transition-transform"><i data-lucide="x" class="w-6 h-6"></i></button>
        <img src="https://images.unsplash.com/photo-1543269865-cbf427effbad?auto=format&fit=crop&q=80&w=600&h=800" alt="Pengumuman" class="w-full h-auto max-h-[80vh] object-contain rounded-2xl shadow-2xl">
    </div>
</div>

<div id="reset-modal" class="modal-background flex items-center justify-center p-4 z-[2000]">
    <div class="glass p-8 w-full max-w-sm animate-slide text-center shadow-[0_20px_50px_rgba(0,0,0,0.5)] relative overflow-hidden border border-[color:var(--border)]">
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-orange-500/10 rounded-full blur-3xl"></div>
        <div id="reset-content">
            <div id="reset-step-1">
                <div class="w-16 h-16 bg-orange-500/20 rounded-2xl flex items-center justify-center mx-auto mb-5 border border-orange-500/30"><i data-lucide="mail-search" class="w-8 h-8 text-orange-400"></i></div>
                <h3 class="text-xl font-bold text-[color:var(--text)] mb-2">Lupa Password</h3>
                <p class="text-[11px] text-[color:var(--text2)] mb-6 px-4">Masukkan NIM dan Email Anda yang terdaftar.</p>
                <input type="number" id="reset-nim-input" class="w-full p-3.5 rounded-xl bg-[color:var(--input-bg)] border border-[color:var(--border)] text-sm text-[color:var(--text)] mb-3 outline-none focus:border-orange-500/50 transition-all" placeholder="NIM Anda">
                <input type="email" id="reset-email-input" class="w-full p-3.5 rounded-xl bg-[color:var(--input-bg)] border border-[color:var(--border)] text-sm text-[color:var(--text)] mb-4 outline-none focus:border-orange-500/50 transition-all" placeholder="Email Anda">
                <button onclick="sendResetLink()" class="w-full py-3.5 rounded-xl font-bold text-white bg-gradient-to-r from-orange-500 to-amber-600 shadow-lg shadow-orange-500/20 active:scale-95 transition-transform">Kirim Link Reset</button>
            </div>
            <div id="reset-step-2" class="hidden">
                <div class="text-center">
                    <h3 class="font-bold text-[color:var(--text)] mb-2">Email Terkirim! ✅</h3>
                    <p class="text-sm text-[color:var(--text2)]">Link pemulihan telah dikirim ke email Anda.<br>Cek kotak masuk atau spam.</p>
                    <button onclick="document.getElementById('reset-modal').classList.remove('show')" class="mt-4 w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl transition-all font-medium">Tutup</button>
                </div>
            </div>
        </div>
        <button onclick="document.getElementById('reset-modal').classList.remove('show')" class="mt-6 text-xs text-[color:var(--text2)] font-medium hover:text-[color:var(--text)] transition-colors">Batal</button>
    </div>
</div>

<div id="global-modal" class="modal-background flex items-center justify-center p-4 z-[1500]">
    <div class="w-full" id="modal-content"></div>
</div>

<input type="file" id="global-file-input" class="hidden" onchange="handleGlobalFileUpload(event)">

<script>
    // ==========================================
    // 1. FIREBASE CONFIGURATION & CONSTANTS
    // ==========================================
    const firebaseConfig = {
        apiKey: "{{ env('FIREBASE_API_KEY') }}",
        authDomain: "{{ env('FIREBASE_AUTH_DOMAIN') }}",
        projectId: "{{ env('FIREBASE_PROJECT_ID') }}",
        storageBucket: "{{ env('FIREBASE_STORAGE_BUCKET') }}",
        messagingSenderId: "{{ env('FIREBASE_MESSAGING_SENDER_ID') }}",
        appId: "{{ env('FIREBASE_APP_ID') }}"
    };
    
    if (!firebase.apps.length) {
        firebase.initializeApp(firebaseConfig);
    }
    const auth = firebase.auth(), db = firebase.firestore();

    const COURSES = [
        { id: 'mo', name: 'Manajemen Operasional', icon: '⚙️' },
        { id: 'pk', name: 'Perilaku Konsumen', icon: '🧠' },
        { id: 'ms', name: 'Manajemen Strategi', icon: '🎯' },
        { id: 'sim', name: 'Sistem Informasi Manajemen', icon: '💻' },
        { id: 'fmk', name: 'Fiqh Muamalah Kontemporer', icon: '📖' },
        { id: 'mks', name: 'Manajemen Keuangan Syariah', icon: '💰' },
        { id: 'aks', name: 'Akuntansi Keuangan Syariah', icon: '📊' },
        { id: 'emm', name: 'Ekonomi Makro dan Mikro', icon: '📈' }
    ];

    const FULL_SCHEDULE = [
        { day: 'Senin', items: [{ time: '08.00 - 10.30', name: 'Manajemen Operasional', room: '204', id: 'mo', code: 'MO-401', sks: 3, dosen: 'Slamet Wijiono, S.E., M.Si.' }, { time: '11.10 - 13.40', name: 'Perilaku Konsumen', room: '203', id: 'pk', code: 'PK-402', sks: 3, dosen: 'Bastomi Dani Umbara, S.E., M.M.' }]},
        { day: 'Selasa', items: [{ time: '08.00 - 10.30', name: 'Manajemen Strategi', room: '202', id: 'ms', code: 'MS-403', sks: 3, dosen: 'Farida Umi Choiriyah, S.Pd., M.M.' }, { time: '11.10 - 13.40', name: 'Sistem Informasi Manajemen', room: '202', id: 'sim', code: 'SIM-404', sks: 3, dosen: 'Bastomi Dani Umbara. S.E., M.M.' }]},
        { day: 'Rabu', items: [{ time: '11.10 - 13.40', name: 'Fiqh Muamalah Kontemporer', room: '202', id: 'fmk', code: 'FMK-405', sks: 2, dosen: 'Miftakhul Jannah, S.Pd., Μ.Ε.' }]},
        { day: 'Kamis', items: [{ time: '11.10 - 13.40', name: 'Manajemen Keuangan Syariah', room: '202', id: 'mks', code: 'MKS-406', sks: 3, dosen: 'Istiadah, S.E., M.E.' }, { time: '14.00 - 16.30', name: 'Akuntansi Keuangan Syariah', room: '203', id: 'aks', code: 'AKS-407', sks: 3, dosen: 'Siti Nur Azizatul Lutfiyah, S.E., M.E.' }]},
        { day: 'Jumat', items: [{ time: '08.00 - 10.30', name: 'Ekonomi Makro dan Mikro', room: '202', id: 'emm', code: 'EMM-408', sks: 3, dosen: 'Hamim, S.E., M.E.' }]}
    ];

    const STATE = {
        currentUser: null, isDark: true, currentCourse: null, screen: 'loading', dashboardTab: 'home',
        chats: {}, assignments: {}, unsubscribers: {}, audioChunks: [], pinnedMessage: null, aiChatHistory: [], aiPendingFile: null, asgPendingFile: null
    };

    // Stiker & Emoji
    STATE.defaultStickers = [
        "https://cdn-icons-png.flaticon.com/512/4632/4632283.png", "https://cdn-icons-png.flaticon.com/512/4632/4632295.png",
        "https://cdn-icons-png.flaticon.com/512/4632/4632338.png", "https://cdn-icons-png.flaticon.com/512/4632/4632311.png",
        "https://cdn-icons-png.flaticon.com/512/4632/4632320.png", "https://cdn-icons-png.flaticon.com/512/4632/4632288.png"
    ];
    STATE.defaultEmojis = ["😀","😃","😄","😁","😆","😅","😂","🤣","🥲","☺️","😊","😇","🙂","🙃","😉","😌","😍","🥰","😘","😗","👍","👎","🙏","💪"];

    // ==========================================
    // 2. HELPER FUNCTIONS
    // ==========================================
    function showToast(msg, type='success') {
        const toast = document.createElement('div');
        toast.className = 'animate-fade fixed top-4 right-4 z-[3000] px-5 py-3 rounded-xl text-sm font-bold shadow-lg text-white';
        toast.style.background = type==='error'?'#ef4444':type==='warning'?'#f59e0b':'#22c55e';
        toast.textContent = msg; document.body.appendChild(toast);
        setTimeout(() => { toast.style.opacity = '0'; setTimeout(() => toast.remove(), 300); }, 2500);
    }
    function formatDate(ts) { const d = ts?.toDate ? ts.toDate() : new Date(ts); return isNaN(d) ? '' : d.toLocaleDateString('id', { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' }); }
    function formatTime(ts) { const d = ts?.toDate ? ts.toDate() : new Date(ts); return isNaN(d) ? '' : d.toLocaleTimeString('id', { hour: '2-digit', minute: '2-digit' }); }
    function formatRecTime(sec) { const m = Math.floor(sec/60); const s = sec%60; return m+':'+(s<10?'0':'')+s; }
    function formatChatDateBadge(ts) { const d = ts?.toDate ? ts.toDate() : new Date(ts); if(isNaN(d)) return ''; const today=new Date(); const yest=new Date(); yest.setDate(today.getDate()-1); if(d.toDateString()===today.toDateString()) return 'Hari Ini'; if(d.toDateString()===yest.toDateString()) return 'Kemarin'; return d.toLocaleDateString('id', {day:'numeric', month:'short', year:'numeric'}); }

    function toggleTheme() { STATE.isDark = !STATE.isDark; document.documentElement.classList.toggle('light', !STATE.isDark); renderFull(); }
    window.switchTab = function(tabName) { STATE.dashboardTab = tabName; renderFull(); };

    function showGlobalModal(html, isLarge = false) {
        const modal = document.getElementById('global-modal'); const content = document.getElementById('modal-content');
        content.innerHTML = html; modal.classList.add('show');
        content.className = isLarge ? "w-full max-w-4xl mx-auto" : "w-full max-w-sm mx-auto";
        if (typeof lucide !== 'undefined') lucide.createIcons();
    }
    window.closeGlobalModal = function() { document.getElementById('global-modal').classList.remove('show'); setTimeout(() => { document.getElementById('modal-content').innerHTML = ''; }, 200); }
    document.getElementById('global-modal').addEventListener('click', e => { if (e.target.id === 'global-modal') closeGlobalModal(); });

    // Cloudinary Uploader
    async function fetchCloudinaryUpload(file, isAudio = false) { 
        const fd = new FormData(); fd.append('file', file); fd.append('upload_preset', isAudio ? 'fungrow_audio_preset' : 'fungrow_preset'); 
        const res = await fetch(`https://api.cloudinary.com/v1_1/dt51ndddv/${isAudio ? 'video' : 'auto'}/upload`, { method: 'POST', body: fd }); 
        const data = await res.json(); 
        if (data.error) throw new Error(data.error.message); 
        return data.secure_url; 
    }

    // ==========================================
    // 3. AUTHENTICATION & ROUTER
    // ==========================================
    auth.onAuthStateChanged(async (user) => {
        if (user) {
            const doc = await db.collection('users').doc(user.uid).get();
            const data = doc.exists ? doc.data() : {};
            STATE.currentUser = { uid: user.uid, ...data, displayName: user.displayName || data.displayName || 'User' };
            STATE.screen = 'dashboard';
            COURSES.forEach(c => { setupAssignmentListener(c.id); setupChatListener(c.id); });
        } else { STATE.screen = 'login'; }
        renderFull();
    });

    function renderFull() {
        const el = document.getElementById('app'); if (!el) return;
        if (STATE.screen === 'loading') el.innerHTML = `<div class="h-full flex items-center justify-center font-bold text-xl text-[color:var(--text)] animate-pulse">FunGrow Pendidikan...</div>`;
        else if (STATE.screen === 'login') renderLogin(el);
        else if (STATE.screen === 'dashboard') renderDashboardLayout(el);
        else if (STATE.screen === 'course') renderCourse(el);
        if (typeof lucide !== 'undefined') lucide.createIcons();
    }

    // LISTENER TUGAS DAN CHAT
    function setupAssignmentListener(courseId) {
        if (STATE.unsubscribers[`asg_${courseId}`]) STATE.unsubscribers[`asg_${courseId}`]();
        STATE.unsubscribers[`asg_${courseId}`] = db.collection('courses').doc(courseId).collection('assignments').onSnapshot(snap => {
            STATE.assignments[courseId] = snap.docs.map(d => ({ id: d.id, courseId, ...d.data() }));
            if(STATE.screen === 'dashboard' && STATE.dashboardTab === 'tasks') renderDashboardContent();
        });
    }
    function setupChatListener(courseId) {
        if (STATE.unsubscribers[`chat_${courseId}`]) STATE.unsubscribers[`chat_${courseId}`]();
        STATE.unsubscribers[`chat_${courseId}`] = db.collection('courses').doc(courseId).collection('chats').orderBy('timestamp').onSnapshot(snap => {
            STATE.chats[courseId] = snap.docs.map(d => ({ id: d.id, ...d.data() }));
            if(STATE.screen === 'course' && STATE.currentCourse?.id === courseId) renderMessagesOnly();
        });
    }

    // LOGIN & SIGNUP
    function renderLogin(el) {
        el.innerHTML = `
        <div class="h-full flex items-center justify-center p-4">
            <div class="glass p-8 w-full max-w-sm animate-slide shadow-2xl border border-[color:var(--border)] text-center">
                <div class="text-4xl mb-3">🎓</div><h1 class="text-2xl font-bold text-[color:var(--text)] mb-8">FunGrow</h1>
                <div id="login-tab" class="space-y-4">
                    <input type="number" id="login-nim" class="w-full p-3.5 rounded-xl bg-[color:var(--input-bg)] border border-[color:var(--border)] text-sm text-[color:var(--text)] outline-none" placeholder="NIM">
                    <input type="password" id="login-password" class="w-full p-3.5 rounded-xl bg-[color:var(--input-bg)] border border-[color:var(--border)] text-sm text-[color:var(--text)] outline-none" placeholder="Password">
                    <button onclick="doLogin()" class="w-full py-3.5 rounded-xl font-bold text-white bg-indigo-600 shadow-lg active:scale-95 transition-transform">Masuk</button>
                    <div class="flex justify-between items-center mt-4">
                        <button onclick="openForgotPasswordModal()" class="text-xs text-orange-400 font-medium underline">Lupa Password?</button>
                        <p class="text-xs text-[color:var(--text2)]">Belum punya akun? <button onclick="document.getElementById('login-tab').classList.add('hidden');document.getElementById('signup-tab').classList.remove('hidden')" class="underline text-indigo-400 font-bold">Daftar</button></p>
                    </div>
                </div>
                <div id="signup-tab" class="space-y-4 hidden">
                    <input type="text" id="signup-name" class="w-full p-3.5 rounded-xl bg-[color:var(--input-bg)] border border-[color:var(--border)] text-sm text-[color:var(--text)]" placeholder="Nama Lengkap">
                    <input type="number" id="signup-nim" class="w-full p-3.5 rounded-xl bg-[color:var(--input-bg)] border border-[color:var(--border)] text-sm text-[color:var(--text)]" placeholder="NIM">
                    <input type="email" id="signup-email" class="w-full p-3.5 rounded-xl bg-[color:var(--input-bg)] border border-[color:var(--border)] text-sm text-[color:var(--text)]" placeholder="Email">
                    <input type="password" id="signup-password" class="w-full p-3.5 rounded-xl bg-[color:var(--input-bg)] border border-[color:var(--border)] text-sm text-[color:var(--text)]" placeholder="Password">
                    <input type="password" id="signup-confirm" class="w-full p-3.5 rounded-xl bg-[color:var(--input-bg)] border border-[color:var(--border)] text-sm text-[color:var(--text)]" placeholder="Konfirmasi Password">
                    <button onclick="doSignup()" class="w-full py-3.5 rounded-xl font-bold text-white bg-indigo-600 shadow-lg active:scale-95 transition-transform">Daftar</button>
                    <p class="text-xs text-center text-[color:var(--text2)] mt-4">Sudah punya akun? <button onclick="document.getElementById('signup-tab').classList.add('hidden');document.getElementById('login-tab').classList.remove('hidden')" class="underline text-indigo-400 font-bold">Masuk</button></p>
                </div>
            </div>
        </div>`;
    }

    window.doLogin = async function() {
        const nim = document.getElementById('login-nim').value, password = document.getElementById('login-password').value;
        if(!nim || !password) return showToast('Isi NIM & Password!', 'error');
        showToast("Memverifikasi...", "warning");
        try {
            const snap = await db.collection("users").where("nim", "==", nim).limit(1).get();
            if (snap.empty) return showToast("NIM tidak terdaftar!", "error");
            let emailAsli = ""; snap.forEach(doc => { emailAsli = doc.data().email; });
            const cred = await auth.signInWithEmailAndPassword(emailAsli, password);
            if (!cred.user.emailVerified) { await auth.signOut(); return showToast("Akun belum aktif! Cek email Anda.", "error"); }
            showToast("Login Berhasil!", "success");
        } catch (e) { showToast("Login Gagal!", "error"); }
    };

    window.doSignup = async function() {
        const nama=document.getElementById('signup-name').value, nim=document.getElementById('signup-nim').value, email=document.getElementById('signup-email').value, password=document.getElementById('signup-password').value, confirm=document.getElementById('signup-confirm').value;
        if(!nama||!nim||!email||!password) return showToast("Isi semua data!", "error");
        if(password!==confirm) return showToast("Password tidak sama!", "error");
        showToast("Memproses...", "warning");
        try {
            const checkNim = await db.collection("users").where("nim", "==", nim).get();
            if (!checkNim.empty) return showToast("NIM sudah terdaftar!", "error");
            const res = await auth.createUserWithEmailAndPassword(email, password);
            await res.user.updateProfile({ displayName: nama }); await res.user.sendEmailVerification();
            await db.collection('users').doc(res.user.uid).set({ displayName: nama, nim: nim, email: email, role: 'mahasiswa' });
            await auth.signOut();
            document.getElementById('signup-tab').classList.add('hidden'); document.getElementById('login-tab').classList.remove('hidden');
            showToast("Sukses! Cek Email untuk verifikasi.", "success");
        } catch(err) { showToast(err.message, 'error'); }
    };

    window.openForgotPasswordModal = () => { document.getElementById('reset-modal').classList.add('show'); document.getElementById('reset-step-1').classList.remove('hidden'); if(document.getElementById('reset-step-2')) document.getElementById('reset-step-2').classList.add('hidden'); };
    window.sendResetLink = async () => {
        const nim = document.getElementById('reset-nim-input').value, email = document.getElementById('reset-email-input').value;
        if(!nim || !email) return showToast('Isi lengkap!', 'error');
        try {
            const snap = await db.collection("users").where("nim", "==", nim).limit(1).get();
            if (snap.empty) return showToast('NIM tidak terdaftar!', 'error');
            let emailAsli = ""; snap.forEach(doc => { emailAsli = doc.data().email; });
            if (emailAsli !== email) return showToast('Email tidak cocok dengan NIM!', 'error');
            await firebase.auth().sendPasswordResetEmail(email);
            document.getElementById('reset-step-1').classList.add('hidden'); document.getElementById('reset-step-2').classList.remove('hidden');
        } catch(e) { showToast('Gagal mengirim link', 'error'); }
    };
    window.doLogout = async function() { Object.values(STATE.unsubscribers).forEach(u => u()); STATE.unsubscribers = {}; await auth.signOut(); };


    // ==========================================
    // 4. DASHBOARD (BOTTOM NAV)
    // ==========================================
    window.renderDashboardLayout = function(el) {
        if(!STATE.dashboardTab) STATE.dashboardTab = 'home';
        const photo = STATE.currentUser?.photoURL ? `<img src="${STATE.currentUser.photoURL}" class="w-10 h-10 rounded-full object-cover border-2 border-[#2563eb] shadow-sm">` : `<div class="w-10 h-10 rounded-full flex items-center justify-center font-bold bg-[#2563eb] text-white border-2 border-[#2563eb] shadow-sm">${STATE.currentUser?.displayName?.[0]?.toUpperCase() || 'U'}</div>`;

        el.innerHTML = `
            <div class="flex flex-col h-full bg-[color:var(--bg)] text-[color:var(--text)] overflow-hidden relative">
                <header class="px-5 py-4 flex justify-between items-center shrink-0 bg-[color:var(--surface)] border-b border-[color:var(--border)] relative z-30 shadow-sm backdrop-blur-xl">
                    <div class="flex items-center gap-3">
                        <button onclick="switchTab('about')" class="shrink-0 active:scale-95 transition-transform">${photo}</button>
                        <div>
                            <h2 class="text-sm font-black tracking-tight leading-none">${STATE.currentUser?.displayName || 'User'}</h2>
                            <span class="text-[9px] font-bold uppercase text-[#2563eb] bg-blue-500/10 px-1.5 py-0.5 rounded mt-1 inline-block border border-blue-500/20">${STATE.currentUser?.role || 'mahasiswa'}</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="relative">
                            <button onclick="openNotifications()" class="p-2.5 rounded-xl bg-[color:var(--card)] text-[color:var(--text2)] border border-[color:var(--border)] active:scale-95 transition-all hover:text-orange-500"><i data-lucide="bell" class="w-5 h-5"></i></button>
                            <span id="notif-badge" class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-red-500 rounded-full border-2 border-[color:var(--bg)] hidden animate-pulse"></span>
                        </div>
                        <button onclick="toggleTheme()" class="p-2.5 rounded-xl bg-[color:var(--card)] text-[color:var(--text2)] border border-[color:var(--border)] active:scale-95 transition-all"><i data-lucide="${STATE.isDark ? 'sun' : 'moon'}" class="w-5 h-5"></i></button>
                    </div>
                </header>
                <main id="dashboard-content" class="flex-1 overflow-y-auto hide-scrollbar pb-[85px] relative pt-2"></main>
                <nav class="fixed bottom-0 left-0 right-0 h-[72px] bg-[color:var(--surface)] border-t border-[color:var(--border)] flex items-center justify-around px-2 z-50 backdrop-blur-xl pb-1 shadow-[0_-10px_30px_rgba(0,0,0,0.1)]">
                    <button onclick="switchTab('home')" class="flex flex-col items-center gap-1 w-16 ${STATE.dashboardTab === 'home' ? 'text-[#2563eb]' : 'text-[color:var(--text2)]'}"><div class="p-1.5 rounded-xl ${STATE.dashboardTab === 'home' ? 'bg-blue-500/10' : ''} transition-all"><i data-lucide="home" class="w-6 h-6"></i></div><span class="text-[9px] font-bold">Home</span></button>
                    <button onclick="switchTab('jadwal')" class="flex flex-col items-center gap-1 w-16 ${STATE.dashboardTab === 'jadwal' ? 'text-[#2563eb]' : 'text-[color:var(--text2)]'}"><div class="p-1.5 rounded-xl ${STATE.dashboardTab === 'jadwal' ? 'bg-blue-500/10' : ''} transition-all"><i data-lucide="calendar" class="w-6 h-6"></i></div><span class="text-[9px] font-bold">Jadwal</span></button>
                    <button onclick="switchTab('kelas')" class="flex flex-col items-center justify-center -mt-8"><div class="w-14 h-14 rounded-full bg-gradient-to-tr from-[#2563eb] to-indigo-600 text-white flex items-center justify-center shadow-lg shadow-blue-500/40 border-4 border-[color:var(--bg)] active:scale-95 transition-transform"><i data-lucide="layout-dashboard" class="w-6 h-6"></i></div><span class="text-[9px] font-bold text-[color:var(--text)] mt-1">Kelas</span></button>
                    ${STATE.currentUser?.role === 'admin' ? `<button onclick="switchTab('mahasiswa')" class="flex flex-col items-center gap-1 w-16 ${STATE.dashboardTab === 'mahasiswa' ? 'text-[#2563eb]' : 'text-[color:var(--text2)]'}"><div class="p-1.5 rounded-xl ${STATE.dashboardTab === 'mahasiswa' ? 'bg-blue-500/10' : ''} transition-all"><i data-lucide="users" class="w-6 h-6"></i></div><span class="text-[9px] font-bold">Data</span></button>` : `<button onclick="switchTab('tasks')" class="flex flex-col items-center gap-1 w-16 ${STATE.dashboardTab === 'tasks' ? 'text-[#2563eb]' : 'text-[color:var(--text2)]'}"><div class="p-1.5 rounded-xl ${STATE.dashboardTab === 'tasks' ? 'bg-blue-500/10' : ''} transition-all"><i data-lucide="check-square" class="w-6 h-6"></i></div><span class="text-[9px] font-bold">Tugas</span></button>`}
                    <button onclick="switchTab('settings')" class="flex flex-col items-center gap-1 w-16 ${STATE.dashboardTab === 'settings' ? 'text-[#2563eb]' : 'text-[color:var(--text2)]'}"><div class="p-1.5 rounded-xl ${STATE.dashboardTab === 'settings' ? 'bg-blue-500/10' : ''} transition-all"><i data-lucide="settings" class="w-6 h-6"></i></div><span class="text-[9px] font-bold">Setelan</span></button>
                </nav>
            </div>
        `;
        renderDashboardContent();
        if(typeof checkNotifications === 'function') checkNotifications();
    };

    window.renderDashboardContent = function() {
        const container = document.getElementById('dashboard-content'); if (!container) return;
        if (STATE.dashboardTab === 'home') { container.innerHTML = getHomeHTML(); setTimeout(() => { if(window.showPromoModal) showPromoModal(); }, 1000); }
        else if (STATE.dashboardTab === 'kelas') { container.innerHTML = getKelasHTML(); setTimeout(() => { if (typeof Swiper !== 'undefined') new Swiper('.banner-swiper', { slidesPerView: 1, spaceBetween: 0, loop: true, autoplay: { delay: 3500 }, pagination: { el: '.swiper-pagination', clickable: true } }); }, 100); }
        else if (STATE.dashboardTab === 'jadwal') container.innerHTML = getJadwalHTML();
        else if (STATE.dashboardTab === 'mahasiswa') { container.innerHTML = getDataMahasiswaHTML(); setTimeout(()=>loadDataMahasiswa(), 50); }
        else if (STATE.dashboardTab === 'about') container.innerHTML = getAboutHTML();
        else if (STATE.dashboardTab === 'tasks') container.innerHTML = renderAllAssignments();
        else if (STATE.dashboardTab === 'settings') container.innerHTML = renderSettings();
        if (typeof lucide !== 'undefined') lucide.createIcons();
    };

    // =====================================
    // FITUR PENCARIAN JURNAL ONLINE (API CROSSREF - INDONESIA FRIENDLY)
    // =====================================
    window.searchJurnal = async function() {
        const query = document.getElementById('jurnal-search-input').value;
        const container = document.getElementById('jurnal-results-container');
        
        if(!query) return showToast('Ketik judul jurnal/materi dulu!', 'warning');
        
        // Animasi Loading
        container.innerHTML = `<div class="w-full text-center py-8"><i data-lucide="loader-2" class="w-8 h-8 animate-spin mx-auto text-[#2563eb] mb-2"></i><p class="text-xs text-[color:var(--text2)] font-bold animate-pulse">Sedang mencari jurnal "${query}"...</p></div>`;
        if (typeof lucide !== 'undefined') lucide.createIcons();

        try {
            // Menggunakan CrossRef API (Database terbesar untuk jurnal kampus & OJS Indonesia)
            const url = `https://api.crossref.org/works?query=${encodeURIComponent(query)}&select=title,author,URL,link,issued&rows=15`;
            const res = await fetch(url);
            const data = await res.json();
            const items = data.message.items;

            if(!items || items.length === 0) {
                throw new Error("Kosong");
            }

            let html = '';
            let count = 0;

            items.forEach(work => {
                if (count >= 10) return; // Batasi 10 hasil terbaik
                
                // Skip jika tidak ada judul
                if (!work.title || work.title.length === 0) return;
                
                const title = work.title[0];
                
                // Ambil nama penulis pertama
                let author = 'Penulis Anonim';
                if (work.author && work.author.length > 0) {
                    const firstAuthor = work.author[0];
                    author = firstAuthor.family ? `${firstAuthor.given || ''} ${firstAuthor.family}`.trim() : (firstAuthor.name || 'Tim Peneliti');
                }

                // Cari link PDF langsung jika ada, jika tidak pakai URL DOI (halaman website jurnal)
                let pdfUrl = work.URL;
                let isDirectPdf = false;
                if (work.link) {
                    const pdfLink = work.link.find(l => l['content-type'] === 'application/pdf');
                    if (pdfLink) {
                        pdfUrl = pdfLink.URL;
                        isDirectPdf = true;
                    }
                }

                // Ambil Tahun Terbit
                let year = '-';
                if (work.issued && work.issued['date-parts'] && work.issued['date-parts'][0][0]) {
                    year = work.issued['date-parts'][0][0];
                }

                html += `
                <div class="glass p-3 rounded-2xl border border-[color:var(--border)] min-w-[160px] max-w-[200px] snap-start shrink-0 flex flex-col gap-2 group hover:bg-[color:var(--card)] transition-all shadow-sm relative">
                    <div class="absolute -top-1 -right-1 flex gap-1 z-10">
                        <span class="text-[8px] font-black text-white ${isDirectPdf ? 'bg-emerald-500' : 'bg-[#2563eb]'} px-1.5 py-0.5 rounded shadow-sm">${isDirectPdf ? 'PDF' : 'WEB'}</span>
                    </div>
                    <div class="h-20 bg-gradient-to-br from-[#2563eb] to-purple-600 rounded-xl flex items-center justify-center relative overflow-hidden shadow-inner p-2 text-center">
                        <i data-lucide="book-open" class="absolute w-12 h-12 text-white opacity-20 group-hover:scale-110 transition-transform"></i>
                        <span class="relative z-10 text-[9px] font-bold text-white line-clamp-3 leading-tight">${title}</span>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-[11px] font-bold text-[color:var(--text)] leading-tight line-clamp-2 mb-0.5" title="${title}">${title}</h4>
                        <p class="text-[8px] text-[color:var(--text2)] line-clamp-1"><i data-lucide="user" class="w-2 h-2 inline"></i> ${author} • ${year}</p>
                    </div>
                    <a href="${pdfUrl}" target="_blank" class="w-full py-2 bg-[color:var(--input-bg)] border border-[color:var(--border)] text-[#2563eb] text-[10px] font-bold rounded-lg group-hover:bg-[#2563eb] group-hover:text-white transition-all flex justify-center items-center gap-1 shadow-sm active:scale-95">
                        <i data-lucide="${isDirectPdf ? 'download' : 'external-link'}" class="w-3 h-3"></i> ${isDirectPdf ? 'Unduh PDF' : 'Buka Jurnal'}
                    </a>
                </div>`;
                count++;
            });

            if(count === 0) throw new Error("Kosong");

            container.innerHTML = html;
            if (typeof lucide !== 'undefined') lucide.createIcons();

        } catch(err) {
            container.innerHTML = `
                <div class="w-full text-center py-6 border border-dashed border-red-500/30 rounded-2xl bg-red-500/5">
                    <i data-lucide="file-x" class="w-8 h-8 mx-auto mb-2 text-red-400 opacity-50"></i>
                    <p class="text-[11px] text-red-400 font-bold">Maaf, jurnal tidak ditemukan.</p>
                    <p class="text-[9px] mt-1 text-[color:var(--text2)]">Pastikan ejaan benar atau gunakan kata kunci lain.</p>
                </div>`;
            if (typeof lucide !== 'undefined') lucide.createIcons();
        }
    };

    // =====================================
    //  5. DASHBOARD HOME UTAMA
    // =====================================
    window.getHomeHTML = function() {
        const nowWIB = new Date(new Date().toLocaleString("en-US", {timeZone: "Asia/Jakarta"}));
        const dateOptions = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
        const todayStr = nowWIB.toLocaleDateString('id-ID', dateOptions);
        const dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const todayName = dayNames[nowWIB.getDay()];
        
        const todaysSchedule = typeof FULL_SCHEDULE !== 'undefined' ? FULL_SCHEDULE.find(s => s.day === todayName)?.items || [] : [];
        let allAsg = STATE.assignments ? Object.values(STATE.assignments).flat().sort((a,b) => (a.deadline?.seconds || 0) - (b.deadline?.seconds || 0)) : [];
        let urgentCount = allAsg.length;

        // KARTU TUGAS TERKINI
        let tasksHTML = allAsg.slice(0, 3).map(a => `
            <div class="glass p-3.5 rounded-2xl border border-[color:var(--border)] flex justify-between items-center group cursor-pointer hover:bg-[color:var(--card)]" onclick="viewAssignmentDetail('${a.courseId}', '${a.id}')">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-500/10 text-blue-500 flex items-center justify-center shrink-0 border border-blue-500/20"><i data-lucide="file-text" class="w-5 h-5"></i></div>
                    <div class="min-w-0"><h4 class="text-[11px] font-bold truncate max-w-[140px] uppercase">${a.title}</h4><p class="text-[9px] text-[color:var(--text2)] truncate">${typeof COURSES !== 'undefined' ? COURSES.find(c=>c.id===a.courseId)?.name : ''}</p></div>
                </div>
                <div class="text-right shrink-0"><p class="text-[9px] font-bold text-orange-500"><i data-lucide="clock" class="w-3 h-3 inline mb-0.5"></i> ${typeof formatDate === 'function' ? formatDate(a.deadline).split(',')[0] : ''}</p><span class="text-[8px] bg-orange-500/10 text-orange-500 px-1.5 py-0.5 rounded uppercase font-black border border-orange-500/20 mt-1 inline-block">Pending</span></div>
            </div>`).join('');

        // JADWAL HARI INI
        let scheduleHTML = todaysSchedule.map((c, idx) => `
            <div class="flex gap-3 relative pb-4 animate-fade" style="animation-delay: ${idx * 0.1}s">
                ${idx !== todaysSchedule.length - 1 ? `<div class="absolute left-[11px] top-6 bottom-[-10px] w-0.5 bg-gradient-to-b from-[#2563eb] to-[color:var(--border)] opacity-50"></div>` : ''}
                <div class="w-6 h-6 rounded-full bg-[#2563eb] text-white flex items-center justify-center shrink-0 z-10 text-[10px] shadow-[0_0_10px_rgba(37,99,235,0.4)] border-2 border-[color:var(--bg)]"><i data-lucide="book-open" class="w-3 h-3"></i></div>
                <div class="flex-1 pb-2"><p class="text-[9px] font-black text-[#2563eb] tracking-wider mb-0.5">${c.time}</p><h4 class="text-xs font-bold leading-tight mb-1">${c.name}</h4><div class="flex items-center gap-2"><span class="text-[8px] bg-[color:var(--input-bg)] border border-[color:var(--border)] px-1.5 py-0.5 rounded opacity-80"><i data-lucide="map-pin" class="w-2.5 h-2.5 inline text-emerald-500"></i> Rg. ${c.room}</span><span class="text-[8px] bg-[color:var(--input-bg)] border border-[color:var(--border)] px-1.5 py-0.5 rounded opacity-80"><i data-lucide="user" class="w-2.5 h-2.5 inline text-amber-500"></i> ${c.dosen || 'Dosen'}</span></div></div>
            </div>`).join('');

        // KALENDER PINTAR (WIB)
        const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        const m = nowWIB.getMonth(); const y = nowWIB.getFullYear(); const d = nowWIB.getDate();
        const firstDay = new Date(y, m, 1).getDay(); const daysInMonth = new Date(y, m + 1, 0).getDate();
        
        let calDays = '';
        for(let i=0; i<firstDay; i++) calDays += `<div></div>`;
        for(let i=1; i<=daysInMonth; i++) {
            if(i === d) calDays += `<div class="w-7 h-7 mx-auto rounded-full bg-[#2563eb] text-white flex items-center justify-center font-black shadow-md shadow-blue-500/30">${i}</div>`;
            else calDays += `<div class="w-7 h-7 mx-auto flex items-center justify-center text-[color:var(--text)] hover:bg-[color:var(--card)] rounded-full cursor-pointer transition-colors">${i}</div>`;
        }
        const miniCalendarHTML = `
            <div class="glass p-5 rounded-3xl border border-[color:var(--border)] shadow-sm mb-4">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="font-bold text-sm flex items-center gap-2"><i data-lucide="calendar" class="w-4 h-4 text-[#2563eb]"></i> ${monthNames[m]} ${y}</h3>
                    <span class="text-[9px] px-2 py-1 bg-blue-500/10 text-blue-500 rounded-md font-bold uppercase border border-blue-500/20 tracking-wider">WIB</span>
                </div>
                <div class="grid grid-cols-7 gap-1 text-center text-[10px] font-bold text-[color:var(--text2)] mb-2">
                    <div>M</div><div>S</div><div>S</div><div>R</div><div>K</div><div>J</div><div>S</div>
                </div>
                <div class="grid grid-cols-7 gap-y-2 text-center text-xs font-medium">${calDays}</div>
            </div>`;

        // GABUNGKAN SEMUA HTML
        return `
            <div class="space-y-6 animate-fade px-4 py-4 max-w-6xl mx-auto pb-10">
                
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 glass p-6 rounded-3xl border border-[color:var(--border)] shadow-sm">
                    <div>
                        <p class="text-[10px] font-bold text-[#2563eb] uppercase mb-1 tracking-wider bg-blue-500/10 px-2 py-1 rounded inline-block border border-blue-500/20">${todayStr}</p>
                        <h2 class="text-xl font-black text-[color:var(--text)] mt-2">Dashboard Perkuliahan</h2>
                    </div>
                    <div class="relative w-full md:w-64">
                        <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[color:var(--text2)]"></i>
                        <input type="text" placeholder="Cari modul / menu..." class="w-full bg-[color:var(--input-bg)] border border-[color:var(--border)] rounded-full py-2.5 pl-9 pr-4 text-xs outline-none focus:border-[#2563eb] shadow-inner transition-colors">
                    </div>
                </div>

                <div class="flex overflow-x-auto hide-scrollbar gap-4 pb-2 snap-x">
                    <div class="glass p-4 rounded-3xl border border-[color:var(--border)] flex items-center gap-3 shrink-0 min-w-[160px] snap-start hover:scale-105 transition-transform cursor-pointer" onclick="switchTab('tasks')">
                        <div class="w-12 h-12 rounded-2xl bg-orange-500/10 text-orange-500 flex items-center justify-center shrink-0"><i data-lucide="flame" class="w-6 h-6"></i></div>
                        <div><p class="text-xl font-black leading-none mb-1">${urgentCount}</p><p class="text-[9px] uppercase tracking-widest text-[color:var(--text2)] font-bold">Mendesak</p></div>
                    </div>
                    <div class="glass p-4 rounded-3xl border border-[color:var(--border)] flex items-center gap-3 shrink-0 min-w-[160px] snap-start hover:scale-105 transition-transform cursor-pointer" onclick="switchTab('kelas')">
                        <div class="w-12 h-12 rounded-2xl bg-blue-500/10 text-blue-500 flex items-center justify-center shrink-0"><i data-lucide="book-open" class="w-6 h-6"></i></div>
                        <div><p class="text-xl font-black leading-none mb-1">${typeof COURSES!=='undefined'?COURSES.length:8}</p><p class="text-[9px] uppercase tracking-widest text-[color:var(--text2)] font-bold">Modul Aktif</p></div>
                    </div>
                    <div class="glass p-4 rounded-3xl border border-[color:var(--border)] flex items-center gap-3 shrink-0 min-w-[180px] snap-start bg-emerald-500/5">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-500/20 text-emerald-500 flex items-center justify-center shrink-0"><i data-lucide="wallet" class="w-6 h-6"></i></div>
                        <div><p class="text-lg font-black text-emerald-500 leading-none mb-1">Rp 450K</p><p class="text-[9px] uppercase tracking-widest text-emerald-600 font-bold">Uang Kas Kelas</p></div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <div class="lg:col-span-2 space-y-6">
                        
                        <div>
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-3 gap-3">
                                <h3 class="text-sm font-black flex items-center gap-2"><i data-lucide="library" class="w-4 h-4 text-purple-500"></i> Pencarian Jurnal (Global)</h3>
                                <div class="flex gap-1 w-full sm:w-64">
                                    <div class="relative flex-1">
                                        <i data-lucide="search" class="absolute left-2.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-[color:var(--text2)]"></i>
                                        <input type="text" id="jurnal-search-input" placeholder="Cari jurnal PDF..." class="w-full bg-[color:var(--input-bg)] border border-[color:var(--border)] rounded-full py-2 pl-8 pr-3 text-[11px] outline-none focus:border-purple-500 transition-colors shadow-sm" onkeydown="if(event.key==='Enter') searchJurnal()">
                                    </div>
                                    <button onclick="searchJurnal()" class="bg-purple-600 hover:bg-purple-700 text-white p-2 rounded-full shrink-0 transition-colors shadow-md active:scale-95"><i data-lucide="search" class="w-4 h-4"></i></button>
                                </div>
                            </div>
                            
                            <div id="jurnal-results-container" class="flex gap-3 overflow-x-auto hide-scrollbar pb-3 snap-x">
                                <div class="w-full p-6 text-center border border-dashed border-[color:var(--border)] rounded-2xl text-[color:var(--text2)] glass">
                                    <i data-lucide="globe" class="w-8 h-8 mx-auto mb-2 opacity-50 text-purple-500"></i>
                                    <p class="text-xs font-bold text-[color:var(--text)]">Ketik judul jurnal/materi di atas</p>
                                    <p class="text-[10px] mt-1 opacity-70 leading-relaxed max-w-sm mx-auto">Sistem akan mencari file PDF <i>Open Access</i> dari database akademik global tanpa batas. Coba ketik "Manajemen Syariah" lalu tekan Enter.</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-3">
                                <h3 class="text-sm font-black flex items-center gap-2"><i data-lucide="activity" class="w-4 h-4 text-emerald-500"></i> Aktivitas Kelas</h3>
                                <div class="glass p-4 rounded-3xl border border-[color:var(--border)] space-y-4 shadow-sm">
                                    <div class="flex gap-3 items-start"><div class="w-6 h-6 rounded-full bg-blue-500/20 text-blue-500 flex items-center justify-center shrink-0 mt-0.5"><i data-lucide="upload-cloud" class="w-3 h-3"></i></div><div><p class="text-[10px] text-[color:var(--text)] leading-tight"><span class="font-bold">Ahmad</span> mengumpulkan tugas <span class="font-bold text-[#2563eb]">Manajemen Operasional</span></p><p class="text-[8px] text-[color:var(--text2)] mt-0.5">10 menit yang lalu</p></div></div>
                                    <div class="flex gap-3 items-start"><div class="w-6 h-6 rounded-full bg-orange-500/20 text-orange-500 flex items-center justify-center shrink-0 mt-0.5"><i data-lucide="file-plus" class="w-3 h-3"></i></div><div><p class="text-[10px] text-[color:var(--text)] leading-tight"><span class="font-bold">Dosen</span> memposting modul <span class="font-bold text-orange-500">Fiqh Muamalah</span></p><p class="text-[8px] text-[color:var(--text2)] mt-0.5">2 jam yang lalu</p></div></div>
                                    <div class="flex gap-3 items-start"><div class="w-6 h-6 rounded-full bg-emerald-500/20 text-emerald-500 flex items-center justify-center shrink-0 mt-0.5"><i data-lucide="check-circle-2" class="w-3 h-3"></i></div><div><p class="text-[10px] text-[color:var(--text)] leading-tight">Nilai <span class="font-bold text-emerald-500">Perilaku Konsumen</span> telah keluar</p><p class="text-[8px] text-[color:var(--text2)] mt-0.5">Kemarin</p></div></div>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <div class="flex items-center justify-between"><h3 class="text-sm font-black flex items-center gap-2"><i data-lucide="clipboard-list" class="w-4 h-4 text-[#2563eb]"></i> Tugas Terkini</h3><button onclick="switchTab('tasks')" class="text-[9px] font-bold px-2 py-1 rounded bg-[color:var(--surface)] border border-[color:var(--border)] hover:bg-[#2563eb] hover:text-white transition-colors">Lihat Semua</button></div>
                                <div class="space-y-2">${tasksHTML || '<p class="text-xs italic opacity-50 p-4 border border-dashed border-[color:var(--border)] rounded-xl text-center glass">Bebas tugas! 🎉</p>'}</div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        ${miniCalendarHTML}
                        
                        <div class="space-y-3">
                            <div class="flex items-center justify-between"><h3 class="text-sm font-black flex items-center gap-2"><i data-lucide="calendar-clock" class="w-4 h-4 text-orange-500"></i> Jadwal Hari Ini</h3><span class="text-[8px] font-bold px-2 py-1 bg-orange-500/10 text-orange-500 rounded uppercase border border-orange-500/20">${todayName}</span></div>
                            <div class="glass p-5 rounded-3xl border border-[color:var(--border)] shadow-sm">${scheduleHTML || '<p class="text-[10px] text-center opacity-50 py-4 font-medium">Tidak ada kelas hari ini. Waktunya istirahat!</p>'}</div>
                        </div>
                    </div>

                </div>
            </div>`;
    };

    window.getKelasHTML = function() {
        return `<div class="px-4 mt-2 mb-8 animate-fade"><h3 class="text-sm font-bold text-[color:var(--text)] flex items-center gap-2 mb-3"><i data-lucide="layout-grid" class="w-4 h-4 text-[#2563eb]"></i> Semua Kelas</h3><div class="grid grid-cols-2 gap-3">${COURSES.map(c => `<div onclick="openCourse('${c.id}')" class="glass p-3.5 rounded-2xl flex flex-col gap-3 cursor-pointer active:scale-95 transition-transform border border-[color:var(--border)] relative overflow-hidden shadow-sm"><div class="w-10 h-10 rounded-xl bg-[color:var(--card)] border border-[color:var(--border)] flex items-center justify-center text-xl shrink-0">${c.icon}</div><div><h4 class="font-bold text-[11px] text-[color:var(--text)] line-clamp-2 leading-snug">${c.name}</h4></div><div class="absolute right-3 top-4"><i data-lucide="arrow-up-right" class="w-3.5 h-3.5 text-[color:var(--text2)] opacity-40"></i></div></div>`).join('')}</div></div>`;
    };

    window.getJadwalHTML = function() {
        return `<div class="animate-fade px-4 py-2"><h2 class="text-lg font-bold text-[color:var(--text)] mb-1">Jadwal Perkuliahan</h2><p class="text-xs text-[color:var(--text2)] mb-6">SEMESTER IV (EMPAT)</p>${FULL_SCHEDULE.map(dayObj => `<div class="mb-6"><div class="flex items-center gap-3 mb-3"><div class="h-px bg-[color:var(--border)] flex-1"></div><h3 class="text-xs font-bold text-[#2563eb] tracking-wider uppercase">${dayObj.day}</h3><div class="h-px bg-[color:var(--border)] flex-1"></div></div><div class="space-y-3">${dayObj.items.map(c => `<div class="glass p-4 rounded-2xl border border-[color:var(--border)] shadow-sm relative overflow-hidden"><div class="absolute top-0 left-0 w-1.5 h-full bg-[#2563eb] opacity-80"></div><div class="flex justify-between items-start mb-2 pl-2"><div><h4 class="font-bold text-sm text-[color:var(--text)] leading-tight mb-1">${c.name}</h4><p class="text-[10px] font-mono text-[color:var(--text2)] bg-[color:var(--card)] inline-block px-1.5 py-0.5 rounded border border-[color:var(--border)]">${c.code}</p></div><span class="text-[11px] font-bold text-[#2563eb] bg-blue-500/10 px-2 py-1 rounded-lg border border-blue-500/20 shrink-0">${c.time}</span></div><div class="pl-2 mt-3 flex flex-col gap-1.5"><div class="flex items-center gap-2"><i data-lucide="user" class="w-3.5 h-3.5 text-[color:var(--text2)]"></i><span class="text-[11px] text-[color:var(--text)]">${c.dosen}</span></div><div class="flex items-center gap-4"><div class="flex items-center gap-2"><i data-lucide="door-open" class="w-3.5 h-3.5 text-emerald-500"></i><span class="text-[11px] text-[color:var(--text)] font-medium">Ruang ${c.room}</span></div><div class="flex items-center gap-2"><i data-lucide="book-copy" class="w-3.5 h-3.5 text-orange-500"></i><span class="text-[11px] text-[color:var(--text)] font-medium">${c.sks} SKS</span></div></div></div></div>`).join('')}</div></div>`).join('')}</div>`;
    };

    // ==========================================
    // 6. RENDER DATA MAHASISWA & PROFIL & UPLOAD FOTO
    // ==========================================
    window.getDataMahasiswaHTML = function() { return `<div class="p-5 animate-fade"><h2 class="text-xl font-black mb-4 text-[color:var(--text)]">Data Mahasiswa</h2><div id="wadah-data-mahasiswa" class="space-y-3"><div class="text-center p-4"><i data-lucide="loader" class="w-6 h-6 animate-spin mx-auto text-[#2563eb]"></i></div></div></div>`; };
    window.loadDataMahasiswa = async function() { const wadah = document.getElementById('wadah-data-mahasiswa'); if (!wadah) return; try { const snapshot = await db.collection('users').get(); if (snapshot.empty) { wadah.innerHTML = `<div class="glass p-5 text-center rounded-2xl text-[color:var(--text2)]">Belum ada data.</div>`; return; } let html = ''; window.cachedMahasiswa = {}; snapshot.forEach(doc => { const user = doc.data(); window.cachedMahasiswa[doc.id] = user; const nama = user.displayName || user.name || 'Tanpa Nama'; const nim = user.nim || 'NIM Tidak Ada'; html += `<div class="glass p-4 rounded-2xl border border-[color:var(--border)] flex items-center gap-4 hover:scale-[1.02] transition-all cursor-pointer" onclick="lihatDetailMahasiswa('${doc.id}')"><div class="w-10 h-10 rounded-full bg-[#2563eb] flex items-center justify-center text-white font-bold shrink-0">${nama.charAt(0)}</div><div class="flex-1 min-w-0"><h3 class="font-bold text-[color:var(--text)] truncate text-sm">${nama}</h3><p class="text-[10px] text-[color:var(--text2)]">${nim}</p></div><span class="text-[9px] font-bold px-2 py-1 rounded bg-blue-500/10 text-blue-500 uppercase">${user.role||'mahasiswa'}</span></div>`; }); wadah.innerHTML = html; } catch (e) { wadah.innerHTML = `<div class="text-red-500">Gagal memuat</div>`; } };
    window.lihatDetailMahasiswa = function(uid) { const user = window.cachedMahasiswa[uid]; if(!user) return; const nama = user.displayName || user.name || 'Tanpa Nama'; showGlobalModal(`<div class="glass p-6 rounded-3xl animate-slide w-full max-w-sm mx-auto border border-[color:var(--border)] relative overflow-hidden"><div class="flex items-center gap-4 border-b border-[color:var(--border)] pb-4 mb-4"><div class="w-16 h-16 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-3xl shrink-0">${nama.charAt(0).toUpperCase()}</div><div><h2 class="text-lg font-bold text-[color:var(--text)] leading-tight">${nama}</h2><p class="text-xs font-mono text-[color:var(--text2)] mt-0.5">${user.nim || '-'}</p><span class="text-[9px] font-bold px-2 py-0.5 rounded-md mt-1 inline-block bg-blue-500/20 text-blue-500 uppercase">${user.role || 'Mahasiswa'}</span></div></div><div class="space-y-3"><div><p class="text-[9px] uppercase text-[color:var(--text2)] font-bold">Email</p><p class="text-sm font-medium">${user.email || '-'}</p></div></div><button onclick="closeGlobalModal()" class="w-full mt-6 py-2.5 rounded-xl bg-[color:var(--surface)] font-bold border border-[color:var(--border)]">Tutup Profil</button></div>`); };

    window.toggleEditProfil = function() { const inputs = document.querySelectorAll('.prof-input, #prof-nama'); const isEditing = !inputs[0].disabled; if(!isEditing) { inputs.forEach(i => i.disabled = false); document.getElementById('prof-nama').focus(); document.getElementById('btn-edit-prof').innerHTML = '<i data-lucide="x" class="w-4 h-4"></i> Batal Edit'; document.getElementById('btn-save-prof').classList.remove('hidden'); lucide.createIcons(); } else { document.getElementById('dashboard-content').innerHTML = getAboutHTML(); lucide.createIcons(); } };
    window.simpanProfil = async function() { const btnSave = document.getElementById('btn-save-prof'); btnSave.innerHTML = 'Menyimpan...'; btnSave.disabled = true; try { const newData = { displayName: document.getElementById('prof-nama').value, tglLahir: document.getElementById('prof-tglLahir').value, fakultas: document.getElementById('prof-fakultas').value, prodi: document.getElementById('prof-prodi').value, alamat: document.getElementById('prof-alamat').value }; await db.collection('users').doc(STATE.currentUser.uid).update(newData); STATE.currentUser = { ...STATE.currentUser, ...newData }; showToast("Profil diperbarui!", "success"); document.getElementById('dashboard-content').innerHTML = getAboutHTML(); lucide.createIcons(); } catch (e) { showToast("Gagal menyimpan", "error"); btnSave.innerHTML = 'Simpan'; btnSave.disabled = false; } };

    window.getAboutHTML = function() {
        const u = STATE.currentUser || {};
        const photo = u.photoURL ? `<img src="${u.photoURL}" class="w-full h-full object-cover">` : `<div class="w-full h-full bg-[#2563eb] flex items-center justify-center text-white text-2xl font-bold">${u.displayName?.[0]?.toUpperCase()}</div>`;
        return `
            <div class="animate-fade px-4 py-6 space-y-6 max-w-xl mx-auto pb-10">
                <div class="glass p-6 rounded-[40px] border border-[color:var(--border)] flex items-center gap-5 shadow-sm">
                    <div class="relative w-20 h-20 rounded-full overflow-hidden border-4 border-[#2563eb] shadow-xl group cursor-pointer" onclick="document.getElementById('mhs-photo-input').click()">
                        ${photo}
                        <div class="absolute inset-0 bg-black/50 flex items-center justify-center text-white opacity-0 group-hover:opacity-100 transition-opacity"><i data-lucide="camera" class="w-6 h-6"></i></div>
                    </div>
                    <div><h2 class="text-xl font-black text-[color:var(--text)]">${u.displayName}</h2><p class="text-xs text-[color:var(--text2)] font-mono">${u.nim}</p></div>
                </div>
                <input type="file" id="mhs-photo-input" class="hidden" accept="image/*" onchange="handleProfilePhoto(this)">
                
                <div class="glass p-6 rounded-[40px] border border-[color:var(--border)] space-y-4 shadow-sm">
                    <div><label class="text-[10px] font-black uppercase text-[color:var(--text2)] ml-1 tracking-wider">Nama Lengkap</label><input type="text" id="p-name" value="${u.displayName}" class="w-full mt-1 p-3 rounded-2xl bg-[color:var(--input-bg)] border border-[color:var(--border)] text-[color:var(--text)] text-sm outline-none focus:border-[#2563eb]"></div>
                    <div><label class="text-[10px] font-black uppercase text-[color:var(--text2)] ml-1 tracking-wider">Email (Bawaan)</label><input type="text" value="${u.email}" class="w-full mt-1 p-3 rounded-2xl bg-[color:var(--input-bg)] border border-[color:var(--border)] text-[color:var(--text)] text-sm outline-none opacity-50 cursor-not-allowed" disabled></div>
                    <div><label class="text-[10px] font-black uppercase text-[color:var(--text2)] ml-1 tracking-wider">Program Studi / Fakultas</label><input type="text" id="p-prodi" value="${u.prodi||''}" class="w-full mt-1 p-3 rounded-2xl bg-[color:var(--input-bg)] border border-[color:var(--border)] text-[color:var(--text)] text-sm outline-none focus:border-[#2563eb]" placeholder="Contoh: Manajemen Bisnis"></div>
                    <button onclick="saveProfileData()" id="btn-save-p" class="w-full py-4 mt-2 bg-[#2563eb] text-white font-black text-xs rounded-2xl shadow-lg shadow-blue-500/20 active:scale-95 transition-all"><i data-lucide="save" class="w-4 h-4 inline mr-1 mb-0.5"></i> SIMPAN PERUBAHAN</button>
                </div>
            </div>`;
    };

    let cropper = null;
    window.handleProfilePhoto = function(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                showGlobalModal(`<div class="glass p-5 rounded-3xl w-full max-w-sm mx-auto shadow-2xl border border-[color:var(--border)]"><h3 class="font-bold mb-4 flex items-center gap-2 text-[#2563eb]"><i data-lucide="crop" class="w-5 h-5"></i> Pangkas Foto Profil</h3><div class="aspect-square bg-black rounded-2xl overflow-hidden mb-4 border border-[color:var(--border)]"><img src="${e.target.result}" id="crop-target"></div><div class="flex gap-2"><button onclick="closeGlobalModal()" class="flex-1 py-3 rounded-xl bg-[color:var(--surface)] text-[color:var(--text)] text-xs font-bold border border-[color:var(--border)] hover:bg-[color:var(--card)]">Batal</button><button onclick="uploadNewPhoto()" id="btn-crop-go" class="flex-1 py-3 bg-[#2563eb] text-white text-xs font-bold rounded-xl shadow-lg shadow-blue-500/20">Simpan Foto</button></div></div>`);
                setTimeout(() => { cropper = new Cropper(document.getElementById('crop-target'), { aspectRatio: 1, viewMode: 1, guides: false, ready(){ document.querySelector('.cropper-view-box').style.borderRadius='50%'; } }); }, 100);
            };
            reader.readAsDataURL(input.files[0]);
        }
    };

    window.uploadNewPhoto = async function() {
        const btn = document.getElementById('btn-crop-go'); btn.disabled = true; btn.innerHTML = '<i data-lucide="loader" class="w-4 h-4 animate-spin inline mr-1"></i> Mengunggah...'; lucide.createIcons();
        cropper.getCroppedCanvas({ width: 400, height: 400 }).toBlob(async (blob) => {
            try {
                const file = new File([blob], "profil.jpg", { type: 'image/jpeg' });
                const url = await fetchCloudinaryUpload(file, false); // Pastikan parameter isAudio = false
                await db.collection('users').doc(STATE.currentUser.uid).update({ photoURL: url });
                if(auth.currentUser) await auth.currentUser.updateProfile({ photoURL: url });
                STATE.currentUser.photoURL = url;
                showToast("Foto profil diperbarui! 🎉", "success"); closeGlobalModal(); renderFull();
            } catch(e) { showToast("Gagal upload", "error"); btn.disabled = false; btn.innerText = 'Coba Lagi'; }
        }, 'image/jpeg');
    };

    window.saveProfileData = async function() {
        const btn = document.getElementById('btn-save-p'); btn.disabled = true; btn.innerHTML = '<i data-lucide="loader" class="w-4 h-4 animate-spin inline mr-1"></i> MENYIMPAN...'; lucide.createIcons();
        const d = { displayName: document.getElementById('p-name').value, prodi: document.getElementById('p-prodi').value };
        try { await db.collection('users').doc(STATE.currentUser.uid).update(d); if(auth.currentUser) await auth.currentUser.updateProfile({displayName: d.displayName}); STATE.currentUser = {...STATE.currentUser, ...d}; showToast("Profil disimpan!", "success"); renderFull(); } catch(e){ showToast("Gagal menyimpan", "error"); btn.disabled = false; btn.innerHTML = 'SIMPAN PERUBAHAN'; }
    };

    // ==========================================
    // 7. CHAT KELAS & VOICE & EMOJI (FULL FEATURES)
    // ==========================================
    window.openCourse = function(id) { STATE.currentCourse = COURSES.find(c => c.id === id); STATE.screen = 'course'; renderFull(); };
    window.renderCourse = function(el) {
        el.innerHTML = `<div class="h-full flex flex-col overflow-hidden bg-[color:var(--bg)] relative"><header class="glass flex items-center justify-between px-4 py-3 shrink-0 rounded-b-2xl z-30 border-b border-[color:var(--border)] shadow-sm rounded-t-none"><div class="flex items-center gap-3"><button onclick="STATE.screen='dashboard'; renderFull()" class="p-2 -ml-2 rounded-full hover:bg-[color:var(--card)] transition-colors"><i data-lucide="arrow-left" class="w-5 h-5 text-[color:var(--text)]"></i></button><h2 class="font-bold text-sm text-[color:var(--text)] truncate max-w-[150px]">${STATE.currentCourse.icon} ${STATE.currentCourse.name}</h2></div><div class="flex items-center gap-1"><button onclick="openAskAIModal()" class="p-2 rounded-xl bg-purple-500/10 text-purple-400 border border-purple-500/20 active:scale-90 transition-all"><i data-lucide="bot" class="w-4 h-4"></i></button><button onclick="if(typeof handleExportNotes === 'function') handleExportNotes();" class="p-2 rounded-xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 active:scale-90 transition-all"><i data-lucide="download" class="w-4 h-4"></i></button></div></header><div id="pinned-container" class="hidden shrink-0 z-20 transition-all"></div><div id="chat-messages-container" class="flex-1 overflow-y-auto px-3 py-4 z-10 scroll-smooth relative"></div><div id="chat-input-container" class="glass p-2 shrink-0 z-30 border-t border-[color:var(--border)] flex gap-1 items-end pb-4 pt-2 rounded-b-none relative bg-[color:var(--surface)]"><button id="btn-clip" onclick="openAttachmentMenu()" class="p-2 sm:p-3 rounded-full text-[color:var(--text2)] hover:text-[color:var(--accent)] shrink-0 active:scale-90 transition-all"><i data-lucide="paperclip" class="w-5 h-5 transform -rotate-45"></i></button><button onclick="toggleStickerPanel()" class="p-2 sm:p-3 rounded-full text-[color:var(--text2)] hover:text-amber-500 shrink-0 active:scale-90 transition-all"><i data-lucide="smile" class="w-6 h-6"></i></button><div id="recording-ui" class="hidden flex-1 flex items-center gap-2 p-1 bg-[color:var(--input-bg)] rounded-full border border-red-500/30"><button onclick="cancelRecording()" class="p-2 rounded-full text-[color:var(--text2)] hover:text-red-400"><i data-lucide="trash-2" class="w-5 h-5"></i></button><div class="flex-1 flex items-center justify-center gap-2"><div class="w-2.5 h-2.5 rounded-full bg-red-500 pulse"></div><span id="rec-time" class="text-sm font-mono font-bold text-[color:var(--text)]">0:00</span></div><button onclick="stopRecording()" class="p-2 rounded-full bg-[#2563eb] text-white shadow-lg"><i data-lucide="send" class="w-4 h-4 ml-0.5"></i></button></div><textarea id="chat-input" class="flex-1 bg-[color:var(--input-bg)] text-[color:var(--text)] text-[15px] rounded-2xl px-4 py-3 max-h-28 outline-none resize-none border border-[color:var(--border)] focus:border-[color:var(--accent)] transition-colors" placeholder="Ketik pesan..." oninput="handleInput(this)" onkeydown="if(event.key==='Enter' && !event.shiftKey) { event.preventDefault(); sendTextMessage(); }"></textarea><button id="btn-send" onclick="sendTextMessage()" class="hidden p-3 rounded-full bg-[#2563eb] text-white shrink-0 active:scale-90 transition-transform shadow-lg mb-0.5"><i data-lucide="send" class="w-5 h-5 ml-0.5"></i></button><button id="btn-mic" onclick="startRecording()" class="p-3 rounded-full bg-[color:var(--card)] border border-[color:var(--border)] text-[color:var(--text)] shrink-0 active:scale-90 transition-transform mb-0.5"><i data-lucide="mic" class="w-5 h-5"></i></button></div></div>`;
        renderPinnedOnly(); renderMessagesOnly();
    };

    window.getFileIconUI = function(filename) {
        if(!filename) return { icon: 'file', color: 'text-white', bg: 'bg-white/20' }; const ext = filename.split('.').pop().toLowerCase();
        if(['pdf'].includes(ext)) return { icon: 'file-text', color: 'text-red-500', bg: 'bg-red-500/20' }; if(['doc','docx'].includes(ext)) return { icon: 'file-text', color: 'text-blue-500', bg: 'bg-blue-500/20' }; if(['xls','xlsx'].includes(ext)) return { icon: 'table', color: 'text-emerald-500', bg: 'bg-emerald-500/20' }; if(['ppt','pptx'].includes(ext)) return { icon: 'presentation', color: 'text-orange-500', bg: 'bg-orange-500/20' }; if(['zip','rar'].includes(ext)) return { icon: 'archive', color: 'text-yellow-500', bg: 'bg-yellow-500/20' }; return { icon: 'file', color: 'text-indigo-500', bg: 'bg-indigo-500/20' };
    };

    window.renderMessagesOnly = function() {
        const container = document.getElementById('chat-messages-container'); if (!container || STATE.screen !== 'course') return;
        const msgs = STATE.chats[STATE.currentCourse?.id] || []; const visible = msgs.filter(m => !(m.deletedFor || []).includes(STATE.currentUser?.uid));
        if(visible.length === 0) { container.innerHTML = `<div class="flex-1 flex flex-col items-center justify-center text-[color:var(--text2)] h-full pt-20"><i data-lucide="messages-square" class="w-12 h-12 mb-3 text-[#2563eb] opacity-50"></i><p class="text-sm font-bold tracking-wide">Mulai obrolan kelas ini</p></div>`; lucide.createIcons(); return; }
        const unreadMsgs = visible.filter(m => m.userId !== STATE.currentUser?.uid && !(m.readBy || []).includes(STATE.currentUser?.uid));
        if (unreadMsgs.length > 0) { const batch = db.batch(); unreadMsgs.forEach(m => { const msgRef = db.collection('courses').doc(STATE.currentCourse.id).collection('chats').doc(m.id); batch.update(msgRef, { readBy: firebase.firestore.FieldValue.arrayUnion(STATE.currentUser.uid) }); }); batch.commit().catch(e => console.error(e)); }
        let html = ''; let lastDateStr = '';
        visible.forEach(m => {
            const dateStr = formatChatDateBadge(m.timestamp);
            if (dateStr !== lastDateStr) { html += `<div class="flex justify-center my-5 z-10 sticky top-2"><div class="px-3 py-1.5 rounded-full bg-[color:var(--surface)] border border-[color:var(--border)] text-[color:var(--text2)] text-[9px] font-bold uppercase tracking-wider backdrop-blur-md">${dateStr}</div></div>`; lastDateStr = dateStr; }
            const mine = m.userId === STATE.currentUser?.uid;
            if(m.type === 'system') { html += `<div class="flex justify-center my-3"><div class="px-4 py-2.5 bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-[11px] rounded-xl font-medium text-center max-w-[85%] break-words">${m.text.replace(/\n/g, '<br>')}</div></div>`; return; }
            let content = ''; let bubbleClass = '';
            if (m.sticker) { content = `<img src="${m.sticker}" onclick="openStickerOptions('${m.sticker}')" class="w-32 h-32 object-contain cursor-pointer hover:scale-105 transition-transform -mb-4">`; bubbleClass = 'bg-transparent shadow-none border-none text-[color:var(--text)]'; }
            else if (m.type === 'image') { content = `<div class="mt-1"><img src="${m.text}" class="rounded-xl w-full max-w-[240px] max-h-64 object-cover cursor-pointer border border-[color:var(--border)] hover:scale-[1.02]" onclick="window.open('${m.text}', '_blank')"></div>`; bubbleClass = mine ? 'bg-gradient-to-br from-blue-600 to-[#2563eb] text-white bubble-right border border-blue-500/50' : 'bg-[color:var(--bubble-theirs)] text-[color:var(--text)] bubble-left border border-[color:var(--border)]'; }
            else if (m.type === 'file') { const ui = window.getFileIconUI(m.fileName); content = `<div class="mt-1.5 mb-1 w-[220px] sm:w-[250px]"><a href="${m.text}" target="_blank" class="flex items-center gap-3 p-3 ${mine ? 'bg-black/20 hover:bg-black/30' : 'bg-[color:var(--surface)] hover:bg-[color:var(--card)]'} rounded-xl transition-all border border-[color:var(--border)] group"><div class="p-2.5 rounded-lg ${mine ? 'bg-white/20' : ui.bg} shrink-0"><i data-lucide="${ui.icon}" class="w-6 h-6 ${mine ? 'text-white' : ui.color}"></i></div><div class="flex-1 min-w-0"><p class="text-[13px] truncate font-bold mb-0.5" style="${mine ? 'color:white' : 'color:var(--text)'}">${m.fileName}</p><p class="text-[9px] uppercase tracking-wider opacity-80" style="${mine ? 'color:white' : 'color:var(--text2)'}">${m.fileSize}</p></div><div class="w-8 h-8 rounded-full ${mine ? 'bg-white/10 text-white' : 'bg-[color:var(--card)] text-[color:var(--text2)]'} flex items-center justify-center shrink-0"><i data-lucide="download" class="w-4 h-4"></i></div></a></div>`; bubbleClass = mine ? 'bg-gradient-to-br from-blue-600 to-[#2563eb] text-white bubble-right border border-blue-500/50' : 'bg-[color:var(--bubble-theirs)] text-[color:var(--text)] bubble-left border border-[color:var(--border)]'; }
            else if (m.type === 'voice') { content = `<div class="voice-note-player ${mine ? 'bg-black/20' : 'bg-[color:var(--surface)]'} p-2 rounded-full mt-1 border border-[color:var(--border)]"><audio id="audio-${m.id}" src="${m.text}" preload="metadata"></audio><button onclick="playVoice('${m.id}')" class="w-9 h-9 rounded-full ${mine ? 'bg-white text-[#2563eb]' : 'bg-[color:var(--accent)] text-white'} flex items-center justify-center shrink-0"><i data-lucide="play" id="play-${m.id}" class="w-4 h-4 vn-play ml-0.5"></i><i data-lucide="pause" id="pause-${m.id}" class="w-4 h-4 vn-pause hidden"></i></button><div class="voice-note-progress ml-1 mr-2"><div id="fill-${m.id}" class="voice-note-progress-fill ${mine ? 'bg-white' : 'bg-[color:var(--accent)]'}"></div></div><span id="time-${m.id}" class="text-[10px] font-mono font-bold mr-3" style="${mine ? 'color:white' : 'color:var(--text2)'}">0:00</span></div>`; bubbleClass = mine ? 'bg-gradient-to-br from-blue-600 to-[#2563eb] text-white bubble-right border border-blue-500/50' : 'bg-[color:var(--bubble-theirs)] text-[color:var(--text)] bubble-left border border-[color:var(--border)]'; }
            else { content = m.text.replace(/\n/g, '<br>'); bubbleClass = mine ? 'bg-gradient-to-br from-blue-600 to-[#2563eb] text-white bubble-right border border-blue-500/50' : 'bg-[color:var(--bubble-theirs)] text-[color:var(--text)] bubble-left border border-[color:var(--border)]'; }
            let checkIcon = mine ? ((m.readBy && m.readBy.some(uid => uid !== STATE.currentUser.uid)) ? `<i data-lucide="check-check" class="w-[15px] h-[15px] text-sky-300 ml-0.5 mt-0.5"></i>` : `<i data-lucide="check" class="w-[14px] h-[14px] text-white/60 ml-0.5 mt-0.5"></i>`) : '';
            html += `<div class="flex ${mine ? 'justify-end' : 'justify-start'} mb-3.5 w-full animate-fade"><div class="relative ${bubbleClass} px-3.5 pt-2.5 pb-6 max-w-[85%] min-w-[110px] shadow-md select-none" onmousedown="startHold(this, '${m.id}')" onmouseup="cancelHold(this)" onmouseleave="cancelHold(this)" ontouchstart="startHold(this, '${m.id}')" ontouchend="cancelHold(this)" ontouchmove="cancelHold(this)">${!mine ? `<div class="text-[10.5px] font-bold text-emerald-500 mb-1.5 truncate"><i data-lucide="user" class="w-3 h-3 inline opacity-70"></i> ${m.userName}</div>` : ''}<div class="text-[13.5px] break-words">${content}</div><div class="absolute bottom-1.5 right-2.5 flex items-center gap-0.5">${m.isEdited ? `<i data-lucide="pencil" class="w-2.5 h-2.5 opacity-60 mr-1"></i>` : ''}<span class="text-[9px] ${mine?'text-white/80':'text-[color:var(--text2)]'} font-bold tracking-wider pt-0.5">${formatTime(m.timestamp)}</span>${checkIcon}</div></div></div>`;
        });
        container.innerHTML = html; lucide.createIcons();
        if(container.scrollHeight - container.scrollTop <= container.clientHeight + 150) container.scrollTop = container.scrollHeight;
    };

    window.renderPinnedOnly = function() { const container = document.getElementById('pinned-container'); if (!container || STATE.screen !== 'course') return; const pin = STATE.pinnedMessage; if (pin) { container.innerHTML = `<div class="px-3 py-2 border-b border-[color:var(--border)] bg-[color:var(--surface)] flex gap-3 items-center mx-3 mt-2 rounded-lg shrink-0 z-20 shadow-sm"><i data-lucide="pin" class="w-4 h-4 text-[color:var(--accent)] shrink-0"></i><div class="flex-1 min-w-0"><span class="text-[10px] font-medium text-[color:var(--accent)] truncate block">Sematkan oleh: ${pin.userName || 'Sistem'}</span><p class="text-xs text-[color:var(--text)] truncate">${pin.text}</p></div><button onclick="unpinMessage()" class="p-1 hover:text-red-400 shrink-0 text-[color:var(--text2)]"><i data-lucide="x" class="w-4 h-4"></i></button></div>`; lucide.createIcons(); container.classList.remove('hidden'); } else { container.innerHTML = ''; container.classList.add('hidden'); } };
    window.handleInput = function(el) { el.style.height = 'auto'; el.style.height = Math.min(el.scrollHeight, 100) + 'px'; const hasText = el.value.trim().length > 0; document.getElementById('btn-send').style.display = hasText ? 'block' : 'none'; document.getElementById('btn-mic').style.display = hasText ? 'none' : 'block'; };
    window.sendTextMessage = async function() { const input = document.getElementById('chat-input'); const text = input.value.trim(); if(!text) return; input.value = ''; handleInput(input); try { await db.collection('courses').doc(STATE.currentCourse.id).collection('chats').add({ userId: STATE.currentUser.uid, userName: STATE.currentUser.displayName, text: text, type: 'text', timestamp: firebase.firestore.FieldValue.serverTimestamp(), readBy: [STATE.currentUser.uid] }); } catch(e) { showToast('Gagal kirim', 'error'); } };
    window.startRecording = async function() { if(!navigator.mediaDevices) return showToast('Browser tidak mendukung mic', 'error'); try { const stream = await navigator.mediaDevices.getUserMedia({ audio: true }); STATE.audioChunks = []; STATE.mediaRecorder = new MediaRecorder(stream); STATE.mediaRecorder.ondataavailable = e => STATE.audioChunks.push(e.data); STATE.mediaRecorder.onstop = uploadVoiceMessage; STATE.mediaRecorder.start(); STATE.isRecording = true; STATE.recordingSeconds = 0; document.getElementById('chat-input').style.display = 'none'; document.getElementById('btn-mic').style.display = 'none'; document.getElementById('btn-clip').style.display = 'none'; document.getElementById('recording-ui').classList.remove('hidden'); document.getElementById('recording-ui').classList.add('flex'); STATE.recordingTimer = setInterval(() => { STATE.recordingSeconds++; document.getElementById('rec-time').innerText = formatRecTime(STATE.recordingSeconds); }, 1000); } catch(e) { showToast('Izinkan akses mic', 'error'); } };
    window.stopRecording = function() { if(STATE.mediaRecorder) STATE.mediaRecorder.stop(); resetRecUI(); };
    window.cancelRecording = function() { if(STATE.mediaRecorder) { STATE.mediaRecorder.onstop = null; STATE.mediaRecorder.stop(); STATE.mediaRecorder.stream.getTracks().forEach(t=>t.stop()); } resetRecUI(); showToast('Batal merekam', 'warning'); };
    function resetRecUI() { STATE.isRecording = false; clearInterval(STATE.recordingTimer); document.getElementById('recording-ui').classList.add('hidden'); document.getElementById('recording-ui').classList.remove('flex'); document.getElementById('chat-input').style.display = 'block'; document.getElementById('btn-clip').style.display = 'block'; handleInput(document.getElementById('chat-input')); }
    async function uploadVoiceMessage() { resetRecUI(); showToast('Mengirim suara...', 'warning'); try { const file = new File(STATE.audioChunks, `vn_${Date.now()}.webm`, { type: 'audio/webm' }); const url = await fetchCloudinaryUpload(file, true); await db.collection('courses').doc(STATE.currentCourse.id).collection('chats').add({ userId: STATE.currentUser.uid, userName: STATE.currentUser.displayName, text: url, type: 'voice', timestamp: firebase.firestore.FieldValue.serverTimestamp(), readBy: [STATE.currentUser.uid] }); } catch(e) { showToast('Gagal kirim', 'error'); } }
    window.playVoice = function(id) { const audio = document.getElementById(`audio-${id}`), btnPlay = document.getElementById(`play-${id}`), btnPause = document.getElementById(`pause-${id}`), fill = document.getElementById(`fill-${id}`), time = document.getElementById(`time-${id}`); if(audio.paused) { document.querySelectorAll('audio').forEach(a => a.pause()); document.querySelectorAll('.vn-pause').forEach(i => i.classList.add('hidden')); document.querySelectorAll('.vn-play').forEach(i => i.classList.remove('hidden')); audio.play(); btnPlay.classList.add('hidden'); btnPause.classList.remove('hidden'); } else { audio.pause(); btnPause.classList.add('hidden'); btnPlay.classList.remove('hidden'); } audio.ontimeupdate = () => { fill.style.width = (audio.currentTime/audio.duration*100)+'%'; time.innerText = formatRecTime(Math.floor(audio.currentTime)); }; audio.onended = () => { btnPause.classList.add('hidden'); btnPlay.classList.remove('hidden'); fill.style.width='0%'; time.innerText='0:00'; } };

    window.openAttachmentMenu = () => showGlobalModal(`<div class="bg-[color:var(--surface)] backdrop-blur-2xl p-6 pb-8 rounded-t-3xl animate-slide-attachment w-full border-t border-[color:var(--border)] shadow-2xl relative"><div class="grid grid-cols-4 gap-y-6 gap-x-2 justify-items-center"><button onclick="openSpecificFileForm('.pdf,.doc,.docx,.txt,.xls,.xlsx')" class="flex flex-col items-center gap-2"><div class="w-14 h-14 rounded-[18px] bg-[#5c37eb] flex items-center justify-center shadow-lg"><i data-lucide="file-text" class="w-6 h-6 text-white"></i></div><span class="text-[11px] font-medium tracking-wide">Dokumen</span></button><button onclick="openSpecificFileForm('image/*', true)" class="flex flex-col items-center gap-2"><div class="w-14 h-14 rounded-[18px] bg-[#eb3765] flex items-center justify-center shadow-lg"><i data-lucide="camera" class="w-6 h-6 text-white"></i></div><span class="text-[11px] font-medium tracking-wide">Kamera</span></button><button onclick="openSpecificFileForm('image/*')" class="flex flex-col items-center gap-2"><div class="w-14 h-14 rounded-[18px] bg-[#0ea5e9] flex items-center justify-center shadow-lg"><i data-lucide="image" class="w-6 h-6 text-white"></i></div><span class="text-[11px] font-medium tracking-wide">Galeri</span></button><button onclick="openSpecificFileForm('audio/*')" class="flex flex-col items-center gap-2"><div class="w-14 h-14 rounded-[18px] bg-[#f97316] flex items-center justify-center shadow-lg"><i data-lucide="headphones" class="w-6 h-6 text-white"></i></div><span class="text-[11px] font-medium tracking-wide">Audio</span></button><button onclick="openAssignForm()" class="flex flex-col items-center gap-2"><div class="w-14 h-14 rounded-[18px] bg-[#10b981] flex items-center justify-center shadow-lg"><i data-lucide="clipboard-list" class="w-6 h-6 text-white"></i></div><span class="text-[11px] font-medium tracking-wide">Tugas</span></button></div><div class="w-12 h-1 bg-[color:var(--text2)] opacity-30 rounded-full mx-auto mt-6"></div></div>`, true);
    window.openSpecificFileForm = (acceptType, capture = false) => { closeGlobalModal(); const input = document.getElementById('global-file-input'); input.accept = acceptType; if (capture) input.setAttribute('capture', 'environment'); else input.removeAttribute('capture'); input.click(); };
    // =====================================================================
    // MESIN 1: KHUSUS KIRIM FILE KE GRUP CHAT (LANGSUNG UPLOAD)
    // =====================================================================
    window.handleGlobalFileUpload = async function(event) { 
        const file = event.target.files[0]; 
        if (!file) return; 
        
        if (file.size > 20 * 1024 * 1024) {
            showToast("Gagal: Ukuran file maksimal 20 MB!", "error");
            return;
        }
        
        event.target.value = ""; // Kosongkan input setelah milih
        showToast('Mengirim file ke chat...', 'warning'); 
        
        try { 
            const isAudio = file.type.startsWith('audio/'); 
            const isImage = file.type.startsWith('image/'); 
            const type = isImage ? 'image' : (isAudio ? 'voice' : 'file'); 
            
            // Langsung upload ke server
            const url = await fetchCloudinaryUpload(file, isAudio); 
            
            // Langsung tembak ke database Chat
            await db.collection('courses').doc(STATE.currentCourse.id).collection('chats').add({ 
                userId: STATE.currentUser.uid, 
                userName: STATE.currentUser.displayName, 
                text: url, 
                fileName: file.name, 
                fileSize: (file.size/1024).toFixed(1)+' KB', 
                type: type, 
                timestamp: firebase.firestore.FieldValue.serverTimestamp(), 
                readBy: [STATE.currentUser.uid] 
            }); 
        } catch(e) { 
            showToast('Gagal kirim file ke chat', 'error'); 
        } 
    };

    // =====================================================================
    // MESIN 2: KHUSUS PENANGKAP FILE DI FORM TUGAS (TUNGGU TOMBOL KIRIM)
    // =====================================================================
    window.handleAsgFileUpload = function(event) {
        const file = event.target.files[0];
        if (!file) return; 
        
        if (file.size > 5 * 1024 * 1024) { 
            alert("Gagal: Ukuran file maksimal 5 MB!");
            event.target.value = ''; 
            return;
        }
        
        // Simpan file ke wadah TUGAS (bukan chat)
        STATE.asgPendingFile = file; 
        
        // Ubah warna kotak form jadi hijau
        const uploadBox = document.getElementById('asg-upload-box');
        const uploadText = document.getElementById('asg-upload-text');
        const uploadIcon = document.getElementById('asg-upload-icon');
        
        if (uploadBox && uploadText && uploadIcon) {
            uploadBox.classList.replace('border-slate-300', 'border-emerald-500');
            uploadBox.classList.add('bg-emerald-50');
            uploadText.innerText = "FILE SIAP: " + file.name;
            uploadText.classList.add('text-emerald-700');
            uploadIcon.classList.replace('text-[#0B1D3A]', 'text-emerald-500');
        }
    };

    window.toggleStickerPanel = function() { let panel = document.getElementById('sticker-panel'); if (!panel) { const chatContainer = document.getElementById('chat-input-container'); if(!chatContainer) return showToast('Buka chat kelas dulu!', 'warning'); panel = document.createElement('div'); panel.id = 'sticker-panel'; panel.className = 'w-full h-64 bg-[color:var(--surface)] border-t border-[color:var(--border)] flex flex-col hidden absolute bottom-full left-0 z-40 shadow-[0_-10px_20px_rgba(0,0,0,0.3)] backdrop-blur-2xl transition-all duration-300'; panel.innerHTML = `<div class="flex items-center gap-2 px-3 py-2 border-b border-[color:var(--border)] bg-[color:var(--input-bg)]"><button onclick="loadStickers('emoji')" class="p-2 rounded-xl text-[color:var(--text2)] hover:text-yellow-500 hover:bg-[color:var(--card)]"><i data-lucide="smile" class="w-5 h-5"></i></button><button onclick="loadStickers('default')" class="p-2 rounded-xl text-[color:var(--text2)] hover:text-[#2563eb] hover:bg-[color:var(--card)]"><i data-lucide="sticker" class="w-5 h-5"></i></button><button onclick="loadStickers('favorites')" class="p-2 rounded-xl text-[color:var(--text2)] hover:text-amber-500 hover:bg-[color:var(--card)]"><i data-lucide="star" class="w-5 h-5"></i></button><button onclick="toggleStickerPanel()" class="ml-auto p-2 text-[color:var(--text2)] hover:text-red-500 hover:bg-red-500/10 rounded-xl"><i data-lucide="chevron-down" class="w-5 h-5"></i></button></div><div id="sticker-grid" class="flex-1 overflow-y-auto p-4 hide-scrollbar bg-[color:var(--bg)]"></div>`; chatContainer.appendChild(panel); lucide.createIcons(); } panel.classList.toggle('hidden'); if (!panel.classList.contains('hidden')) loadStickers('emoji'); };
    window.insertEmoji = function(emoji) { const input = document.getElementById('chat-input'); if(input) { input.value += emoji; handleInput(input); input.focus(); } };
    window.loadStickers = async function(type) { const grid = document.getElementById('sticker-grid'); grid.innerHTML = '<div class="col-span-full text-center text-xs mt-5 animate-pulse">Memuat...</div>'; if (type === 'emoji') { grid.className = 'flex-1 overflow-y-auto p-3 grid grid-cols-7 sm:grid-cols-10 gap-2 hide-scrollbar bg-[color:var(--bg)]'; grid.innerHTML = STATE.defaultEmojis.map(emoji => `<button onclick="insertEmoji('${emoji}')" class="text-2xl hover:bg-[color:var(--card)] rounded-lg p-1 transition-colors active:scale-90">${emoji}</button>`).join(''); return; } grid.className = 'flex-1 overflow-y-auto p-4 grid grid-cols-4 sm:grid-cols-5 gap-4 hide-scrollbar bg-[color:var(--bg)]'; let stickersToLoad = []; if (type === 'default') stickersToLoad = STATE.defaultStickers; else if (type === 'favorites') { try { const doc = await db.collection('users').doc(auth.currentUser.uid).get(); stickersToLoad = doc.data().favoriteStickers || []; } catch(e){} } if (stickersToLoad.length === 0) { grid.innerHTML = `<div class="col-span-full text-center text-xs mt-5 text-[color:var(--text2)]">Belum ada stiker.</div>`; return; } grid.innerHTML = stickersToLoad.map(url => `<img src="${url}" onclick="sendSticker('${url}')" class="w-16 h-16 object-contain cursor-pointer hover:scale-110 active:scale-95 transition-transform drop-shadow-md">`).join(''); };
    window.sendSticker = async function(url) { if (!STATE.currentCourse) return; toggleStickerPanel(); try { await db.collection('courses').doc(STATE.currentCourse.id).collection('chats').add({ text: '', sticker: url, userId: auth.currentUser.uid, userName: STATE.currentUser.displayName, timestamp: firebase.firestore.FieldValue.serverTimestamp(), readBy: [auth.currentUser.uid] }); } catch(e){} };
    window.openStickerOptions = function(url) { showGlobalModal(`<div class="glass p-6 rounded-3xl animate-slide w-full max-w-xs text-center border border-white/10 shadow-2xl"><img src="${url}" class="w-32 h-32 object-contain mx-auto mb-6 drop-shadow-xl animate-bounce"><button onclick="addToFavorites('${url}')" class="w-full py-3 bg-[color:var(--card)] hover:bg-[color:var(--input-bg)] border border-[color:var(--border)] rounded-xl font-bold flex items-center justify-center gap-2 mb-2"><i data-lucide="star" class="w-5 h-5 text-amber-500"></i> Tambah ke Favorit</button><button onclick="closeGlobalModal()" class="w-full py-3 font-bold rounded-xl text-sm text-[color:var(--text2)]">Tutup</button></div>`); };
    window.addToFavorites = async function(url) { try { await db.collection('users').doc(auth.currentUser.uid).update({ favoriteStickers: firebase.firestore.FieldValue.arrayUnion(url) }); closeGlobalModal(); showToast('Masuk Favorit!', 'success'); } catch(e){} };

    let pressTimer = null;
    window.startHold = function(el, msgId) { el.classList.add('msg-active'); pressTimer = setTimeout(() => { el.classList.remove('msg-active'); openMessageMenu(msgId); }, 500); };
    window.cancelHold = function(el) { clearTimeout(pressTimer); if(el) el.classList.remove('msg-active'); };
    window.openMessageMenu = function(msgId) { if ("vibrate" in navigator) navigator.vibrate(50); const msg = STATE.chats[STATE.currentCourse.id].find(m => m.id === msgId); if(!msg) return; const isMine = msg.userId === STATE.currentUser.uid; const isAdmin = STATE.currentUser?.role === 'admin'; let html = `<div class="glass p-5 rounded-3xl w-full max-w-xs animate-slide-up mx-auto absolute bottom-4 left-0 right-0 border border-[color:var(--border)] shadow-2xl"><h3 class="text-center font-bold text-[color:var(--text2)] mb-4 text-sm">Opsi Pesan</h3><div class="space-y-2">`; if(isMine && msg.type === 'text') html += `<button onclick="openEditForm('${msg.id}', '${msg.text.replace(/'/g, "\\'")}')" class="w-full py-3 px-4 rounded-xl bg-[color:var(--card)] font-medium flex items-center gap-3 border border-[color:var(--border)]"><i data-lucide="pencil" class="w-4 h-4 text-[color:var(--accent)]"></i> Edit Pesan</button>`; html += `<button onclick="pinMessage('${msg.id}')" class="w-full py-3 px-4 rounded-xl bg-[color:var(--card)] font-medium flex items-center gap-3 border border-[color:var(--border)]"><i data-lucide="pin" class="w-4 h-4 text-[color:var(--accent2)]"></i> Sematkan</button>`; if(isMine || isAdmin) html += `<button onclick="deleteForEveryone('${msg.id}')" class="w-full py-3 px-4 rounded-xl bg-[color:var(--card)] text-red-400 font-medium flex items-center gap-3 border border-[color:var(--border)]"><i data-lucide="trash" class="w-4 h-4 text-red-400"></i> Hapus Semua</button>`; html += `<button onclick="deleteForMe('${msg.id}')" class="w-full py-3 px-4 rounded-xl bg-[color:var(--card)] text-orange-400 font-medium flex items-center gap-3 border border-[color:var(--border)]"><i data-lucide="user-minus" class="w-4 h-4 text-orange-400"></i> Hapus Untukku</button>`; html += `<button onclick="closeGlobalModal()" class="w-full py-3 px-4 rounded-xl bg-[color:var(--bg)] font-bold mt-4 text-center justify-center border border-[color:var(--border)]">Batal</button></div></div>`; showGlobalModal(html, true); };
    window.openEditForm = function(id, text) { showGlobalModal(`<div class="glass p-5 rounded-2xl w-full animate-fade"><h3 class="font-bold mb-3">Edit Pesan</h3><textarea id="edit-txt" class="w-full bg-[color:var(--input-bg)] p-3 rounded-xl text-sm mb-4 h-24 border border-[color:var(--border)] outline-none">${text}</textarea><div class="flex gap-2 justify-end"><button onclick="closeGlobalModal()" class="px-4 py-2 font-bold text-[color:var(--text2)]">Batal</button><button onclick="saveEdit('${id}')" class="px-4 py-2 font-bold bg-[#2563eb] text-white rounded-xl">Simpan</button></div></div>`); };
    window.saveEdit = async function(id) { const text = document.getElementById('edit-txt').value.trim(); if(!text) return; closeGlobalModal(); try { await db.collection('courses').doc(STATE.currentCourse.id).collection('chats').doc(id).update({ text, isEdited: true }); showToast('Diubah'); } catch(e){} };
    window.deleteForEveryone = async function(id) { closeGlobalModal(); try { await db.collection('courses').doc(STATE.currentCourse.id).collection('chats').doc(id).delete(); showToast('Dihapus'); } catch(e){} };
    window.deleteForMe = async function(id) { closeGlobalModal(); try { await db.collection('courses').doc(STATE.currentCourse.id).collection('chats').doc(id).update({ deletedFor: firebase.firestore.FieldValue.arrayUnion(STATE.currentUser.uid) }); showToast('Dihapus'); } catch(e){} };
    window.pinMessage = async function(id) { closeGlobalModal(); const msg = STATE.chats[STATE.currentCourse.id].find(m=>m.id===id); const txt = msg.type==='text' ? msg.text : `[${msg.type.toUpperCase()}]`; try { await db.collection('courses').doc(STATE.currentCourse.id).update({ pinnedMessage: { id, text: txt, userName: msg.userName } }); showToast('Disematkan'); } catch(e){} };
    window.unpinMessage = async function() { try { await db.collection('courses').doc(STATE.currentCourse.id).update({ pinnedMessage: null }); showToast('Sematan dilepas'); } catch(e){} };

    // ==========================================
    // 8. AI CHAT & EXPORT
    // ==========================================
    window.openAskAIModal = function() {
        showGlobalModal(`
            <div class="fixed inset-0 z-[2000] flex flex-col animate-slide-up overflow-hidden bg-[color:var(--bg)]">
                <div class="relative z-20 px-4 py-3 flex items-center justify-between border-b border-[color:var(--border)] bg-[color:var(--surface)]">
                    <div class="flex items-center gap-2.5"><div class="w-8 h-8 rounded-full bg-gradient-to-tr from-blue-500 to-purple-600 flex items-center justify-center text-white"><i data-lucide="sparkles" class="w-4 h-4"></i></div><h2 class="text-sm font-bold text-[color:var(--text)]">FunGrow AI</h2></div>
                    <button onclick="closeGlobalModal()" class="p-2 rounded-full text-[color:var(--text2)]"><i data-lucide="x" class="w-5 h-5"></i></button>
                </div>
                <div id="ai-chat-body" class="flex-1 overflow-y-auto px-4 py-6 space-y-6 relative z-10">
                    ${STATE.aiChatHistory.length === 0 ? `<div class="h-full flex flex-col items-center justify-center text-center animate-fade"><div class="w-16 h-16 rounded-3xl bg-blue-500/10 flex items-center justify-center mb-5"><i data-lucide="bot" class="w-8 h-8 text-[#2563eb]"></i></div><h3 class="text-xl font-bold mb-2">Halo, ${STATE.currentUser?.displayName?.split(' ')[0] || 'User'}</h3><p class="text-xs text-[color:var(--text2)] max-w-[280px]">Saya asisten AI di kelas <b>${STATE.currentCourse.name}</b>. Ketik pertanyaan atau upload file.</p></div>` : ''}
                </div>
                <div class="p-4 bg-[color:var(--bg)] border-t border-[color:var(--border)] pb-6 relative z-30">
                    <div id="ai-img-preview-container" class="max-w-2xl mx-auto hidden mb-2 px-2"></div>
                    <div class="flex items-end gap-2 bg-[color:var(--input-bg)] border border-[color:var(--border)] rounded-[24px] p-1.5 pr-2">
                        <button onclick="triggerAIFile('file')" class="w-10 h-10 shrink-0 rounded-full flex items-center justify-center text-[color:var(--text2)]"><i data-lucide="paperclip" class="w-5 h-5 transform -rotate-45"></i></button>
                        <input type="file" id="ai-file-upload" class="hidden" onchange="handleAIFileUpload(event)">
                        <textarea id="ai-input-field" class="flex-1 bg-transparent text-[color:var(--text)] text-sm p-2.5 max-h-32 outline-none resize-none hide-scrollbar placeholder-[color:var(--text2)]" placeholder="Tanya AI..." oninput="handleAIInput(this)" onkeydown="if(event.key==='Enter' && !event.shiftKey) { event.preventDefault(); submitAskAI(); }"></textarea>
                        <button id="ai-btn-mic" onclick="startAIVoice()" class="w-10 h-10 rounded-full flex items-center justify-center text-[color:var(--text2)]"><i data-lucide="mic" class="w-5 h-5"></i></button>
                        <button id="ai-btn-send" onclick="submitAskAI()" class="hidden w-10 h-10 rounded-full bg-[#2563eb] text-white flex items-center justify-center shadow-lg"><i data-lucide="send" class="w-4 h-4 ml-0.5 mt-0.5"></i></button>
                    </div>
                </div>
            </div>`, true);
        if(STATE.aiChatHistory.length > 0) renderAIChatHistory(); lucide.createIcons();
    };
    
    window.checkNotifications = function() {
        let urgent = STATE.assignments ? Object.values(STATE.assignments).flat().filter(a => {
            const diff = (a.deadline?.seconds * 1000) - new Date().getTime();
            return diff > 0 && diff <= 172800000; // 48 Jam
        }) : [];
        const badge = document.getElementById('notif-badge');
        if(badge) urgent.length > 0 ? badge.classList.remove('hidden') : badge.classList.add('hidden');
    };

    window.openNotifications = function() {
        let urgent = STATE.assignments ? Object.values(STATE.assignments).flat().filter(a => {
            const diff = (a.deadline?.seconds * 1000) - new Date().getTime();
            return diff > 0 && diff <= 172800000;
        }) : [];
        let html = urgent.length === 0 ? '<div class="p-8 text-center opacity-50 text-sm"><i data-lucide="bell-off" class="w-10 h-10 mx-auto mb-2"></i>Tidak ada tugas mendesak.</div>' : urgent.map(a => `<div class="p-3 mb-2 bg-red-500/10 border border-red-500/20 rounded-xl cursor-pointer hover:bg-red-500/20 transition-all flex items-start gap-3" onclick="closeGlobalModal(); viewAssignmentDetail('${a.courseId}', '${a.id}')"><div class="w-8 h-8 rounded-full bg-red-500/20 text-red-500 flex items-center justify-center shrink-0 mt-0.5"><i data-lucide="alert-triangle" class="w-4 h-4"></i></div><div><h4 class="text-xs font-bold uppercase">${a.title}</h4><p class="text-[10px] text-[color:var(--text2)]">${COURSES.find(c=>c.id===a.courseId)?.name}</p><p class="text-[9px] text-red-500 font-black mt-1">Sisa Waktu: ${formatDate(a.deadline)}</p></div></div>`).join('');
        showGlobalModal(`<div class="glass p-5 rounded-3xl w-full max-w-sm mx-auto animate-slide shadow-2xl border border-[color:var(--border)]"><h3 class="font-bold mb-4 flex items-center gap-2 text-orange-500 border-b border-[color:var(--border)] pb-3"><i data-lucide="bell-ring" class="w-5 h-5"></i> Notifikasi Mendesak</h3><div class="max-h-60 overflow-y-auto hide-scrollbar">${html}</div><button onclick="closeGlobalModal()" class="w-full mt-4 py-3 bg-[color:var(--surface)] border border-[color:var(--border)] text-xs font-bold rounded-xl">Tutup</button></div>`);
    };
    
    window.triggerAIFile = function(type) { const input = document.getElementById('ai-file-upload'); input.accept = type==='file'?'.pdf,.doc,.docx,.txt':'*/*'; input.click(); };
    window.handleAIInput = function(el) { el.style.height = 'auto'; el.style.height = el.scrollHeight + 'px'; const hasCont = el.value.trim().length > 0 || STATE.aiPendingFile; document.getElementById('ai-btn-send').classList.toggle('hidden', !hasCont); document.getElementById('ai-btn-mic').classList.toggle('hidden', hasCont); };
    window.handleAIFileUpload = async function(e) { const file = e.target.files[0]; if(!file) return; e.target.value = ""; showToast('Menyiapkan file...', 'warning'); try { const isImg = file.type.startsWith('image/'); const url = await fetchCloudinaryUpload(file, false); STATE.aiPendingFile = { url, isImage: isImg, name: file.name }; const box = document.getElementById('ai-img-preview-container'); box.innerHTML = `<div class="relative inline-block border border-[color:var(--border)] p-1 rounded-xl bg-[color:var(--surface)]"><span class="text-xs truncate px-2 block w-32">${file.name}</span><button onclick="STATE.aiPendingFile=null; this.parentElement.remove(); handleAIInput(document.getElementById('ai-input-field'));" class="absolute -top-2 -right-2 w-5 h-5 bg-red-500 text-white rounded-full">x</button></div>`; box.classList.remove('hidden'); handleAIInput(document.getElementById('ai-input-field')); showToast('Siap!', 'success'); } catch(err){} };
    
    function renderAIChatHistory() { const body = document.getElementById('ai-chat-body'); if(!body) return; body.innerHTML = STATE.aiChatHistory.map(m => `<div class="flex ${m.role === 'user' ? 'justify-end' : 'justify-start'} animate-fade w-full"><div class="${m.role === 'user' ? 'bg-[#2563eb] text-white' : 'bg-[color:var(--card)] border border-[color:var(--border)]'} max-w-[85%] px-4 py-3 rounded-[20px] ${m.role === 'user' ? 'rounded-br-sm' : 'rounded-bl-sm'}">${m.role === 'ai' ? `<div class="flex items-start gap-3"><div class="w-6 h-6 rounded-full bg-gradient-to-tr from-blue-500 to-purple-600 shrink-0 flex items-center justify-center mt-0.5"><i data-lucide="sparkles" class="w-3.5 h-3.5 text-white"></i></div><div class="text-sm break-words whitespace-pre-line">${m.text}</div></div>` : `<div class="text-sm break-words">${m.text}</div>`}</div></div>`).join(''); body.scrollTop = body.scrollHeight; lucide.createIcons(); }
    
    window.submitAskAI = async function() { const input = document.getElementById('ai-input-field'); const text = input.value.trim(); const file = STATE.aiPendingFile; if(!text && !file) return; input.value = ''; input.style.height = 'auto'; document.getElementById('ai-img-preview-container').innerHTML = ''; STATE.aiPendingFile = null; handleAIInput(input); STATE.aiChatHistory.push({ role: 'user', text: text }); renderAIChatHistory(); const body = document.getElementById('ai-chat-body'); const typingId = 'typing-' + Date.now(); body.innerHTML += `<div id="${typingId}" class="flex justify-start animate-fade w-full"><div class="bg-[color:var(--card)] border border-[color:var(--border)] rounded-[20px] rounded-bl-sm px-4 py-3 flex items-center gap-3"><div class="w-6 h-6 rounded-full bg-gradient-to-tr from-blue-500 to-purple-600 shrink-0 flex items-center justify-center"><i data-lucide="sparkles" class="w-3.5 h-3.5 text-white"></i></div><div class="flex gap-1.5 px-1 mt-1"><div class="w-1.5 h-1.5 bg-[color:var(--text2)] rounded-full animate-bounce"></div><div class="w-1.5 h-1.5 bg-[color:var(--text2)] rounded-full animate-bounce" style="animation-delay: 0.2s"></div><div class="w-1.5 h-1.5 bg-[color:var(--text2)] rounded-full animate-bounce" style="animation-delay: 0.4s"></div></div></div></div>`; body.scrollTop = body.scrollHeight; lucide.createIcons(); try { const msgs = STATE.chats[STATE.currentCourse.id] || []; const history = msgs.slice(-10).map(m => `${m.userName}: ${m.text}`).join('\n'); const prompt = `[AI Kelas ${STATE.currentCourse.name}]\nChat:\n${history}`; const q = file ? `[File: ${file.name}]\n${text}` : text; const res = await fetch('/ai/ask', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ history: prompt, question: q }) }); const data = await res.json(); document.getElementById(typingId).remove(); STATE.aiChatHistory.push({ role: 'ai', text: data.result }); renderAIChatHistory(); } catch(e) { document.getElementById(typingId).remove(); showToast('Koneksi AI gagal', 'error'); } };
    window.startAIVoice = function() { const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition; if (!SpeechRecognition) return showToast('Tidak didukung', 'error'); const recognition = new SpeechRecognition(); recognition.lang = 'id-ID'; recognition.start(); const micBtn = document.getElementById('ai-btn-mic'); micBtn.innerHTML = '<div class="w-3 h-3 bg-red-500 rounded-full animate-pulse shadow-[0_0_10px_rgba(239,68,68,0.5)]"></div>'; showToast('Bicara...', 'warning'); recognition.onresult = function(e) { const input = document.getElementById('ai-input-field'); input.value += (input.value ? ' ' : '') + e.results[0][0].transcript; handleAIInput(input); }; recognition.onend = function() { micBtn.innerHTML = '<i data-lucide="mic" class="w-5 h-5"></i>'; lucide.createIcons(); }; };
    window.handleAISummary = async function() { const msgs = STATE.chats[STATE.currentCourse?.id] || []; if(msgs.length < 3) return showToast('Butuh min 3 chat', 'warning'); const chatHistory = msgs.slice(-50).map(m => `${m.userName}: ${m.text}`).join('\n'); const contextPrompt = `[Rangkuman kelas "${STATE.currentCourse.name}".]\n${chatHistory}`; showToast('AI menyusun...', 'warning'); try { const res = await fetch('/ai/summarize', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ history: contextPrompt }) }); const data = await res.json(); showGlobalModal(`<div class="glass p-6 rounded-3xl border border-indigo-500/20 w-full max-w-sm"><div class="flex items-center gap-3 mb-4 border-b border-[color:var(--border)] pb-3"><div class="p-2.5 rounded-xl bg-gradient-to-br from-indigo-500 to-blue-600 text-white shadow-lg"><i data-lucide="file-text" class="w-5 h-5"></i></div><div><h3 class="font-bold">Ringkasan Diskusi</h3></div></div><div class="text-[13px] leading-relaxed bg-[color:var(--input-bg)] p-4 rounded-xl border border-[color:var(--border)] max-h-[300px] overflow-y-auto" style="white-space: pre-line;">${data.result.replace(/\n/g, '<br>')}</div><button onclick="closeGlobalModal()" class="w-full mt-4 py-3 bg-[color:var(--surface)] border border-[color:var(--border)] rounded-xl font-bold">Tutup</button></div>`); } catch(e) { showToast('Gagal memanggil AI', 'error'); } };
    window.handleExportNotes = function() { const msgs = STATE.chats[STATE.currentCourse.id] || []; if(msgs.length === 0) return showToast('Belum ada pesan', 'warning'); const content = msgs.map(m => `[${formatTime(m.timestamp)}] ${m.userName}: ${m.text}`).join('\n'); const fullText = `# CATATAN KELAS: ${STATE.currentCourse.name}\nTanggal: ${new Date().toLocaleDateString('id-ID')}\n\n---\n\n${content}`; const blob = new Blob([fullText], { type: 'text/markdown' }); const url = URL.createObjectURL(blob); const a = document.createElement('a'); a.href = url; a.download = `Catatan_${STATE.currentCourse.id}.md`; a.click(); showToast('Diunduh!'); };

    // ==========================================
    // 9. PERBAIKAN PENGATURAN (DENGAN REKOMENDASI FITUR)
    // ==========================================
    window.renderSettings = function() {
        return `
            <div class="p-6 animate-fade space-y-6 pb-24 max-w-4xl mx-auto">
                <div>
                    <h2 class="text-xl font-black text-[color:var(--text)]">Pengaturan</h2>
                    <p class="text-[10px] text-[color:var(--text2)] uppercase font-bold tracking-widest">Akun & Preferensi Aplikasi</p>
                </div>
                
                <div class="space-y-4">
                    <div class="glass p-5 rounded-3xl border border-[color:var(--border)] shadow-sm">
                        <div class="flex items-center gap-4 mb-4 pb-3 border-b border-[color:var(--border)]">
                            <div class="w-10 h-10 rounded-xl bg-red-500/10 text-red-500 flex items-center justify-center border border-red-500/20"><i data-lucide="shield-check" class="w-5 h-5"></i></div>
                            <div><h3 class="font-bold text-sm">Keamanan Akun</h3><p class="text-[9px] text-[color:var(--text2)] font-medium">Lindungi privasi Anda.</p></div>
                        </div>
                        <button onclick="openChangePasswordModal()" class="w-full p-3.5 rounded-xl bg-[color:var(--surface)] text-[11px] font-bold flex justify-between items-center border border-[color:var(--border)] active:scale-95 transition-all hover:bg-[color:var(--card)]">
                            <span class="flex items-center gap-3"><i data-lucide="key-round" class="w-4 h-4 text-amber-500"></i> Ubah Kata Sandi</span><i data-lucide="chevron-right" class="w-4 h-4 opacity-30"></i>
                        </button>
                    </div>
                    
                    <div class="glass p-5 rounded-3xl border border-[color:var(--border)] shadow-sm">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-10 h-10 rounded-xl bg-indigo-500/10 text-indigo-500 flex items-center justify-center border border-indigo-500/20"><i data-lucide="palette" class="w-5 h-5"></i></div>
                            <div><h3 class="font-bold text-sm">Tema Aplikasi</h3><p class="text-[9px] text-[color:var(--text2)] font-medium">Kustomisasi antarmuka.</p></div>
                        </div>
                        <button onclick="toggleTheme()" class="w-full p-4 rounded-2xl bg-gradient-to-r from-[#2563eb] to-indigo-600 text-white text-xs font-black flex justify-between items-center shadow-lg active:scale-95 transition-all">
                            <span>GANTI MODE ${STATE.isDark ? 'TERANG' : 'GELAP'}</span><i data-lucide="${STATE.isDark ? 'sun' : 'moon'}" class="w-5 h-5"></i>
                        </button>
                    </div>

                    <div class="glass p-5 rounded-3xl border border-[color:var(--border)] shadow-sm">
                        <div class="flex items-center gap-4 mb-4 pb-3 border-b border-[color:var(--border)]">
                            <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-500 flex items-center justify-center border border-emerald-500/20"><i data-lucide="help-circle" class="w-5 h-5"></i></div>
                            <div><h3 class="font-bold text-sm">Info & Bantuan</h3><p class="text-[9px] text-[color:var(--text2)] font-medium">Pusat bantuan mahasiswa.</p></div>
                        </div>
                        <div class="space-y-2">
                            <button onclick="showToast('Pusat Bantuan sedang dikembangkan!', 'warning')" class="w-full p-3 rounded-xl bg-[color:var(--surface)] text-[11px] font-bold flex justify-between items-center border border-[color:var(--border)] active:scale-95 transition-all hover:bg-[color:var(--card)]">
                                <span class="flex items-center gap-3"><i data-lucide="message-square" class="w-4 h-4 text-blue-500"></i> Hubungi Admin Pusat</span><i data-lucide="chevron-right" class="w-4 h-4 opacity-30"></i>
                            </button>
                            <button onclick="showToast('Kebijakan Privasi Aman & Terenkripsi!', 'success')" class="w-full p-3 rounded-xl bg-[color:var(--surface)] text-[11px] font-bold flex justify-between items-center border border-[color:var(--border)] active:scale-95 transition-all hover:bg-[color:var(--card)]">
                                <span class="flex items-center gap-3"><i data-lucide="file-check-2" class="w-4 h-4 text-emerald-500"></i> Kebijakan Privasi</span><i data-lucide="chevron-right" class="w-4 h-4 opacity-30"></i>
                            </button>
                            <div class="w-full p-3 rounded-xl bg-[color:var(--input-bg)] text-[11px] font-bold flex justify-between items-center border border-[color:var(--border)] opacity-70">
                                <span class="flex items-center gap-3"><i data-lucide="info" class="w-4 h-4 text-gray-400"></i> Versi Aplikasi</span><span class="text-[9px] bg-black/20 px-2 py-1 rounded">v3.0 Enterprise</span>
                            </div>
                        </div>
                    </div>

                    <button onclick="auth.signOut()" class="w-full py-4 mt-2 rounded-3xl bg-red-500/10 text-red-500 font-black text-xs border border-red-500/20 hover:bg-red-500 hover:text-white transition-all shadow-sm">KELUAR DARI SISTEM</button>
                </div>
            </div>
        `;
    };

    // ==========================================
    // 10. LOGIKA POP-UP GANTI PASSWORD
    // ==========================================
    window.renderAllAssignments = function() {
        let allAsg = STATE.assignments ? Object.values(STATE.assignments).flat().sort((a,b) => (a.deadline?.seconds || 0) - (b.deadline?.seconds || 0)) : [];
        
        let listHTML = allAsg.length === 0 ? 
            `<div class="p-6 text-center border border-dashed border-[color:var(--border)] rounded-2xl"><p class="text-xs text-[color:var(--text2)] italic">Belum ada tugas kuliah.</p></div>` : 
            allAsg.map(a => {
                const course = typeof COURSES !== 'undefined' ? COURSES.find(c => c.id === a.courseId) : null;
                return `
                <div class="glass p-4 rounded-2xl border border-[color:var(--border)] flex items-center gap-4 cursor-pointer shadow-sm relative overflow-hidden mb-3 hover:scale-[1.02] transition-transform z-10" onclick="viewAssignmentDetail('${a.courseId}', '${a.id}')">
                    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-[#2563eb] opacity-80"></div>
                    <div class="w-12 h-12 rounded-xl bg-blue-500/10 text-blue-500 flex items-center justify-center text-xl shrink-0 border border-blue-500/20">
                        <i data-lucide="file-text" class="w-6 h-6"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-bold text-[13px] text-[color:var(--text)] truncate uppercase">${a.title}</h4>
                        <p class="text-[10px] text-[color:var(--text2)] truncate font-medium">${course ? course.name : ''}</p>
                        <div class="flex items-center gap-3 mt-1.5">
                            <span class="text-[9px] font-bold text-orange-500 flex items-center gap-1"><i data-lucide="clock" class="w-3 h-3"></i> ${typeof formatDate === 'function' ? formatDate(a.deadline) : ''}</span>
                            <span class="text-[9px] font-bold text-[#2563eb] bg-blue-500/10 px-1.5 py-0.5 rounded border border-blue-500/20 uppercase">${a.type}</span>
                        </div>
                    </div>
                    <i data-lucide="chevron-right" class="w-5 h-5 text-[color:var(--text2)] opacity-30 shrink-0"></i>
                </div>`;
            }).join('');

        const todos = STATE.currentUser?.todos || [];
        const todoHTML = todos.length === 0 ? 
            `<div class="text-center p-6 bg-[color:var(--surface)] rounded-2xl border border-dashed border-[color:var(--border)]"><i data-lucide="check-circle" class="w-8 h-8 mx-auto mb-2 text-[#2563eb] opacity-30"></i><p class="text-xs text-[color:var(--text2)] font-medium">Belum ada catatan pribadi.</p></div>` : 
            todos.map(t => `
            <div class="flex items-center justify-between p-3 rounded-xl bg-[color:var(--surface)] border border-[color:var(--border)] mb-2 shadow-sm transition-all ${t.done ? 'opacity-50' : ''} hover:bg-[color:var(--card)] z-10 relative">
                <div class="flex items-center gap-3 flex-1 min-w-0 cursor-pointer" onclick="toggleTodo('${t.id}')">
                    <div class="w-6 h-6 shrink-0 rounded-md border ${t.done ? 'bg-emerald-500 border-emerald-500 text-white' : 'border-[color:var(--border)] text-transparent'} flex items-center justify-center transition-colors shadow-inner">
                        <i data-lucide="check" class="w-4 h-4"></i>
                    </div>
                    <span class="text-sm font-medium truncate ${t.done ? 'line-through text-[color:var(--text2)]' : 'text-[color:var(--text)]'}">${t.text}</span>
                </div>
                <button onclick="deleteTodo('${t.id}')" class="text-red-400 hover:text-red-500 p-2 shrink-0 active:scale-90 transition-transform relative z-20">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                </button>
            </div>`).join('');

        return `
        <div class="p-5 animate-fade space-y-6 pb-24 max-w-4xl mx-auto relative z-10">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-xl font-black text-[color:var(--text)]">Tugas Kuliah</h2>
                        <p class="text-[10px] text-[color:var(--text2)] uppercase font-bold tracking-widest">Semua Mata Kuliah</p>
                    </div>
                    <div class="bg-blue-500/10 px-3 py-1 rounded-full border border-blue-500/20 shadow-sm">
                        <span class="text-[11px] font-black text-[#2563eb]">${allAsg.length} TUGAS</span>
                    </div>
                </div>
                <div>${listHTML}</div>
            </div>
            <div class="h-px w-full bg-[color:var(--border)] opacity-50 my-2"></div>
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-indigo-500/10 text-indigo-500 flex items-center justify-center border border-indigo-500/20 shadow-sm"><i data-lucide="list-todo" class="w-5 h-5"></i></div>
                    <div>
                        <h2 class="text-xl font-black text-[color:var(--text)]">Catatan Pribadi</h2>
                        <p class="text-[10px] text-[color:var(--text2)] uppercase font-bold tracking-widest">To-Do List Saya</p>
                    </div>
                </div>
                <div class="flex gap-2 mb-4 relative z-20">
                    <input type="text" id="todo-input" class="flex-1 bg-[color:var(--input-bg)] border border-[color:var(--border)] rounded-xl p-3.5 text-sm outline-none focus:border-[#2563eb] text-[color:var(--text)] shadow-inner transition-colors" placeholder="Ketik target baru..." onkeydown="if(event.key==='Enter') saveTodo()">
                    <button onclick="saveTodo()" class="bg-[#2563eb] text-white px-5 rounded-xl shadow-lg active:scale-95 transition-transform"><i data-lucide="plus" class="w-5 h-5"></i></button>
                </div>
                <div id="todo-list-container" class="space-y-2">${todoHTML}</div>
            </div>
        </div>`;
    };

    window.saveTodo = async function() { const input = document.getElementById('todo-input'); const text = input?.value.trim(); if(!text) return; const newTodo = { id: Date.now().toString(), text: text, done: false }; const updatedTodos = [...(STATE.currentUser.todos || []), newTodo]; STATE.currentUser.todos = updatedTodos; if(input) input.value = ''; renderDashboardContent(); try { await db.collection('users').doc(STATE.currentUser.uid).update({ todos: updatedTodos }); } catch(e){} };
    window.toggleTodo = async function(id) { const updatedTodos = (STATE.currentUser.todos || []).map(t => t.id === id ? { ...t, done: !t.done } : t); STATE.currentUser.todos = updatedTodos; renderDashboardContent(); try { await db.collection('users').doc(STATE.currentUser.uid).update({ todos: updatedTodos }); } catch(e){} };
    window.deleteTodo = async function(id) { const updatedTodos = (STATE.currentUser.todos || []).filter(t => t.id !== id); STATE.currentUser.todos = updatedTodos; renderDashboardContent(); try { await db.collection('users').doc(STATE.currentUser.uid).update({ todos: updatedTodos }); } catch(e){} };

    window.viewAssignmentDetail = async (courseId, asgId) => {
        try {
            const asg = STATE.assignments?.[courseId]?.find(a => a.id === asgId);
            if(!asg) return showToast("Data tugas tidak ditemukan", "error");

            const isDosen = STATE.currentUser && (STATE.currentUser.role === 'dosen' || STATE.currentUser.role === 'admin');
            let submissions = [];
            try {
                const subSnap = await db.collection('courses').doc(courseId).collection('assignments').doc(asgId).collection('submissions').get();
                submissions = subSnap.docs.map(doc => ({ id: doc.id, ...doc.data() }));
            } catch(e) { console.error("Gagal load submissions"); }

            showGlobalModal(`
            <div class="glass animate-slide border border-[color:var(--border)] max-h-[90vh] overflow-y-auto hide-scrollbar shadow-2xl rounded-3xl flex flex-col bg-[color:var(--bg)] w-full max-w-4xl mx-auto relative overflow-hidden z-[2000]">
                <div class="bg-[#0f172a] text-white p-6 shrink-0 flex items-center justify-between z-20">
                    <div class="flex items-center gap-4"><div class="p-3 bg-blue-500/20 rounded-2xl border border-blue-500/30 text-blue-400"><i data-lucide="briefcase" class="w-6 h-6"></i></div><div><h2 class="text-xl font-black uppercase tracking-tight">${asg.title}</h2><p class="text-xs text-gray-400 font-bold tracking-widest">${asg.courseName} • ${asg.dosen}</p></div></div>
                    <button onclick="closeGlobalModal()" class="p-2 rounded-full hover:bg-white/10 text-white transition-colors"><i data-lucide="x" class="w-6 h-6"></i></button>
                </div>
                <div class="flex flex-col md:flex-row flex-1">
                    <div class="flex-1 overflow-y-auto p-6 space-y-6 border-b md:border-b-0 md:border-r border-[color:var(--border)] bg-[color:var(--surface)]">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-4 rounded-2xl bg-orange-500/5 border border-orange-500/20"><p class="text-[9px] uppercase text-orange-500 font-bold mb-1 tracking-widest">Waktu Terakhir</p><p class="text-sm font-black text-orange-500">${formatDate(asg.deadline)}</p></div>
                            <div class="p-4 rounded-2xl bg-blue-500/5 border border-blue-500/20"><p class="text-[9px] uppercase text-blue-500 font-bold mb-1 tracking-widest">Target Tugas</p><p class="text-sm font-black text-blue-500 uppercase">${asg.type}</p></div>
                        </div>
                        ${asg.type === 'kelompok' && asg.kelompok ? `<div class="p-5 rounded-2xl bg-indigo-500/5 border border-indigo-500/20 space-y-3"><div class="flex items-center gap-2"><i data-lucide="users" class="w-4 h-4 text-indigo-500"></i><h4 class="text-xs font-bold text-indigo-500 uppercase">Informasi Kelompok</h4></div><div class="bg-[color:var(--bg)] p-4 rounded-xl border border-[color:var(--border)]"><p class="text-xs font-black text-[color:var(--text)] mb-1">${asg.kelompok.nama} : ${asg.kelompok.judul}</p><div class="text-[11px] text-[color:var(--text2)] leading-relaxed whitespace-pre-line">${asg.kelompok.anggota}</div></div></div>` : ''}
                        <div>
                            <div class="flex items-center justify-between mb-2"><h4 class="text-xs font-black text-[color:var(--text2)] uppercase tracking-widest">Keterangan & Instruksi</h4>${isDosen ? `<button onclick="updateAsgInstruksi('${courseId}', '${asgId}')" class="text-[10px] font-bold text-emerald-500 flex items-center gap-1 hover:underline"><i data-lucide="save" class="w-3 h-3"></i> SIMPAN</button>` : ''}</div>
                            ${isDosen ? `<textarea id="edit-asg-desc" class="w-full p-5 rounded-2xl bg-[color:var(--bg)] border border-[color:var(--border)] text-sm text-[color:var(--text)] h-40 focus:border-[#2563eb] outline-none">${asg.description || ''}</textarea>` : `<div class="bg-[color:var(--bg)] p-5 rounded-2xl border border-[color:var(--border)] text-sm leading-relaxed whitespace-pre-line">${asg.description || 'Tidak ada instruksi.'}</div>`}
                        </div>
                    </div>
                    <div class="w-full md:w-[320px] bg-[color:var(--bg)] overflow-y-auto p-6 space-y-6">
                        <h4 class="text-xs font-black text-[color:var(--text2)] uppercase tracking-widest mb-4">Pengumpulan File</h4>
                        ${!isDosen ? `<div onclick="document.getElementById('mhs-file').click()" class="w-full border-2 border-dashed border-[#2563eb]/30 rounded-2xl p-6 flex flex-col items-center justify-center text-center cursor-pointer hover:bg-blue-500/5 transition-all"><i data-lucide="upload-cloud" class="w-8 h-8 text-[#2563eb] mb-2"></i><p class="text-[11px] font-bold text-[color:var(--text)]">Upload Tugas (Maks 5MB)</p></div><input type="file" id="mhs-file" class="hidden" onchange="handleMhsUpload(event, '${courseId}', '${asgId}')"><div id="mhs-upload-status" class="mt-2 text-center"></div>` : ''}
                        <div class="space-y-4">
                            ${submissions.length === 0 ? `<p class="text-xs italic text-[color:var(--text2)]">Belum ada yang mengumpulkan.</p>` : submissions.map(sub => `<div class="p-4 rounded-2xl bg-[color:var(--surface)] border border-[color:var(--border)] space-y-3"><div class="flex items-center gap-3"><div class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-500 flex items-center justify-center"><i data-lucide="file-check-2" class="w-4 h-4"></i></div><div class="min-w-0"><p class="text-[11px] font-bold truncate">${sub.userName}</p><p class="text-[9px] text-[color:var(--text2)]">${formatDate(sub.timestamp)}</p></div></div><a href="${sub.fileUrl}" target="_blank" class="w-full py-2 bg-[color:var(--bg)] text-[10px] font-bold rounded-lg border border-[color:var(--border)] flex items-center justify-center gap-2 hover:bg-[#2563eb] hover:text-white transition-all">LIHAT FILE</a><div class="pt-2 border-t border-[color:var(--border)] flex items-center justify-between"><span class="text-[10px] font-bold text-[color:var(--text2)]">NILAI</span>${isDosen ? `<div class="flex gap-1"><input type="number" id="grade-${sub.id}" value="${sub.nilai || ''}" class="w-12 p-1 text-center bg-[color:var(--bg)] border border-[color:var(--border)] rounded text-[11px] font-bold"><button onclick="saveNilai('${courseId}', '${asgId}', '${sub.id}')" class="p-1 bg-emerald-500 text-white rounded"><i data-lucide="check" class="w-3 h-3"></i></button></div>` : `<span class="text-lg font-black ${sub.nilai ? 'text-emerald-500' : 'text-[color:var(--text2)]'}">${sub.nilai || '-'}</span>`}</div></div>`).join('')}
                        </div>
                    </div>
                </div>
            </div>
            `, true);
            if (typeof lucide !== 'undefined') lucide.createIcons();
        } catch(e) { console.error("Error Detail Tugas", e); showToast("Gagal memuat tugas", "error"); }
    };

    window.updateAsgInstruksi = async function(courseId, asgId) { try { await db.collection('courses').doc(courseId).collection('assignments').doc(asgId).update({ description: document.getElementById('edit-asg-desc').value }); showToast("Tersimpan!", "success"); } catch(e) { showToast("Gagal", "error"); } };
    window.handleMhsUpload = async function(e, courseId, asgId) { const file = e.target.files[0]; if(!file) return; if(file.size > 5242880) return alert("Maks 5 MB!"); document.getElementById('mhs-upload-status').innerHTML = '<span class="text-xs text-blue-500">Mengunggah...</span>'; try { const url = await fetchCloudinaryUpload(file, false); await db.collection('courses').doc(courseId).collection('assignments').doc(asgId).collection('submissions').add({ userId: STATE.currentUser.uid, userName: STATE.currentUser.displayName, fileUrl: url, fileName: file.name, timestamp: firebase.firestore.FieldValue.serverTimestamp(), nilai: null }); document.getElementById('mhs-upload-status').innerHTML = '<span class="text-xs text-emerald-500 font-bold">Berhasil!</span>'; setTimeout(() => viewAssignmentDetail(courseId, asgId), 1000); } catch(err){} };
    window.saveNilai = async function(courseId, asgId, subId) { try { await db.collection('courses').doc(courseId).collection('assignments').doc(asgId).collection('submissions').doc(subId).update({ nilai: parseInt(document.getElementById(`grade-${subId}`).value) }); showToast("Nilai disimpan!", "success"); } catch(e){} };

    // ==========================================
    // 11. POP-UP UBAH PASSWORD
    // ==========================================
    window.openChangePasswordModal = function() {
        showGlobalModal(`
        <div class="glass p-5 md:p-6 rounded-3xl animate-slide w-full max-w-md border border-amber-500/30 shadow-[0_20px_50px_rgba(245,158,11,0.15)] relative overflow-hidden h-max max-h-[90vh] overflow-y-auto hide-scrollbar mx-auto">
            <div class="flex justify-between items-start mb-5 border-b border-[color:var(--border)] pb-4 relative z-10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 text-white flex items-center justify-center shadow-lg shrink-0">
                        <i data-lucide="shield-check" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-[color:var(--text)] text-lg leading-tight">Ubah Password</h3>
                        <p class="text-[9px] text-amber-500 uppercase tracking-wider font-bold">Verifikasi Identitas Anda</p>
                    </div>
                </div>
                <button onclick="closeGlobalModal()" class="p-1.5 text-[color:var(--text2)] hover:bg-red-500/20 hover:text-red-500 rounded-full transition-colors"><i data-lucide="x" class="w-5 h-5"></i></button>
            </div>
            <div class="space-y-4 relative z-10">
                <div class="bg-[color:var(--input-bg)] p-4 rounded-2xl border border-[color:var(--border)]">
                    <label class="text-[10px] font-bold text-[color:var(--text2)] uppercase tracking-wider mb-1.5 block">Email Terdaftar</label>
                    <p class="text-sm font-bold text-[color:var(--text)]">${STATE.currentUser?.email || '-'}</p>
                </div>
                <div>
                    <label class="text-[10px] font-bold text-[color:var(--text2)] uppercase tracking-wider mb-1.5 block">Password Saat Ini</label>
                    <div class="relative">
                        <i data-lucide="unlock" class="absolute left-3.5 top-3.5 w-4 h-4 text-[color:var(--text2)]"></i>
                        <input type="password" id="old-password" placeholder="Ketik password lama" class="w-full text-sm p-3.5 pl-10 rounded-xl bg-[color:var(--input-bg)] text-[color:var(--text)] border border-[color:var(--border)] focus:border-amber-500 outline-none transition-colors">
                    </div>
                </div>
                <div class="pt-2 border-t border-[color:var(--border)]">
                    <label class="text-[10px] font-bold text-[color:var(--text2)] uppercase tracking-wider mb-1.5 block">Password Baru</label>
                    <div class="relative">
                        <i data-lucide="key-round" class="absolute left-3.5 top-3.5 w-4 h-4 text-[color:var(--text2)]"></i>
                        <input type="password" id="new-password" placeholder="Buat password baru" class="w-full text-sm p-3.5 pl-10 rounded-xl bg-[color:var(--input-bg)] text-[color:var(--text)] border border-[color:var(--border)] focus:border-amber-500 outline-none transition-colors">
                    </div>
                </div>
                <div>
                    <label class="text-[10px] font-bold text-[color:var(--text2)] uppercase tracking-wider mb-1.5 block">Konfirmasi Password Baru</label>
                    <div class="relative">
                        <i data-lucide="check-circle-2" class="absolute left-3.5 top-3.5 w-4 h-4 text-[color:var(--text2)]"></i>
                        <input type="password" id="confirm-password" placeholder="Ketik ulang password baru" class="w-full text-sm p-3.5 pl-10 rounded-xl bg-[color:var(--input-bg)] text-[color:var(--text)] border border-[color:var(--border)] focus:border-amber-500 outline-none transition-colors">
                    </div>
                </div>
            </div>
            <div class="mt-6 relative z-10">
                <button onclick="submitNewPassword()" id="btn-save-pass" class="w-full py-3.5 rounded-xl text-white font-bold bg-gradient-to-r from-amber-500 to-orange-500 active:scale-95 transition-transform shadow-lg shadow-amber-500/20 flex items-center justify-center gap-2">
                    <i data-lucide="send" class="w-4 h-4"></i> Simpan Password Baru
                </button>
            </div>
        </div>`, true);
        lucide.createIcons();
    };

    // =====================================================================
    // FITUR TUGAS 1: WADAH DATA & SAKLAR PINTAR UI
    // =====================================================================

    // 1A. Memastikan Wadah File Tersedia di STATE
    if (typeof STATE !== 'undefined' && STATE.asgPendingFile === undefined) {
        STATE.asgPendingFile = null;
    }

    // 1B. Saklar untuk Membuka/Menutup Panel Kelompok
    window.toggleGroupSection = function(val) {
        const sec = document.getElementById('group-section');
        const memberInput = document.getElementById('asg-group-members');
        if (!sec || !memberInput) return;

        if (val === 'kelompok') {
            sec.classList.remove('hidden');
            if (!memberInput.value.trim()) memberInput.value = "1. \n2. ";
        } else {
            sec.classList.add('hidden');
        }
    };

    // 1C. Saklar untuk Memunculkan Input "Lainnya"
    window.toggleJenisLainnya = function(val) {
        const inputLainnya = document.getElementById('asg-jenis-lainnya');
        if (!inputLainnya) return;

        if (val === 'Lainnya') {
            inputLainnya.classList.remove('hidden');
            inputLainnya.focus(); // Langsung arahkan kursor buat ngetik
        } else {
            inputLainnya.classList.add('hidden');
        }
    };

    // ==========================================
    // 12. DESAIN FORM TUGAS NEGARA
    // ==========================================
    window.openAssignForm = function() {
        const dosenName = STATE.currentCourse?.dosen || STATE.currentUser?.displayName || 'Dosen Pengampu';
        const courseName = STATE.currentCourse?.name?.toUpperCase() || 'MATA KULIAH';

        showGlobalModal(`
        <div class="bg-white w-full max-w-md mx-auto rounded-none sm:rounded-xl overflow-hidden shadow-2xl relative flex flex-col h-max max-h-[90vh]">
            
            <div class="bg-[#0B1D3A] px-6 py-5 text-center shrink-0">
                <h2 class="text-white text-lg font-black tracking-wide">${courseName}</h2>
                <p class="text-slate-300 text-[11px] mt-1 tracking-wider">${dosenName}</p>
            </div>

            <div class="p-5 md:p-6 overflow-y-auto hide-scrollbar space-y-6 bg-slate-50 flex-1">
                
                <div>
                    <label class="flex items-center gap-2 text-[11px] font-black text-[#0B1D3A] uppercase tracking-wider mb-2"><div class="w-5 h-5 rounded-full bg-[#0B1D3A] text-white flex items-center justify-center shrink-0"><i data-lucide="file-text" class="w-3 h-3"></i></div> JENIS TUGAS</label>
                    <div class="relative">
                        <select id="asg-jenis" onchange="window.toggleJenisLainnya(this.value)" class="w-full bg-white border border-slate-300 text-black font-medium rounded-lg p-3 text-sm outline-none focus:border-[#0B1D3A] focus:ring-1 focus:ring-[#0B1D3A] appearance-none shadow-sm cursor-pointer">
                            <option value="" disabled selected hidden>Pilih jenis tugas</option>
                            <option value="Makalah">Makalah</option>
                            <option value="Proposal">Proposal</option>
                            <option value="Karya Ilmiah">Karya Ilmiah</option>
                            <option value="Tulis Tangan">Tulis Tangan</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                        <i data-lucide="chevron-down" class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"></i>
                    </div>
                    <input type="text" id="asg-jenis-lainnya" class="hidden w-full bg-white border border-slate-300 rounded-lg p-3 text-sm text-black font-medium outline-none focus:border-[#0B1D3A] focus:ring-1 focus:ring-[#0B1D3A] shadow-sm mt-3" placeholder="Ketik jenis tugas secara manual...">
                </div>

                <div>
                    <label class="flex items-center gap-2 text-[11px] font-black text-[#0B1D3A] uppercase tracking-wider mb-2"><div class="w-5 h-5 rounded-full bg-[#0B1D3A] text-white flex items-center justify-center shrink-0"><i data-lucide="users" class="w-3 h-3"></i></div> TARGET TUGAS</label>
                    <div class="relative">
                        <select id="asg-type" onchange="window.toggleGroupSection(this.value)" class="w-full bg-white border border-slate-300 text-black font-medium rounded-lg p-3 text-sm outline-none focus:border-[#0B1D3A] focus:ring-1 focus:ring-[#0B1D3A] appearance-none shadow-sm cursor-pointer">
                            <option value="" disabled selected hidden>Pilih target tugas</option>
                            <option value="individu">Tugas Individu</option>
                            <option value="kelompok">Tugas Kelompok</option>
                        </select>
                        <i data-lucide="chevron-down" class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"></i>
                    </div>

                    <div id="group-section" class="hidden mt-3 p-4 border border-[#7DA0C4]/30 bg-[#F0F4F8] rounded-lg space-y-3 relative shadow-inner">
                        <div class="absolute -top-2 left-6 w-4 h-4 bg-[#F0F4F8] border-t border-l border-[#7DA0C4]/30 transform rotate-45"></div>
                        <div class="relative z-10">
                            <label class="text-[10px] font-bold text-[#0B1D3A] uppercase tracking-wider mb-1 block">Nama Kelompok</label>
                            <input type="text" id="asg-group-name" class="w-full bg-white border border-slate-300 rounded p-2.5 text-xs text-black font-bold outline-none focus:border-[#0B1D3A]" placeholder="Ketik nama kelompok..." value="Kelompok 1">
                        </div>
                        <div class="relative z-10">
                            <label class="text-[10px] font-bold text-[#0B1D3A] uppercase tracking-wider mb-1 block">Daftar Anggota (Min. 2 Orang)</label>
                            <textarea id="asg-group-members" class="w-full bg-white border border-slate-300 rounded p-2.5 text-xs text-black font-medium outline-none focus:border-[#0B1D3A] h-20 resize-none leading-relaxed" placeholder="1. Nama Anggota 1&#10;2. Nama Anggota 2"></textarea>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="flex items-center gap-2 text-[11px] font-black text-[#0B1D3A] uppercase tracking-wider mb-2"><div class="w-5 h-5 rounded-full bg-[#0B1D3A] text-white flex items-center justify-center shrink-0"><i data-lucide="clipboard-list" class="w-3 h-3"></i></div> KETERANGAN & LAMPIRAN</label>
                    <textarea id="asg-desc" class="w-full bg-white border border-slate-300 text-black font-medium rounded-lg p-3 text-sm outline-none focus:border-[#0B1D3A] focus:ring-1 focus:ring-[#0B1D3A] h-24 resize-none shadow-sm" placeholder="Tuliskan ketentuan tugas, referensi, dan informasi lainnya"></textarea>
                </div>

                <div>
                    <label class="flex items-center gap-2 text-[11px] font-black text-[#0B1D3A] uppercase tracking-wider mb-2"><div class="w-5 h-5 rounded-full bg-[#0B1D3A] text-white flex items-center justify-center shrink-0"><i data-lucide="calendar" class="w-3 h-3"></i></div> WAKTU PENGUMPULAN</label>
                    <input type="datetime-local" id="asg-deadline" class="w-full bg-white border border-slate-300 text-black font-medium rounded-lg p-3 text-sm outline-none focus:border-[#0B1D3A] focus:ring-1 focus:ring-[#0B1D3A] shadow-sm cursor-pointer uppercase">
                </div>

                <div>
                    <label class="flex items-center gap-2 text-[11px] font-black text-[#0B1D3A] uppercase tracking-wider mb-2"><div class="w-5 h-5 rounded-full bg-[#0B1D3A] text-white flex items-center justify-center shrink-0"><i data-lucide="image" class="w-3 h-3"></i></div> UPLOAD FOTO (OPSIONAL)</label>
                    <div onclick="document.getElementById('asg-file').click()" id="asg-upload-box" class="border-2 border-dashed border-slate-300 rounded-lg p-6 text-center cursor-pointer hover:bg-slate-100 transition-colors bg-white">
                        <i data-lucide="upload" id="asg-upload-icon" class="w-5 h-5 text-[#0B1D3A] mx-auto mb-2 transition-colors"></i>
                        <p id="asg-upload-text" class="text-[10px] font-bold text-slate-700 truncate px-2">Klik untuk upload atau drag & drop file di sini</p>
                        <p class="text-[9px] text-slate-400 mt-1">Format: JPG, PNG, PDF (Maks. 5 MB)</p>
                    </div>
                    <input type="file" id="asg-file" class="hidden" accept="image/jpeg, image/png, application/pdf" onchange="window.handleAsgFileUpload(event)">
                </div>

                <div class="bg-[#F0F4F8] border border-[#D0E1F0] p-4 rounded-lg flex items-start gap-3">
                    <div class="w-5 h-5 rounded-full bg-[#7DA0C4] text-white flex items-center justify-center shrink-0 mt-0.5">
                        <i data-lucide="info" class="w-3 h-3"></i>
                    </div>
                    <div>
                        <h4 class="text-[11px] font-bold text-[#0B1D3A]">Periksa kembali sebelum mengirim</h4>
                        <p class="text-[10px] text-slate-500 mt-0.5">Pastikan semua informasi sudah benar dan lengkap.</p>
                    </div>
                </div>

            </div>

            <div class="p-5 md:p-6 bg-white border-t border-slate-200 shrink-0 space-y-3">
                <button onclick="window.submitNewAssignment()" id="btn-submit-asg" class="w-full py-3.5 bg-[#0B1D3A] hover:bg-[#1a3668] text-white rounded-lg font-bold text-[11px] uppercase tracking-wider flex items-center justify-center gap-2 transition-colors active:scale-[0.98]">
                    <i data-lucide="send" class="w-4 h-4"></i> KIRIM TUGAS UNTUK DITAMPILKAN
                </button>
                <button onclick="closeGlobalModal()" class="w-full py-3.5 bg-white text-slate-600 border border-slate-300 rounded-lg font-bold text-[11px] uppercase tracking-wider flex items-center justify-center gap-2 hover:bg-slate-50 transition-colors active:scale-[0.98]">
                    <i data-lucide="log-out" class="w-4 h-4"></i> TUTUP / KELUAR HALAMAN
                </button>
            </div>

        </div>`, true);
        
        lucide.createIcons();
    };

    // =====================================================================
    // FITUR TUGAS 3: VALIDASI & PENGIRIMAN KE DATABASE
    // =====================================================================
    window.submitNewAssignment = async function() {
        // --- 1. AMBIL DATA DARI FORM ---
        let jenis = document.getElementById('asg-jenis').value;
        const desc = document.getElementById('asg-desc').value.trim();
        const type = document.getElementById('asg-type').value;
        const deadlineRaw = document.getElementById('asg-deadline').value;
        
        // --- 2. VALIDASI JENIS TUGAS ---
        if (jenis === 'Lainnya') {
            jenis = document.getElementById('asg-jenis-lainnya').value.trim();
            if (!jenis) return alert('Peringatan: Harap ketikkan jenis tugas manual Anda!');
        } else if (!jenis) {
            return alert('Peringatan: Harap pilih Jenis Tugas!');
        }

        if (!type || !deadlineRaw) {
            return alert('Peringatan: Harap lengkapi Target Tugas dan Waktu Pengumpulan!');
        }

        // --- 3. VALIDASI KHUSUS KELOMPOK ---
        let kelompokData = null;
        if (type === 'kelompok') {
            const gName = document.getElementById('asg-group-name').value.trim();
            const gMembers = document.getElementById('asg-group-members').value.trim();
            
            if (!gName || !gMembers) return alert("Peringatan: Data kelompok belum lengkap!");
            
            kelompokData = { 
                nama: gName, 
                judul: jenis.toUpperCase(), 
                anggota: gMembers 
            };
        }
        
        // --- 4. PERSIAPAN LOADING ---
        const btn = document.getElementById('btn-submit-asg');
        btn.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i> MEMPROSES...';
        btn.disabled = true;

        // --- 5. EKSEKUSI PENYIMPANAN ---
        try {
            let fileUrl = null;
            
            // A. Upload File Jika Ada
            if (STATE.asgPendingFile) {
                btn.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i> MENGUPLOAD FILE...';
                fileUrl = await fetchCloudinaryUpload(STATE.asgPendingFile, false);
            }

            // B. Siapkan Data untuk Firebase
            const deadlineDate = new Date(deadlineRaw);
            const dosenName = STATE.currentCourse?.dosen || STATE.currentUser.displayName;
            
            // C. Tembak ke Database Firebase
            await db.collection('courses').doc(STATE.currentCourse.id).collection('assignments').add({
                title: jenis.toUpperCase(),
                description: desc,
                type: type,
                kelompok: kelompokData, 
                deadline: firebase.firestore.Timestamp.fromDate(deadlineDate),
                courseId: STATE.currentCourse.id,
                courseName: STATE.currentCourse.name,
                dosen: dosenName,
                fileUrl: fileUrl, 
                timestamp: firebase.firestore.FieldValue.serverTimestamp()
            });
            
            // D. Sukses & Bersihkan Form
            alert('Tugas berhasil dipublikasikan ke kelas!');
            STATE.asgPendingFile = null; 
            closeGlobalModal();

        } catch (error) {
            alert('Terjadi kesalahan jaringan: ' + error.message);
            btn.innerHTML = '<i data-lucide="send" class="w-4 h-4"></i> KIRIM TUGAS UNTUK DITAMPILKAN';
            btn.disabled = false;
        }
    };

    // ==========================================
    // 14. UPDATE NEW PASWORD
    // ==========================================
    window.submitNewPassword = async function() {
        const oldPass = document.getElementById('old-password').value;
        const newPass = document.getElementById('new-password').value;
        const confPass = document.getElementById('confirm-password').value;
        const btn = document.getElementById('btn-save-pass');
        const user = auth.currentUser;

        if (!oldPass || !newPass || !confPass) return showToast('Isi semua kolom!', 'warning');
        if (newPass.length < 6) return showToast('Password baru minimal 6 karakter!', 'error');
        if (newPass !== confPass) return showToast('Konfirmasi password tidak cocok!', 'error');

        btn.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i> Memproses...';
        btn.disabled = true;

        try {
            await auth.signInWithEmailAndPassword(user.email, oldPass); // Verifikasi sandi lama
            await user.updatePassword(newPass); // Ganti ke sandi baru
            
            showGlobalModal(`
                <div class="glass p-8 rounded-3xl w-full max-w-sm mx-auto text-center border border-emerald-500/30">
                    <div class="w-20 h-20 mx-auto bg-emerald-500/20 text-emerald-500 rounded-full flex items-center justify-center mb-4">
                        <i data-lucide="shield-check" class="w-10 h-10"></i>
                    </div>
                    <h2 class="text-xl font-bold text-[color:var(--text)] mb-2">Password Berhasil Diubah!</h2>
                    <p class="text-sm text-[color:var(--text2)] leading-relaxed">Gunakan password baru Anda untuk login selanjutnya.</p>
                    <button onclick="closeGlobalModal()" class="w-full mt-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold transition-colors">Selesai</button>
                </div>
            `, true);
        } catch(e) {
            showToast('Gagal: Password lama salah!', 'error');
            btn.innerHTML = '<i data-lucide="send" class="w-4 h-4"></i> Simpan Password Baru';
            btn.disabled = false;
        }
    };

    // =====================================================================
    // 1. DESAIN KARTU TUGAS MENDESAK (PERSIS SEPERTI GAMBAR)
    // =====================================================================
    window.generateTugasMendesakHTML = function(assignmentsArray) {
        if (!assignmentsArray || assignmentsArray.length === 0) return '';

        const now = Date.now();
        let htmlContent = '';

        // Urutkan dari deadline terdekat
        const sortedAssignments = assignmentsArray.sort((a, b) => {
            const timeA = a.deadline && typeof a.deadline.toDate === 'function' ? a.deadline.toDate().getTime() : 0;
            const timeB = b.deadline && typeof b.deadline.toDate === 'function' ? b.deadline.toDate().getTime() : 0;
            return timeA - timeB;
        });

        sortedAssignments.forEach(asg => {
            const deadlineMs = asg.deadline && typeof asg.deadline.toDate === 'function' ? asg.deadline.toDate().getTime() : 0;
            
            // Hanya tampilkan jika waktu masih ada
            if (deadlineMs > now) {
                htmlContent += `
                <div class="assignment-card bg-white border border-slate-200 rounded-xl p-4 shadow-sm flex items-center justify-between mb-3 transition-all duration-300" data-deadline="${deadlineMs}">
                    
                    <div class="flex-1 min-w-0 pr-4">
                        <h3 class="text-[13px] font-black text-[#0B1D3A] uppercase truncate">${asg.title || 'TUGAS'}</h3>
                        <p class="text-[10px] font-medium text-slate-500 mt-1 truncate flex items-center gap-1.5">
                            <i data-lucide="book-open" class="w-3 h-3 text-slate-400"></i> ${asg.courseName || 'Mata Kuliah'} <span class="text-slate-300">•</span> ${asg.dosen || 'Dosen'}
                        </p>
                    </div>
                    
                    <div class="flex items-center gap-4 shrink-0">
                        <div class="text-right">
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">BERAKHIR DALAM :</p>
                            <div class="bg-rose-50 text-rose-600 px-2.5 py-1.5 rounded-md flex items-center gap-1.5 border border-rose-100">
                                <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                                <span class="countdown-timer text-[11px] font-black tracking-widest">-- : -- : --</span>
                            </div>
                        </div>
                        
                        <button onclick="window.viewAssignmentDetail('${asg.courseId}', '${asg.id}')" class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-colors shrink-0">
                            <i data-lucide="chevron-right" class="w-5 h-5"></i>
                        </button>
                    </div>

                </div>
                `;
            }
        });

        return htmlContent;
    };

    // =====================================================================
    // 2. MESIN DETAK WAKTU (STARTER OTOMATIS)
    // =====================================================================
    window.startAssignmentCountdown = function() {
        // Matikan mesin lama biar gak bentrok
        if (window.assignmentTimer) clearInterval(window.assignmentTimer);

        // Nyalakan mesin baru (berdetak setiap 1 detik)
        window.assignmentTimer = setInterval(() => {
            const cards = document.querySelectorAll('.assignment-card');
            const now = Date.now();

            cards.forEach(card => {
                const deadline = parseInt(card.getAttribute('data-deadline'));
                const timerEl = card.querySelector('.countdown-timer');
                if (!timerEl) return;

                const diff = deadline - now;

                // JIKA WAKTU HABIS: Hapus kartu otomatis
                if (diff <= 0) {
                    card.style.display = 'none'; 
                    return;
                }

                // HITUNGAN MATEMATIKA JAM : MENIT : DETIK
                const hours = Math.floor(diff / (1000 * 60 * 60));
                const mins = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const secs = Math.floor((diff % (1000 * 60)) / 1000);

                // Format angka biar selalu 2 digit (contoh: 09, bukan 9)
                const hStr = hours.toString().padStart(2, '0');
                const mStr = mins.toString().padStart(2, '0');
                const sStr = secs.toString().padStart(2, '0');

                // Tampilkan ke layar
                timerEl.innerText = `${hStr} : ${mStr} : ${sStr}`;
            });
        }, 1000); // 1000 ms = 1 detik
    };

    // KUNCI KONTAK: Langsung putar mesinnya agar berdetak di latar belakang!
    window.startAssignmentCountdown();

</script>
</body>
</html>
