<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detail Aset: {{ $asset->nama_barang }}
        </h2>
    </x-slot>

    <div x-data="{ 
        showDeskripsiModal: false,
        showMaintenanceModal: false,
        showCompleteModal: false,
        showMaintenanceHistory: false,
        showBorrowModal: false,
        currentLogId: null
     }">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        

                        @php
                            // Ambil parameter 'back' dari URL
                            $backParam = request('back');
                            
                            // Fallback jika tidak ada back param
                            $fallback = route('assets.index'); // atau route('categories.index') jika lebih logis
                            
                            // Validasi: hanya izinkan redirect ke dalam aplikasi
                            $backUrl = $fallback;
                            if ($backParam && str_starts_with($backParam, url('/'))) {
                                $backUrl = $backParam;
                            }
                        @endphp
                        <a href="{{ $backUrl }}"
                        class="mb-4 inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            &larr; Kembali
                        </a>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4 border-t border-gray-200 dark:border-gray-700 pt-6">
                            <div>
                                <h6 class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Barang</h6>
                                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $asset->nama_barang }}</p>
                            </div>
                            <div>
                                <h6 class="text-sm font-medium text-gray-500 dark:text-gray-400">Kode Aset</h6>
                                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $asset->kode_aset }}</p>
                            </div>
                            <div>
                                <h6 class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</h6>
                                <p>
                                    @if ($asset->status == 'Tersedia')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Tersedia</span>
                                    @elseif ($asset->status == 'Dipinjam')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Dipinjam</span>
                                    @elseif ($asset->status == 'Perbaikan')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Perbaikan</span>
                                    @elseif ($asset->status == 'Rusak')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rusak</span>
                                    @endif
                                </p>
                            </div>
                            <div>
                                <h6 class="text-sm font-medium text-gray-500 dark:text-gray-400">Kategori</h6>
                                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $asset->kategori }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <h6 class="text-sm font-medium text-gray-500 dark:text-gray-400">Lokasi</h6>
                                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $asset->lokasi }}</p>
                            </div>
                        </div>

                        <hr class="my-6 border-gray-200 dark:border-gray-700">

                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <h6 class="text-sm font-medium text-gray-500 dark:text-gray-400">Deskripsi</h6>
                                @if(auth()->user()->isAdmin() || auth()->user()->role == 'staf')
                                <button @click="showDeskripsiModal = true" class="px-2 py-1 text-xs font-medium text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                    Edit
                                </button>
                                @endif
                            </div>
                            <p class="text-gray-700 dark:text-gray-300 prose" id="assetDeskripsi">
                                {{ $asset->deskripsi ?? 'Tidak ada deskripsi untuk aset ini.' }}
                            </p>
                        </div>
                        
                        <hr class="my-6 border-gray-200 dark:border-gray-700">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h6 class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Ditambahkan</h6>
                                <p class="text-gray-700 dark:text-gray-300">{{ $asset->created_at->format('d F Y, \P\u\k\u\l H:i') }}</p>
                            </div>
                            <div>
                                <h6 class="text-sm font-medium text-gray-500 dark:text-gray-400">Terakhir Diperbarui</h6>
                                <p class="text-gray-700 dark:text-gray-300">{{ $asset->updated_at->format('d F Y, \P\u\k\u\l H:i') }}</p>
                            </div>
                        </div>

                            {{-- ============ DROPDOWN RIWAYAT PERBAIKAN ============ --}}
                        @if($asset->maintenanceLogs->count())
                            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                                <button 
                                    @click="showMaintenanceHistory = !showMaintenanceHistory"
                                    class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">
                                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Riwayat Perbaikan ({{ $asset->maintenanceLogs->count() }})
                                    <svg :class="{'rotate-180': showMaintenanceHistory}" class="w-4 h-4 ml-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>

                                <div x-show="showMaintenanceHistory"
                                    x-transition:enter="transition ease-out duration-700"
                                    x-transition:enter-start="opacity-0 max-h-0"
                                    x-transition:enter-end="opacity-100 max-h-96"
                                    x-transition:leave="transition ease-in duration-200"
                                    x-transition:leave-start="opacity-100 max-h-96"
                                    x-transition:leave-end="opacity-0 max-h-0"
                                    class="mt-4 overflow-hidden"
                                    style="display: none;">
                                    <div class="space-y-4">
                                        @foreach($asset->maintenanceLogs as $log)
                                            <div class="p-4 rounded-lg border {{ $log->status == 'Selesai' ? 'border-green-200 bg-green-50' : 'border-yellow-200 bg-yellow-50' }} dark:bg-opacity-10">
                                                <div class="flex justify-between">
                                                    <span class="font-medium text-gray-800 dark:text-gray-200">{{ $log->reported_by }}</span>
                                                    <span class="text-xs text-gray-500">{{ $log->created_at->format('d M Y H:i') }}</span>
                                                </div>
                                                <p class="mt-2 text-gray-700 dark:text-gray-300">{{ $log->issue_description }}</p>
                                                <span class="inline-block mt-3 px-3 py-1 text-xs font-semibold rounded-full 
                                                    @if($log->status == 'Selesai') 
                                                        bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                                    @else 
                                                        bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                                    @endif">
                                                    @if($log->status == 'Selesai') ✅ Selesai @else ⏳ Menunggu @endif
                                                </span>

                                                {{-- Tombol Diperbaiki (muncul jika status log "Menunggu") --}}
                                                @if($log->status === 'Menunggu' && auth()->user()->isAdmin())
                                                    <form method="POST" action="{{ route('maintenance.start', $log) }}" class="mt-2 inline-block">
                                                        @csrf
                                                        <button type="submit" class="text-xs font-medium text-yellow-600 hover:text-yellow-800">
                                                            🛠️ Diperbaiki
                                                        </button>
                                                    </form>
                                                @endif

                                                {{-- Tombol Tandai Selesai (muncul jika status log "Sedang Dikerjakan") --}}
                                                @if($log->status === 'Sedang Dikerjakan' && auth()->user()->isAdmin())
                                                    <button 
                                                        @click="
                                                            showCompleteModal = true; 
                                                            currentLogId = {{ $log->id }};
                                                            document.getElementById('completeMaintenanceForm').setAttribute('action', '{{ route('maintenance.complete', $log) }}');
                                                        "
                                                        class="text-xs font-medium text-green-600 hover:text-green-800">
                                                        ✅ Tandai Selesai
                                                    </button>
                                                @endif

                                                @if($log->resolution_notes && $log->resolution_notes !== '-')
                                                    <div class="mt-2 pt-2 border-t border-gray-200 dark:border-gray-700">
                                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                                            <span class="font-medium">Catatan:</span> {{ $log->resolution_notes }}
                                                        </p>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                            {{-- ============ LAPOR KERUSAKAN (untuk staf/admin) ============ --}}
                            @if(auth()->user()->role == 'staf' || auth()->user()->isAdmin())
                                <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                                    <button 
                                        @click="showMaintenanceModal = true"
                                        class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-md shadow-sm transition">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                        </svg>
                                        Laporkan Kerusakan
                                    </button>
                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                        Gunakan fitur ini jika aset ini mengalami masalah teknis.
                                    </p>
                                </div>
                            @endif

                    
                        
                    </div>
                </div>
            </div>
        </div>

        <div x-show="showDeskripsiModal"
             x-transition:enter="transition ease-out duration-300" ... (salin transisi)
             class="fixed inset-0 z-50 overflow-y-auto bg-gray-500 bg-opacity-75"
             style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div @click.away="showDeskripsiModal = false"
                     x-show="showDeskripsiModal" ... (salin transisi)
                     class="bg-white rounded-lg shadow-xl overflow-hidden w-full max-w-lg">
                    
                    <form id="editDeskripsiForm" 
                        action="{{ route('assets.updateDescription', $asset->id) }}" 
                        method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="px-6 py-4 bg-gray-50 border-b">
                            <h3 class="text-lg font-medium text-gray-900">Edit Deskripsi</h3>
                        </div>

                        <div class="p-6">
                            <textarea id="edit_deskripsi" name="deskripsi" rows="8" class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ $asset->deskripsi ?? '' }}</textarea>
                            <div class="text-red-600 text-sm mt-1 form-error" id="deskripsi_error"></div>
                        </div>

                        <div class="px-6 py-4 bg-gray-50 border-t flex justify-end space-x-3">
                            <button type="button" @click="showDeskripsiModal = false" class="px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
                                Tutup
                            </button>
                            <button type="submit" form="editDeskripsiForm" class="px-4 py-2 bg-blue-600 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-blue-700">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
         @include('maintenance.create')

        {{-- Modal Tandai Selesai --}}
            <div x-show="showCompleteModal"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50"
                style="display: none;">
                <div class="flex items-center justify-center min-h-screen px-4">
                    <div @click.away="showCompleteModal = false"
                        x-show="showCompleteModal"
                        class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-lg">
                        <form id="completeMaintenanceForm" method="POST">
                            @csrf
                            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="text-lg font-medium text-green-600 dark:text-green-400 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Tandai Perbaikan Selesai
                                </h3>
                            </div>

                            <div class="p-6">
                                <label for="resolution_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Catatan Perbaikan (Opsional)
                                </label>
                                <textarea 
                                    id="resolution_notes" 
                                    name="resolution_notes" 
                                    rows="4" 
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 dark:bg-gray-700 dark:text-white"
                                    placeholder="Contoh: Ganti PSU, tes normal, layar OK."></textarea>
                                <div id="notes_error" class="mt-2 text-sm text-red-600"></div>
                            </div>

                            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600 flex justify-end space-x-3">
                                <button type="button" @click="showCompleteModal = false" 
                                        class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-500 rounded-md hover:bg-gray-50 dark:hover:bg-gray-500">
                                    Batal
                                </button>
                                <button type="submit" 
                                        class="px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                    Simpan & Selesai
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </div> 
   
    
    @push('scripts')
   <script>
