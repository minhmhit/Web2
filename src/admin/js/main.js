
document.addEventListener('DOMContentLoaded', function () {
const rows = document.querySelectorAll('.data-product-row');
const rowsPerPage = 5;
const pagination = document.getElementById('pagination');
const totalPages = Math.ceil(rows.length / rowsPerPage);
let currentPage = 1;
const maxVisiblePages = 3;

function displayPage(page) {
    currentPage = page;
    rows.forEach((row, index) => {
    row.style.display = (index >= (page - 1) * rowsPerPage && index < page * rowsPerPage) ? '' : 'none';
    });
    updatePagination();
}

function updatePagination() {
    pagination.innerHTML = '';

    // Prev button
    const prevBtn = document.createElement('button');
    prevBtn.textContent = 'Prev';
    prevBtn.className = 'px-3 py-1 border rounded-md bg-white text-gray-700 hover:bg-gray-100';
    prevBtn.disabled = currentPage === 1;
    if (prevBtn.disabled) {
    prevBtn.classList.add('opacity-50', 'cursor-not-allowed');
    }
    prevBtn.addEventListener('click', () => displayPage(currentPage - 1));
    pagination.appendChild(prevBtn);

    // Calculate start and end page
    let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
    let endPage = startPage + maxVisiblePages - 1;
    if (endPage > totalPages) {
    endPage = totalPages;
    startPage = Math.max(1, endPage - maxVisiblePages + 1);
    }

    // Page number buttons
    for (let i = startPage; i <= endPage; i++) {
    const btn = document.createElement('button');
    btn.textContent = i;
    if (i === currentPage) {
        btn.className = 'px-3 py-1 border rounded-md bg-blue-600 text-white mx-1';
    } else {
        btn.className = 'px-3 py-1 border rounded-md bg-white text-gray-700 hover:bg-gray-100 mx-1';
    }
    btn.addEventListener('click', () => displayPage(i));
    pagination.appendChild(btn);
    }

    // Next button
    const nextBtn = document.createElement('button');
    nextBtn.textContent = 'Next';
    nextBtn.className = 'px-3 py-1 border rounded-md bg-white text-gray-700 hover:bg-gray-100';
    nextBtn.disabled = currentPage === totalPages;
    if (nextBtn.disabled) {
    nextBtn.classList.add('opacity-50', 'cursor-not-allowed');
    }
    nextBtn.addEventListener('click', () => displayPage(currentPage + 1));
    pagination.appendChild(nextBtn);
}

if (rows.length > 0) {
    displayPage(1);
}
});

function addSizeStockRow() {
    const container = document.getElementById('size-stock-container');

    const row = document.createElement('div');
    row.className = "flex space-x-4";

    row.innerHTML = `
        <div class="w-1/2">
            <input type="text" name="sizes[]" required placeholder="Nhập Size"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
        </div>
        <div class="w-1/2">
            <input type="number" name="stock_quantities[]" required min="0" placeholder="Nhập số lượng"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
        </div>
    `;

    container.appendChild(row);
}

// Auto thêm 1 dòng đầu tiên
window.onload = function() {
    addSizeStockRow();
}
function addSizeStockRow2() {
    const container = document.getElementById('size-stock-container');
    const row = document.createElement('div');
    row.className = "flex space-x-4 items-center";

    row.innerHTML = `
        <input type="hidden" name="product_size_ids[]" value="">
        <div class="w-1/2">
            <input type="text" name="sizes[]" required
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
        </div>
        <div class="w-1/2">
            <input type="number" name="stock_quantities[]" min="0" required
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
        </div>
        <button type="button" onclick="removeRow(this)" class="text-red-500 hover:text-red-700">Xóa</button>
    `;
    container.appendChild(row);
}

function removeRow(button) {
    button.parentElement.remove();
}