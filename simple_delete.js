/**
 * Simple Delete Handler untuk Tanggapan
 * Versi sederhana tanpa dependency eksternal
 */

// Fungsi utama untuk konfirmasi delete
function confirmDeleteTanggapan(element) {
    // Cegah double click
    if (element.classList.contains('processing')) {
        return false;
    }

    // Ambil data dari element
    const responseId = element.getAttribute('data-id') || element.href.split('=')[1];
    const responseText = element.getAttribute('data-text') || 'tanggapan ini';
    const deleteUrl = element.href;

    // Validasi data
    if (!responseId || !deleteUrl) {
        showAlert('Data tidak lengkap untuk menghapus tanggapan', 'error');
        return false;
    }

    // Tampilkan konfirmasi
    const confirmMessage = createConfirmMessage(responseText);
    
    if (confirm(confirmMessage)) {
        // Tandai sedang processing
        element.classList.add('processing');
        element.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menghapus...';
        element.style.pointerEvents = 'none';

        // Tampilkan loading
        showLoadingMessage();

        // Simulasi delay untuk UX yang lebih baik
        setTimeout(() => {
            // Redirect ke URL delete
            window.location.href = deleteUrl;
        }, 1000);

        return true;
    }
    
    return false;
}

// Buat pesan konfirmasi yang informatif
function createConfirmMessage(responseText) {
    const truncatedText = responseText.length > 50 
        ? responseText.substring(0, 50) + '...' 
        : responseText;
    
    return `🗑️ KONFIRMASI HAPUS TANGGAPAN\n\n` +
           `Tanggapan: "${truncatedText}"\n\n` +
           `⚠️ PERINGATAN:\n` +
           `• Tindakan ini TIDAK DAPAT DIBATALKAN\n` +
           `• Status pengaduan akan berubah menjadi "Belum Ditanggapi"\n` +
           `• Data tanggapan akan hilang permanen\n\n` +
           `Apakah Anda yakin ingin melanjutkan?`;
}

// Tampilkan loading message
function showLoadingMessage() {
    // Buat overlay loading
    const overlay = document.createElement('div');
    overlay.id = 'deleteLoadingOverlay';
    overlay.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        font-family: Arial, sans-serif;
    `;

    overlay.innerHTML = `
        <div style="
            background: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            min-width: 250px;
        ">
            <div style="
                width: 40px;
                height: 40px;
                border: 4px solid #f3f3f3;
                border-top: 4px solid #dc3545;
                border-radius: 50%;
                animation: spin 1s linear infinite;
                margin: 0 auto 20px;
            "></div>
            <h4 style="margin: 0 0 10px 0; color: #333;">Menghapus Tanggapan</h4>
            <p style="margin: 0; color: #666;">Mohon tunggu sebentar...</p>
        </div>
    `;

    // Tambahkan CSS animation
    if (!document.getElementById('spinnerStyle')) {
        const style = document.createElement('style');
        style.id = 'spinnerStyle';
        style.textContent = `
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        `;
        document.head.appendChild(style);
    }

    document.body.appendChild(overlay);
}

// Tampilkan alert message
function showAlert(message, type = 'info') {
    const alertColors = {
        success: { bg: '#d4edda', border: '#c3e6cb', text: '#155724', icon: '✅' },
        error: { bg: '#f8d7da', border: '#f5c6cb', text: '#721c24', icon: '❌' },
        warning: { bg: '#fff3cd', border: '#ffeaa7', text: '#856404', icon: '⚠️' },
        info: { bg: '#d1ecf1', border: '#bee5eb', text: '#0c5460', icon: 'ℹ️' }
    };

    const colors = alertColors[type] || alertColors.info;

    const alert = document.createElement('div');
    alert.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${colors.bg};
        color: ${colors.text};
        border: 2px solid ${colors.border};
        padding: 15px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        z-index: 10000;
        font-family: Arial, sans-serif;
        font-size: 14px;
        max-width: 350px;
        word-wrap: break-word;
        animation: slideInRight 0.3s ease-out;
    `;

    alert.innerHTML = `
        <div style="display: flex; align-items: center; gap: 10px;">
            <span style="font-size: 18px;">${colors.icon}</span>
            <span style="flex: 1;">${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" 
                    style="background: none; border: none; font-size: 18px; cursor: pointer; color: ${colors.text}; opacity: 0.7;"
                    onmouseover="this.style.opacity='1'" 
                    onmouseout="this.style.opacity='0.7'">×</button>
        </div>
    `;

    // Tambahkan animation CSS jika belum ada
    if (!document.getElementById('alertAnimationStyle')) {
        const style = document.createElement('style');
        style.id = 'alertAnimationStyle';
        style.textContent = `
            @keyframes slideInRight {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
        `;
        document.head.appendChild(style);
    }

    document.body.appendChild(alert);

    // Auto remove setelah 5 detik
    setTimeout(() => {
        if (alert.parentNode) {
            alert.style.opacity = '0';
            alert.style.transform = 'translateX(100%)';
            setTimeout(() => alert.remove(), 300);
        }
    }, 5000);
}

// Handle untuk tombol delete dengan class tertentu
function setupDeleteButtons() {
    // Setup untuk tombol dengan class btn-delete-response
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-delete-response') || 
            e.target.closest('.btn-delete-response')) {
            
            e.preventDefault();
            const button = e.target.classList.contains('btn-delete-response') 
                ? e.target 
                : e.target.closest('.btn-delete-response');
            
            confirmDeleteTanggapan(button);
        }
    });

    // Setup untuk link dengan onclick
    const deleteLinks = document.querySelectorAll('a[href*="hapus_tanggapan"]');
    deleteLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            confirmDeleteTanggapan(this);
        });
    });
}

// Inisialisasi ketika DOM ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', setupDeleteButtons);
} else {
    setupDeleteButtons();
}

// Tambahkan fungsi untuk menampilkan pesan berdasarkan URL parameter
function checkUrlParameters() {
    const urlParams = new URLSearchParams(window.location.search);
    
    if (urlParams.has('deleted') && urlParams.get('deleted') === 'success') {
        showAlert('✅ Tanggapan berhasil dihapus!', 'success');
        
        // Bersihkan URL parameter
        const newUrl = window.location.pathname;
        window.history.replaceState({}, document.title, newUrl);
    }
    
    if (urlParams.has('error')) {
        const errorType = urlParams.get('error');
        let errorMessage = 'Terjadi kesalahan saat menghapus tanggapan';
        
        switch(errorType) {
            case 'not_found':
                errorMessage = 'Tanggapan tidak ditemukan';
                break;
            case 'invalid_id':
                errorMessage = 'ID tanggapan tidak valid';
                break;
            case 'permission_denied':
                errorMessage = 'Anda tidak memiliki izin untuk menghapus tanggapan';
                break;
            case 'database_error':
                errorMessage = 'Terjadi kesalahan database';
                break;
        }
        
        showAlert(errorMessage, 'error');
        
        // Bersihkan URL parameter
        const newUrl = window.location.pathname;
        window.history.replaceState({}, document.title, newUrl);
    }
}

// Jalankan pengecekan URL parameters
checkUrlParameters();

// Export functions untuk penggunaan global
window.confirmDeleteTanggapan = confirmDeleteTanggapan;
window.showAlert = showAlert;