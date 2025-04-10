<div class="max-w-4xl mx-auto p-6">
    <div class="bg-white rounded-lg shadow-md p-8">
        <!-- Header section -->
        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Chi tiết đơn hàng #<?= $order['OrderID'] ?></h2>
                <a href="admin.php?page=orders&action=list" class="text-blue-600 hover:text-blue-800 text-sm flex items-center mt-2">
                    <i class="fas fa-arrow-left mr-1"></i> Quay lại danh sách đơn hàng
                </a>
            </div>
            <span class="px-3 py-1 rounded-full text-sm font-medium 
                <?= $order['PaymentStatus'] == 'Processed' ? 'bg-green-100 text-green-800' : ($order['PaymentStatus'] == 'Cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') ?>">
                <?= $order['PaymentStatus'] == 'Processed' ? 'Đã xử lý' : ($order['PaymentStatus'] == 'Cancelled' ? 'Đã hủy' : 'Đang chờ') ?>
            </span>
        </div>

        <!-- Order info section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="font-medium text-gray-700 mb-3">Thông tin khách hàng</h3>
                <p class="text-gray-600 mb-2"><span class="font-medium">Tên:</span> <?= htmlspecialchars($order['UserFullname']) ?></p>
                <p class="text-gray-600 mb-2"><span class="font-medium">Email:</span> <?= htmlspecialchars($order['UserEmail']) ?></p>
                <p class="text-gray-600"><span class="font-medium">SĐT:</span> <?= htmlspecialchars($order['UserPhone']) ?></p>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="font-medium text-gray-700 mb-3">Thông tin đơn hàng</h3>
                <p class="text-gray-600 mb-2"><span class="font-medium">Ngày đặt:</span> <?= date('d/m/Y H:i', strtotime($order['OrderDate'])) ?></p>
                <p class="text-gray-600 mb-2"><span class="font-medium">Tổng tiền:</span>
                    <span class="font-bold text-blue-600"><?= number_format($order['Total'], 0, ',', '.') ?> ₫</span>
                </p>
                <p class="text-gray-600"><span class="font-medium">Phương thức:</span> <?= htmlspecialchars($order['PaymentMethod']) ?></p>
            </div>
        </div>

        <!-- Status update form -->
        <form method="POST" action="admin.php?page=orders&action=update" class="border-t pt-6">
            <input type="hidden" name="id" value="<?= $order['OrderID'] ?>">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cập nhật trạng thái</label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <option value="Pending" <?= $order['PaymentStatus'] == 'Pending' ? 'selected' : '' ?>>Đang chờ</option>
                        <option value="Processed" <?= $order['PaymentStatus'] == 'Processed' ? 'selected' : '' ?>>Đã xử lý</option>
                        <option value="Cancelled" <?= $order['PaymentStatus'] == 'Cancelled' ? 'selected' : '' ?>>Đã hủy</option>
                    </select>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="w-full md:w-auto px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                        <i class="fas fa-sync-alt mr-2"></i> Cập nhật
                    </button>
                </div>
            </div>
        </form>

        <!-- Products list section -->
        <div class="mt-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Sản phẩm đã đặt</h3>
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <ul class="divide-y divide-gray-200">
                    <?php foreach ($orderDetails as $item): ?>
                        <li class="p-4 hover:bg-gray-50">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0 w-16 h-16">
                                    <img src="<?= htmlspecialchars($item['ImageURL']) ?>"
                                        alt="<?= htmlspecialchars($item['ProductName']) ?>"
                                        class="w-full h-full object-cover rounded-md">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">
                                        <?= htmlspecialchars($item['ProductName']) ?>
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        Số lượng: <?= $item['Quantity'] ?>
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        Đơn giá: <?= number_format($item['Price'], 0, ',', '.') ?> ₫
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-blue-600">
                                        <?= number_format($item['Price'] * $item['Quantity'], 0, ',', '.') ?> ₫
                                    </p>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <!-- Order summary -->
                <div class="bg-gray-50 px-4 py-4 sm:px-6">
                    <div class="flex justify-end space-x-4">
                        <span class="text-gray-600">Tổng cộng:</span>
                        <span class="font-bold text-blue-600 text-lg">
                            <?= number_format($order['Total'], 0, ',', '.') ?> ₫
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>