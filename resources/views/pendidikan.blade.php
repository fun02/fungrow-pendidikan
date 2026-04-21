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
    <script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/lucide@latest"></script>
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
        .animate-fade { animation: fadeIn 0.3s ease both; }
        .animate-slide { animation: slideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) both; }
        .animate-slide-attachment { animation: slideUpAttachment 0.3s cubic-bezier(0.16, 1, 0.3, 1) both; }
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
        .sidebar-open { transform: translateX(0) !important; }
        .overlay-open { opacity: 1 !important; pointer-events: auto !important; }
                  /* Kustomisasi Dots Slider FunGrow */
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
            <button onclick="closePromoModal()" class="absolute -top-4 -right-4 w-10 h-10 bg-white text-slate-800 rounded-full flex items-center justify-center shadow-xl border border-slate-200 z-10 active:scale-90 transition-transform">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
            <img src="https://images.unsplash.com/photo-1543269865-cbf427effbad?auto=format&fit=crop&q=80&w=600&h=800" alt="Pengumuman" class="w-full h-auto max-h-[80vh] object-contain rounded-2xl shadow-2xl">
        </div>
    </div>

<div id="reset-modal" class="modal-background flex items-center justify-center p-4 z-[2000]">
    <div class="glass p-8 w-full max-w-sm animate-slide text-center shadow-[0_20px_50px_rgba(0,0,0,0.5)] relative overflow-hidden border border-[color:var(--border)]">
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-orange-500/10 rounded-full blur-3xl"></div>
        <div id="reset-content">
            <div id="reset-step-1">
                <div class="w-16 h-16 bg-orange-500/20 rounded-2xl flex items-center justify-center mx-auto mb-5 border border-orange-500/30">
                    <i data-lucide="mail-search" class="w-8 h-8 text-orange-400"></i>
                </div>
                <h3 class="text-xl font-bold text-[color:var(--text)] mb-2">Lupa Password</h3>
                <p class="text-[11px] text-[color:var(--text2)] mb-6 px-4">Masukkan NIM dan Email Anda yang terdaftar.</p>
                
                <input type="number" id="reset-nim-input" class="w-full p-3.5 rounded-xl bg-[color:var(--input-bg)] border border-[color:var(--border)] text-sm text-[color:var(--text)] mb-3 outline-none focus:border-orange-500/50 transition-all" placeholder="NIM Anda">
                
                <input type="email" id="reset-email-input" class="w-full p-3.5 rounded-xl bg-[color:var(--input-bg)] border border-[color:var(--border)] text-sm text-[color:var(--text)] mb-4 outline-none focus:border-orange-500/50 transition-all" placeholder="Email Anda">
                
                <button onclick="sendResetLink()" class="w-full py-3.5 rounded-xl font-bold text-white bg-gradient-to-r from-orange-500 to-amber-600 shadow-lg shadow-orange-500/20 active:scale-95 transition-transform">Kirim Link Reset</button>
            </div>
            <div id="reset-step-2" class="hidden">
                <div class="w-16 h-16 bg-emerald-500/20 rounded-2xl flex items-center justify-center mx-auto mb-5 border border-emerald-500/30">
                    <i data-lucide="shield-check" class="w-8 h-8 text-emerald-400"></i>
                </div>
                <h3 class="text-xl font-bold text-[color:var(--text)] mb-2">Verifikasi OTP</h3>
                <p class="text-[11px] text-[color:var(--text2)] mb-6 px-4">Kode OTP telah dikirim ke email Anda.</p>
                <input type="text" id="otp-input" maxlength="6" class="w-full p-3.5 rounded-xl bg-[color:var(--input-bg)] border border-[color:var(--border)] text-2xl tracking-[0.5em] font-bold text-[color:var(--text)] mb-4 text-center outline-none focus:border-emerald-500/50" placeholder="000000">
                <button onclick="verifyOTP()" class="w-full py-3.5 rounded-xl font-bold text-white bg-emerald-600 active:scale-95 transition-transform shadow-lg shadow-emerald-500/20">Verifikasi</button>
            </div>
            <div id="reset-step-3" class="hidden">
                <h3 class="text-xl font-bold text-[color:var(--text)] mb-2">Buat Password Baru</h3>
                <p class="text-[11px] text-[color:var(--text2)] mb-6">Pastikan password baru Anda aman.</p>
                <input type="password" id="new-pass-input" class="w-full p-3.5 rounded-xl bg-[color:var(--input-bg)] border border-[color:var(--border)] text-sm text-[color:var(--text)] mb-4 outline-none focus:border-indigo-500/50" placeholder="Password Baru">
                <button onclick="saveNewPassword()" class="w-full py-3.5 rounded-xl font-bold text-white bg-indigo-600 active:scale-95 transition-transform shadow-lg shadow-indigo-500/20">Simpan Password</button>
            </div>
        </div>
        <button onclick="document.getElementById('reset-modal').classList.remove('show')" class="mt-6 text-xs text-[color:var(--text2)] font-medium hover:text-[color:var(--text)] transition-colors">Batal</button>
    </div>
</div>

<div id="sidebar-overlay" class="modal-background transition-opacity duration-300 z-[1001]" onclick="closeSidebar()"></div>
<div id="sidebar" class="fixed inset-y-0 left-0 w-[280px] bg-[color:var(--surface)] backdrop-blur-3xl border-r border-[color:var(--border)] shadow-2xl transform -translate-x-full transition-transform duration-300 z-[1002] flex flex-col">
    <div class="p-6 pt-10 flex items-center gap-3 border-b border-[color:var(--border)]">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#2563eb] to-indigo-600 flex items-center justify-center shadow-lg"><span class="text-xl">🎓</span></div>
        <div>
            <h2 class="font-bold text-xl text-[color:var(--text)] tracking-tight">FunGrow</h2>
            <p class="text-[10px] text-[color:var(--text2)] font-medium uppercase tracking-wider">Pendidikan</p>
        </div>
    </div>
    <div class="flex-1 overflow-y-auto py-6 px-4 space-y-2">
        <button onclick="switchTab('home')" class="w-full flex items-center gap-4 px-4 py-3 rounded-xl text-left font-semibold text-[color:var(--text)] hover:bg-[color:var(--card)] transition-colors active:scale-95"><i data-lucide="home" class="w-5 h-5 text-[#2563eb]"></i> Home</button>
        <button onclick="switchTab('kelas')" class="w-full flex items-center gap-4 px-4 py-3 rounded-xl text-left font-semibold text-[color:var(--text)] hover:bg-[color:var(--card)] transition-colors active:scale-95"><i data-lucide="layout-dashboard" class="w-5 h-5 text-emerald-500"></i> Kelas FunGrow</button>
        <button onclick="switchTab('jadwal')" class="w-full flex items-center gap-4 px-4 py-3 rounded-xl text-left font-semibold text-[color:var(--text)] hover:bg-[color:var(--card)] transition-colors active:scale-95"><i data-lucide="calendar-days" class="w-5 h-5 text-orange-500"></i> Jadwal Perkuliahan</button>
        <div class="h-px bg-[color:var(--border)] my-4 mx-2"></div>
        <button onclick="switchTab('about'); closeSidebar();" class="flex items-center gap-3 p-3 w-full rounded-2xl hover:bg-[color:var(--surface)] text-[color:var(--text2)] hover:text-[color:var(--text)] transition-all font-medium"><i data-lucide="user-circle" class="w-5 h-5"></i><span>Profil Akademik</span></button>
        <button onclick="openChangePasswordModal()" class="w-full flex items-center gap-4 px-4 py-3 rounded-xl text-left font-semibold text-[color:var(--text)] hover:bg-[color:var(--card)] transition-colors active:scale-95"><i data-lucide="key-round" class="w-5 h-5 text-amber-500"></i> Ganti Password</button>
        <button onclick="switchTab('mahasiswa'); closeSidebar();" class="flex items-center gap-3 p-3 w-full rounded-2xl hover:bg-[color:var(--surface)] text-[color:var(--text2)] hover:text-[color:var(--text)] transition-all font-medium"><i data-lucide="users" class="w-5 h-5"></i><span>Data Mahasiswa</span></button>
    </div>
    <div class="p-6 border-t border-[color:var(--border)]">
        <button onclick="doLogout()" class="w-full flex items-center justify-center gap-2 py-3 rounded-xl bg-red-500/10 text-red-500 font-bold hover:bg-red-500/20 transition-colors"><i data-lucide="log-out" class="w-4 h-4"></i> Keluar</button>
    </div>
</div>

<div id="global-modal" class="modal-background flex items-center justify-center p-4 z-[1500]">
    <div class="w-full" id="modal-content"></div>
</div>

<input type="file" id="global-file-input" class="hidden" onchange="handleGlobalFileUpload(event)">

