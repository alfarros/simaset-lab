<div x-show="showStatusModal" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 overflow-y-auto bg-gray-500 bg-opacity-75 flex items-center justify-center px-4" 
     style="display: none;"> 
     <div @click.away="showStatusModal = false" 
         x-show="showStatusModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform scale-90"
         x-transition:enter-end="opacity-100 transform scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform scale-100"
         x-transition:leave-end="opacity-0 transform scale-90"
         class="bg-white rounded-lg shadow-xl overflow-hidden w-full max-w-sm">

        <form id="updateStatusForm" method="POST" :action="statusUpdateUrl">
            @csrf
            @method('PATCH')
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Ubah Status Aset</h3>
            </div>
            
            <div class="p-6">
                <label for="new_status" class="block text-sm font-medium text-gray-700">Pilih Status Baru</label>
                <select id="new_status" name="status" required
                        class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        x-init="$watch('currentStatus', value => $el.value = value)" :value="currentStatus"> <option value="Tersedia">Tersedia</option>
                    <option value="Dipinjam">Dipinjam</option>
                    <option value="Perbaikan">Perbaikan</option>
                    <option value="Rusak">Rusak</option>
                </select>
                <div class="text-red-600 text-sm mt-1 form-error" id="status_error"></div>
            </div>
            
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3">
                <button type="button" @click="showStatusModal = false" class="px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit" form="updateStatusForm" class="px-4 py-2 bg-blue-600 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-blue-700">
                    Simpan Status
                </button>
            </div>
        </form>
    </div>