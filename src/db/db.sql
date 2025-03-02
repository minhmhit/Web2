-- NguoiDung
CREATE TABLE NguoiDung (
    MaNguoiDung INT PRIMARY KEY AUTO_INCREMENT,
    TenDangNhap VARCHAR(50) NOT NULL UNIQUE,
    MatKhau VARCHAR(255) NOT NULL,
    Email VARCHAR(100) NOT NULL UNIQUE,
    HoTen VARCHAR(100) NOT NULL,
    SoDienThoai VARCHAR(15),
    NgaySinh DATE,
    GioiTinh VARCHAR(10),
    DiaChi TEXT,
    VaiTro VARCHAR(20) DEFAULT 'KhachHang', -- KhachHang, QuanTriVien, NhanVien
    NgayDangKy DATETIME DEFAULT CURRENT_TIMESTAMP,
    TrangThai BOOLEAN DEFAULT TRUE
);

-- DanhMuc
CREATE TABLE DanhMuc (
    MaDanhMuc INT PRIMARY KEY AUTO_INCREMENT,
    TenDanhMuc VARCHAR(100) NOT NULL,
    MoTa TEXT,
    DanhMucCha INT,
    TrangThai BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (DanhMucCha) REFERENCES DanhMuc(MaDanhMuc) ON DELETE SET NULL
);

-- ThuongHieu
CREATE TABLE ThuongHieu (
    MaThuongHieu INT PRIMARY KEY AUTO_INCREMENT,
    TenThuongHieu VARCHAR(100) NOT NULL,
    MoTa TEXT,
    Logo VARCHAR(255),
    TrangThai BOOLEAN DEFAULT TRUE
);

-- SanPham
CREATE TABLE SanPham (
    MaSanPham INT PRIMARY KEY AUTO_INCREMENT,
    TenSanPham VARCHAR(200) NOT NULL,
    MoTaNgan VARCHAR(500),
    MoTaChiTiet TEXT,
    GiaGoc DECIMAL(15, 2) NOT NULL,
    GiaBan DECIMAL(15, 2) NOT NULL,
    AnhDaiDien VARCHAR(255),
    SoLuongTon INT DEFAULT 0,
    MaDanhMuc INT,
    MaThuongHieu INT,
    NgayTao DATETIME DEFAULT CURRENT_TIMESTAMP,
    LuotXem INT DEFAULT 0,
    LuotMua INT DEFAULT 0,
    DacTrung BOOLEAN DEFAULT FALSE,
    MoiNhat BOOLEAN DEFAULT FALSE,
    BanChay BOOLEAN DEFAULT FALSE,
    TrangThai BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (MaDanhMuc) REFERENCES DanhMuc(MaDanhMuc) ON DELETE SET NULL,
    FOREIGN KEY (MaThuongHieu) REFERENCES ThuongHieu(MaThuongHieu) ON DELETE SET NULL
);

-- KichCo
CREATE TABLE KichCo (
    MaKichCo INT PRIMARY KEY AUTO_INCREMENT,
    TenKichCo VARCHAR(20) NOT NULL
);

-- MauSac
CREATE TABLE MauSac (
    MaMauSac INT PRIMARY KEY AUTO_INCREMENT,
    TenMauSac VARCHAR(50) NOT NULL,
    MaMau VARCHAR(20) -- Mã màu HEX hoặc RGB
);

-- SanPhamChiTiet (biến thể của sản phẩm: kích cỡ, màu sắc)
CREATE TABLE SanPhamChiTiet (
    MaSanPhamChiTiet INT PRIMARY KEY AUTO_INCREMENT,
    MaSanPham INT NOT NULL,
    MaKichCo INT NOT NULL,
    MaMauSac INT NOT NULL,
    SoLuong INT NOT NULL DEFAULT 0,
    AnhMau VARCHAR(255),
    TrangThai BOOLEAN DEFAULT TRUE,
    UNIQUE KEY (MaSanPham, MaKichCo, MaMauSac),
    FOREIGN KEY (MaSanPham) REFERENCES SanPham(MaSanPham) ON DELETE CASCADE,
    FOREIGN KEY (MaKichCo) REFERENCES KichCo(MaKichCo) ON DELETE CASCADE,
    FOREIGN KEY (MaMauSac) REFERENCES MauSac(MaMauSac) ON DELETE CASCADE
);

-- AnhSanPham
CREATE TABLE AnhSanPham (
    MaAnh INT PRIMARY KEY AUTO_INCREMENT,
    MaSanPham INT NOT NULL,
    DuongDanAnh VARCHAR(255) NOT NULL,
    ViTri INT DEFAULT 0,
    FOREIGN KEY (MaSanPham) REFERENCES SanPham(MaSanPham) ON DELETE CASCADE
);

