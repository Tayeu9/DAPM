function confirmDelete(event, employeeId) {
    event.stopPropagation();
    if (confirm('Bạn có chắc chắn muốn xóa nhân viên này?')) {
        window.location.href = 'delete.php?id=' + employeeId;
    }
}

function goToEdit(event, maNV) {
    event.stopPropagation();
    window.location.href = 'edit.php?id=' + maNV;
}
function goToDetail(employeeId) {
    window.location.href = 'chitiet.php?id=' + employeeId;
}
function gotoadd() {
    window.location.href = 'taomoi.php';
}
function logout() {
    // Sử dụng AJAX để gửi yêu cầu đến logout.php
    fetch('logout.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Lỗi đăng xuất');
            }
            // Chuyển hướng sau khi đăng xuất thành công
            window.location.href = 'login.php';
        })
        .catch(error => {
            console.error(error);
            alert('Đã xảy ra lỗi trong quá trình đăng xuất.');
        });
}