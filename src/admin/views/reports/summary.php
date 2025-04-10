<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-8">Báo cáo tổng hợp hệ thống</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Thống kê tài chính -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Thống kê tài chính</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Tổng nhập hàng:</span>
                    <span class="font-medium text-red-600"><?= number_format($totalImport, 0, ',', '.') ?> ₫</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Tổng doanh thu:</span>
                    <span class="font-medium text-green-600"><?= number_format($totalSales, 0, ',', '.') ?> ₫</span>
                </div>
                <div class="flex justify-between items-center pt-2 border-t border-gray-200">
                    <span class="text-gray-600 font-medium">Lợi nhuận:</span>
                    <span class="font-bold text-blue-600"><?= number_format($totalSales - $totalImport, 0, ',', '.') ?> ₫</span>
                </div>
            </div>
        </div>

        <!-- Thống kê người dùng -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Thống kê người dùng</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Tổng số người dùng:</span>
                    <span class="font-medium text-purple-600"><?= $userCount ?></span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Số quản trị viên:</span>
                    <span class="font-medium text-purple-600"><?= $adminCount ?></span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Số nhân viên:</span>
                    <span class="font-medium text-purple-600"><?= $employeeCount ?></span>
                </div>
            </div>
        </div>

        <!-- Thống kê sản phẩm -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Thống kê sản phẩm</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Số sản phẩm trong kho:</span>
                    <span class="font-medium text-green-600"><?= $productCount ?></span>
                </div>
                <!-- Có thể thêm các thống kê khác về sản phẩm nếu có -->
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Số đơn hàng:</span>
                    <span class="font-medium text-green-600"><?= $orderCount ?? 'N/A' ?></span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Số phiếu nhập:</span>
                    <span class="font-medium text-green-600"><?= $importCount ?? 'N/A' ?></span>
                </div>
            </div>
        </div>
    </div>

 
</div>