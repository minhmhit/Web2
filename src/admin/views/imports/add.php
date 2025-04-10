<div class="max-w-md mx-auto p-6">
    <div class="bg-white rounded-lg shadow-md p-8">
        <div class="flex justify-between items-center mb-8 border-b pb-4">
            <h2 class="text-2xl font-bold text-gray-800">Thêm phiếu nhập hàng</h2>
            <a href="admin.php?page=imports&action=list" 
               class="text-blue-600 hover:text-blue-800 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Quay lại
            </a>
        </div>

        <form method="POST" action="admin.php?page=imports&action=add" class="space-y-6">
            <div class="grid grid-cols-1 gap-6">
                <!-- ID Nhân viên -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">ID Nhân viên <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <select name="EmployeeID" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition appearance-none">
                            <option value="">-- Chọn nhân viên --</option>
                            <?php foreach ($employees as $employee): ?>
                            <option value="<?= $employee['EmployeeID'] ?>">
                                <?= htmlspecialchars($employee['Fullname']) ?> (ID: <?= $employee['EmployeeID'] ?>)
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                </div>

                <!-- Tổng tiền -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tổng tiền <span class="text-red-500">*</span></label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500">₫</span>
                        </div>
                        <input type="number" name="Total" required
                               class="block w-full pl-8 pr-12 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                               placeholder="0.00">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <span class="text-gray-500">VND</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-6 border-t border-gray-200">
                <button type="reset" 
                        class="mr-3 px-6 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-redo mr-2"></i> Nhập lại
                </button>
                <button type="submit" 
                        class="px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-plus-circle mr-2"></i> Thêm phiếu nhập
                </button>
            </div>
        </form>
    </div>
</div>