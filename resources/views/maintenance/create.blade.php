<!-- Modal Laporan Perbaikan -->
<div x-show="showMaintenanceModal"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50"
     style="display: none;">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div @click.away="showMaintenanceModal = false"
             x-show="showMaintenanceModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl overflow-hidden w-full max-w-lg">
            
            <form 
                id="maintenanceForm"
                action="{{ route('maintenance.store', $asset) }}"
                method="POST">
                @csrf
                <input type="hidden" name="asset_id" value="{{ $asset->id }}">
                <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-red-50 dark:bg-red-900/20">
                    <div class="flex items-center">
                        <div class="p-2 bg-red-100 dark:bg-red-900/50 rounded-lg mr-3">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-red-700 dark:text-red-300">
                            Lapor Kerusakan: {{ $asset->nama_barang }}
                        </h3>
                    </div>
                </div>

                <div class="p-6">
                    <label for="issue_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                        Deskripsi Masalah <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        id="issue_description" 
                        name="issue_description" 
                        rows="5" 
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
                        placeholder="Contoh: Tidak bisa nyala, layar biru, printer macet, dll."
                        required></textarea>
                    <div class="text-red-600 text-sm mt-2 min-h-6" id="issue_error"></div>
                </div>

                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-200 dark:border-gray-700 flex justify-end space-x-3">
                    <button type="button" 
                            @click="showMaintenanceModal = false" 
                            class="px-5 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-500 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-500 transition-colors duration-200">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-5 py-2.5 text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 rounded-lg shadow-sm transition-colors duration-200">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        Kirim Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>