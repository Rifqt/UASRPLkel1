/**
 * Delete Response Handler
 * Menangani penghapusan tanggapan dengan konfirmasi dan loading state
 */

class DeleteResponseHandler {
    constructor() {
        this.isProcessing = false;
        this.init();
    }

    init() {
        // Bind event listeners
        this.bindDeleteButtons();
        this.createLoadingOverlay();
        this.createConfirmModal();
    }

    /**
     * Bind event listeners untuk tombol delete
     */
    bindDeleteButtons() {
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('btn-delete-response') || 
                e.target.closest('.btn-delete-response')) {
                e.preventDefault();
                
                const button = e.target.classList.contains('btn-delete-response') 
                    ? e.target 
                    : e.target.closest('.btn-delete-response');
                
                this.handleDeleteClick(button);
            }
        });
    }

    /**
     * Handle klik tombol delete
     */
    async handleDeleteClick(button) {
        if (this.isProcessing) {
            this.showAlert('Sedang memproses permintaan sebelumnya...', 'warning');
            return;
        }

        const responseId = button.getAttribute('data-id');
        const responseText = button.getAttribute('data-text') || 'tanggapan ini';
        const deleteUrl = button.getAttribute('href') || button.getAttribute('data-url');

        if (!responseId || !deleteUrl) {
            this.showAlert('Data tidak lengkap untuk menghapus tanggapan', 'error');
            return;
        }

        // Tampilkan modal konfirmasi
        this.showConfirmModal(responseId, responseText, deleteUrl);
    }

    /**
     * Tampilkan modal konfirmasi
     */
    showConfirmModal(responseId, responseText, deleteUrl) {
        const modal = document.getElementById('deleteConfirmModal');
        const responsePreview = document.getElementById('responsePreview');
        const confirmBtn = document.getElementById('confirmDeleteBtn');

        // Set preview text
        const previewText = responseText.length > 100 
            ? responseText.substring(0, 100) + '...' 
            : responseText;
        responsePreview.textContent = previewText;

        // Set confirm button action
        confirmBtn.onclick = () => {
            this.executeDelete(deleteUrl, responseId);
            this.hideModal(modal);
        };

        this.showModal(modal);
    }

    /**
     * Eksekusi penghapusan
     */
    async executeDelete(deleteUrl, responseId) {
        this.isProcessing = true;
        this.showLoadingOverlay('Menghapus tanggapan...');

        try {
            // Cek apakah menggunakan AJAX atau redirect
            if (this.shouldUseAjax()) {
                await this.deleteWithAjax(deleteUrl, responseId);
            } else {
                await this.deleteWithRedirect(deleteUrl);
            }
        } catch (error) {
            console.error('Delete error:', error);
            this.showAlert('Terjadi kesalahan saat menghapus tanggapan', 'error');
        } finally {
            this.isProcessing = false;
            this.hideLoadingOverlay();
        }
    }

    /**
     * Delete menggunakan AJAX
     */
    async deleteWithAjax(deleteUrl, responseId) {
        const response = await fetch(deleteUrl, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (response.ok) {
            const result = await response.text();
            
            // Cek apakah response berisi error
            if (result.includes('error') || result.includes('gagal')) {
                throw new Error('Server returned error');
            }

            // Hapus baris dari tabel
            this.removeTableRow(responseId);
            this.showAlert('Tanggapan berhasil dihapus!', 'success');
            
            // Reload halaman setelah 2 detik
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        } else {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
    }

    /**
     * Delete menggunakan redirect
     */
    async deleteWithRedirect(deleteUrl) {
        // Tambahkan delay untuk loading effect
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        // Redirect ke URL delete
        window.location.href = deleteUrl;
    }

    /**
     * Hapus baris dari tabel
     */
    removeTableRow(responseId) {
        const row = document.querySelector(`tr[data-id="${responseId}"]`);
        if (row) {
            row.style.transition = 'opacity 0.3s ease-out';
            row.style.opacity = '0';
            
            setTimeout(() => {
                row.remove();
                this.updateTableNumbers();
            }, 300);
        }
    }

    /**
     * Update nomor urut tabel setelah delete
     */
    updateTableNumbers() {
        const numberCells = document.querySelectorAll('table tbody tr td:first-child');
        numberCells.forEach((cell, index) => {
            cell.textContent = index + 1;
        });
    }

    /**
     * Cek apakah harus menggunakan AJAX
     */
    shouldUseAjax() {
        // Gunakan AJAX jika jQuery tersedia dan bukan mobile
        return typeof $ !== 'undefined' && !this.isMobile();
    }

    /**
     * Cek apakah device mobile
     */
    isMobile() {
        return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    }

    /**
     * Buat loading overlay
     */
    createLoadingOverlay() {
        if (document.getElementById('loadingOverlay')) return;

        const overlay = document.createElement('div');
        overlay.id = 'loadingOverlay';
        overlay.className = 'loading-overlay';
        overlay.innerHTML = `
            <div class="loading-content">
                <div class="spinner"></div>
                <p id="loadingText">Memproses...</p>
            </div>
        `;

        document.body.appendChild(overlay);
    }

    /**
     * Buat modal konfirmasi
     */
    createConfirmModal() {
        if (document.getElementById('deleteConfirmModal')) return;

        const modal = document.createElement('div');
        modal.id = 'deleteConfirmModal';
        modal.className = 'modal-overlay';
        modal.innerHTML = `
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Konfirmasi Hapus Tanggapan</h5>
                    <button type="button" class="modal-close" onclick="deleteHandler.hideModal(this.closest('.modal-overlay'))">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Peringatan!</strong> Tindakan ini tidak dapat dibatalkan.
                    </div>
                    <p>Apakah Anda yakin ingin menghapus tanggapan berikut?</p>
                    <div class="response-preview">
                        <strong>Tanggapan:</strong>
                        <p id="responsePreview" class="text-muted"></p>
                    </div>
                    <p class="text-info">
                        <i class="fas fa-info-circle"></i>
                        Status pengaduan akan berubah menjadi "Belum Ditanggapi"
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="deleteHandler.hideModal(this.closest('.modal-overlay'))">
                        Batal
                    </button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                        <i class="fas fa-trash"></i> Ya, Hapus
                    </button>
                </div>
            </div>
        `;

        document.body.appendChild(modal);
    }

    /**
     * Tampilkan loading overlay
     */
    showLoadingOverlay(text = 'Memproses...') {
        const overlay = document.getElementById('loadingOverlay');
        const loadingText = document.getElementById('loadingText');
        
        if (loadingText) loadingText.textContent = text;
        if (overlay) overlay.style.display = 'flex';
    }

    /**
     * Sembunyikan loading overlay
     */
    hideLoadingOverlay() {
        const overlay = document.getElementById('loadingOverlay');
        if (overlay) overlay.style.display = 'none';
    }

    /**
     * Tampilkan modal
     */
    showModal(modal) {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        // Fokus ke modal untuk accessibility
        setTimeout(() => {
            const firstButton = modal.querySelector('button');
            if (firstButton) firstButton.focus();
        }, 100);
    }

    /**
     * Sembunyikan modal
     */
    hideModal(modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    /**
     * Tampilkan alert
     */
    showAlert(message, type = 'info') {
        // Hapus alert sebelumnya
        const existingAlert = document.querySelector('.custom-alert');
        if (existingAlert) existingAlert.remove();

        const alertDiv = document.createElement('div');
        alertDiv.className = `custom-alert alert-${type}`;
        
        const icon = this.getAlertIcon(type);
        alertDiv.innerHTML = `
            <div class="alert-content">
                <i class="${icon}"></i>
                <span>${message}</span>
                <button type="button" class="alert-close" onclick="this.parentElement.parentElement.remove()">&times;</button>
            </div>
        `;

        document.body.appendChild(alertDiv);

        // Auto hide setelah 5 detik
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.style.opacity = '0';
                setTimeout(() => alertDiv.remove(), 300);
            }
        }, 5000);
    }

    /**
     * Get icon untuk alert
     */
    getAlertIcon(type) {
        const icons = {
            success: 'fas fa-check-circle',
            error: 'fas fa-exclamation-circle',
            warning: 'fas fa-exclamation-triangle',
            info: 'fas fa-info-circle'
        };
        return icons[type] || icons.info;
    }
}

