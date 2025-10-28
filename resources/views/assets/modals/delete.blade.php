<div x-show="showHapusModal"
     x-transition:enter="transition ease-out duration-300" ... (salin transisi)
     class="fixed inset-0 z-50 overflow-y-auto bg-gray-500 bg-opacity-75"
     style="display: none;">
    
    <div class="flex items-center justify-center min-h-screen px-4">
        <div @click.away="showHapusModal = false"
             x-show="showHapusModal" ... (salin transisi)
             class="bg-white rounded-lg shadow-xl overflow-hidden w-full max-w-md">

            <form id="hapusAsetForm" method="POST" :action="deleteUrl">
                @csrf
                @method('DELETE')
                <div class="px-6 py-4 bg-gray-50 border-b">
                    <h3 class="text-lg font-medium text-gray-900">Konfirmasi Hapus</h3>
                </div>
                
                <div class="p-6">
                    <p class="text-sm text-gray-600">Apakah Anda yakin ingin menghapus aset ini? Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                
                <div class="px-6 py-4 bg-gray-50 border-t flex justify-end space-x-3">
                    <button type="button" @click="showHapusModal = false" class="px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit" form="hapusAsetForm" class="px-4 py-2 bg-red-600 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-red-700">
                        Ya, Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>