document.addEventListener('DOMContentLoaded', function () {
    // === EDIT DESKRIPSI ===
    const editForm = document.getElementById('editDeskripsiForm');
    if (editForm) {
        editForm.addEventListener('submit', function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            fetch(this.action, {
                method: 'POST',
                headers: { 
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) { return response.json().then(data => { throw data.errors; }); }
                return response.json();
            })
            .then(data => {
                alert(data.message);
                location.reload();
            })
            .catch(errors => {
                // Tambahkan logika error di sini jika perlu
                console.error(errors);
            });
        });
    }

    // === LAPOR KERUSAKAN ===
    const maintenanceForm = document.getElementById('maintenanceForm');
    if (maintenanceForm) {
        maintenanceForm.addEventListener('submit', function(e) {
            e.preventDefault();
            document.getElementById('issue_error').textContent = '';
            const formData = new FormData(this);
            const url = this.getAttribute('action');

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) return response.json().then(err => { throw err; });
                return response.json();
            })
            .then(data => {
                const notif = document.createElement('div');
                notif.innerHTML = `
                    <div class="fixed top-4 right-4 z-50 bg-green-500 text-white px-4 py-2 rounded-md shadow-lg flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        ${data.message}
                    </div>
                `;
                document.body.appendChild(notif);
                setTimeout(() => notif.remove(), 3000);
                setTimeout(() => location.reload(), 1000);
            })
            .catch(error => {
                if (error.errors?.issue_description) {
                    document.getElementById('issue_error').textContent = error.errors.issue_description[0];
                } else {
                    document.getElementById('issue_error').textContent = 'Terjadi kesalahan. Silakan coba lagi.';
                }
            });
        });
    }

    // === TANDAI SELESAI ===
        document.getElementById('completeMaintenanceForm')?.addEventListener('submit', function(e) {
            e.preventDefault();

            // Reset error
            const notesError = document.getElementById('notes_error');
            if (notesError) notesError.textContent = '';

            const formData = new FormData(this);
            const url = this.getAttribute('action');

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) return response.json().then(err => { throw err; });
                return response.json();
            })
            .then(data => {
                const notif = document.createElement('div');
                notif.innerHTML = `
                    <div class="fixed top-4 right-4 z-50 bg-green-500 text-white px-4 py-2 rounded-md shadow-lg flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        ${data.message}
                    </div>
                `;
                document.body.appendChild(notif);
                setTimeout(() => notif.remove(), 3000);

                // Reload halaman untuk update status
                setTimeout(() => location.reload(), 1000);
            })
            .catch(error => {
                if (error.errors?.resolution_notes) {
                    if (notesError) notesError.textContent = error.errors.resolution_notes[0];
                } else {
                    if (notesError) notesError.textContent = 'Terjadi kesalahan. Silakan coba lagi.';
                }
            });
        });

});
</script>
    @endpush
</x-app-layout>