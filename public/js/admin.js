// Admin Layout JavaScript

// Toast Notification Function
function showToast(message, type = 'success') {
    const container = document.getElementById('toast-container');
    if (!container) return;

    const toast = document.createElement('div');

    const colors = {
        success: 'from-green-600 to-green-700 border-green-500',
        error: 'from-red-600 to-red-700 border-red-500',
        warning: 'from-yellow-600 to-yellow-700 border-yellow-500',
        info: 'from-blue-600 to-blue-700 border-blue-500'
    };

    const icons = {
        success: 'fa-check-circle',
        error: 'fa-times-circle',
        warning: 'fa-exclamation-triangle',
        info: 'fa-info-circle'
    };

    toast.className = `toast-item bg-gradient-to-r ${colors[type] || colors.success} border-2 text-white px-6 py-4 rounded-lg shadow-2xl flex items-center space-x-3 min-w-[300px] max-w-md animate-slide-down`;
    toast.innerHTML = `
        <i class="fas ${icons[type] || icons.success} text-2xl"></i>
        <span class="flex-1 font-medium">${message}</span>
        <button onclick="this.parentElement.remove()" class="text-white/80 hover:text-white transition-colors">
            <i class="fas fa-times"></i>
        </button>
    `;

    container.appendChild(toast);

    // Auto remove after 5 seconds
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(-20px)';
        setTimeout(() => toast.remove(), 300);
    }, 5000);
}