-- GioHang
CREATE TABLE GioHang (
    MaGioHang INT PRIMARY KEY AUTO_INCREMENT,
    MaNguoiDung INT NOT NULL,
    NgayTao DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (MaNguoiDung) REFERENCES NguoiDung(MaNguoiDung) ON DELETE CASCADE
);

-- GioHangChiTiet
CREATE TABLE GioHangChiTiet (
    MaGioHangChiTiet INT PRIMARY KEY AUTO_INCREMENT,
    MaGioHang INT NOT NULL,
    MaSanPhamChiTiet INT NOT NULL,
    SoLuong INT NOT NULL DEFAULT 1,
    GiaTien DECIMAL(15, 2) NOT NULL,
    UNIQUE KEY (MaGioHang, MaSanPhamChiTiet),
    FOREIGN KEY (MaGioHang) REFERENCES GioHang(MaGioHang) ON DELETE CASCADE,
    FOREIGN KEY (MaSanPhamChiTiet) REFERENCES SanPhamChiTiet(MaSanPhamChiTiet) ON DELETE CASCADE
);

-- YeuThich
CREATE TABLE YeuThich (
    MaYeuThich INT PRIMARY KEY AUTO_INCREMENT,
    MaNguoiDung INT NOT NULL,
    MaSanPham INT NOT NULL,
    NgayThem DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY (MaNguoiDung, MaSanPham),
    FOREIGN KEY (MaNguoiDung) REFERENCES NguoiDung(MaNguoiDung) ON DELETE CASCADE,
    FOREIGN KEY (MaSanPham) REFERENCES SanPham(MaSanPham) ON DELETE CASCADE
);


-- DiaChi
CREATE TABLE DiaChi (
    MaDiaChi INT PRIMARY KEY AUTO_INCREMENT,
    MaNguoiDung INT NOT NULL,
    HoTenNguoiNhan VARCHAR(100) NOT NULL,
    SoDienThoai VARCHAR(15) NOT NULL,
    DiaChi TEXT NOT NULL,
    TinhThanh VARCHAR(50) NOT NULL,
    QuanHuyen VARCHAR(50) NOT NULL,
    PhuongXa VARCHAR(50) NOT NULL,
    MacDinh BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (MaNguoiDung) REFERENCES NguoiDung(MaNguoiDung) ON DELETE CASCADE
);

-- DonHang
CREATE TABLE DonHang (
    MaDonHang INT PRIMARY KEY AUTO_INCREMENT,
    MaNguoiDung INT NOT NULL,
    MaDiaChi INT NOT NULL,
    TongTien DECIMAL(15, 2) NOT NULL,
    PhiVanChuyen DECIMAL(15, 2) NOT NULL DEFAULT 0,
    ThanhTien DECIMAL(15, 2) NOT NULL,
    PhuongThucThanhToan VARCHAR(50) NOT NULL, -- ChuyenKhoan, ThanhToanKhiNhan, Visa...
    TrangThaiThanhToan VARCHAR(50) NOT NULL DEFAULT 'ChuaThanhToan', -- ChuaThanhToan, DaThanhToan
    TrangThaiDonHang VARCHAR(50) NOT NULL DEFAULT 'ChoXacNhan', -- ChoXacNhan, DaXacNhan, DangVanChuyen, DaGiao, DaHuy
    GhiChu TEXT,
    NgayDatHang DATETIME DEFAULT CURRENT_TIMESTAMP,
    NgayGiaoHang DATETIME,
    LyDoHuy TEXT,
    FOREIGN KEY (MaNguoiDung) REFERENCES NguoiDung(MaNguoiDung) ON DELETE CASCADE,
    FOREIGN KEY (MaDiaChi) REFERENCES DiaChi(MaDiaChi) ON DELETE CASCADE,
    FOREIGN KEY (MaMaGiamGia) REFERENCES MaGiamGia(MaMaGiamGia) ON DELETE SET NULL
);

-- DonHangChiTiet
CREATE TABLE DonHangChiTiet (
    MaDonHangChiTiet INT PRIMARY KEY AUTO_INCREMENT,
    MaDonHang INT NOT NULL,
    MaSanPhamChiTiet INT NOT NULL,
    TenSanPham VARCHAR(200) NOT NULL,
    KichCo VARCHAR(20) NOT NULL,
    MauSac VARCHAR(50) NOT NULL,
    SoLuong INT NOT NULL,
    DonGia DECIMAL(15, 2) NOT NULL,
    ThanhTien DECIMAL(15, 2) NOT NULL,
    FOREIGN KEY (MaDonHang) REFERENCES DonHang(MaDonHang) ON DELETE CASCADE,
    FOREIGN KEY (MaSanPhamChiTiet) REFERENCES SanPhamChiTiet(MaSanPhamChiTiet) ON DELETE CASCADE
);

