# Thư mục inc - Include Files

Thư mục này chứa các file function được tách nhỏ từ `functions.php` chính để dễ quản lý và bảo trì.

## Cấu trúc file

### 1. `theme-setup.php`
- **Chức năng**: Thiết lập theme cơ bản
- **Nội dung**:
  - `dntheme_setup()` - Thiết lập theme support, menu, image sizes
  - `dntheme_widgets_init()` - Đăng ký widget areas
  - `wps_attachment_display_settings()` - Thiết lập mặc định cho upload
  - `dntheme_front_page_template()` - Xử lý front page template

### 2. `scripts-styles.php`
- **Chức năng**: Enqueue scripts và styles
- **Nội dung**:
  - `dntheme_javascript_detection()` - Phát hiện JavaScript
  - `dntheme_scripts()` - Enqueue tất cả CSS/JS cần thiết

### 3. `content-functions.php`
- **Chức năng**: Các function liên quan đến nội dung
- **Nội dung**:
  - `dntheme_excerpt_more()` - Tùy chỉnh excerpt
  - `dn_excerpt()` - Custom excerpt function
  - `dn_thumbnail_html_null()` - Xử lý thumbnail mặc định
  - `give_linked_images_class()` - Thêm class cho hình ảnh
  - `dntheme_get_the_archive_title()` - Tùy chỉnh archive title

### 4. `utilities.php`
- **Chức năng**: Tất cả các function tiện ích (đã gộp chung helpers.php và utility-functions.php)
- **Nội dung**:
  - **Date Functions**: Xử lý ngày tháng, định dạng thời gian
  - **Formatting Functions**: Định dạng số, chuỗi, xử lý tiếng Việt
  - **Social Media Functions**: Xử lý Facebook, YouTube
  - **Theme Utilities**: Menu, header/footer scripts

### 5. `custom-post-types.php`
- **Chức năng**: Custom Post Types
- **Nội dung**: Đăng ký post type 'service' và taxonomy

### 6. `template-tags.php`
- **Chức năng**: Template tags và helper functions
- **Nội dung**: Các function hiển thị template

### 7. `performance.php`
- **Chức năng**: Tối ưu hiệu suất (đổi tên từ optimize.php)
- **Nội dung**: Loại bỏ các tính năng không cần thiết, tối ưu WordPress

### 8. `woocommerce.php`
- **Chức năng**: Tùy chỉnh WooCommerce
- **Nội dung**: Các function liên quan đến WooCommerce

### 9. `widgets/`
- **Chức năng**: Custom widgets
- **Nội dung**: Các widget tùy chỉnh

## Cách sử dụng

Tất cả các file này được include tự động trong `functions.php` chính. Khi thêm function mới:

1. **Function thiết lập theme** → `theme-setup.php`
2. **Function CSS/JS** → `scripts-styles.php`
3. **Function nội dung** → `content-functions.php`
4. **Function tiện ích** → `utilities.php`
5. **Custom Post Types** → `custom-post-types.php`
6. **Function tối ưu** → `performance.php`
7. **Function WooCommerce** → `woocommerce.php`

## Lưu ý

- Tất cả function đều có kiểm tra `function_exists()` để tránh lỗi
- Các lỗi linter về WordPress functions có thể bỏ qua (do không mở toàn bộ WordPress)
- Code sẽ hoạt động bình thường trên server WordPress 