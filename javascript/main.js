document.addEventListener("DOMContentLoaded", function () {
    // Giảm số lượng sản phẩm
    document.querySelectorAll(".quantity-decrease").forEach((button) => {
        button.addEventListener("click", function () {
            const productId = this.getAttribute("data-id"); // Lấy ID sản phẩm
            const input = document.querySelector(`.quantity-input[data-id="${productId}"]`);
            let quantity = parseInt(input.value);
            //1
            if (quantity > 1 ) {
                quantity--; // Giảm số lượng
                input.value = quantity;
                capNhatGioHang(productId, quantity); // Gửi yêu cầu cập nhật giỏ hàng
            }
        });
    });

    // Tăng số lượng sản phẩm
    document.querySelectorAll(".quantity-increase").forEach((button) => {
        button.addEventListener("click", function () {
            const productId = this.getAttribute("data-id");
            const input = document.querySelector(`.quantity-input[data-id="${productId}"]`);
            let quantity = parseInt(input.value);

            quantity++; // Tăng số lượng
            input.value = quantity;
            capNhatGioHang(productId, quantity);
        });
    });

    // Xử lý khi nhập số lượng trực tiếp
    document.querySelectorAll(".quantity-input").forEach((input) => {
        input.addEventListener("change", function () {
            const productId = this.getAttribute("data-id");
            let quantity = parseInt(this.value);

            if (quantity < 1 || isNaN(quantity)) {
                quantity = 1; // Đảm bảo số lượng tối thiểu là 1
                this.value = quantity;
            }
            capNhatGioHang(productId, quantity);
        });
    });

    // Hàm cập nhật giỏ hàng qua AJAX
    function capNhatGioHang(productId, quantity) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "/module/main/capnhatgiohang.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onload = function () {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    // Cập nhật tổng tiền
                    document.getElementById("total-price").textContent = response.totalPriceFormatted;

                    // Cập nhật tổng tiền từng sản phẩm
                    const productItem = document.querySelector(`.product-item[data-id="${productId}"]`);
                    const totalPriceElement = productItem.querySelector(".total-price");
                    totalPriceElement.textContent = response.itemTotalPriceFormatted;
                } else {
                    alert("Có lỗi xảy ra khi cập nhật giỏ hàng.");
                }
            }
        };

        // Gửi dữ liệu qua POST
        xhr.send(`id=${productId}&quantity=${quantity}`);
    }
});