-- LichSuDonHang
CREATE TABLE LichSuDonHang (
    MaLichSu INT PRIMARY KEY AUTO_INCREMENT,
    MaDonHang INT NOT NULL,
    TrangThaiDonHang VARCHAR(50) NOT NULL,
    GhiChu TEXT,
    NguoiThucHien INT, -- Mã nhân viên hoặc hệ thống thực hiện
    NgayThucHien DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (MaDonHang) REFERENCES DonHang(MaDonHang) ON DELETE CASCADE,
    FOREIGN KEY (NguoiThucHien) REFERENCES NguoiDung(MaNguoiDung) ON DELETE SET NULL
);

-- PhuongThucThanhToan
CREATE TABLE PhuongThucThanhToan (
    MaPTTT INT PRIMARY KEY AUTO_INCREMENT,
    TenPTTT VARCHAR(100) NOT NULL,
    MoTa TEXT,
    HinhAnh VARCHAR(255),
    TrangThai BOOLEAN DEFAULT TRUE
);

-- PhuongThucVanChuyen
CREATE TABLE PhuongThucVanChuyen (
    MaPTVC INT PRIMARY KEY AUTO_INCREMENT,
    TenPTVC VARCHAR(100) NOT NULL,
    MoTa TEXT,
    PhiVanChuyen DECIMAL(15, 2) NOT NULL DEFAULT 0,
    ThoiGianDuKien VARCHAR(100),
    HinhAnh VARCHAR(255),
    TrangThai BOOLEAN DEFAULT TRUE
);

-- ThanhToanOnline
CREATE TABLE ThanhToanOnline (
    MaThanhToanOnline INT PRIMARY KEY AUTO_INCREMENT,
    MaDonHang INT NOT NULL,
    MaGiaoDich VARCHAR(100) NOT NULL,
    SoTien DECIMAL(15, 2) NOT NULL,
    LoaiThanhToan VARCHAR(50) NOT NULL, -- Momo, VNPay, PayPal...
    TrangThai VARCHAR(50) NOT NULL, -- ThanhCong, ThatBai, DangXuLy
    NoiDung TEXT,
    NgayThanhToan DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (MaDonHang) REFERENCES DonHang(MaDonHang) ON DELETE CASCADE
);

-- NhomQuyen
CREATE TABLE NhomQuyen (
    MaNhomQuyen INT PRIMARY KEY AUTO_INCREMENT,
    TenNhomQuyen VARCHAR(100) NOT NULL,
    MoTa TEXT,
    TrangThai BOOLEAN DEFAULT TRUE
);

-- Quyen
CREATE TABLE Quyen (
    MaQuyen INT PRIMARY KEY AUTO_INCREMENT,
    TenQuyen VARCHAR(100) NOT NULL,
    MaRoute VARCHAR(100) NOT NULL,
    MoTa TEXT,
    TrangThai BOOLEAN DEFAULT TRUE
);

-- PhanQuyen
CREATE TABLE PhanQuyen (
    MaNhomQuyen INT NOT NULL,
    MaQuyen INT NOT NULL,
    PRIMARY KEY (MaNhomQuyen, MaQuyen),
    FOREIGN KEY (MaNhomQuyen) REFERENCES NhomQuyen(MaNhomQuyen) ON DELETE CASCADE,
    FOREIGN KEY (MaQuyen) REFERENCES Quyen(MaQuyen) ON DELETE CASCADE
);

-- NguoiDung_NhomQuyen
CREATE TABLE NguoiDung_NhomQuyen (
    MaNguoiDung INT NOT NULL,
    MaNhomQuyen INT NOT NULL,
    PRIMARY KEY (MaNguoiDung, MaNhomQuyen),
    FOREIGN KEY (MaNguoiDung) REFERENCES NguoiDung(MaNguoiDung) ON DELETE CASCADE,
    FOREIGN KEY (MaNhomQuyen) REFERENCES NhomQuyen(MaNhomQuyen) ON DELETE CASCADE
);

-- ThongKe
CREATE TABLE ThongKe (
    MaThongKe INT PRIMARY KEY AUTO_INCREMENT,
    Ngay DATE NOT NULL,
    LuotTruyCap INT DEFAULT 0,
    LuotXemSanPham INT DEFAULT 0,
    DonHangMoi INT DEFAULT 0,
    DoanhThu DECIMAL(15, 2) DEFAULT 0,
    SanPhamBanRa INT DEFAULT 0,
    KhachHangMoi INT DEFAULT 0,
    UNIQUE KEY (Ngay)
);

-- PhienDangNhap
CREATE TABLE PhienDangNhap (
    MaPhien VARCHAR(100) PRIMARY KEY,
    MaNguoiDung INT NOT NULL,
    ThietBi VARCHAR(255),
    DiaChiIP VARCHAR(50),
    ViTri VARCHAR(255),
    NgayBatDau DATETIME DEFAULT CURRENT_TIMESTAMP,
    NgayKetThuc DATETIME,
    TrangThai BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (MaNguoiDung) REFERENCES NguoiDung(MaNguoiDung) ON DELETE CASCADE
);


