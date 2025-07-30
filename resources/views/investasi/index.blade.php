@extends('layouts.app')

@section('title', 'Investasi - Financial Management')

@section('content')
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Data Investasi</h1>
                <p class="text-gray-600 mt-1">Kelola investasi dan portofolio Anda</p>
            </div>
            <button onclick="openCreateModal()" class="btn-primary flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Cards View -->
    <div class="md:hidden space-y-4">
        @forelse($investasis as $investasi)
            <div class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition-shadow">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <div class="text-sm text-gray-500">{{ $investasi->tanggal->format('d/m/Y') }}</div>
                        <div class="font-semibold text-gray-900">{{ $investasi->keterangan }}</div>
                    </div>
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                        {{ $investasi->jenis }}
                    </span>
                </div>
                <div class="flex justify-between items-center">
                    <div class="text-lg font-bold text-yellow-600">
                        Rp {{ number_format($investasi->jumlah, 0, ',', '.') }}
                    </div>
                    <div class="flex space-x-2">
                        <button onclick="openEditModal({{ $investasi->id }})" class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                            Edit
                        </button>
                        <button onclick="confirmDelete('{{ route('investasi.destroy', $investasi->id) }}')" class="text-red-600 hover:text-red-900 text-sm font-medium">
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <div class="text-gray-500">Belum ada data investasi</div>
            </div>
        @endforelse
    </div>

    <!-- Desktop Table View -->
    <div class="hidden md:block bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($investasis as $investasi)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $investasi->tanggal->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    {{ $investasi->jenis }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $investasi->keterangan }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-yellow-600">
                                Rp {{ number_format($investasi->jumlah, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button onclick="openEditModal({{ $investasi->id }})" class="text-blue-600 hover:text-blue-900 mr-3 font-medium">
                                    Edit
                                </button>
                                <button onclick="confirmDelete('{{ route('investasi.destroy', $investasi->id) }}')" class="text-red-600 hover:text-red-900 font-medium">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                Belum ada data investasi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($investasis->hasPages())
        <div class="mt-6">
            {{ $investasis->links() }}
        </div>
    @endif

    <!-- Create/Edit Modal -->
    <div id="investasiModal" class="modal-overlay fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="modal-content relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 id="modalTitle" class="text-lg font-medium text-gray-900">Tambah Investasi</h3>
                    <button onclick="closeModal('investasiModal')" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form id="investasiForm" class="space-y-4">
                    @csrf
                    <input type="hidden" id="investasi_id" name="investasi_id">
                    <input type="hidden" id="_method" name="_method" value="POST">

                    <div>
                        <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                        <input type="date" id="tanggal" name="tanggal"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition-colors"
                               required>
                    </div>

                    <div>
                        <label for="jenis" class="block text-sm font-medium text-gray-700">Jenis Investasi</label>
                        <input type="text" id="jenis" name="jenis"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition-colors"
                               placeholder="Contoh: Saham, Reksadana, Emas, dll" required>
                    </div>

                    <div>
                        <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
                        <input type="text" id="keterangan" name="keterangan"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition-colors"
                               required>
                    </div>

                    <div>
                        <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah (Rp)</label>
                        <input type="number" id="jumlah" name="jumlah"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition-colors"
                               min="0" step="0.01" required>
                    </div>

                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" onclick="closeModal('investasiModal')" class="btn-secondary">
                            Batal
                        </button>
                        <button type="submit" class="btn-primary">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    let isEditMode = false;

    function openCreateModal() {
        isEditMode = false;
        document.getElementById('modalTitle').textContent = 'Tambah Investasi';
        document.getElementById('investasiForm').reset();
        document.getElementById('investasi_id').value = '';
        document.getElementById('_method').value = 'POST';
        document.getElementById('tanggal').value = new Date().toISOString().split('T')[0];
        openModal('investasiModal');
    }

    function openEditModal(id) {
        isEditMode = true;
        document.getElementById('modalTitle').textContent = 'Edit Investasi';
        document.getElementById('_method').value = 'PUT';

        // Fetch investasi data
        $.get(`/investasi/${id}/edit`, function(data) {
            document.getElementById('investasi_id').value = data.id;
            document.getElementById('tanggal').value = data.tanggal;
            document.getElementById('jenis').value = data.jenis;
            document.getElementById('keterangan').value = data.keterangan;
            document.getElementById('jumlah').value = data.jumlah;
            openModal('investasiModal');
        });
    }

    // Handle form submission
    $('#investasiForm').on('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const url = isEditMode
            ? `/investasi/${document.getElementById('investasi_id').value}`
            : '/investasi';

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    showSuccess(response.message);
                    closeModal('investasiModal');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    showError(xhr.responseJSON.message);
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    // Handle validation errors
                    let errorMessage = 'Validasi gagal:\n';
                    Object.keys(xhr.responseJSON.errors).forEach(function(key) {
                        errorMessage += '- ' + xhr.responseJSON.errors[key][0] + '\n';
                    });
                    showError(errorMessage);
                } else {
                    showError('Terjadi kesalahan. Silakan coba lagi.');
                }
            }
        });
    });

    // Close modal when clicking outside
    document.getElementById('investasiModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal('investasiModal');
        }
    });
</script>
@endsection
