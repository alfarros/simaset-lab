<div x-show="showEditModal"
     x-transition:enter="transition ease-out duration-300" ... (salin transisi dari modal tambah)
     class="fixed inset-0 z-50 overflow-y-auto bg-gray-500 bg-opacity-75"
     style="display: none;">
    
    <div class="flex items-center justify-center min-h-screen px-4">
        <div @click.away="showEditModal = false"
             x-show="showEditModal" ... (salin transisi dari modal tambah)
             class="bg-white rounded-lg shadow-xl overflow-hidden w-full max-w-lg">

            <form id="editAsetForm" method="POST" :action="editAssetData.updateUrl">
                @csrf
                @method('PUT')
                <div class="px-6 py-4 bg-gray-50 border-b">
                    <h3 class="text-lg font-medium text-gray-900">Edit Aset</h3>
                </div>
                
                <div class="p-6 space-y-4">
                    <div>
                        <label for="edit_nama_barang" class="block text-sm font-medium text-gray-700">Nama Barang</label>
                        <input type="text" id="edit_nama_barang" name="nama_barang" required :value="editAssetData.nama_barang"
                               class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <div class="text-red-600 text-sm mt-1 form-error" id="edit_nama_barang_error"></div>
                    </div>
                    <div>
                        <label for="edit_kode_aset" class.="block text-sm font-medium text-gray-700">Kode Aset</label>
                        <input type="text" id="edit_kode_aset" name="kode_aset" required :value="editAssetData.kode_aset"
                               class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <div class="text-red-600 text-sm mt-1 form-error" id="edit_kode_aset_error"></div>
                    </div>
                    <div>
                        <label for="edit_kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                        <select id="edit_kategori" name="kategori" required
                                class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                :value="editAssetData.kategori"> 
                                @foreach ($categoriesEnum as $category)
                                <option value="{{ $category->value }}">{{ $category->value }}</option>
                                @endforeach
                        </select>
                        <div class="text-red-600 text-sm mt-1 form-error" id="edit_kategori_error"></div>
                    </div>
                    <div>
                        <label for="edit_lokasi" class="block text-sm font-medium text-gray-700">Lokasi</label>
                        <input type="text" id="edit_lokasi" name="lokasi" required :value="editAssetData.lokasi"
                               class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <div class="text-red-600 text-sm mt-1 form-error" id="edit_lokasi_error"></div>
                    </div>
                    <div>
                        <label for="edit_status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select id="edit_status" name="status" class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm" :value="editAssetData.status">
                            <option value="Tersedia">Tersedia</option>
                            <option value="Dipinjam">Dipinjam</option>
                            <option value="Perbaikan">Perbaikan</option>
                            <option value="Rusak">Rusak</option>
                        </select>
                    </div>
                </div>
                
                <div class="px-6 py-4 bg-gray-50 border-t flex justify-end space-x-3">
                    <button type="button" @click="showEditModal = false" class="px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Tutup
                    </button>
                    <button type="submit" form="editAsetForm" class="px-4 py-2 bg-blue-600 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-blue-700">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

