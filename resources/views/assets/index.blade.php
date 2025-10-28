<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Manajemen Aset') }}
        </h2>
    </x-slot>

    <div x-data="{
        showTambahModal: false,
        showEditModal: false,
        showHapusModal: false,
        editAssetData: {},
        deleteUrl: '',
        showStatusModal: false,
        statusUpdateUrl: '',
        currentStatus: '',
        
    }">

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        @if (session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(auth()->user()->isAdmin())
                        <button @click="showTambahModal = true" class="mb-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Tambah Aset Baru
                        </button>
                        @endif
                        

                        <!-- Form Pencarian -->
                        <div class="mb-6">
                            <form method="GET" action="{{ route('assets.index') }}" class="flex gap-2">
                                <input
                                    type="text"
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="Cari aset (nama, kode, kategori, lokasi, status)..."
                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                >
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                                    Cari
                                </button>
                                @if(request()->has('search'))
                                    <a href="{{ route('assets.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">
                                        Reset
                                    </a>
                                @endif
                            </form>
                        </div>

                        <div class="overflow-x-auto border border-gray-200 rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <a href="{{ route('assets.index', array_filter([
                                                'sort_by' => 'nama_barang',
                                                'order' => ($sortBy == 'nama_barang' && $order == 'asc') ? 'desc' : 'asc',
                                                'search' => request('search')
                                                ])) }}" class="flex items-center">
                                                Nama Barang
                                                @if ($sortBy == 'nama_barang')
                                                    <span class="ml-1" aria-hidden="true">
                                                        {!! $order == 'asc' ? '&#9650;' : '&#9660;' !!}
                                                    </span>
                                                @endif
                                            </a>
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <a href="{{ route('assets.index', array_filter([
                                                'sort_by' => 'kode_aset', 
                                                'order' => ($sortBy == 'kode_aset' && $order == 'asc') ? 'desc' : 'asc',
                                                'search' => request('search')
                                                ])) }}" class="flex items-center">
                                                Kode
                                                @if ($sortBy == 'kode_aset')
                                                    <span class="ml-1">
                                                        {!! $order == 'asc' ? '&#9650;' : '&#9660;' !!}
                                                    </span>
                                                @endif
                                            </a>
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <a href="{{ route('assets.index', array_filter([
                                                'sort_by' => 'kategori',
                                                'order' => ($sortBy == 'kategori' && $order == 'asc') ? 'desc' : 'asc',
                                                'search' => request('search')
                                                ])) }}" class="flex items-center">
                                                Kategori
                                                @if ($sortBy == 'kategori')
                                                    <span class="ml-1">
                                                        {!! $order == 'asc' ? '&#9650;' : '&#9660;' !!}
                                                    </span>
                                                @endif
                                            </a>
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <a href="{{ route('assets.index', array_filter([
                                            'sort_by' => 'lokasi', 
                                            'order' => ($sortBy == 'lokasi' && $order == 'asc') ? 'desc' : 'asc',
                                            'search' => request('search')
                                            ])) }}" class="flex items-center">
                                                Lokasi
                                                @if ($sortBy == 'lokasi')
                                                    <span class="ml-1">
                                                        {!! $order == 'asc' ? '&#9650;' : '&#9660;' !!}
                                                    </span>
                                                @endif
                                            </a>
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <a href="{{ route('assets.index', array_filter([
                                            'sort_by' => 'status',
                                            'order' => ($sortBy == 'status' && $order == 'asc') ? 'desc' : 'asc',
                                            'search' => request('search')
                                            ])) }}" class="flex items-center">
                                                Status
                                                @if ($sortBy == 'status')
                                                    <span class="ml-1">
                                                        {!! $order == 'asc' ? '&#9650;' : '&#9660;' !!}
                                                    </span>
                                                @endif
                                            </a>
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($assets as $asset)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $asset->nama_barang }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $asset->kode_aset }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $asset->kategori }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $asset->lokasi }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $asset->status }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('assets.show', $asset->id) }}" class="text-indigo-600 hover:text-indigo-900">Lihat</a>
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
                                                " class="ml-4 text-yellow-600 hover:text-yellow-900">Edit</button>

                                                <button @click="
                                                    showHapusModal = true;
                                                    deleteUrl = '{{ route('assets.destroy', $asset->id) }}'
                                                " class="ml-4 text-red-600 hover:text-red-900">Hapus</button>
                                                @endif

                                                @if(auth()->user()->role == 'staf')
                                                 <button @click="
                                                        showStatusModal = true;
                                                        currentStatus = '{{ $asset->status }}';
                                                        statusUpdateUrl = '{{ route('assets.updateStatus', $asset->id) }}';
                                                    " class="ml-4 text-green-600 hover:text-green-900">
                                                    Ubah Status
                                                </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Data Aset belum tersedia.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4">
                            {{ $assets->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @include('assets.modals.create')
    @include('assets.modals.edit')
    @include('assets.modals.delete')
    @include('assets.modals.update_status')

    </div> 
    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        
        // === 1. LOGIKA UNTUK MODAL TAMBAH ASET ===
        const tambahAsetForm = document.getElementById('tambahAsetForm');
        if (tambahAsetForm) {
            tambahAsetForm.addEventListener('submit', function(event) {
                event.preventDefault();
                let formData = new FormData(this);
                let url = this.action;
                fetch(url, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), 'Accept': 'application/json' },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) { return response.json().then(data => { throw data.errors; }); }
                    return response.json();
                })
                .then(data => {
                    alert(data.message);
                    location.reload(); // Reload halaman, modal akan tertutup otomatis
                })
                .catch(errors => {
                    // Tampilkan error validasi (Ganti class 'form-control' & 'is-invalid' dengan Tailwind)
                    document.querySelectorAll('.form-input').forEach(el => el.classList.remove('border-red-500'));
                    document.querySelectorAll('.form-error').forEach(el => el.textContent = '');
                    
                    for (const field in errors) {
                        let errorElement = document.getElementById(field + '_error');
                        let inputElement = document.getElementById(field);
                        if (errorElement) {
                            inputElement.classList.add('border-red-500'); // Class error Tailwind
                            errorElement.textContent = errors[field][0];
                        }
                    }
                });
            });
        }

        // === 2. LOGIKA UNTUK MODAL EDIT ASET ===
        const editAsetForm = document.getElementById('editAsetForm');
        if (editAsetForm) {
            editAsetForm.addEventListener('submit', function (e) {
                e.preventDefault();
                let formData = new FormData(this);
                // 'this.action' akan otomatis diisi oleh Alpine :action
                fetch(this.action, {
                    method: 'POST', // @method('PUT') akan menanganinya
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), 'Accept': 'application/json' },
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
                .catch(errors => { /* Logika tampilkan error validasi (sama seperti 'tambah') */ });
            });
        }

        // === 3. LOGIKA UNTUK MODAL HAPUS ASET ===
        const hapusAsetForm = document.getElementById('hapusAsetForm');
        if (hapusAsetForm) {
            // Kita TIDAK PERLU 'show.bs.modal' lagi!

            hapusAsetForm.addEventListener('submit', function (e) {
                e.preventDefault();
                // 'this.action' akan otomatis diisi oleh Alpine :action
                fetch(this.action, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), 'Accept': 'application/json' }
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    location.reload();
                })
                .catch(error => console.error('Error:', error));
            });
        }

        // === 4. LOGIKA UNTUK MODAL UPDATE STATUS ASET ===
        const updateStatusAsetForm = document.getElementById('updateStatusForm');
        if (updateStatusAsetForm) {
            updateStatusAsetForm.addEventListener('submit', function (e) {
                e.preventDefault();
                let formData = new FormData(this);
                // 'this.action' akan otomatis diisi oleh Alpine :action
                fetch(this.action, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), 'Accept': 'application/json' },
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
                .catch(error => console.error('Error:', error));
            });
        }

     });
</script>
@endpush
</x-app-layout>