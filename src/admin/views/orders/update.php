<div class="max-w-2xl mx-auto p-6">
    <div class="bg-white rounded-lg shadow-md p-8">
        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <h2 class="text-2xl font-bold text-gray-800">Cập nhật đơn hàng #<?= $order['OrderID'] ?></h2>
            <a href="admin.php?page=orders&action=list" class="text-blue-600 hover:text-blue-800 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Quay lại
            </a>
        </div>

        <form method="POST" action="admin.php?page=orders&action=update&id=<?= $order['OrderID'] ?>" class="space-y-6">
            <!-- Order Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mã đơn hàng</label>
                    <input type="text" name="OrderID" value="<?= $order['OrderID'] ?>" readonly
                           class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md cursor-not-allowed">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tổng tiền (VND)</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500">₫</span>
                        </div>
                        <input type="number" name="Total" value="<?= $order['Total'] ?>" required
                               class="block w-full pl-10 pr-12 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>

            <!-- Status Update -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Trạng thái đơn hàng</label>
                <select name="Status" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <?php 
                    $statuses = [
                        'Pending' => 'Chờ xác nhận',
                        'Processing' => 'Đang giao hàng', 
                        'Completed' => 'Đã giao hàng',
                        'Cancelled' => 'Đã hủy'
                    ];
                    
                    $currentStatus = $order['Status'];
                    $allowableStatuses = [
                        'Pending' => ['Processing', 'Cancelled'],
                        'Processing' => ['Completed'],
                        'Completed' => [],
                        'Cancelled' => []
                    ];
                    
                    foreach ($statuses as $value => $label): 
                        if ($value == $currentStatus || in_array($value, $allowableStatuses[$currentStatus])): 
                    ?>
                        <option value="<?= $value ?>" <?= $value == $currentStatus ? 'selected' : '' ?>>
                            <?= $label ?>
                        </option>
                    <?php 
                        endif;
                    endforeach; 
                    ?>
                </select>
                <p class="mt-1 text-sm text-gray-500">Chỉ được cập nhật trạng thái xuôi</p>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end pt-6 border-t border-gray-200">
                <button type="reset" class="mr-3 px-6 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-redo mr-2"></i> Nhập lại
                </button>
                <button type="submit" class="px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-save mr-2"></i> Cập nhật
                </button>
            </div>
        </form>
    </div>
</div>