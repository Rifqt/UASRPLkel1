/**
 * JavaScript untuk Manajemen Tanggapan
 * Mengelola pemilihan multiple checkbox dan penghapusan tanggapan
 */

document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi elemen-elemen DOM
    const checkAll = document.getElementById('checkAll');
    const tanggapanCheckboxes = document.querySelectorAll('.tanggapan-checkbox');
    const btnHapusTerpilih = document.getElementById('btnHapusTerpilih');
    const btnPilihSemua = document.getElementById('btnPilihSemua');
    const btnBatalPilih = document.getElementById('btnBatalPilih');
    const formHapus = document.getElementById('formHapusTanggapan');
    const searchInput = document.getElementById('searchTanggapan');
    const filterStatus = document.getElementById('filterStatus');

    // Fungsi untuk mengupdate status tombol berdasarkan checkbox yang dipilih
    function updateButtonState() {
        const checkedBoxes = document.querySelectorAll('.tanggapan-checkbox:checked');
        const checkedCount = checkedBoxes.length;
        
        // Update tombol hapus
        btnHapusTerpilih.disabled = checkedCount === 0;
        
        // Update text tombol dengan counter
        if (checkedCount > 0) {
            btnHapusTerpilih.innerHTML = `<i class="fas fa-trash"></i> Hapus Terpilih (${checkedCount})`;
            btnHapusTerpilih.classList.remove('btn-danger');
            btnHapusTerpilih.classList.add('btn-danger');
        } else {
            btnHapusTerpilih.innerHTML = '<i class="fas fa-trash"></i> Hapus Terpilih';
            btnHapusTerpilih.classList.remove('btn-danger');
            btnHapusTerpilih.classList.add('btn-secondary');
        }
        
        // Update status checkbox "Pilih Semua"
        updateCheckAllState();
    }

    // Fungsi untuk mengupdate status checkbox "Pilih Semua"
    function updateCheckAllState() {
        const visibleCheckboxes = getVisibleCheckboxes();
        const checkedVisible = visibleCheckboxes.filter(cb => cb.checked).length;
        
        if (checkedVisible === 0) {
            checkAll.checked = false;
            checkAll.indeterminate = false;
        } else if (checkedVisible === visibleCheckboxes.length) {
            checkAll.checked = true;
            checkAll.indeterminate = false;
        } else {
            checkAll.checked = false;
            checkAll.indeterminate = true;
        }
    }

    // Fungsi untuk mendapatkan checkbox yang terlihat (tidak tersembunyi oleh filter)
    function getVisibleCheckboxes() {
        return Array.from(tanggapanCheckboxes).filter(checkbox => {
            const row = checkbox.closest('tr');
            return row && row.style.display !== 'none';
        });
    }

    // Event listener untuk checkbox "Pilih Semua"
    checkAll.addEventListener('change', function() {
        const visibleCheckboxes = getVisibleCheckboxes();
        visibleCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
            highlightRow(checkbox);
        });
        updateButtonState();
    });

    // Event listener untuk checkbox individual
    tanggapanCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            highlightRow(this);
            updateButtonState();
        });
    });

    // Fungsi untuk highlight baris yang dipilih
    function highlightRow(checkbox) {
        const row = checkbox.closest('tr');
        if (checkbox.checked) {
            row.classList.add('table-warning');
        } else {
            row.classList.remove('table-warning');
        }
    }

    // Tombol "Pilih Semua"
    btnPilihSemua.addEventListener('click', function() {
        const visibleCheckboxes = getVisibleCheckboxes();
        checkAll.checked = true;
        visibleCheckboxes.forEach(checkbox => {
            checkbox.checked = true;
            highlightRow(checkbox);
        });
        updateButtonState();
        
        // Animasi feedback
        this.classList.add('btn-success');
        setTimeout(() => {
            this.classList.remove('btn-success');
        }, 200);
    });

    // Tombol "Batal Pilih"
    btnBatalPilih.addEventListener('click', function() {
        checkAll.checked = false;
        checkAll.indeterminate = false;
        tanggapanCheckboxes.forEach(checkbox => {
            checkbox.checked = false;
            highlightRow(checkbox);
        });
        updateButtonState();
        
        // Animasi feedback
        this.classList.add('btn-info');
        setTimeout(() => {
            this.classList.remove('btn-info');
        }, 200);
    });

    // Tombol "Hapus Terpilih"
    btnHapusTerpilih.addEventListener('click', function() {
        const checkedBoxes = document.querySelectorAll('.tanggapan-checkbox:checked');
        
        if (checkedBoxes.length === 0) {
            showAlert('Pilih setidaknya satu tanggapan untuk dihapus!', 'warning');
            return;
        }

        // Buat daftar tanggapan yang akan dihapus untuk konfirmasi
        const selectedData = Array.from(checkedBoxes).map(cb => {
            const row = cb.closest('tr');
            const nik = row.cells[2].textContent;
            const tanggal = row.cells[5].textContent;
            return `• NIK: ${nik} (${tanggal})`;
        });

        const confirmMessage = `Yakin ingin menghapus ${checkedBoxes.length} tanggapan berikut?\n\n${selectedData.join('\n')}\n\n⚠️ Tindakan ini tidak dapat dibatalkan!`;
        
        if (confirm(confirmMessage)) {
            // Loading state
            this.disabled = true;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menghapus...';
            
            formHapus.submit();
        }
    });

    // Fitur pencarian real-time
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            filterTable(searchTerm);
        });
    }

    // Fitur filter status
    if (filterStatus) {
        filterStatus.addEventListener('change', function() {
            const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
            filterTable(searchTerm);
        });
    }

    // Fungsi untuk filter tabel
    function filterTable(searchTerm = '') {
        const rows = document.querySelectorAll('tbody tr');
        let visibleCount = 0;

        rows.forEach(row => {
            const cells = row.cells;
            let shouldShow = true;

            // Filter berdasarkan pencarian
            if (searchTerm) {
                const searchableText = [
                    cells[2].textContent, // NIK
                    cells[4].textContent, // Laporan
                    cells[6].textContent, // Tanggapan
                    cells[7].textContent  // Nama Petugas
                ].join(' ').toLowerCase();

                shouldShow = searchableText.includes(searchTerm);
            }

            // Filter berdasarkan status (jika ada)
            if (shouldShow && filterStatus && filterStatus.value !== '') {
                // Implementasi filter status bisa disesuaikan
                // Contoh: filter berdasarkan bulan tanggapan
                const tanggalTanggapan = cells[5].textContent;
                // Custom logic untuk filter status
            }

            // Tampilkan/sembunyikan baris
            if (shouldShow) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
                // Uncheck checkbox untuk baris yang disembunyikan
                const checkbox = row.querySelector('.tanggapan-checkbox');
                if (checkbox && checkbox.checked) {
                    checkbox.checked = false;
                    highlightRow(checkbox);
                }
            }
        });

        // Update counter dan button state
        updateButtonState();
        updateResultCounter(visibleCount, rows.length);
    }

    // Fungsi untuk update counter hasil pencarian
    function updateResultCounter(visible, total) {
        let counterElement = document.getElementById('searchCounter');
        if (!counterElement) {
            counterElement = document.createElement('small');
            counterElement.id = 'searchCounter';
            counterElement.className = 'text-muted ms-2';
            if (searchInput) {
                searchInput.parentNode.appendChild(counterElement);
            }
        }

        if (visible < total) {
            counterElement.textContent = `Menampilkan ${visible} dari ${total} tanggapan`;
        } else {
            counterElement.textContent = '';
        }
    }

    // Fungsi untuk menampilkan alert custom
    function showAlert(message, type = 'info') {
        // Hapus alert sebelumnya jika ada
        const existingAlert = document.querySelector('.custom-alert');
        if (existingAlert) {
            existingAlert.remove();
        }

        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show custom-alert`;
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        // Insert alert di bagian atas form
        formHapus.insertBefore(alertDiv, formHapus.firstChild);

        // Auto dismiss setelah 5 detik
        setTimeout(() => {
            if (alertDiv && alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 5000);
    }

    // Fungsi untuk keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl + A untuk pilih semua
        if (e.ctrlKey && e.key === 'a' && e.target.tagName !== 'INPUT') {
            e.preventDefault();
            btnPilihSemua.click();
        }
        
        // Delete key untuk hapus yang terpilih
        if (e.key === 'Delete' && e.target.tagName !== 'INPUT') {
            e.preventDefault();
            if (!btnHapusTerpilih.disabled) {
                btnHapusTerpilih.click();
            }
        }
        
        // Escape untuk batal pilih
        if (e.key === 'Escape') {
            btnBatalPilih.click();
        }
    });

    // Tooltip untuk tombol (jika menggunakan Bootstrap)
    if (typeof bootstrap !== 'undefined') {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    // Animasi loading untuk form submit
    formHapus.addEventListener('submit', function() {
        const submitBtn = btnHapusTerpilih;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
    });

    // Initial state
    updateButtonState();
    
    // Auto-refresh setiap 30 detik (opsional)
    // setInterval(function() {
    //     if (document.querySelectorAll('.tanggapan-checkbox:checked').length === 0) {
    //         location.reload();
    //     }
    // }, 30000);

    console.log('✅ Tanggapan management system initialized');
});