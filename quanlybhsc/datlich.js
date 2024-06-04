const form1 = document.getElementById('form1');
const form2 = document.getElementById('form2');

form1.addEventListener('submit', (event) => {
    event.preventDefault();

    form1.style.display = 'none'; // Ẩn form 1
    form2.style.display = 'block'; // Hiển thị form 2
});
form2.addEventListener('submit', (event) => {
    event.preventDefault(); // Ngăn chặn hành vi mặc định của form (gửi dữ liệu)

    form2.style.display = 'none'; // Ẩn form 1
    form3.style.display = 'block'; // Hiển thị form 2
});


