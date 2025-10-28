<div x-show="showTambahModal"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 overflow-y-auto bg-gray-500 bg-opacity-75"
     style="display: none;">
    
    <div class="flex items-center justify-center min-h-screen px-4">
        <div @click.away="showTambahModal = false"
             x-show="showTambahModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-90"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-90"
             class="bg-white rounded-lg shadow-xl overflow-hidden w-full max-w-lg">

            <form id="tambahAsetForm" action="{{ route('assets.store') }}" method="POST">
                @csrf
                <div class="px-6 py-4 bg-gray-50 border-b">
                    <h3 class="text-lg font-medium text-gray-900">Tambah Aset Baru</h3>
                </div>
                
                <div class="p-6 space-y-4">
                    <div>
                        <label for="nama_barang" class="block text-sm font-medium text-gray-700">Nama Barang</label>
                        <input type="text" id="nama_barang" name="nama_barang" required
                               class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <div class="text-red-600 text-sm mt-1 form-error" id="nama_barang_error"></div>
                    </div>
                    <div>
                        <label for="kode_aset" class="block text-sm font-medium text-gray-700">Kode Aset</label>
                        <input type="text" id="kode_aset" name="kode_aset" required
                               class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <div class="text-red-600 text-sm mt-1 form-error" id="kode_aset_error"></div>
                    </div>
                    <div>
                        <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                        <select id="kategori" name="kategori" required
                                class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="" disabled selected>Pilih sebuah kategori...</option>
                            @foreach ($categoriesEnum as $category)
                                <option value="{{ $category->value }}">{{ $category->value }}</option>
                            @endforeach
                        </select>
                        <div class="text-red-600 text-sm mt-1 form-error" id="kategori_error"></div>
                    </div>
                    <div>
                        <label for="lokasi" class="block text-sm font-medium text-gray-700">Lokasi</label>
                        <input type="text" id="lokasi" name="lokasi" required
                               class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <div class="text-red-600 text-sm mt-1 form-error" id="lokasi_error"></div>
                    </div>
                    <input type="hidden" name="status" value="Tersedia">
                </div>
                
                <div class="px-6 py-4 bg-gray-50 border-t flex justify-end space-x-3">
                    <button type="button" @click="showTambahModal = false" class="px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Tutup
                    </button>
                    <button type="submit" form="tambahAsetForm" class="px-4 py-2 bg-blue-600 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-blue-700">
                        Simpan Aset
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>