<script>
    // ========== FIREBASE CONFIGURATION ==========
    const firebaseConfig = {
        apiKey: "{{ env('FIREBASE_API_KEY') }}",
        authDomain: "{{ env('FIREBASE_AUTH_DOMAIN') }}",
        projectId: "{{ env('FIREBASE_PROJECT_ID') }}",
        storageBucket: "{{ env('FIREBASE_STORAGE_BUCKET') }}",
        messagingSenderId: "{{ env('FIREBASE_MESSAGING_SENDER_ID') }}",
        appId: "{{ env('FIREBASE_APP_ID') }}"
    };

    function initializeFirebase() {
        if (firebase.apps.length > 0) return true;
        try { firebase.initializeApp(firebaseConfig); return true; } catch (error) { console.error('Firebase init failed:', error); throw error; }
    }
    initializeFirebase();
    const auth = firebase.auth();
    const db = firebase.firestore();
    db.enablePersistence().catch(err => console.warn('Persistence error:', err));

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

    // ========== FULL SCHEDULE DATA (SEMESTER 4) ==========
    const FULL_SCHEDULE = [
        { day: 'Senin', items: [
            { time: '08.00 - 10.30', code: 'MBS233', name: 'Manajemen Operasional', sks: 3, dosen: 'Slamet Wijiono, S.E., M.Si.', room: '204', id: 'mo' },
            { time: '11.10 - 13.40', code: 'MBS234', name: 'Perilaku Konsumen', sks: 3, dosen: 'Bastomi Dani Umbara, S.E., M.M.', room: '203', id: 'pk' }
        ]},
        { day: 'Selasa', items: [
            { time: '08.00 - 10.30', code: 'MBS202', name: 'Manajemen Strategi', sks: 3, dosen: 'Farida Umi Choiriyah, S.Pd., M.M.', room: '202', id: 'ms' },
            { time: '11.10 - 13.40', code: 'MBS231', name: 'Sistem Informasi Manajemen', sks: 3, dosen: 'Bastomi Dani Umbara, S.E., M.M.', room: '202', id: 'sim' }
        ]},
        { day: 'Rabu', items: [
            { time: '11.10 - 13.40', code: 'MBS230', name: 'Fiqh Muamalah Kontemporer', sks: 3, dosen: 'Miftakhul Jannah, S.Pd., M.E.', room: '202', id: 'fmk' }
        ]},
        { day: 'Kamis', items: [
            { time: '11.10 - 13.40', code: 'MBS203', name: 'Manajemen Keuangan Syariah', sks: 3, dosen: 'Istiada, S.E., M.E.', room: '202', id: 'mks' },
            { time: '14.00 - 16.30', code: 'MBS229', name: 'Akuntansi Keuangan Syariah', sks: 3, dosen: 'Siti Nur Azizatul Lutfiyah, S.E., M.E.', room: '203', id: 'aks' }
        ]},
        { day: 'Jumat', items: [
            { time: '08.00 - 10.30', code: 'MBS232', name: 'Ekonomi Makro dan Mikro', sks: 3, dosen: 'Hamim, S.E., M.E.', room: '202', id: 'emm' }
        ]}
    ];

    const STATE = {
        currentUser: null, isDark: true, currentCourse: null,
        screen: 'loading', dashboardTab: 'kelas',
        chats: {}, assignments: {}, unsubscribers: {},
        isLoading: false, isRecording: false, recordingTimer: null, recordingSeconds: 0, audioChunks: [], mediaRecorder: null,
        pinnedMessage: null, currentAsgAttachment: null
    };

    function showToast(msg, type = 'success') {
        const bgColor = type === 'error' ? '#ef4444' : type === 'warning' ? '#f59e0b' : '#22c55e';
        const toast = document.createElement('div');
        toast.className = 'animate-fade fixed top-4 right-4 z-[3000] px-5 py-3 rounded-xl text-sm font-medium shadow-lg text-white';
        toast.style.background = bgColor;
        toast.textContent = msg;
        document.body.appendChild(toast);
        setTimeout(() => { toast.style.opacity = '0'; setTimeout(() => toast.remove(), 300); }, 2500);
    }

    function formatTime(date) { const d = date?.toDate ? date.toDate() : new Date(date); return isNaN(d) ? '' : d.toLocaleTimeString('id', { hour: '2-digit', minute: '2-digit' }); }
    function formatDate(date) { const d = date?.toDate ? date.toDate() : new Date(date); return isNaN(d) ? '' : d.toLocaleDateString('id', { year: 'numeric', month: 'long', day: 'numeric' }); }

    function formatChatDateBadge(ts) {
        if (!ts) return "Hari Ini";
        const d = ts.toDate ? ts.toDate() : new Date(ts); const now = new Date();
        const dDate = new Date(d.getFullYear(), d.getMonth(), d.getDate()); const nDate = new Date(now.getFullYear(), now.getMonth(), now.getDate());
        const diffDays = Math.round((nDate - dDate) / (1000 * 60 * 60 * 24));
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        if (diffDays === 0) return "Hari Ini"; if (diffDays === 1) return "Kemarin";
        if (diffDays > 1 && diffDays < 7) return days[d.getDay()];
        return `${d.getDate()} ${months[d.getMonth()]} ${d.getFullYear()}`;
    }
    function formatRecTime(s) { return `${Math.floor(s/60)}:${(s%60).toString().padStart(2,'0')}`; }

    function toggleTheme() { STATE.isDark = !STATE.isDark; document.documentElement.classList.toggle('light', !STATE.isDark); renderFull(); }
    function openSidebar() { document.getElementById('sidebar').classList.add('sidebar-open'); document.getElementById('sidebar-overlay').classList.add('overlay-open'); }
    function closeSidebar() { document.getElementById('sidebar').classList.remove('sidebar-open'); document.getElementById('sidebar-overlay').classList.remove('overlay-open'); }
    function switchTab(tabName) { STATE.dashboardTab = tabName; closeSidebar(); renderDashboardContent(); }

    function renderFull() {
        const el = document.getElementById('app');
        if (!el) return;
        if (STATE.screen === 'loading') el.innerHTML = `<div class="h-full flex items-center justify-center font-bold text-xl text-[color:var(--text)]">Memuat...</div>`;
        else if (STATE.screen === 'login') renderLogin(el);
        else if (STATE.screen === 'dashboard') renderDashboardLayout(el);
        else if (STATE.screen === 'course') renderCourse(el);
        lucide.createIcons();
    }

    function setupChatListener(courseId) {
        if (STATE.unsubscribers[`chat_${courseId}`]) STATE.unsubscribers[`chat_${courseId}`]();
        STATE.unsubscribers[`chat_${courseId}`] = db.collection('courses').doc(courseId).collection('chats').orderBy('timestamp', 'asc').limit(150).onSnapshot(snapshot => {
            STATE.chats[courseId] = snapshot.docs.map(doc => ({ id: doc.id, ...doc.data() })); renderMessagesOnly();
        });
    }
    function setupCourseDocumentListener(courseId) {
        if (STATE.unsubscribers[`doc_${courseId}`]) STATE.unsubscribers[`doc_${courseId}`]();
        STATE.unsubscribers[`doc_${courseId}`] = db.collection('courses').doc(courseId).onSnapshot(doc => {
            STATE.pinnedMessage = doc.exists ? doc.data().pinnedMessage : null; renderPinnedOnly();
        });
    }

    // ========== LOGIKA PRIVASI TUGAS ==========
    function setupAssignmentListener(courseId) {
        if (STATE.unsubscribers[`assign_${courseId}`]) STATE.unsubscribers[`assign_${courseId}`]();
        STATE.unsubscribers[`assign_${courseId}`] = db.collection('courses').doc(courseId).collection('assignments').orderBy('createdAt', 'desc').onSnapshot(snapshot => {
            const allAsg = snapshot.docs.map(doc => ({ id: doc.id, courseId: courseId, ...doc.data() }));
            STATE.assignments[courseId] = allAsg.filter(a => {
                const myRole = STATE.currentUser?.role || 'mahasiswa';
                const myUid = STATE.currentUser?.uid;
                if (myRole === 'admin' || myRole === 'dosen') return true;
                return (a.createdByRole === 'admin' || a.createdByRole === 'dosen' || a.createdBy === myUid);
            });
            if(STATE.dashboardTab === 'kelas') renderDashboardContent();
            if(STATE.screen === 'course') renderPinnedOnly();
        });
    }

    auth.onAuthStateChanged(async (user) => {
        if (user) {
            try {
                const userDoc = await db.collection('users').doc(user.uid).get(); const userData = userDoc.exists ? userDoc.data() : {};
                STATE.currentUser = { uid: user.uid, email: user.email, nim: userData.nim, displayName: user.displayName || userData.displayName || 'User', photoURL: user.photoURL || userData.photoURL, role: userData.role || 'user', joined: user.metadata?.creationTime };
                STATE.screen = 'dashboard'; STATE.dashboardTab = 'home';
                COURSES.forEach(c => setupAssignmentListener(c.id));
            } catch (e) { STATE.screen = 'login'; }
        } else { STATE.currentUser = null; STATE.screen = 'login'; }
        renderFull();
    });
    
        // ========== LOGIKA DAFTAR (SIGNUP) + VERIFIKASI EMAIL ==========
    window.doLogin = async function() {
    const nim = document.getElementById('login-nim').value;
    const password = document.getElementById('login-password').value;

    if(!nim || !password) return showToast('Harap isi NIM dan Password!', 'error');
    showToast("Sedang memverifikasi...", "warning");

    try {
        const snapshot = await db.collection("users").where("nim", "==", nim).limit(1).get();
        if (snapshot.empty) return showToast("NIM tidak terdaftar!", "error");

        let emailAsli = "";
        snapshot.forEach((doc) => { emailAsli = doc.data().email; });

        const userCredential = await auth.signInWithEmailAndPassword(emailAsli, password);
        const user = userCredential.user;

        // CEK APAKAH EMAIL SUDAH DIVERIFIKASI
        if (!user.emailVerified) {
            await auth.signOut(); // Paksa keluar lagi
            return showToast("Akun belum aktif! Silakan buka email Anda dan klik link verifikasi.", "error");
        }

        showToast("Login Berhasil, Hai CEO!", "success");
    } catch (error) {
        showToast("Login Gagal! Pastikan password benar.", "error");
    }
};
    
    // ========== LOGIKA DAFTAR (SIGNUP) + POP-UP VERIFIKASI ==========
    window.doSignup = async function() {
        const nama = document.getElementById('signup-name').value;
        const nim = document.getElementById('signup-nim').value;
        const email = document.getElementById('signup-email').value;
        const password = document.getElementById('signup-password').value;
        const confirmPassword = document.getElementById('signup-confirm').value;

        // 1. Validasi Input
        const nimNumber = Number(nim);
        if (nim.length !== 13 || isNaN(nimNumber) || nimNumber < 2403806131001 || nimNumber > 2403806131050) {
            return showToast("Pendaftaran Gagal! NIM tidak valid/di luar rentang.", "error");
        }
        if (password !== confirmPassword) return showToast("Password tidak sama!", "error");
        if (!email) return showToast("Email wajib diisi!", "error");

        showToast("Memproses pendaftaran...", "warning");

        try {
            // 2. Cek apakah NIM sudah dipakai
            const checkNim = await db.collection("users").where("nim", "==", nim).get();
            if (!checkNim.empty) return showToast("NIM ini sudah terdaftar sebelumnya!", "error");

            // 3. Buat Akun & Kirim Email Verifikasi
            const res = await auth.createUserWithEmailAndPassword(email, password);
            await res.user.updateProfile({ displayName: nama });
            await res.user.sendEmailVerification();
            
            // 4. Simpan ke Firestore
            await db.collection('users').doc(res.user.uid).set({ 
                displayName: nama, nim: nim, email: email, photoURL: null, role: 'mahasiswa' 
            });

            // 5. Paksa Logout (Agar tidak bisa nyelonong masuk ke dashboard)
            await auth.signOut();

            // 6. Sembunyikan form daftar, kembalikan ke form login di latar belakang
            document.getElementById('signup-tab').classList.add('hidden');
            document.getElementById('login-tab').classList.remove('hidden');

            // 7. TAMPILKAN POP-UP PEMBERITAHUAN BESAR
            showGlobalModal(`
                <div class="glass p-8 text-center rounded-3xl border border-emerald-500/30 w-full animate-slide shadow-2xl relative overflow-hidden">
                    <div class="absolute -top-10 -right-10 w-32 h-32 bg-emerald-500/10 rounded-full blur-3xl"></div>
                    <div class="w-20 h-20 bg-emerald-500/20 rounded-3xl flex items-center justify-center mx-auto mb-5 border border-emerald-500/30 shadow-[0_0_15px_rgba(16,185,129,0.3)]">
                        <i data-lucide="mail-check" class="w-10 h-10 text-emerald-400"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-[color:var(--text)] mb-3 tracking-tight">Pendaftaran Sukses!</h3>
                    <p class="text-sm text-[color:var(--text2)] mb-8 leading-relaxed">
                        Link verifikasi telah dikirim ke email:<br>
                        <b class="text-[color:var(--text)]">${email}</b><br><br>
                        Silakan tutup halaman ini, buka aplikasi Email/Gmail Anda, cek kotak masuk atau folder <b class="text-orange-400">Spam</b>, lalu klik link tersebut untuk mengaktifkan akun.
                    </p>
                    <button onclick="closeGlobalModal()" class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-emerald-600/20 active:scale-95">
                        Siap, Saya Mengerti
                    </button>
                </div>
            `);

        } catch(err) { 
            showToast(err.message, 'error'); 
        }
    };

    // ========== LOGIKA LUPA PASSWORD (CEK NIM & EMAIL) ==========
    window.sendResetLink = async () => {
        const nim = document.getElementById('reset-nim-input').value; 
        const email = document.getElementById('reset-email-input').value; 
        
        if(!nim || !email) return showToast('NIM dan Email wajib diisi!', 'error'); 
        showToast('Memverifikasi data...', 'warning');

        try {
            // 1. Cek apakah NIM ada di database
            const snapshot = await db.collection("users").where("nim", "==", nim).limit(1).get();
            if (snapshot.empty) {
                return showToast('Gagal: NIM tidak terdaftar!', 'error');
            }

            // 2. Cocokkan email dari database dengan email yang diketik
            let emailAsli = "";
            snapshot.forEach((doc) => { emailAsli = doc.data().email; });

            if (emailAsli !== email) {
                return showToast('Gagal: Email tidak cocok dengan NIM tersebut!', 'error');
            }

            // 3. Jika cocok, jalankan fungsi Firebase kirim link reset
            await firebase.auth().sendPasswordResetEmail(email);
            
            // Ubah tampilan modal ke langkah sukses
            document.getElementById('reset-step-1').classList.add('hidden'); 
            const step2 = document.getElementById('reset-step-2');
            step2.classList.remove('hidden');
            step2.innerHTML = `
                <div class="text-center">
                    <h3 class="font-bold text-[color:var(--text)] mb-2">Email Terkirim! ✅</h3>
                    <p class="text-sm text-[color:var(--text2)]">Link pemulihan telah dikirim ke <b>${email}</b>.<br>Cek kotak masuk atau spam.</p>
                    <button onclick="document.getElementById('reset-modal').classList.remove('show')" class="mt-4 w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl transition-all font-medium">Tutup</button>
                </div>
            `;
            showToast('Email pemulihan berhasil dikirim!', 'success'); 
            
        } catch(error) { 
            showToast('Gagal: ' + error.message, 'error'); 
        }
    };
    
    window.doLogout = async function() { closeSidebar(); Object.values(STATE.unsubscribers).forEach(u => u()); STATE.unsubscribers = {}; await auth.signOut(); };
    window.openCourse = function(id) {
        STATE.currentCourse = COURSES.find(c => c.id === id);
        STATE.screen = 'course';
        setupChatListener(id); setupCourseDocumentListener(id); setupAssignmentListener(id); renderFull();
    };

    function showGlobalModal(html, isLarge = false) {
        const modal = document.getElementById('global-modal');
        const content = document.getElementById('modal-content');
        content.innerHTML = html; modal.classList.add('show');
        content.className = isLarge ? "w-full max-w-md mx-auto" : "w-full max-w-sm mx-auto";
        lucide.createIcons();
    }
    window.closeGlobalModal = function() { document.getElementById('global-modal').classList.remove('show'); setTimeout(() => { document.getElementById('modal-content').innerHTML = ''; }, 200); }
    document.getElementById('global-modal').addEventListener('click', e => { if (e.target.id === 'global-modal') closeGlobalModal(); });

    window.openChangePasswordModal = function() {
        closeSidebar();
        showGlobalModal(`<div class="glass p-6 rounded-3xl animate-slide w-full border border-[color:var(--border)]">
            <h3 class="font-bold text-center text-[color:var(--text)] mb-2 text-lg">Ganti Password</h3>
            <p class="text-xs text-[color:var(--text2)] text-center mb-6">Masukkan password baru untuk akun Anda.</p>
            <input type="password" id="new-password" placeholder="Password Baru (min. 6 karakter)" class="w-full text-sm p-3.5 rounded-xl bg-[color:var(--input-bg)] mb-4 text-[color:var(--text)] border border-[color:var(--border)] focus:border-[#2563eb] outline-none transition-colors">
            <button onclick="submitNewPassword()" class="w-full py-3.5 rounded-xl text-white font-bold bg-[#2563eb] active:scale-95 transition-transform shadow-lg shadow-blue-500/20">Simpan Password</button>
            <button onclick="closeGlobalModal()" class="w-full py-2.5 mt-2 rounded-xl text-[color:var(--text2)] font-bold hover:text-[color:var(--text)]">Batal</button>
        </div>`);
    }
    window.submitNewPassword = async function() {
        const newPass = document.getElementById('new-password').value;
        if(newPass.length < 6) return showToast('Password minimal 6 karakter', 'error');
        try { await auth.currentUser.updatePassword(newPass); showToast('Password berhasil diubah!'); closeGlobalModal();
        } catch(e) { if(e.code === 'auth/requires-recent-login') showToast('Sesi terlalu lama, silakan login ulang dulu', 'error');
        else showToast(e.message, 'error'); }
    }

    // ========== RENDER LOGIN & LUPA PASSWORD ==========
    function renderLogin(el) {
        el.innerHTML = `
        <div class="h-full flex items-center justify-center p-4">
            <div class="glass p-8 w-full max-w-sm animate-slide shadow-2xl border border-[color:var(--border)]">
                <div class="text-center mb-8"><div class="text-4xl mb-3">🎓</div><h1 class="text-2xl font-bold text-[color:var(--text)]">FunGrow</h1></div>
                <div id="login-tab" class="space-y-4">
                    <input type="number" id="login-nim" class="w-full p-3.5 rounded-xl bg-[color:var(--input-bg)] border border-[color:var(--border)] text-sm text-[color:var(--text)] outline-none focus:border-[#2563eb]" placeholder="NIM">
                    <input type="password" id="login-password" class="w-full p-3.5 rounded-xl bg-[color:var(--input-bg)] border border-[color:var(--border)] text-sm text-[color:var(--text)] outline-none focus:border-[#2563eb]" placeholder="Password">
                    <button onclick="doLogin()" class="w-full py-3.5 rounded-xl font-bold text-white bg-indigo-600 shadow-lg shadow-indigo-600/20 active:scale-95 transition-transform">Masuk</button>
                    <div class="flex justify-between items-center mt-4">
                        <button onclick="openForgotPasswordModal()" class="text-xs text-orange-400 font-medium hover:text-orange-300 transition-colors underline">Lupa Password?</button>
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

    // ========== DASHBOARD LAYOUT & TABS ==========
    function renderDashboardLayout(el) {
        const photo = STATE.currentUser?.photoURL ? `<img src="${STATE.currentUser.photoURL}" class="w-8 h-8 rounded-full object-cover border border-[color:var(--border)]">` : `<div class="w-8 h-8 rounded-full flex items-center justify-center font-bold bg-[#2563eb] text-white">${STATE.currentUser?.displayName?.[0]?.toUpperCase()}</div>`;
        el.innerHTML = `
        <div class="h-full flex flex-col relative overflow-hidden">
            <header class="glass flex items-center justify-between px-4 py-3 mx-3 mt-3 rounded-2xl z-30 shadow-sm backdrop-blur-xl">
                <div class="flex items-center gap-3">
                    <button onclick="openSidebar()" class="p-2 rounded-xl bg-[color:var(--card)] border border-[color:var(--border)] text-[color:var(--text)] active:scale-95 transition-transform"><i data-lucide="menu" class="w-5 h-5"></i></button>
                    <div class="font-bold text-[color:var(--text)] flex items-center gap-2"><span class="text-xl">🎓</span> FunGrow</div>
                </div>
                <div class="flex items-center gap-3">
                    <button onclick="toggleTheme()" class="p-2 rounded-full bg-[color:var(--card)] text-[color:var(--text2)] border border-[color:var(--border)]"><i data-lucide="${STATE.isDark ? 'sun' : 'moon'}" class="w-4 h-4"></i></button>
                    <button onclick="switchTab('about')" class="shrink-0 active:scale-95 transition-transform">${photo}</button>
                </div>
            </header>
            <div id="dashboard-content" class="flex-1 overflow-auto pb-8 relative pt-2"></div>
        </div>`;
        renderDashboardContent();
    }
    function renderDashboardContent() {
        const container = document.getElementById('dashboard-content');
        if (!container) return;
        
        if (STATE.dashboardTab === 'home') {
            container.innerHTML = getHomeHTML();
            
            // Pemicu Pop-up Promo (Aman)
            setTimeout(() => {
                if (typeof window.showPromoModal === 'function') {
                    window.showPromoModal();
                }
            }, 1000); 
        } 
        else if (STATE.dashboardTab === 'kelas') {
            container.innerHTML = getKelasHTML();
            
            // Pemicu Banner Swiper (Aman)
            setTimeout(() => {
                if (typeof Swiper !== 'undefined') {
                    new Swiper('.banner-swiper', {
                        slidesPerView: 1,
                        spaceBetween: 0,
                        loop: true,
                        autoplay: { delay: 3500, disableOnInteraction: false },
                        pagination: { el: '.swiper-pagination', clickable: true }
                    });
                }
            }, 100);
        } 
            // DATA MAHASISWA:
        else if (STATE.dashboardTab === 'mahasiswa') {
            container.innerHTML = getDataMahasiswaHTML();
            // fungsi penarik data sesaat setelah HTML-nya dimuat
            setTimeout(() => {
                loadDataMahasiswa();
            }, 50);
        }
        else if (STATE.dashboardTab === 'jadwal') {
            container.innerHTML = getJadwalHTML();
        } 
        else if (STATE.dashboardTab === 'about') {
            container.innerHTML = getAboutHTML();
        }
        
        lucide.createIcons();
    } 
        function getHomeHTML() {
        return `
            <div class="space-y-5 animate-fade px-4 py-2">
                
                <div class="flex items-center justify-between glass p-5 rounded-3xl border border-[color:var(--border)] shadow-[0_10px_30px_rgba(37,99,235,0.1)]">
                    <div>
                        <p class="text-sm text-[color:var(--text2)] mb-0.5">Selamat datang kembali,</p>
                        <h2 class="text-xl font-bold text-[color:var(--text)]">Hai, ${STATE.currentUser?.displayName?.split(' ')[0] || 'Siswa'}! 👋</h2>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-xl shadow-lg border-2 border-white/20">
                        ${STATE.currentUser?.displayName?.charAt(0).toUpperCase() || 'S'}
                    </div>
                </div>

                <div class="swiper banner-swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="glass rounded-3xl overflow-hidden shadow-lg border border-[color:var(--border)] relative aspect-[16/9] group">
                                <img src="https://images.unsplash.com/photo-1501504905252-473c47e087f8?auto=format&fit=crop&q=80&w=800&h=450" class="absolute inset-0 w-full h-full object-cover">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="glass rounded-3xl overflow-hidden shadow-lg border border-[color:var(--border)] relative aspect-[16/9] group">
                                <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&q=80&w=800&h=450" class="absolute inset-0 w-full h-full object-cover">
                            </div>
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="glass p-5 rounded-3xl border border-[color:var(--border)] flex flex-col items-center justify-center text-center hover:scale-105 transition-transform cursor-pointer">
                        <div class="w-12 h-12 rounded-full bg-orange-500/20 text-orange-500 flex items-center justify-center mb-3">
                            <i data-lucide="flame" class="w-6 h-6"></i>
                        </div>
                        <h3 class="font-extrabold text-[color:var(--text)] text-2xl mb-1">0</h3>
                        <p class="text-xs text-[color:var(--text2)] font-medium">Tugas Mendesak</p>
                    </div>
                    
                    <div class="glass p-5 rounded-3xl border border-[color:var(--border)] flex flex-col items-center justify-center text-center hover:scale-105 transition-transform cursor-pointer">
                        <div class="w-12 h-12 rounded-full bg-blue-500/20 text-blue-500 flex items-center justify-center mb-3">
                            <i data-lucide="book-open" class="w-6 h-6"></i>
                        </div>
                        <h3 class="font-extrabold text-[color:var(--text)] text-2xl mb-1">6</h3>
                        <p class="text-xs text-[color:var(--text2)] font-medium">Total Modul</p>
                    </div>
                </div>
                
            </div>
        `;
    }

    function getKelasHTML() {
        const currentDayIndex = new Date().getDay();
        const dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const todayName = dayNames[currentDayIndex];
        const todaysSchedule = FULL_SCHEDULE.find(s => s.day === todayName)?.items || [];

        let allAsg = Object.values(STATE.assignments).flat().sort((a,b) => a.deadline - b.deadline);
        let scheduleHTML = '';
        if (todaysSchedule.length === 0) {
            scheduleHTML = `<div class="glass p-4 rounded-2xl flex items-center gap-4 border border-dashed border-[color:var(--border)]">
                <div class="w-12 h-12 rounded-full bg-emerald-500/10 flex items-center justify-center shrink-0"><i data-lucide="coffee" class="w-6 h-6 text-emerald-500"></i></div>
                <div><p class="text-sm font-bold text-[color:var(--text)]">Tidak ada kelas hari ini</p><p class="text-[10px] text-[color:var(--text2)] mt-0.5">Waktunya istirahat atau nugas mandiri.</p></div>
            </div>`;
        } else {
            scheduleHTML = todaysSchedule.map((c, index) => `
                <div onclick="openCourse('${c.id}')" class="glass p-3.5 rounded-2xl flex items-center gap-4 border border-[color:var(--border)] relative overflow-hidden cursor-pointer active:scale-95 transition-transform mb-3 hover:bg-[color:var(--card)] shadow-sm">
                    ${index === 0 ? `<div class="absolute left-0 top-0 bottom-0 w-1 bg-[#2563eb]"></div>` : ''}
                    <div class="w-14 h-14 rounded-xl bg-[color:var(--card)] flex flex-col items-center justify-center shrink-0 border border-[color:var(--border)]">
                        <span class="text-[11px] font-bold text-[color:var(--text)]">${c.time.split(' - ')[0]}</span>
                        <span class="text-[8px] text-[color:var(--text2)]">${c.time.split(' - ')[1]}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-bold text-[13px] text-[color:var(--text)] truncate">${c.name}</h4>
                        <div class="flex items-center gap-1.5 mt-1"><i data-lucide="map-pin" class="w-3 h-3 text-[#2563eb]"></i><span class="text-[10px] text-[color:var(--text2)] font-medium">Ruang ${c.room}</span></div>
                    </div>
                    <i data-lucide="chevron-right" class="w-5 h-5 text-[color:var(--text2)] opacity-50 shrink-0"></i>
                </div>
            `).join('');
        }

        return `
                    <div class="swiper banner-swiper mt-2 animate-fade">
                <div class="swiper-wrapper">
                    
                    <div class="swiper-slide px-4">
                        <div class="glass rounded-3xl overflow-hidden shadow-[0_15px_30px_rgba(37,99,235,0.2)] border border-[color:var(--border)] relative aspect-[16/9] flex items-center justify-center group cursor-pointer active:scale-95 transition-transform">
                            <img src="https://images.unsplash.com/photo-1501504905252-473c47e087f8?auto=format&fit=crop&q=80&w=800&h=450">
                        </div>
                    </div>

                    <div class="swiper-slide px-4">
                        <div class="glass rounded-3xl overflow-hidden shadow-[0_15px_30px_rgba(168,85,247,0.2)] border border-[color:var(--border)] relative aspect-[16/9] flex items-center justify-center group cursor-pointer active:scale-95 transition-transform">
                            <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&q=80&w=800&h=450">
                        </div>
                    </div>

                    <div class="swiper-slide px-4">
                        <div class="glass rounded-3xl overflow-hidden shadow-[0_15px_30px_rgba(16,185,129,0.2)] border border-[color:var(--border)] relative aspect-[16/9] flex items-center justify-center group cursor-pointer active:scale-95 transition-transform">
                            <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&q=80&w=800&h=450">
                        </div>
                    </div>

                </div>
                <div class="swiper-pagination"></div>
            </div>
                <i data-lucide="book-open" class="absolute -right-4 -bottom-4 w-32 h-32 text-white opacity-10 transform -rotate-12"></i>
            </div>
            <div class="px-4 mt-6">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-sm font-bold text-[color:var(--text)] flex items-center gap-2"><i data-lucide="calendar-clock" class="w-4 h-4 text-[#2563eb]"></i> Jadwal Hari Ini</h3>
                    <span class="text-[9px] font-bold text-[#2563eb] bg-blue-500/10 px-2 py-1 rounded-md tracking-wider uppercase border border-blue-500/20">${todayName}</span>
                </div>
                <div>${scheduleHTML}</div>
            </div>
            <div class="px-4 mt-5">
                <h3 class="text-sm font-bold text-[color:var(--text)] flex items-center gap-2 mb-3"><i data-lucide="flame" class="w-4 h-4 text-orange-500"></i> Deadline Terdekat</h3>
                <div class="flex gap-3 overflow-x-auto pb-4 snap-x hide-scrollbar">
                    ${allAsg.length > 0 ? allAsg.map(a => `
                        <div class="snap-start shrink-0 w-[240px] glass p-4 rounded-2xl border border-red-500/30 shadow-[0_4px_20px_rgba(239,68,68,0.08)] relative overflow-hidden flex flex-col justify-between h-[130px]">
                            <div class="absolute -top-6 -right-6 w-16 h-16 bg-red-500/20 rounded-full blur-xl"></div>
                            <div class="z-10">
                                <div class="flex items-center gap-2 mb-2"><span class="px-2 py-0.5 rounded-md bg-red-500/10 text-red-500 text-[9px] font-bold uppercase tracking-wider border border-red-500/20">DEADLINE</span></div>
                                <h4 class="text-sm font-bold text-[color:var(--text)] mb-1 line-clamp-1">${a.title}</h4>
                                <p class="text-[10px] text-[color:var(--text2)] truncate">${COURSES.find(c=>c.id===a.courseId)?.name || ''}</p>
                            </div>
                            <div class="text-[10px] font-bold text-orange-400 z-10 flex items-center gap-1 mt-2">
                                <i data-lucide="clock" class="w-3 h-3"></i> ${formatDate(a.deadline)}
                            </div>
                        </div>`).join('') : `<p class="text-[10px] text-[color:var(--text2)] italic px-2">Tidak ada tugas dalam waktu dekat.</p>`}
                </div>
            </div>
            <div class="px-4 mt-2">
                <h3 class="text-sm font-bold text-[color:var(--text)] flex items-center gap-2 mb-3"><i data-lucide="layout-grid" class="w-4 h-4 text-[#2563eb]"></i> Semua Kelas</h3>
                <div class="grid grid-cols-2 gap-3">
                    ${COURSES.map(c => `
                        <div onclick="openCourse('${c.id}')" class="glass p-3.5 rounded-2xl flex flex-col gap-3 cursor-pointer active:scale-95 transition-transform border border-[color:var(--border)] relative overflow-hidden hover:bg-[color:var(--card)] shadow-sm">
                            <div class="w-10 h-10 rounded-xl bg-[color:var(--card)] border border-[color:var(--border)] flex items-center justify-center text-xl shrink-0">${c.icon}</div>
                            <div><h4 class="font-bold text-[11px] text-[color:var(--text)] line-clamp-2 leading-snug">${c.name}</h4></div>
                            <div class="absolute right-3 top-4"><i data-lucide="arrow-up-right" class="w-3.5 h-3.5 text-[color:var(--text2)] opacity-40"></i></div>
                        </div>
                    `).join('')}
                </div>
            </div>
        </div>`;
    }

    function getJadwalHTML() {
        const scheduleList = FULL_SCHEDULE.map(dayObj => `
            <div class="mb-6">
                <div class="flex items-center gap-3 mb-3">
                    <div class="h-px bg-[color:var(--border)] flex-1"></div>
                    <h3 class="text-xs font-bold text-[#2563eb] tracking-wider uppercase">${dayObj.day}</h3>
                    <div class="h-px bg-[color:var(--border)] flex-1"></div>
                </div>
                <div class="space-y-3">
                    ${dayObj.items.map(c => `
                        <div class="glass p-4 rounded-2xl border border-[color:var(--border)] shadow-sm relative overflow-hidden group">
                            <div class="absolute top-0 left-0 w-1.5 h-full bg-[#2563eb] opacity-80"></div>
                            <div class="flex justify-between items-start mb-2 pl-2">
                                <div>
                                    <h4 class="font-bold text-sm text-[color:var(--text)] leading-tight mb-1">${c.name}</h4>
                                    <p class="text-[10px] font-mono text-[color:var(--text2)] bg-[color:var(--card)] inline-block px-1.5 py-0.5 rounded border border-[color:var(--border)]">${c.code}</p>
                                </div>
                                <span class="text-[11px] font-bold text-[#2563eb] bg-blue-500/10 px-2 py-1 rounded-lg border border-blue-500/20 shrink-0">${c.time}</span>
                            </div>
                            <div class="pl-2 mt-3 flex flex-col gap-1.5">
                                <div class="flex items-center gap-2"><i data-lucide="user" class="w-3.5 h-3.5 text-[color:var(--text2)]"></i><span class="text-[11px] text-[color:var(--text)]">${c.dosen}</span></div>
                                <div class="flex items-center gap-4">
                                    <div class="flex items-center gap-2"><i data-lucide="door-open" class="w-3.5 h-3.5 text-emerald-500"></i><span class="text-[11px] text-[color:var(--text)] font-medium">Ruang ${c.room}</span></div>
                                    <div class="flex items-center gap-2"><i data-lucide="book-copy" class="w-3.5 h-3.5 text-orange-500"></i><span class="text-[11px] text-[color:var(--text)] font-medium">${c.sks} SKS</span></div>
                                </div>
                            </div>
                        </div>
                    `).join('')}
                </div>
            </div>
        `).join('');
        return `
        <div class="animate-fade px-4 py-2">
            <h2 class="text-lg font-bold text-[color:var(--text)] mb-1">Jadwal Perkuliahan</h2>
            <p class="text-xs text-[color:var(--text2)] mb-6">SEMESTER IV (EMPAT)</p>
            ${scheduleList}
        </div>`;
    }
    
    // ==========================================
    // TAMPILAN HALAMAN DATA MAHASISWA
    // ==========================================
    window.getDataMahasiswaHTML = function() {
        return `
            <div class="animate-fade px-4 py-2 space-y-4">
                <div class="glass p-5 rounded-3xl border border-[color:var(--border)] shadow-[0_10px_30px_rgba(37,99,235,0.1)] flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-bold text-[color:var(--text)] mb-1">Data Mahasiswa</h2>
                        <p class="text-xs text-[color:var(--text2)]">Daftar pengguna terdaftar di sistem FunGrow</p>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-indigo-500/20 text-indigo-500 flex items-center justify-center border border-indigo-500/30">
                        <i data-lucide="users" class="w-6 h-6"></i>
                    </div>
                </div>
                
                <div id="wadah-data-mahasiswa" class="space-y-3 pb-10">
                    <div class="text-center py-10 text-[color:var(--text2)] flex flex-col items-center">
                        <i data-lucide="loader-2" class="w-8 h-8 animate-spin mb-3 text-indigo-500"></i>
                        <p class="text-sm font-medium">Memuat data dari Firebase...</p>
                    </div>
                </div>
            </div>
        `;
    };
    // ==========================================
    // LOGIKA TARIK DATA MAHASISWA DARI FIREBASE
    // ==========================================
    window.loadDataMahasiswa = async function() {
        const wadah = document.getElementById('wadah-data-mahasiswa');
        if (!wadah) return;

        try {
            const snapshot = await db.collection('users').get();
            
            if (snapshot.empty) {
                wadah.innerHTML = `<div class="glass p-5 text-center rounded-2xl text-[color:var(--text2)]">Belum ada data mahasiswa terdaftar.</div>`;
                return;
            }

            let html = '';
            
            // Sediakan wadah memori lokal (Cukup tulis SEKALI di sini, di luar loop)
            window.cachedMahasiswa = window.cachedMahasiswa || {};
            
            // Lakukan Looping SEKALI saja
            snapshot.forEach(doc => {
                const user = doc.data();
                window.cachedMahasiswa[doc.id] = user; // Simpan ke memori
                
                const nama = user.displayName || user.name || 'Tanpa Nama';
                const nim = user.nim || 'NIM Tidak Ada';
                const email = user.email || 'Email Tidak Ada';
                const role = user.role || 'mahasiswa';
                const inisial = nama.charAt(0).toUpperCase();
                
                html += `
                    <div class="glass p-4 rounded-2xl border border-[color:var(--border)] flex items-center gap-4 hover:scale-[1.02] hover:shadow-lg transition-all duration-300">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex-shrink-0 flex items-center justify-center text-white font-bold text-lg shadow-md border-2 border-white/20">
                            ${inisial}
                        </div>
                        <div class="flex-1 overflow-hidden">
                            <h3 class="font-bold text-[color:var(--text)] truncate text-base">${nama}</h3>
                            <div class="flex items-center gap-2 text-[10px] sm:text-xs mt-1">
                                <span class="bg-[color:var(--surface)] text-[color:var(--text)] px-2 py-1 rounded-md font-bold border border-[color:var(--border)] shadow-sm">${nim}</span>
                                <span class="text-[color:var(--text2)] truncate">${email}</span>
                            </div>
                        </div>
                        
                        <div class="flex flex-col items-end gap-1.5">
                            <button onclick="lihatDetailMahasiswa('${doc.id}')" class="text-[9px] font-bold px-3 py-1 rounded-full bg-blue-500/10 text-blue-500 hover:bg-blue-500 hover:text-white transition-colors border border-blue-500/30">
                                LIHAT DETAIL
                            </button>
                            <div class="text-[9px] font-bold px-3 py-1 rounded-full uppercase tracking-wider ${role === 'admin' ? 'bg-orange-500/20 text-orange-500 border border-orange-500/30' : 'bg-emerald-500/20 text-emerald-500 border border-emerald-500/30'}">
                                ${role}
                            </div>
                        </div>
                    </div>
                `;
            });

            wadah.innerHTML = html;
            lucide.createIcons(); 

        } catch (error) {
            console.error("Error mengambil data mahasiswa:", error);
            wadah.innerHTML = `<div class="glass p-5 text-center rounded-2xl text-red-400 border-red-500/30">Gagal memuat data: ${error.message}</div>`;
        }
    };
        // ==========================================
    // LOGIKA MODAL POP-UP DETAIL MAHASISWA
    // ==========================================
    window.lihatDetailMahasiswa = function(uid) {
        const user = window.cachedMahasiswa[uid];
        if(!user) return showToast("Data tidak ditemukan!", "error");

        const nama = user.displayName || user.name || 'Tanpa Nama';
        const inisial = nama.charAt(0).toUpperCase();

        const htmlModal = `
            <div class="glass p-6 rounded-3xl animate-slide w-full max-w-sm mx-auto border border-[color:var(--border)] text-left relative overflow-hidden shadow-2xl">
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-indigo-500/20 rounded-full blur-3xl"></div>

                <div class="flex items-center gap-4 border-b border-[color:var(--border)] pb-4 mb-4 relative z-10">
                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-3xl shadow-lg border-2 border-white/20 flex-shrink-0">
                        ${inisial}
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-[color:var(--text)] leading-tight">${nama}</h2>
                        <p class="text-xs font-mono text-[color:var(--text2)] mt-0.5">${user.nim || 'NIM Kosong'}</p>
                        <span class="text-[9px] font-bold px-2 py-0.5 rounded-md mt-1 inline-block ${user.role === 'admin' ? 'bg-orange-500/20 text-orange-500' : 'bg-emerald-500/20 text-emerald-500'} uppercase">${user.role || 'Mahasiswa'}</span>
                    </div>
                </div>

                <div class="space-y-3 relative z-10">
                    <div>
                        <p class="text-[9px] uppercase text-[color:var(--text2)] font-bold tracking-wider">Email Terdaftar</p>
                        <p class="text-sm text-[color:var(--text)] font-medium">${user.email || '-'}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <p class="text-[9px] uppercase text-[color:var(--text2)] font-bold tracking-wider">Fakultas</p>
                            <p class="text-sm text-[color:var(--text)] font-medium truncate">${user.fakultas || '<span class="italic text-gray-500">Belum diisi</span>'}</p>
                        </div>
                        <div>
                            <p class="text-[9px] uppercase text-[color:var(--text2)] font-bold tracking-wider">Program Studi</p>
                            <p class="text-sm text-[color:var(--text)] font-medium truncate">${user.prodi || '<span class="italic text-gray-500">Belum diisi</span>'}</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-[9px] uppercase text-[color:var(--text2)] font-bold tracking-wider">Tanggal Lahir</p>
                        <p class="text-sm text-[color:var(--text)] font-medium">${user.tglLahir || '<span class="italic text-gray-500">Belum diisi</span>'}</p>
                    </div>
                    <div>
                        <p class="text-[9px] uppercase text-[color:var(--text2)] font-bold tracking-wider">Alamat Lengkap</p>
                        <p class="text-sm text-[color:var(--text)] font-medium leading-relaxed bg-[color:var(--surface)] p-2 rounded-xl mt-1 border border-[color:var(--border)]">${user.alamat || '<span class="italic text-gray-500">Belum diisi</span>'}</p>
                    </div>
                </div>

                <button onclick="closeGlobalModal()" class="w-full mt-6 py-2.5 rounded-xl bg-[color:var(--surface)] text-[color:var(--text)] font-bold border border-[color:var(--border)] hover:bg-red-500/10 hover:text-red-500 hover:border-red-500/30 transition-all relative z-10">
                    Tutup Profil
                </button>
            </div>
        `;
        
        showGlobalModal(htmlModal);
    };
    
    // ==========================================
    // HALAMAN PROFIL AKADEMIK (DENGAN FITUR FOTO)
    // ==========================================
    window.getAboutHTML = function() {
        const user = STATE.currentUser || {};
        
        // Tentukan gambar profil (pakai foto asli atau inisial jika kosong)
        const photoContent = user.photoURL ? 
            `<img src="${user.photoURL}" class="w-full h-full object-cover rounded-full" id="prof-photo-img">` :
            `<div class="w-full h-full rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-2xl border-2 border-white/20" id="prof-photo-initial">
                ${user.displayName ? user.displayName.charAt(0).toUpperCase() : 'M'}
            </div>`;

        return `
        <div class="animate-fade px-4 py-2 space-y-4 pb-20">
            <div class="glass p-5 rounded-3xl border border-[color:var(--border)] shadow-[0_10px_30px_rgba(37,99,235,0.1)] flex items-center gap-4">
                
                <div class="relative group cursor-pointer flex-shrink-0" onclick="pilihFotoProfil()">
                    <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-indigo-500/50 group-hover:border-indigo-500 transition-colors">
                        ${photoContent}
                    </div>
                    <div class="absolute inset-0 rounded-full bg-black/50 flex items-center justify-center text-white opacity-0 group-hover:opacity-100 transition-opacity">
                        <i data-lucide="camera" class="w-5 h-5"></i>
                    </div>
                </div>

                <div>
                    <h2 class="text-xl font-bold text-[color:var(--text)]">Profil Akademik</h2>
                    <p class="text-xs text-[color:var(--text2)]">Ketuk foto untuk mengubahnya</p>
                </div>
            </div>

            <input type="file" id="input-foto-profil" accept="image/*" class="hidden" onchange="handleFileSelect(this)">

            <div class="glass p-6 rounded-3xl border border-[color:var(--border)] relative">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-[10px] font-bold text-[color:var(--text2)] uppercase tracking-wider">Nama Lengkap</label>
                        <input type="text" id="prof-nama" value="${user.displayName || ''}" class="w-full mt-1 p-3 rounded-xl bg-[color:var(--input-bg)] border border-[color:var(--border)] text-[color:var(--text)] font-medium" disabled>
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-[color:var(--text2)] uppercase tracking-wider">NIM / Nomor Induk</label>
                        <input type="text" id="prof-nim" value="${user.nim || ''}" class="w-full mt-1 p-3 rounded-xl bg-[color:var(--input-bg)] border border-[color:var(--border)] text-[color:var(--text)] opacity-70 cursor-not-allowed" disabled>
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-[color:var(--text2)] uppercase tracking-wider">Akun Email (Gmail)</label>
                        <input type="text" id="prof-email" value="${user.email || ''}" class="w-full mt-1 p-3 rounded-xl bg-[color:var(--input-bg)] border border-[color:var(--border)] text-[color:var(--text)] opacity-70 cursor-not-allowed" disabled>
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-[color:var(--text2)] uppercase tracking-wider">Tanggal Lahir</label>
                        <input type="date" id="prof-tglLahir" value="${user.tglLahir || ''}" class="w-full mt-1 p-3 rounded-xl bg-[color:var(--input-bg)] border border-[color:var(--border)] text-[color:var(--text)] prof-input" disabled>
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-[color:var(--text2)] uppercase tracking-wider">Fakultas</label>
                        <input type="text" id="prof-fakultas" value="${user.fakultas || ''}" class="w-full mt-1 p-3 rounded-xl bg-[color:var(--input-bg)] border border-[color:var(--border)] text-[color:var(--text)] prof-input" disabled>
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-[color:var(--text2)] uppercase tracking-wider">Program Studi</label>
                        <input type="text" id="prof-prodi" value="${user.prodi || ''}" class="w-full mt-1 p-3 rounded-xl bg-[color:var(--input-bg)] border border-[color:var(--border)] text-[color:var(--text)] prof-input" disabled>
                    </div>
                    <div class="md:col-span-2 mt-2">
                        <label class="text-[10px] font-bold text-[color:var(--text2)] uppercase tracking-wider">Alamat Lengkap</label>
                        <textarea id="prof-alamat" rows="2" class="w-full mt-1 p-3 rounded-xl bg-[color:var(--input-bg)] border border-[color:var(--border)] text-[color:var(--text)] prof-input resize-none" disabled>${user.alamat || ''}</textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-8 pt-5 border-t border-[color:var(--border)]">
                    <button id="btn-edit-prof" onclick="toggleEditProfil()" class="px-5 py-2.5 rounded-xl font-bold bg-[color:var(--surface)] text-[color:var(--text)] border border-[color:var(--border)] hover:bg-indigo-500/10 hover:text-indigo-500 transition-all flex items-center gap-2">
                        <i data-lucide="edit-3" class="w-4 h-4"></i> Edit Profil
                        <div id="loading-change-password" class="w-4 h-4 rounded-full border-2 border-indigo-500 border-t-transparent animate-spin hidden"></div>
                    </button>
                    <button id="btn-save-prof" onclick="simpanProfil()" class="px-6 py-2.5 rounded-xl font-bold bg-indigo-600 text-white shadow-lg hidden hover:bg-indigo-700 hover:scale-105 transition-all flex items-center gap-2">
                        <i data-lucide="save" class="w-4 h-4"></i> Simpan Pembaruan
                    </button>
                </div>
            </div>
        </div>
        `;
    };

    // LOGIKA TOMBOL EDIT PROFIL
    window.toggleEditProfil = function() {
        const inputs = document.querySelectorAll('.prof-input, #prof-nama');
        const isEditing = !inputs[0].disabled;

        if(!isEditing) {
            // Buka gembok form
            inputs.forEach(i => i.disabled = false);
            document.getElementById('prof-nama').focus();
            
            // Ubah tombol Edit jadi Batal
            const btnEdit = document.getElementById('btn-edit-prof');
            btnEdit.innerHTML = '<i data-lucide="x" class="w-4 h-4"></i> Batal Edit';
            btnEdit.classList.replace('hover:text-indigo-500', 'hover:text-red-500');
            
            // Munculkan tombol Simpan
            document.getElementById('btn-save-prof').classList.remove('hidden');
            lucide.createIcons();
        } else {
            // Jika Batal, render ulang halaman ke awal
            document.getElementById('dashboard-content').innerHTML = getAboutHTML();
            lucide.createIcons();
        }
    };

    // LOGIKA SIMPAN KE FIREBASE
    window.simpanProfil = async function() {
        const btnSave = document.getElementById('btn-save-prof');
        btnSave.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i> Menyimpan...';
        btnSave.disabled = true;

        try {
            // 1. Ambil data dari input
            const newData = {
                displayName: document.getElementById('prof-nama').value,
                tglLahir: document.getElementById('prof-tglLahir').value, 
                fakultas: document.getElementById('prof-fakultas').value,
                prodi: document.getElementById('prof-prodi').value,
                alamat: document.getElementById('prof-alamat').value,
            };

            // 2. Simpan ke Firebase (Awan)
            await db.collection('users').doc(STATE.currentUser.uid).update(newData);

            // 3. Sinkronkan Memori Lokal
            STATE.currentUser = { ...STATE.currentUser, ...newData };

            showToast("Profil berhasil diperbarui!", "success");

            // 4. Render ulang tampilan
            document.getElementById('dashboard-content').innerHTML = getAboutHTML();
            lucide.createIcons();

        } catch (error) {
            showToast("Gagal menyimpan: " + error.message, "error");
            btnSave.innerHTML = '<i data-lucide="save" class="w-4 h-4"></i> Simpan Pembaruan';
            btnSave.disabled = false;
        }
    }; 

    // ==========================================
    // LOGIKA GANTI & PANGKAS FOTO PROFIL (JURUS UTAMA)
    // ==========================================
    let cropper = null; // Memori global untuk pemangkas

    // 1. Trigger saat foto diklik
    window.pilihFotoProfil = function() {
        document.getElementById('input-foto-profil').click();
    };

    // 2. Saat file terpilih, tampilkan Pop-up Pemangkas
    window.handleFileSelect = function(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Desain Pop-up Modal Khusus Pemangkas (WhatsApp Style)
                const htmlModal = `
                    <div class="glass p-5 rounded-3xl animate-slide w-full max-w-sm mx-auto border border-[color:var(--border)] text-left relative shadow-2xl overflow-hidden">
                        <h3 class="font-bold text-[color:var(--text)] mb-3 flex items-center gap-2">
                            <i data-lucide="crop" class="w-5 h-5 text-indigo-500"></i> Atur Foto Profil
                        </h3>
                        
                        <div class="w-full aspect-square bg-[color:var(--input-bg)] rounded-2xl overflow-hidden border border-[color:var(--border)] mb-4">
                            <img src="${e.target.result}" id="image-to-crop" class="max-w-full">
                        </div>
                        
                        <div class="flex gap-3">
                            <button onclick="closeGlobalModal()" class="flex-1 py-2 rounded-xl bg-[color:var(--surface)] text-[color:var(--text)] font-bold border border-[color:var(--border)] active:scale-95 transition-all text-sm">
                                Batal
                            </button>
                            <button onclick="uploadFotoProfil()" id="btn-save-crop" class="flex-1 py-2 rounded-xl bg-indigo-600 text-white font-bold shadow-lg hover:bg-indigo-700 active:scale-95 transition-all text-sm flex items-center justify-center gap-2">
                                <i data-lucide="check" class="w-4 h-4"></i> Simpan Foto
                            </button>
                        </div>
                    </div>
                `;
                
                showGlobalModal(htmlModal);
                
                // Nyalakan Cropper.js (Bulat, Rasio 1:1) setelah modal muncul
                setTimeout(() => {
                    const image = document.getElementById('image-to-crop');
                    if(cropper) cropper.destroy(); // Hapus sisa lama
                    cropper = new Cropper(image, {
                        aspectRatio: 1, // Persegi (wajib untuk bulat)
                        viewMode: 1, // Jaga agar pemangkas tidak keluar dari gambar
                        guides: false, // Matikan garis bantu
                        center: true, // Matikan titik tengah
                        background: false, // Matikan kotak-kotak latar
                        movable: true,
                        zoomable: true,
                        ready() {
                            // Bikin pandangan WhatsApp: Sudut dibulatkan di tampilan pemangkas
                            const cropperViewBox = document.querySelector('.cropper-view-box');
                            if(cropperViewBox) cropperViewBox.style.borderRadius = '50%';
                        }
                    });
                }, 100);
            };
            reader.readAsDataURL(input.files[0]);
        }
    };
        
    // ==========================================
    // 3. KONVERSI & UPLOAD FOTO PROFIL (CLOUDINARY)
    // ==========================================
    window.uploadFotoProfil = async function() {
        if (!cropper) {
            showToast("Tunggu sebentar, gambar belum siap dipotong.", "warning");
            return;
        }

        const btnSave = document.getElementById('btn-save-crop');
        btnSave.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i> Mengunggah...';
        btnSave.disabled = true;

        try {
            // Potong gambar jadi ukuran HD (400x400px) yang ringan
            const canvas = cropper.getCroppedCanvas({ width: 400, height: 400 });
            
            if (!canvas) throw new Error("Gagal membaca area potongan gambar.");

            // Konversi hasil potong menjadi file siap kirim
            canvas.toBlob(async (blob) => {
                try {
                    // Bungkus jadi File gambar
                    const file = new File([blob], `profil_${Date.now()}.jpg`, { type: 'image/jpeg' });
                    
                    // Tembak langsung ke Cloudinary (Sama seperti upload Tugas/Chat)
                    const url = await fetchCloudinaryUpload(file, false);
                    
                    // Simpan URL gambar yang sudah jadi ke Database Firebase
                    await db.collection('users').doc(STATE.currentUser.uid).update({ photoURL: url });
                    
                    if (auth.currentUser) {
                        await auth.currentUser.updateProfile({ photoURL: url });
                    }
                    
                    // Perbarui memori layar HP agar fotonya langsung berubah
                    STATE.currentUser.photoURL = url;
                    
                    showToast("Foto profil berhasil diperbarui! 🎉", "success");
                    closeGlobalModal();
                    
                    // Render ulang halaman profil
                    document.getElementById('dashboard-content').innerHTML = getAboutHTML();
                    lucide.createIcons();

                } catch (err) {
                    showToast("Gagal mengunggah ke awan: " + err.message, "error");
                    btnSave.innerHTML = '<i data-lucide="check" class="w-4 h-4"></i> Simpan Foto';
                    btnSave.disabled = false;
                }
            }, 'image/jpeg', 0.8); // Kualitas 80% biar irit kuota

        } catch (error) {
            showToast("Error pemangkas: " + error.message, "error");
            btnSave.innerHTML = '<i data-lucide="check" class="w-4 h-4"></i> Simpan Foto';
            btnSave.disabled = false;
        }
    };

        // ========== RENDER COURSE CHAT ==========
    
    // Mesin Pendeteksi Jenis File & Warna Ikon
    window.getFileIconUI = function(filename) {
        if(!filename) return { icon: 'file', color: 'text-white', bg: 'bg-white/20' };
        const ext = filename.split('.').pop().toLowerCase();
        if(['pdf'].includes(ext)) return { icon: 'file-text', color: 'text-red-500', bg: 'bg-red-500/20' };
        if(['doc','docx'].includes(ext)) return { icon: 'file-text', color: 'text-blue-500', bg: 'bg-blue-500/20' };
        if(['xls','xlsx'].includes(ext)) return { icon: 'table', color: 'text-emerald-500', bg: 'bg-emerald-500/20' };
        if(['ppt','pptx'].includes(ext)) return { icon: 'presentation', color: 'text-orange-500', bg: 'bg-orange-500/20' };
        if(['zip','rar'].includes(ext)) return { icon: 'archive', color: 'text-yellow-500', bg: 'bg-yellow-500/20' };
        return { icon: 'file', color: 'text-indigo-500', bg: 'bg-indigo-500/20' };
    };

        function renderMessagesOnly() {
        const container = document.getElementById('chat-messages-container');
        if (!container || STATE.screen !== 'course') return;
        const msgs = STATE.chats[STATE.currentCourse?.id] || [];
        const visible = msgs.filter(m => !(m.deletedFor || []).includes(STATE.currentUser?.uid));

        if(visible.length === 0) { 
            container.innerHTML = `<div class="flex-1 flex flex-col items-center justify-center text-[color:var(--text2)] h-full pt-20"><i data-lucide="messages-square" class="w-12 h-12 mb-3 text-[#2563eb] opacity-50"></i><p class="text-sm font-bold tracking-wide">Mulai obrolan di kelas ini</p></div>`;
            lucide.createIcons(); return; 
        }

        // === 1. MESIN RADAR BACA (AUTO-READ) ===
        // Cari pesan dari orang lain yang BELUM kita baca, lalu tandai "Sudah Dibaca" ke Database
        const unreadMsgs = visible.filter(m => m.userId !== STATE.currentUser?.uid && !(m.readBy || []).includes(STATE.currentUser?.uid));
        if (unreadMsgs.length > 0) {
            unreadMsgs.forEach(m => {
                db.collection('courses').doc(STATE.currentCourse.id).collection('chats').doc(m.id)
                  .update({ readBy: firebase.firestore.FieldValue.arrayUnion(STATE.currentUser.uid) })
                  .catch(e => {}); // Update berjalan diam-diam di latar belakang
            });
        }

        let html = ''; let lastDateStr = '';
        visible.forEach(m => {
            const dateStr = formatChatDateBadge(m.timestamp);
            if (dateStr !== lastDateStr) { 
                html += `<div class="flex justify-center my-5 z-10 sticky top-2"><div class="px-3 py-1.5 rounded-full bg-[color:var(--surface)] border border-[color:var(--border)] text-[color:var(--text2)] text-[9px] font-bold uppercase tracking-wider backdrop-blur-md shadow-sm">${dateStr}</div></div>`; 
                lastDateStr = dateStr; 
            }
            
            const mine = m.userId === STATE.currentUser?.uid;

            if(m.type === 'system') { 
                html += `<div class="flex justify-center my-3"><div class="px-4 py-2.5 bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-[11px] rounded-xl font-medium text-center max-w-[85%] break-words shadow-sm backdrop-blur-sm">${m.text.replace(/\n/g, '<br>')}</div></div>`; 
                return; 
            }

            let content = '';
            
            if (m.type === 'image') { 
                content = `<div class="mt-1"><img src="${m.text}" class="rounded-xl w-full max-w-[240px] max-h-64 object-cover cursor-pointer border border-[color:var(--border)] shadow-md transition hover:scale-[1.02]" onclick="window.open('${m.text}', '_blank')"></div>`;
            }
            else if (m.type === 'file') { 
                const ui = window.getFileIconUI(m.fileName);
                content = `
                <div class="mt-1.5 mb-1 w-[220px] sm:w-[250px]">
                    <a href="${m.text}" target="_blank" class="flex items-center gap-3 p-3 ${mine ? 'bg-black/20 hover:bg-black/30' : 'bg-[color:var(--surface)] hover:bg-[color:var(--card)]'} rounded-xl transition-all border border-[color:var(--border)] backdrop-blur-sm shadow-sm group">
                        <div class="p-2.5 rounded-lg ${mine ? 'bg-white/20' : ui.bg} shrink-0 transition-transform group-hover:scale-105">
                            <i data-lucide="${ui.icon}" class="w-6 h-6 ${mine ? 'text-white' : ui.color}"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[13px] truncate font-bold text-[color:var(--text)] mb-0.5" style="${mine ? 'color:white' : ''}">${m.fileName || 'Dokumen'}</p>
                            <p class="text-[9px] uppercase tracking-wider font-mono opacity-80" style="${mine ? 'color:rgba(255,255,255,0.8)' : 'color:var(--text2)'}">${m.fileSize || 'FILE'}</p>
                        </div>
                        <div class="w-8 h-8 rounded-full ${mine ? 'bg-white/10 text-white' : 'bg-[color:var(--card)] text-[color:var(--text2)]'} flex items-center justify-center shrink-0">
                            <i data-lucide="download" class="w-4 h-4"></i>
                        </div>
                    </a>
                </div>`;
            }
            else if (m.type === 'voice') { 
                content = `<div class="voice-note-player ${mine ? 'bg-black/20' : 'bg-[color:var(--surface)]'} p-2 rounded-full mt-1 border border-[color:var(--border)] backdrop-blur-sm shadow-sm"><audio id="audio-${m.id}" src="${m.text}" preload="metadata"></audio><button onclick="playVoice('${m.id}')" class="w-9 h-9 rounded-full ${mine ? 'bg-white text-[#2563eb]' : 'bg-[color:var(--accent)] text-white'} flex items-center justify-center shrink-0 shadow-md active:scale-95 transition-transform"><i data-lucide="play" id="play-${m.id}" class="w-4 h-4 vn-play ml-0.5"></i><i data-lucide="pause" id="pause-${m.id}" class="w-4 h-4 vn-pause hidden"></i></button><div class="voice-note-progress ml-1 mr-2"><div id="fill-${m.id}" class="voice-note-progress-fill ${mine ? 'bg-white' : 'bg-[color:var(--accent)]'}"></div></div><span id="time-${m.id}" class="text-[10px] font-mono font-bold mr-3" style="${mine ? 'color:white' : 'color:var(--text2)'}">0:00</span></div>`;
            }
            else { 
                content = m.text.replace(/\n/g, '<br>');
            }

            let bubbleClass = mine ? 'bg-gradient-to-br from-blue-600 to-[#2563eb] text-white bubble-right border border-blue-500/50' : 'bg-[color:var(--bubble-theirs)] text-[color:var(--text)] bubble-left border border-[color:var(--border)]';
            let nameColor = mine ? 'text-white' : 'text-emerald-500';
            let timeColor = mine ? 'text-white/80' : 'text-[color:var(--text2)] opacity-90';
            
            // === 2. LOGIKA TAMPILAN CENTANG 1 & 2 ===
            // Mengecek apakah sudah ada orang lain di database yang melihat pesan ini
            let isRead = m.readBy && m.readBy.some(uid => uid !== STATE.currentUser.uid);
            
            // Jika sudah dibaca = centang 2 biru langit, Jika belum = centang 1 putih pudar
            let checkIcon = mine ? 
                (isRead ? `<i data-lucide="check-all" class="w-[14px] h-[14px] text-sky-300 ml-0.5 mt-0.5"></i>` 
                        : `<i data-lucide="check" class="w-[14px] h-[14px] text-white/60 ml-0.5 mt-0.5"></i>`) 
                : '';

            html += `
            <div class="flex ${mine ? 'justify-end' : 'justify-start'} mb-3.5 w-full animate-fade">
                <div class="relative ${bubbleClass} px-3.5 pt-2.5 pb-6 max-w-[85%] min-w-[110px] shadow-md select-none" oncontextmenu="event.preventDefault();" onmousedown="startHold(this, '${m.id}')" onmouseup="cancelHold(this)" onmouseleave="cancelHold(this)" ontouchstart="startHold(this, '${m.id}')" ontouchend="cancelHold(this)" ontouchmove="cancelHold(this)">
                    ${!mine ? `<div class="text-[10.5px] font-bold ${nameColor} mb-1.5 truncate flex items-center gap-1.5"><i data-lucide="user" class="w-3 h-3 opacity-70"></i> ${m.userName}</div>` : ''}
                    <div class="text-[13.5px] break-words leading-relaxed">${content}</div>
                    <div class="absolute bottom-1.5 right-2.5 flex items-center gap-0.5">
                        ${m.isEdited ? `<i data-lucide="pencil" class="w-2.5 h-2.5 opacity-60 mr-1"></i>` : ''}
                        <span class="text-[9px] ${timeColor} font-bold tracking-wider pt-0.5">${formatTime(m.timestamp)}</span>
                        ${checkIcon}
                    </div>
                </div>
            </div>`;
        });
        
        container.innerHTML = html; 
        lucide.createIcons(); 
        
        if(container.scrollHeight - container.scrollTop <= container.clientHeight + 150) container.scrollTop = container.scrollHeight;
    }

    function renderCourse(el) {
        el.innerHTML = `<div class="h-full flex flex-col overflow-hidden bg-[color:var(--bg)] relative">
            <header class="glass flex items-center justify-between px-4 py-3 shrink-0 rounded-b-2xl z-30 border-b border-[color:var(--border)] shadow-sm rounded-t-none">
                <div class="flex items-center gap-3">
                    <button onclick="STATE.screen='dashboard'; renderFull()" class="p-2 -ml-2 rounded-full hover:bg-[color:var(--card)] transition-colors"><i data-lucide="arrow-left" class="w-5 h-5 text-[color:var(--text)]"></i></button>
                    <h2 class="font-bold text-sm text-[color:var(--text)] truncate max-w-[150px]">${STATE.currentCourse.icon} ${STATE.currentCourse.name}</h2>
                </div>
                <div class="flex items-center gap-1">
                    <button onclick="openAskAIModal()" class="p-2 rounded-xl bg-purple-500/10 text-purple-400 border border-purple-500/20 hover:bg-purple-500/20 active:scale-90 transition-all" title="Tanya AI"><i data-lucide="bot" class="w-4 h-4"></i></button>
                    <button onclick="handleAISummary()" class="p-2 rounded-xl bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 hover:bg-indigo-500/20 active:scale-90 transition-all" title="Ringkasan"><i data-lucide="sparkles" class="w-4 h-4"></i></button>
                    <button onclick="handleExportNotes()" class="p-2 rounded-xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 hover:bg-emerald-500/20 active:scale-90 transition-all" title="Export"><i data-lucide="download" class="w-4 h-4"></i></button>
                </div>
            </header>
            <div id="pinned-container" class="hidden shrink-0 z-20 transition-all"></div>
            <div id="chat-messages-container" class="flex-1 overflow-y-auto px-3 py-4 z-10 scroll-smooth"></div>
            <div class="glass p-2 shrink-0 z-30 border-t border-[color:var(--border)] flex gap-2 items-end pb-4 pt-2 rounded-b-none">
                <button id="btn-clip" onclick="openAttachmentMenu()" class="p-3 rounded-full text-[color:var(--text2)] hover:text-[color:var(--accent)] shrink-0 active:scale-90 transition-all"><i data-lucide="paperclip" class="w-5 h-5 transform -rotate-45"></i></button>
                <div id="recording-ui" class="hidden flex-1 flex items-center gap-2 p-1 bg-[color:var(--input-bg)] rounded-full border border-red-500/30">
                    <button onclick="cancelRecording()" class="p-2 rounded-full text-[color:var(--text2)] hover:text-red-400"><i data-lucide="trash-2" class="w-5 h-5"></i></button>
                    <div class="flex-1 flex items-center justify-center gap-2"><div class="w-2.5 h-2.5 rounded-full bg-red-500 pulse"></div><span id="rec-time" class="text-sm font-mono font-bold text-[color:var(--text)]">0:00</span></div>
                    <button onclick="stopRecording()" class="p-2 rounded-full bg-[#2563eb] text-white shadow-lg"><i data-lucide="send" class="w-4 h-4 ml-0.5"></i></button>
                </div>
                <textarea id="chat-input" class="flex-1 bg-[color:var(--input-bg)] text-[color:var(--text)] text-[15px] rounded-2xl px-4 py-3 max-h-28 outline-none resize-none border border-[color:var(--border)] focus:border-[color:var(--accent)] transition-colors" placeholder="Ketik pesan..." oninput="handleInput(this)" onkeydown="if(event.key==='Enter' && !event.shiftKey) { event.preventDefault(); sendTextMessage(); }"></textarea>
                <button id="btn-send" onclick="sendTextMessage()" class="hidden p-3 rounded-full bg-[#2563eb] text-white shrink-0 active:scale-90 transition-transform shadow-lg shadow-blue-600/20 mb-0.5"><i data-lucide="send" class="w-5 h-5 ml-0.5"></i></button>
                <button id="btn-mic" onclick="startRecording()" class="p-3 rounded-full bg-[color:var(--card)] border border-[color:var(--border)] text-[color:var(--text)] shrink-0 active:scale-90 transition-transform mb-0.5"><i data-lucide="mic" class="w-5 h-5"></i></button>
            </div>
        </div>`;
        renderPinnedOnly(); renderMessagesOnly();
    }

    function renderPinnedOnly() {
        const container = document.getElementById('pinned-container'); if (!container || STATE.screen !== 'course') return;
        const pin = STATE.pinnedMessage;
        if (pin) { container.innerHTML = `<div class="px-3 py-2 border-b border-[color:var(--border)] bg-[color:var(--surface)] flex gap-3 items-center mx-3 mt-2 rounded-lg shrink-0 z-20 shadow-sm"><i data-lucide="pin" class="w-4 h-4 text-[color:var(--accent)] shrink-0"></i><div class="flex-1 min-w-0"><span class="text-[10px] font-medium text-[color:var(--accent)] truncate block">Sematkan oleh: ${pin.userName || 'Sistem'}</span><p class="text-xs text-[color:var(--text)] truncate">${pin.text}</p></div><button onclick="unpinMessage()" class="p-1 hover:text-red-400 shrink-0 text-[color:var(--text2)]"><i data-lucide="x" class="w-4 h-4"></i></button></div>`; lucide.createIcons(); container.classList.remove('hidden'); }
        else { container.innerHTML = ''; container.classList.add('hidden'); }
    }

    // ========== CLOUDINARY, ATTACHMENT, CHAT ACTIONS ==========
    async function fetchCloudinaryUpload(file, isAudio = false) { const fd = new FormData(); fd.append('file', file); fd.append('upload_preset', isAudio ? 'fungrow_audio_preset' : 'fungrow_preset'); const res = await fetch(`https://api.cloudinary.com/v1_1/dt51ndddv/${isAudio ? 'video' : 'auto'}/upload`, { method: 'POST', body: fd }); const data = await res.json(); if (data.error) throw new Error(data.error.message); return data.secure_url; }
    window.openAttachmentMenu = () => showGlobalModal(`<div class="bg-[color:var(--surface)] backdrop-blur-2xl p-6 pb-8 rounded-t-3xl animate-slide-attachment w-full border-t border-[color:var(--border)] shadow-2xl relative"><div class="grid grid-cols-4 gap-y-6 gap-x-2 justify-items-center"><button onclick="openSpecificFileForm('.pdf,.doc,.docx,.txt,.xls,.xlsx')" class="flex flex-col items-center gap-2 active:scale-90 transition-transform"><div class="w-14 h-14 rounded-[18px] bg-[#5c37eb] flex items-center justify-center shadow-lg"><i data-lucide="file-text" class="w-6 h-6 text-white"></i></div><span class="text-[11px] text-[color:var(--text)] font-medium tracking-wide">Dokumen</span></button><button onclick="openSpecificFileForm('image/*', true)" class="flex flex-col items-center gap-2 active:scale-90 transition-transform"><div class="w-14 h-14 rounded-[18px] bg-[#eb3765] flex items-center justify-center shadow-lg"><i data-lucide="camera" class="w-6 h-6 text-white"></i></div><span class="text-[11px] text-[color:var(--text)] font-medium tracking-wide">Kamera</span></button><button onclick="openSpecificFileForm('image/*')" class="flex flex-col items-center gap-2 active:scale-90 transition-transform"><div class="w-14 h-14 rounded-[18px] bg-[#0ea5e9] flex items-center justify-center shadow-lg"><i data-lucide="image" class="w-6 h-6 text-white"></i></div><span class="text-[11px] text-[color:var(--text)] font-medium tracking-wide">Galeri</span></button><button onclick="openSpecificFileForm('audio/*')" class="flex flex-col items-center gap-2 active:scale-90 transition-transform"><div class="w-14 h-14 rounded-[18px] bg-[#f97316] flex items-center justify-center shadow-lg"><i data-lucide="headphones" class="w-6 h-6 text-white"></i></div><span class="text-[11px] text-[color:var(--text)] font-medium tracking-wide">Audio</span></button><button onclick="openAssignForm()" class="flex flex-col items-center gap-2 active:scale-90 transition-transform"><div class="w-14 h-14 rounded-[18px] bg-[#10b981] flex items-center justify-center shadow-lg"><i data-lucide="clipboard-list" class="w-6 h-6 text-white"></i></div><span class="text-[11px] text-[color:var(--text)] font-medium tracking-wide">Tugas</span></button></div><div class="w-12 h-1 bg-[color:var(--text2)] opacity-30 rounded-full mx-auto mt-6"></div></div>`, true);
    window.openSpecificFileForm = (acceptType, capture = false) => { closeGlobalModal(); const input = document.getElementById('global-file-input'); input.accept = acceptType; if (capture) input.setAttribute('capture', 'environment'); else input.removeAttribute('capture'); input.click(); };
    window.handleGlobalFileUpload = async function(event) { const file = event.target.files[0]; if (!file) return; event.target.value = ""; showToast('Mengirim file...', 'warning'); try { const isAudio = file.type.startsWith('audio/'); const isImage = file.type.startsWith('image/'); const type = isImage ? 'image' : (isAudio ? 'voice' : 'file'); const url = await fetchCloudinaryUpload(file, isAudio); await db.collection('courses').doc(STATE.currentCourse.id).collection('chats').add({ userId: STATE.currentUser.uid, userName: STATE.currentUser.displayName, text: url, fileName: file.name, fileSize: (file.size/1024).toFixed(1)+' KB', type: type, timestamp: firebase.firestore.FieldValue.serverTimestamp() }); } catch(e) { showToast('Gagal kirim file', 'error'); } };

    // ========== PERBAIKAN FORM TUGAS MAHASISWA & DOSEN ==========
    window.handleListInput = function(e) {
        if (e.key === 'Enter') {
            e.preventDefault(); const el = e.target; const lines = el.value.split('\n'); const lastLine = lines[lines.length - 1]; const match = lastLine.match(/^(\d+)\.\s/); const nextNum = match ? parseInt(match[1]) + 1 : lines.length + 1; el.value += '\n' + nextNum + '. ';
        }
    };

    window.toggleKelompokArea = (val) => {
        const area = document.getElementById('kelompok-area'); if(val === 'kelompok') area.style.display = 'block'; else area.style.display = 'none';
    };
    window.handleAsgFileUpload = async function(e) {
        const file = e.target.files[0]; if(!file) return; const statusEl = document.getElementById('asg-file-status'); statusEl.innerHTML = `<span class="text-orange-400 italic animate-pulse">Mengunggah ${file.name}...</span>`; try { const url = await fetchCloudinaryUpload(file, false); STATE.currentAsgAttachment = { url, name: file.name, type: file.type }; statusEl.innerHTML = `<span class="text-emerald-400 font-bold flex items-center gap-1"><i data-lucide="check-circle" class="w-3 h-3"></i> Berhasil: ${file.name}</span>`; lucide.createIcons(); } catch(err) { statusEl.innerHTML = `<span class="text-red-400">Gagal upload file!</span>`; }
    };
    window.openAssignForm = () => {
        closeGlobalModal(); const asgns = STATE.assignments[STATE.currentCourse?.id] || []; const dosenList = [...new Set(FULL_SCHEDULE.flatMap(d => d.items.map(i => i.dosen)))];
        setTimeout(() => {
            showGlobalModal(`
            <div class="glass p-6 animate-slide border border-[color:var(--border)] max-h-[90vh] overflow-y-auto hide-scrollbar shadow-2xl">
                <div class="flex items-center gap-3 mb-6 border-b border-[color:var(--border)] pb-4">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center"><i data-lucide="clipboard-edit" class="w-5 h-5"></i></div>
                    <div><h3 class="font-bold text-[color:var(--text)] text-lg">Manajemen Tugas</h3><p class="text-[10px] text-[color:var(--text2)] uppercase tracking-wider font-medium">Buat Tugas Baru</p></div>
                </div>
                <div class="space-y-4">
                    <div><label class="text-[10px] font-bold text-[color:var(--text2)] uppercase mb-1.5 block tracking-wide">Mata Kuliah</label><div class="w-full p-3.5 rounded-xl bg-[color:var(--card)] border border-[color:var(--border)] text-sm text-[color:var(--text)] flex items-center gap-2"><span>${STATE.currentCourse.icon}</span> ${STATE.currentCourse.name}</div></div>
                    <div><label class="text-[10px] font-bold text-[color:var(--text2)] uppercase mb-1.5 block tracking-wide">Tugas</label><input type="text" id="asg-title" class="w-full p-3.5 rounded-xl bg-[color:var(--input-bg)] border border-[color:var(--border)] text-sm text-[color:var(--text)] outline-none focus:border-[color:var(--accent)] transition-all" placeholder="Nama tugas..."></div>
                    <div><label class="text-[10px] font-bold text-[color:var(--text2)] uppercase mb-1.5 block tracking-wide">Dosen Pengampu</label><select id="asg-dosen" class="w-full p-3.5 rounded-xl bg-[color:var(--input-bg)] border border-[color:var(--border)] text-sm text-[color:var(--text)] outline-none focus:border-[color:var(--accent)] appearance-none"><option value="">-- Pilih Dosen --</option>${dosenList.map(d => `<option value="${d}">${d}</option>`).join('')}</select></div>
                    <div><label class="text-[10px] font-bold text-[color:var(--text2)] uppercase mb-1.5 block tracking-wide">Target Tugas</label><select id="asg-type" onchange="toggleKelompokArea(this.value)" class="w-full p-3.5 rounded-xl bg-[color:var(--input-bg)] border border-[color:var(--border)] text-sm text-[color:var(--text)] outline-none focus:border-[color:var(--accent)] appearance-none"><option value="individu">Tugas Individu</option><option value="kelompok">Tugas Kelompok</option></select></div>
                    <div id="kelompok-area" style="display:none;" class="p-4 rounded-2xl bg-indigo-500/5 border border-indigo-500/20 space-y-4 animate-fade relative overflow-hidden"><div class="absolute -top-6 -right-6 w-16 h-16 bg-indigo-500/10 rounded-full blur-xl"></div><div><label class="text-[10px] font-bold text-indigo-400 uppercase mb-1.5 block tracking-wide">Nama Kelompok</label><input type="text" id="asg-group-name" class="w-full p-3 rounded-xl bg-[color:var(--input-bg)] border border-[color:var(--border)] text-sm text-[color:var(--text)] outline-none focus:border-indigo-500" placeholder="Cth: Kelompok 1"></div><div><label class="text-[10px] font-bold text-indigo-400 uppercase mb-1.5 block tracking-wide">Judul Spesifik Kelompok</label><input type="text" id="asg-group-title" class="w-full p-3 rounded-xl bg-[color:var(--input-bg)] border border-[color:var(--border)] text-sm text-[color:var(--text)] outline-none focus:border-indigo-500" placeholder="Topik materi untuk kelompok ini"></div><div><label class="text-[10px] font-bold text-indigo-400 uppercase mb-1.5 block tracking-wide">Daftar Anggota</label><textarea id="asg-group-members" onkeydown="handleListInput(event)" class="w-full p-3 rounded-xl bg-[color:var(--input-bg)] border border-[color:var(--border)] text-sm text-[color:var(--text)] h-24 resize-none outline-none focus:border-indigo-500 leading-relaxed" placeholder="1. "></textarea></div></div>
                    <div><label class="text-[10px] font-bold text-[color:var(--text2)] uppercase mb-1.5 block tracking-wide">Keterangan & Lampiran</label><textarea id="asg-desc" class="w-full p-3.5 rounded-xl bg-[color:var(--input-bg)] border border-[color:var(--border)] text-sm text-[color:var(--text)] h-24 resize-none outline-none focus:border-[color:var(--accent)] mb-2" placeholder="Ketentuan tugas, referensi, dsb..."></textarea><div class="flex items-center gap-3"><button onclick="document.getElementById('asg-file-upload').click()" class="flex items-center gap-2 px-3 py-2 rounded-xl bg-[color:var(--card)] border border-[color:var(--border)] text-xs text-[color:var(--text)] active:scale-95 transition-transform"><i data-lucide="paperclip" class="w-4 h-4 text-emerald-400"></i> Upload File</button><input type="file" id="asg-file-upload" class="hidden" onchange="handleAsgFileUpload(event)"><div id="asg-file-status" class="text-[10px] text-[color:var(--text2)] flex-1 truncate">Tidak ada file.</div></div></div>
                    <div><label class="text-[10px] font-bold text-[color:var(--text2)] uppercase mb-1.5 block tracking-wide">Waktu / Tanggal Jatuh Tempo</label><input type="datetime-local" id="asg-date" class="w-full p-3.5 rounded-xl bg-[color:var(--input-bg)] border border-[color:var(--border)] text-sm text-[color:var(--text)] outline-none focus:border-[color:var(--accent)]" style="color-scheme: dark;"></div>
                </div>
                <div class="mt-8 pt-4 border-t border-[color:var(--border)]"><button onclick="sendAssign()" class="w-full py-4 rounded-2xl bg-emerald-600 text-white font-bold text-sm shadow-lg shadow-emerald-600/20 active:scale-95 transition-all flex items-center justify-center gap-2"><i data-lucide="send" class="w-4 h-4"></i> Terbitkan Tugas</button><button onclick="closeGlobalModal()" class="w-full py-2.5 mt-2 text-[color:var(--text2)] font-bold text-xs uppercase hover:text-[color:var(--text)] transition-colors">Tutup</button></div>
                <div class="mt-8 pt-4 border-t border-dashed border-[color:var(--border)]"><p class="text-[11px] font-bold text-emerald-400 mb-3 tracking-wider uppercase">Riwayat Tugas (${asgns.length})</p><div class="space-y-3">${asgns.map(a => `<div class="p-4 rounded-xl bg-[color:var(--card)] border border-[color:var(--border)] shadow-sm relative overflow-hidden">${a.type === 'kelompok' ? `<div class="absolute top-0 right-0 px-2 py-1 bg-indigo-500/20 text-indigo-400 text-[8px] font-bold rounded-bl-lg">KELOMPOK</div>` : ''}<div class="font-bold text-sm text-[color:var(--text)] pr-12 line-clamp-2">${a.title}</div><div class="flex items-center gap-2 mt-2 text-[10px] text-[color:var(--text2)]"><i data-lucide="user" class="w-3 h-3"></i> ${a.dosen || '-'}</div><div class="flex items-center gap-2 mt-1 text-[10px] text-orange-400 font-bold"><i data-lucide="clock" class="w-3 h-3"></i> Batas: ${formatDate(a.deadline)} ${formatTime(a.deadline)}</div></div>`).join('') || '<div class="text-xs text-center text-[color:var(--text2)] mt-4">Belum ada tugas</div>'}</div></div>
            </div>`, true);
        }, 300);
    }; 

        // ==============================================
// LOGIKA POP-UP PENGUMUMAN (Tampil TERUS untuk Testing)
// ==============================================
window.showPromoModal = function() {
    const modal = document.getElementById('promo-modal');
    const content = document.getElementById('promo-content');
    
    if(modal && content) {
        // Munculkan elemennya dulu
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        // Beri sedikit jeda untuk memicu animasi masuk (fade in & zoom)
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modal.classList.add('opacity-100');
            content.classList.remove('scale-95');
            content.classList.add('scale-100');
        }, 50);
    }
};

    window.closePromoModal = function() {
        const modal = document.getElementById('promo-modal');
        const content = document.getElementById('promo-content');
        
        if(modal && content) {
            // Animasi keluar (fade out & un-zoom)
            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0');
            content.classList.remove('scale-100');
            content.classList.add('scale-95');
            
            // Sembunyikan elemen setelah animasi selesai (300ms)
            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }, 300);
        }
    };

    window.sendAssign = async function() {
        const title = document.getElementById('asg-title').value, dosen = document.getElementById('asg-dosen').value, dl = document.getElementById('asg-date').value, type = document.getElementById('asg-type').value;
        if(!title || !dosen || !dl) return showToast('Tugas, dosen, dan deadline wajib diisi!', 'error');
        showToast('Memproses tugas...', 'warning'); closeGlobalModal();
        try {
            const data = { title, dosen, type, courseName: STATE.currentCourse.name, description: document.getElementById('asg-desc').value, deadline: firebase.firestore.Timestamp.fromDate(new Date(dl)), createdBy: STATE.currentUser.uid, createdByRole: STATE.currentUser.role, attachment: STATE.currentAsgAttachment || null, createdAt: firebase.firestore.FieldValue.serverTimestamp() };
            if(type === 'kelompok') { data.kelompok = { nama: document.getElementById('asg-group-name').value, judul: document.getElementById('asg-group-title').value, anggota: document.getElementById('asg-group-members').value }; }
            await db.collection('courses').doc(STATE.currentCourse.id).collection('assignments').add(data);
            if(STATE.currentUser.role === 'admin' || STATE.currentUser.role === 'dosen') {
                let msg = `📢 *TUGAS BARU: ${title}*\n👨‍🏫 Dosen: ${dosen}\n⏳ Batas: ${formatDate(new Date(dl))}`;
                if(type === 'kelompok') msg += `\n👥 Tugas Kelompok: ${data.kelompok.nama}`;
                await db.collection('courses').doc(STATE.currentCourse.id).collection('chats').add({ userId: 'system', userName: 'Sistem', text: msg, type: 'system', timestamp: firebase.firestore.FieldValue.serverTimestamp() });
            }
            STATE.currentAsgAttachment = null; showToast('Tugas berhasil diterbitkan!', 'success');
        } catch(e) { console.error(e); showToast('Gagal menerbitkan tugas', 'error'); }
    };

    // ========== LOGIKA FITUR TAMBAHAN (AI) ==========
    window.openProfileModal = function() { const input = document.createElement('input'); input.type = 'file'; input.accept = 'image/*'; input.onchange = async (e) => { const file = e.target.files[0]; if(!file) return; showToast('Mengunggah foto...', 'warning'); try { const url = await fetchCloudinaryUpload(file); await auth.currentUser.updateProfile({ photoURL: url }); await db.collection('users').doc(auth.currentUser.uid).update({ photoURL: url }); STATE.currentUser.photoURL = url; showToast('Foto profil berhasil diubah!'); renderFull(); } catch(err) { showToast('Gagal upload', 'error'); } }; input.click(); };
    window.handleAISummary = async function() {
        const msgs = STATE.chats[STATE.currentCourse.id] || []; if(msgs.length < 5) return showToast('Butuh minimal 5 pesan', 'warning');
        const chatHistory = msgs.slice(-50).map(m => `${m.userName}: ${m.text}`).join('\n'); showToast('AI sedang merangkum...', 'warning');
        try {
            const response = await fetch('/ai/summarize', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ history: chatHistory }) }); const data = await response.json();
            showGlobalModal(`
                <div class="glass p-6 rounded-3xl border border-indigo-500/20 w-full max-w-sm animate-slide"><div class="flex items-center gap-2 mb-4"><div class="p-2 rounded-lg bg-indigo-500/20 text-indigo-400"><i data-lucide="sparkles" class="w-5 h-5"></i></div><h3 class="font-bold text-[color:var(--text)]">Ringkasan AI</h3></div><div class="text-[13px] text-[color:var(--text)] leading-relaxed bg-[color:var(--card)] p-4 rounded-2xl border border-[color:var(--border)] max-h-[300px] overflow-y-auto">${data.result.replace(/\n/g, '<br>')}</div><button onclick="closeGlobalModal()" class="w-full mt-6 py-3.5 bg-indigo-600 rounded-xl font-bold text-white active:scale-95 transition-transform">Tutup</button></div>
            `);
        } catch(e) { showToast('Gagal memanggil AI', 'error'); }
    };
    window.openAskAIModal = function() { showGlobalModal(`
        <div class="glass p-6 rounded-3xl animate-slide w-full max-w-sm border border-purple-500/20"><h3 class="font-bold text-purple-400 mb-2 flex items-center gap-2"><i data-lucide="bot"></i> Tanya AI</h3><p class="text-xs text-[color:var(--text2)] mb-4">Tanyakan apapun terkait obrolan kelas ini.</p><textarea id="ai-question" class="w-full bg-[color:var(--input-bg)] p-3 rounded-xl text-sm text-[color:var(--text)] mb-4 border border-[color:var(--border)] focus:border-purple-500 outline-none resize-none h-24" placeholder="Contoh: Apa tugas yang baru saja diberikan?"></textarea><button onclick="submitAskAI()" class="w-full py-3.5 bg-purple-600 rounded-xl font-bold text-white shadow-lg active:scale-95 transition-transform">Tanyakan</button><button onclick="closeGlobalModal()" class="w-full mt-2 py-2 text-[color:var(--text2)] font-bold hover:text-[color:var(--text)] transition-colors">Batal</button></div>
    `); };
    window.submitAskAI = async function() {
        const question = document.getElementById('ai-question').value; if(!question) return showToast('Masukkan pertanyaan', 'warning');
        const msgs = STATE.chats[STATE.currentCourse.id] || []; const history = msgs.slice(-50).map(m => `${m.userName}: ${m.text}`).join('\n'); showToast('AI sedang berpikir...', 'warning'); closeGlobalModal();
        try {
            const response = await fetch('/ai/ask', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ history: history, question: question }) }); const data = await response.json();
            showGlobalModal(`
                <div class="glass p-6 rounded-3xl animate-slide w-full max-w-sm border border-purple-500/20"><h3 class="font-bold text-purple-400 mb-4 flex items-center gap-2"><i data-lucide="bot"></i> Jawaban AI</h3><div class="text-[13px] text-[color:var(--text)] leading-relaxed bg-[color:var(--card)] p-4 rounded-xl border border-[color:var(--border)] max-h-[300px] overflow-y-auto">${data.result.replace(/\n/g, '<br>')}</div><button onclick="closeGlobalModal()" class="w-full mt-6 py-3.5 bg-purple-600 rounded-xl font-bold text-white active:scale-95 transition-transform">Tutup</button></div>
            `);
        } catch(e) { showToast('Gagal memanggil AI', 'error'); }
    };
    window.handleExportNotes = function() {
        const messages = STATE.chats[STATE.currentCourse.id] || []; if(messages.length === 0) return showToast('Belum ada pesan', 'warning');
        const title = `CATATAN KELAS: ${STATE.currentCourse.name}`; const content = messages.map(m => `[${formatTime(m.timestamp)}] ${m.userName}: ${m.text}`).join('\n');
        const fullText = `# ${title}\nTanggal: ${new Date().toLocaleDateString('id-ID')}\n\n---\n\n${content}`;
        const blob = new Blob([fullText], { type: 'text/markdown' }); const url = URL.createObjectURL(blob);
        const a = document.createElement('a'); a.href = url; a.download = `Catatan_${STATE.currentCourse.id}.md`; a.click(); showToast('Catatan berhasil diunduh!');
    };

    // ========== LOGIKA LUPA PASSWORD (FIREBASE LINK) ==========
    window.openForgotPasswordModal = () => { 
        document.getElementById('reset-modal').classList.add('show'); 
        document.getElementById('reset-step-1').classList.remove('hidden'); 
        if(document.getElementById('reset-step-2')) document.getElementById('reset-step-2').classList.add('hidden'); 
        if(document.getElementById('reset-step-3')) document.getElementById('reset-step-3').classList.add('hidden'); 
        lucide.createIcons(); 
    };

    window.sendResetLink = async () => {
        const email = document.getElementById('reset-email-input').value; 
        if(!email) return showToast('Email wajib diisi!', 'error'); 
        showToast('Meminta Firebase mengirim email...', 'warning');

        try {
            await firebase.auth().sendPasswordResetEmail(email);
            
            document.getElementById('reset-step-1').classList.add('hidden'); 
            const step2 = document.getElementById('reset-step-2');
            step2.classList.remove('hidden');
            step2.innerHTML = `
                <div class="text-center">
                    <h3 class="font-bold text-[color:var(--text)] mb-2">Email Terkirim! ✅</h3>
                    <p class="text-sm text-[color:var(--text2)]">Link pemulihan telah dikirim ke <b>${email}</b>.<br>Cek kotak masuk atau spam.</p>
                    <button onclick="document.getElementById('reset-modal').classList.remove('show')" class="mt-4 w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl transition-all font-medium">Tutup</button>
                </div>
            `;
            showToast('Email pemulihan berhasil dikirim!', 'success'); 
        } catch(error) { 
            if(error.code === 'auth/user-not-found') {
                showToast('Email tidak terdaftar!', 'error');
            } else {
                showToast('Gagal: ' + error.message, 'error'); 
            }
        }
    };

    // ========== CHAT ACTIONS ==========
    window.handleInput = function(el) { el.style.height = 'auto'; el.style.height = Math.min(el.scrollHeight, 100) + 'px'; const hasText = el.value.trim().length > 0; document.getElementById('btn-send').style.display = hasText ? 'block' : 'none'; document.getElementById('btn-mic').style.display = hasText ? 'none' : 'block'; }
    window.sendTextMessage = async function() { const input = document.getElementById('chat-input'); const text = input.value.trim(); if(!text) return; input.value = ''; handleInput(input); try { await db.collection('courses').doc(STATE.currentCourse.id).collection('chats').add({ userId: STATE.currentUser.uid, userName: STATE.currentUser.displayName, text: text, type: 'text', timestamp: firebase.firestore.FieldValue.serverTimestamp() }); } catch(e) { showToast('Gagal kirim', 'error'); } }
    window.startRecording = async function() { if(!navigator.mediaDevices) return showToast('Browser tidak mendukung mic', 'error'); try { const stream = await navigator.mediaDevices.getUserMedia({ audio: true }); STATE.audioChunks = []; STATE.mediaRecorder = new MediaRecorder(stream); STATE.mediaRecorder.ondataavailable = e => STATE.audioChunks.push(e.data); STATE.mediaRecorder.onstop = uploadVoiceMessage; STATE.mediaRecorder.start(); STATE.isRecording = true; STATE.recordingSeconds = 0; document.getElementById('chat-input').style.display = 'none'; document.getElementById('btn-mic').style.display = 'none'; document.getElementById('btn-clip').style.display = 'none'; document.getElementById('recording-ui').classList.remove('hidden'); document.getElementById('recording-ui').classList.add('flex'); STATE.recordingTimer = setInterval(() => { STATE.recordingSeconds++; document.getElementById('rec-time').innerText = formatRecTime(STATE.recordingSeconds); }, 1000); } catch(e) { showToast('Izinkan akses mikrofon di browser', 'error'); } }
    window.stopRecording = function() { if(STATE.mediaRecorder) STATE.mediaRecorder.stop(); resetRecUI(); }
    window.cancelRecording = function() { if(STATE.mediaRecorder) { STATE.mediaRecorder.onstop = null; STATE.mediaRecorder.stop(); STATE.mediaRecorder.stream.getTracks().forEach(t=>t.stop()); } resetRecUI(); showToast('Batal merekam', 'warning'); }
    function resetRecUI() { STATE.isRecording = false; clearInterval(STATE.recordingTimer); document.getElementById('recording-ui').classList.add('hidden'); document.getElementById('recording-ui').classList.remove('flex'); document.getElementById('chat-input').style.display = 'block'; document.getElementById('btn-clip').style.display = 'block'; handleInput(document.getElementById('chat-input')); }
    async function uploadVoiceMessage() { resetRecUI(); showToast('Mengirim suara...', 'warning'); try { const file = new File(STATE.audioChunks, `vn_${Date.now()}.webm`, { type: 'audio/webm' }); const url = await fetchCloudinaryUpload(file, true); await db.collection('courses').doc(STATE.currentCourse.id).collection('chats').add({ userId: STATE.currentUser.uid, userName: STATE.currentUser.displayName, text: url, type: 'voice', timestamp: firebase.firestore.FieldValue.serverTimestamp() }); } catch(e) { showToast('Gagal kirim suara', 'error'); } }
    window.playVoice = function(id) { const audio = document.getElementById(`audio-${id}`), btnPlay = document.getElementById(`play-${id}`), btnPause = document.getElementById(`pause-${id}`); const fill = document.getElementById(`fill-${id}`), time = document.getElementById(`time-${id}`); if(audio.paused) { document.querySelectorAll('audio').forEach(a => a.pause()); document.querySelectorAll('.vn-pause').forEach(i => i.classList.add('hidden')); document.querySelectorAll('.vn-play').forEach(i => i.classList.remove('hidden')); audio.play(); btnPlay.classList.add('hidden'); btnPause.classList.remove('hidden'); } else { audio.pause(); btnPause.classList.add('hidden'); btnPlay.classList.remove('hidden'); } audio.ontimeupdate = () => { fill.style.width = (audio.currentTime/audio.duration*100)+'%'; time.innerText = formatRecTime(Math.floor(audio.currentTime)); }; audio.onended = () => { btnPause.classList.add('hidden'); btnPlay.classList.remove('hidden'); fill.style.width='0%'; time.innerText='0:00'; } }

    let pressTimer = null;
    window.startHold = function(el, msgId) { el.classList.add('msg-active'); pressTimer = setTimeout(() => { el.classList.remove('msg-active'); openMessageMenu(msgId); }, 500); }
    window.cancelHold = function(el) { clearTimeout(pressTimer); if(el) el.classList.remove('msg-active'); }
    window.openMessageMenu = function(msgId) { if ("vibrate" in navigator) navigator.vibrate(50); const msg = STATE.chats[STATE.currentCourse.id].find(m => m.id === msgId); if(!msg) return; const isMine = msg.userId === STATE.currentUser.uid; const isAdmin = STATE.currentUser?.role === 'admin'; let html = `<div class="glass p-5 rounded-3xl w-full max-w-xs animate-slide-up mx-auto absolute bottom-4 left-0 right-0 border border-[color:var(--border)] shadow-2xl"><h3 class="text-center font-bold text-[color:var(--text2)] mb-4 text-sm">Opsi Pesan ${isAdmin ? '(Admin)' : ''}</h3><div class="space-y-2">`; if(isMine && msg.type === 'text') html += `<button onclick="openEditForm('${msg.id}', '${msg.text.replace(/'/g, "\\'")}')" class="w-full py-3 px-4 rounded-xl bg-[color:var(--card)] text-[color:var(--text)] font-medium flex items-center gap-3 border border-[color:var(--border)] hover:bg-[color:var(--surface)]"><i data-lucide="pencil" class="w-4 h-4 text-[color:var(--accent)]"></i> Edit Pesan</button>`; html += `<button onclick="pinMessage('${msg.id}')" class="w-full py-3 px-4 rounded-xl bg-[color:var(--card)] text-[color:var(--text)] font-medium flex items-center gap-3 border border-[color:var(--border)] hover:bg-[color:var(--surface)]"><i data-lucide="pin" class="w-4 h-4 text-[color:var(--accent2)]"></i> Sematkan Pesan</button>`; if(isMine || isAdmin) { html += `<button onclick="deleteForEveryone('${msg.id}')" class="w-full py-3 px-4 rounded-xl bg-[color:var(--card)] text-red-400 font-medium flex items-center gap-3 border border-[color:var(--border)] hover:bg-[color:var(--surface)]"><i data-lucide="trash" class="w-4 h-4 text-red-400"></i> Hapus untuk semua orang</button>`; } html += `<button onclick="deleteForMe('${msg.id}')" class="w-full py-3 px-4 rounded-xl bg-[color:var(--card)] text-orange-400 font-medium flex items-center gap-3 border border-[color:var(--border)] hover:bg-[color:var(--surface)]"><i data-lucide="user-minus" class="w-4 h-4 text-orange-400"></i> Hapus untuk saya</button>`; html += `<button onclick="closeGlobalModal()" class="w-full py-3 px-4 rounded-xl bg-[color:var(--bg)] text-[color:var(--text2)] font-bold mt-4 text-center justify-center border border-[color:var(--border)]">Batal</button></div></div>`; showGlobalModal(html, true); }
    window.openEditForm = function(id, text) { showGlobalModal(`<div class="glass p-5 rounded-2xl w-full animate-fade border border-[color:var(--border)]"><h3 class="font-bold text-[color:var(--text)] mb-3">Edit Pesan</h3><textarea id="edit-txt" class="w-full bg-[color:var(--input-bg)] p-3 rounded-xl text-sm text-[color:var(--text)] mb-4 h-24 border border-[color:var(--border)] focus:border-[color:var(--accent)] outline-none">${text}</textarea><div class="flex gap-2 justify-end"><button onclick="closeGlobalModal()" class="px-4 py-2 font-bold text-[color:var(--text2)] hover:text-[color:var(--text)] transition-colors">Batal</button><button onclick="saveEdit('${id}')" class="px-4 py-2 font-bold bg-[#2563eb] text-white rounded-xl shadow-md shadow-blue-500/20">Simpan</button></div></div>`); }
    window.saveEdit = async function(id) { const text = document.getElementById('edit-txt').value.trim(); if(!text) return; closeGlobalModal(); try { await db.collection('courses').doc(STATE.currentCourse.id).collection('chats').doc(id).update({ text, isEdited: true }); showToast('Pesan diubah'); } catch(e){} }
    window.deleteForEveryone = async function(id) { closeGlobalModal(); try { await db.collection('courses').doc(STATE.currentCourse.id).collection('chats').doc(id).delete(); showToast('Dihapus untuk semua'); } catch(e){} }
    window.deleteForMe = async function(id) { closeGlobalModal(); try { await db.collection('courses').doc(STATE.currentCourse.id).collection('chats').doc(id).update({ deletedFor: firebase.firestore.FieldValue.arrayUnion(STATE.currentUser.uid) }); showToast('Dihapus untuk Anda'); } catch(e){} }
    window.pinMessage = async function(id) { closeGlobalModal(); const msg = STATE.chats[STATE.currentCourse.id].find(m=>m.id===id); const txt = msg.type==='text' ? msg.text : `[${msg.type.toUpperCase()}]`; try { await db.collection('courses').doc(STATE.currentCourse.id).update({ pinnedMessage: { id, text: txt, userName: msg.userName } }); showToast('Disematkan'); } catch(e){} }
    window.unpinMessage = async function() { try { await db.collection('courses').doc(STATE.currentCourse.id).update({ pinnedMessage: null }); showToast('Sematan dilepas'); } catch(e){} }
</script>
</body>
</html>