// CSS Styles
const styles = `
<style>
.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.loading-content {
    background: white;
    padding: 30px;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
}

.spinner {
    width: 40px;
    height: 40px;
    border: 4px solid #f3f3f3;
    border-top: 4px solid #007bff;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto 15px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.modal-content {
    background: white;
    border-radius: 8px;
    width: 90%;
    max-width: 500px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
}

.modal-header {
    padding: 20px;
    border-bottom: 1px solid #dee2e6;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h5 {
    margin: 0;
    color: #333;
}

.modal-close {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
    color: #999;
}

.modal-close:hover {
    color: #333;
}

.modal-body {
    padding: 20px;
}

.modal-footer {
    padding: 20px;
    border-top: 1px solid #dee2e6;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.response-preview {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 5px;
    margin: 15px 0;
    border-left: 4px solid #007bff;
}

.alert {
    padding: 12px 15px;
    border-radius: 5px;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.alert-warning {
    background: #fff3cd;
    border: 1px solid #ffeaa7;
    color: #856404;
}

.custom-alert {
    position: fixed;
    top: 20px;
    right: 20px;
    min-width: 300px;
    z-index: 10000;
    border-radius: 5px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    animation: slideIn 0.3s ease-out;
}

.custom-alert.alert-success {
    background: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
}

.custom-alert.alert-error {
    background: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
}

.custom-alert.alert-warning {
    background: #fff3cd;
    border: 1px solid #ffeaa7;
    color: #856404;
}

.custom-alert.alert-info {
    background: #d1ecf1;
    border: 1px solid #bee5eb;
    color: #0c5460;
}

.alert-content {
    padding: 15px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.alert-close {
    background: none;
    border: none;
    font-size: 20px;
    cursor: pointer;
    margin-left: auto;
    opacity: 0.7;
}

.alert-close:hover {
    opacity: 1;
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.btn {
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 14px;
    transition: all 0.2s;
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #5a6268;
}

.btn-danger {
    background: #dc3545;
    color: white;
}

.btn-danger:hover {
    background: #c82333;
}

.text-muted {
    color: #6c757d !important;
}

.text-info {
    color: #17a2b8 !important;
}

@media (max-width: 768px) {
    .modal-content {
        width: 95%;
        margin: 20px;
    }
    
    .custom-alert {
        right: 10px;
        left: 10px;
        min-width: auto;
    }
    
    .modal-footer {
        flex-direction: column;
    }
    
    .modal-footer .btn {
        justify-content: center;
    }
}
</style>
`;

// Inject styles
document.head.insertAdjacentHTML('beforeend', styles);

// Initialize handler ketika DOM ready
let deleteHandler;

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function() {
        deleteHandler = new DeleteResponseHandler();
    });
} else {
    deleteHandler = new DeleteResponseHandler();
}

// Fallback function untuk onclick handler
function confirmDeleteResponse(button) {
    if (deleteHandler) {
        deleteHandler.handleDeleteClick(button);
    } else {
        // Fallback ke confirm biasa
        const responseText = button.getAttribute('data-text') || 'tanggapan ini';
        const confirmed = confirm('Apakah Anda yakin ingin menghapus ' + responseText + '?\n\nTindakan ini tidak dapat dibatalkan.');
        
        if (confirmed) {
            const url = button.getAttribute('href') || button.getAttribute('data-url');
            if (url) {
                window.location.href = url;
            }
        }
    }
    return false;
}