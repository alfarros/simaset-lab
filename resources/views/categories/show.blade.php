<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Detail Kategori: {{ $category }}
        </h2>
    </x-slot>

    <div x-data="{
        showEditModal: false,
        editAssetData: {},
        showEditModal: false,
        showStatusModal: false,
        statusUpdateUrl: '',
        currentStatus: ''
    }">

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <a href="{{ route('categories.index') }}" class="mb-4 inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700">
                    &larr; Kembali ke Semua Kategori
                </a>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-2xl font-semibold mb-4">Ringkasan: {{ $category }}</h3>
                        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                            <div class="p-4 bg-blue-50 dark:bg-gray-700 rounded-lg">
                                <div class="text-sm font-medium text-blue-600 dark:text-blue-300">Total Aset</div>
                                <div class="text-3xl font-bold text-blue-900 dark:text-blue-100">{{ $stats['total'] }}</div>
                            </div>
                            <div class="p-4 bg-green-50 dark:bg-gray-700 rounded-lg">
                                <div class="text-sm font-medium text-green-600 dark:text-green-300">Tersedia</div>
                                <div class="text-3xl font-bold text-green-900 dark:text-green-100">{{ $stats['tersedia'] }}</div>
                            </div>
                            <div class="p-4 bg-yellow-50 dark:bg-gray-700 rounded-lg">
                                <div class="text-sm font-medium text-yellow-600 dark:text-yellow-300">Dipinjam</div>
                                <div class="text-3xl font-bold text-yellow-900 dark:text-yellow-100">{{ $stats['dipinjam'] }}</div>
                            </div>
                            <div class="p-4 bg-orange-50 dark:bg-gray-700 rounded-lg">
                                <div class="text-sm font-medium text-orange-600 dark:text-orange-300">Perbaikan</div>
                                <div class="text-3xl font-bold text-orange-900 dark:text-orange-100">{{ $stats['perbaikan'] }}</div>
                            </div>
                            <div class="p-4 bg-red-50 dark:bg-gray-700 rounded-lg">
                                <div class="text-sm font-medium text-red-600 dark:text-red-300">Rusak</div>
                                <div class="text-3xl font-bold text-red-900 dark:text-red-100">{{ $stats['rusak'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @forelse ($assets as $asset)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900 dark:text-gray-100 flex flex-col justify-between h-full">
                                <div>
                                    <div>
                                        @if ($asset->status == 'Tersedia')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Tersedia</span>
                                        @elseif ($asset->status == 'Dipinjam')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Dipinjam</span>
                                        @elseif ($asset->status == 'Perbaikan')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Perbaikan</span>
                                        @elseif ($asset->status == 'Rusak')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rusak</span>
                                        @endif
                                    </div>

                                    <h4 class="mt-4 text-lg font-semibold">{{ $asset->nama_barang }}</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $asset->kode_aset }}</p>
                                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">{{ $asset->lokasi }}</p>
                                </div>

                                <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700 flex items-center space-x-4">
                                    <a href="{{ route('assets.show', $asset->id) }}?back={{ urlencode(request()->fullUrl()) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                        Lihat Detail
                                    </a>

                                    @if(auth()->user()->isAdmin())
                                    <button @click="
                                        showEditModal = true;
                                        editAssetData = {
                                            nama_barang: '{{ $asset->nama_barang }}',
                                            kode_aset: '{{ $asset->kode_aset }}',
                                            kategori: '{{ $asset->kategori }}',
                                            lokasi: '{{ $asset->lokasi }}',
                                            status: '{{ $asset->status }}',
                                            updateUrl: '{{ route('assets.update', $asset->id) }}'
                                        }
                                    " class="text-sm font-medium text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300">
                                        Edit
                                    </button>
                                    @endif

                                    @if(auth()->user()->role == 'staf')
                                    <button @click="
                                        showStatusModal = true;
                                        currentStatus = '{{ $asset->status }}';
                                        statusUpdateUrl = '{{ route('assets.updateStatus', $asset->id) }}';
                                    " class="text-sm font-medium text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300">
                                        Ubah Status
                                    </button>
                                @endif
                                    
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center text-gray-500 dark:text-gray-400 py-10">
                            Tidak ada aset yang ditemukan dalam kategori ini.
                        </div>
                    @endforelse
                </div>

                <div class="mt-6">
                    {{ $assets->links() }}
                </div>

            </div>
        </div>


        @include('assets.modals.edit')
        @include('assets.modals.update_status')

    </div> @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function () {
    // === FORM EDIT ===
    const editAsetForm = document.getElementById('editAsetForm');
    if (editAsetForm) {
        editAsetForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            const url = this.getAttribute('action'); // Ambil langsung dari action form

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) return response.json().then(data => { throw data.errors; });
                return response.json();
            })
            .then(data => {
                alert(data.message);
                location.reload();
            })
            .catch(errors => {
                // Reset error
                this.querySelectorAll('.form-input').forEach(el => el.classList.remove('border-red-500'));
                this.querySelectorAll('.form-error').forEach(el => el.textContent = '');

                for (const field in errors) {
                    const errorEl = this.querySelector(`#edit_${field}_error`);
                    const inputEl = this.querySelector(`#edit_${field}`);
                    if (errorEl && inputEl) {
                        inputEl.classList.add('border-red-500');
                        errorEl.textContent = errors[field][0];
                    }
                }
            });
        });
    }

        // === LOGIKA UNTUK MODAL UPDATE STATUS ===
        const updateStatusForm = document.getElementById('updateStatusForm');
        if (updateStatusForm) {
            updateStatusForm.addEventListener('submit', function (e) {
                e.preventDefault();
                let formData = new FormData(this);
                // Ambil URL dari Alpine
                const alpineWrapper = document.querySelector('[x-data]');
                const statusUpdateUrl = alpineWrapper.__x.$data.statusUpdateUrl;

                fetch(statusUpdateUrl, {
                    method: 'POST',
                    headers: { 
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengubah status.');
                });
            });
        }

    });
    </script>
    @endpush

</x-app-layout>