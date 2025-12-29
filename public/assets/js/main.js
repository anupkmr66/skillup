/**
 * SkillUp - Main JavaScript
 * Computer Center Management System
 */

// Initialize AOS animations
document.addEventListener('DOMContentLoaded', function () {
    // Initialize AOS if available
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });
    }

    // Sticky Navbar Animation
    const navbar = document.getElementById('mainNav');
    if (navbar) {
        window.addEventListener('scroll', function () {
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });

        // Check initial state
        if (window.scrollY > 50) {
            navbar.classList.add('navbar-scrolled');
        }
    }
});

// AJAX Helper Function
function ajaxRequest(url, method = 'GET', data = {}, successCallback, errorCallback) {
    const options = {
        method: method,
        headers: {
            'X-Requested-With': 'XMLhttprequest',
            'Content-Type': 'application/json'
        }
    };

    if (method !== 'GET') {
        options.body = JSON.stringify(data);
    }

    fetch(url, options)
        .then(response => response.json())
        .then(data => {
            if (successCallback) successCallback(data);
        })
        .catch(error => {
            if (errorCallback) errorCallback(error);
            else console.error('Ajax Error:', error);
        });
}

// Show Toast Notification
function showToast(message, type = 'success') {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: type,
            title: message,
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    } else {
        alert(message);
    }
}

// Confirm Dialog
function confirmDialog(title, text, confirmCallback) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: title,
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#6366f1',
            cancelButtonColor: '#ef4444',
            confirmButtonText: 'Yes, proceed!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed && confirmCallback) {
                confirmCallback();
            }
        });
    } else {
        if (confirm(text)) {
            if (confirmCallback) confirmCallback();
        }
    }
}

// Form Validation
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return false;

    const inputs = form.querySelectorAll('[required]');
    let isValid = true;

    inputs.forEach(input => {
        if (!input.value.trim()) {
            input.classList.add('is-invalid');
            isValid = false;
        } else {
            input.classList.remove('is-invalid');
        }
    });

    return isValid;
}

// Real-time validation
document.addEventListener('DOMContentLoaded', function () {
    const inputs = document.querySelectorAll('.form-control');

    inputs.forEach(input => {
        input.addEventListener('blur', function () {
            if (this.hasAttribute('required') && !this.value.trim()) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }

            // Email validation
            if (this.type === 'email' && this.value) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(this.value)) {
                    this.classList.add('is-invalid');
                } else {
                    this.classList.remove('is-invalid');
                }
            }
        });
    });
});

// File Upload Preview
function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function (e) {
            document.getElementById(previewId).src = e.target.result;
        };

        reader.readAsDataURL(input.files[0]);
    }
}

// DataTables Initialization
function initDataTable(tableId, options = {}) {
    if (typeof $.fn.dataTable !== 'undefined') {
        const defaultOptions = {
            responsive: true,
            pageLength: 10,
            language: {
                search: "Search:",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                }
            }
        };

        const finalOptions = Object.assign(defaultOptions, options);

        $(`#${tableId}`).DataTable(finalOptions);
    }
}

// Smooth Scroll
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        if (href !== '#') {
            e.preventDefault();
            const target = document.querySelector(href);
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }
    });
});

// Number Formatting
function formatCurrency(amount) {
    return '₹' + parseFloat(amount).toLocaleString('en-IN', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

// Date Formatting
function formatDate(dateString) {
    const date = new Date(dateString);
    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    return date.toLocaleDateString('en-IN', options);
}

// Load More functionality
function setupLoadMore(containerId, itemSelector, showCount = 6) {
    const container = document.getElementById(containerId);
    if (!container) return;

    const items = container.querySelectorAll(itemSelector);
    let currentCount = showCount;

    // Hide items beyond showCount
    items.forEach((item, index) => {
        if (index >= showCount) {
            item.style.display = 'none';
        }
    });

    // Load more button click
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function () {
            currentCount += showCount;

            items.forEach((item, index) => {
                if (index < currentCount) {
                    item.style.display = 'block';
                }
            });

            if (currentCount >= items.length) {
                loadMoreBtn.style.display = 'none';
            }
        });
    }
}

// Copy to Clipboard
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function () {
        showToast('Copied to clipboard!', 'success');
    }, function () {
        showToast('Failed to copy', 'error');
    });
}

// Print Element
function printElement(elementId) {
    const printContent = document.getElementById(elementId);
    if (!printContent) return;

    const winPrint = window.open('', '', 'width=800,height=600');
    winPrint.document.write('<html><head><title>Print</title>');
    winPrint.document.write('<style>body{font-family:Arial;padding:20px;}</style>');
    winPrint.document.write('</head><body>');
    winPrint.document.write(printContent.innerHTML);
    winPrint.document.write('</body></html>');
    winPrint.document.close();
    winPrint.focus();
    winPrint.print();
    winPrint.close();
}

// Export Table to CSV
function exportTableToCSV(tableId, filename = 'export.csv') {
    const table = document.getElementById(tableId);
    if (!table) return;

    let csv = [];
    const rows = table.querySelectorAll('tr');

    rows.forEach(row => {
        const cols = row.querySelectorAll('td, th');
        const rowData = [];

        cols.forEach(col => {
            rowData.push(col.innerText);
        });

        csv.push(rowData.join(','));
    });

    // Download CSV
    const csvContent = csv.join('\n');
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    a.click();
    window.URL.revokeObjectURL(url);
}

// Auto-hide alerts
setTimeout(function () {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        alert.style.transition = 'opacity 0.5s';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
    });
}, 5000);

// Mobile Sidebar Toggle
const sidebarToggle = document.getElementById('sidebarToggle');
const sidebar = document.querySelector('.sidebar');

if (sidebarToggle && sidebar) {
    sidebarToggle.addEventListener('click', function () {
        sidebar.classList.toggle('active');
    });
}
