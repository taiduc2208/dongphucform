<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng ký đồng phục</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <!-- jQuery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

  <!-- Slick -->
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

  <link rel="stylesheet" href="./jquery.fancybox.min.css">
  <link rel="stylesheet" href="./modal-video.min.css">
  <link rel="stylesheet" href="slide.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Noto+Sans+JP:wght@100..900&display=swap"
    rel="stylesheet">
  <style>
    * {
      font-family: "Inter", sans-serif;
      font-optical-sizing: auto;
      font-style: normal;
    }
  </style>
</head>

<body>
  <!-- Header Section -->
  <header class="bg-blue-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
      <div class="flex items-center justify-between">
        <!-- Logo Section -->
        <div class="flex-shrink-0">
          <a href="/" class="text-2xl font-bold">Thamdongphuc </a>
        </div>

        <!-- Navigation Menu -->
        <nav class="hidden md:flex space-x-10 text-lg">
          <a href="/index.html" class="hover:text-gray-300 transition-all">Trang chủ</a>
          <a href="#services" class="hover:text-gray-300 transition-all">Mẫu áo</a>
          <a href="./form.php" class="hover:text-gray-300 transition-all">Đăng ký áo</a>
          <a href="./link.html" class="hover:text-gray-300 transition-all">Tạo form đăng ký áo</a>
        </nav>

        <!-- Call-to-Action Button -->
        <div class="hidden md:block">
          <a href="#"
            class="bg-yellow-500 hover:bg-yellow-400 text-black py-2 px-6 rounded-full text-lg transition-all">
            Nhận báo giá
          </a>
        </div>

        <!-- Mobile Menu Button (for smaller screens) -->
        <div class="md:hidden flex items-center">
          <button id="menu-button" class="text-white focus:outline-none">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
          </button>
        </div>
      </div>

      <!-- Mobile Navigation Menu -->
      <div id="mobile-menu" class="md:hidden mt-5 hidden space-y-4">
        <a href="/index.html" class="block text-lg hover:text-gray-300 transition-all">Trang chủ</a>
        <a href="#services" class="block text-lg hover:text-gray-300 transition-all">Mẫu áo</a>
        <a href="./form.php" class="block text-lg hover:text-gray-300 transition-all">Đăng ký áo</a>
        <a href="./link.html" class="block text-lg hover:text-gray-300 transition-all">Tạo form đăng ký áo</a>
      </div>
    </div>
  </header>

  <script>
    // Mobile Menu Toggle
    const menuButton = document.getElementById('menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    menuButton.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });
  </script>

  <!-- Form -->
  <?php
  session_start();
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
  ?>
  <div class="bg-white px-8 py-6 mx-auto my-8 max-w-2xl">
    <h2 class="text-2xl font-medium mb-4">Đăng ký đồng phục</h2>
    <form id="orderForm" method="post">
      <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
      <input type="hidden" name="token" value="tham0501_an3008_abu2208">
      <div class="mb-4">
        <label for="school_name" class="block text-gray-700 font-medium mb-2">Trường</label>
        <input type="text" id="school_name" name="school_name"
          class="border border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:border-blue-400" readonly
          required>
      </div>
      <div class="mb-4">
        <label for="parent_name" class="block text-gray-700 font-medium mb-2">Tên phụ huynh</label>
        <input type="text" id="parent_name" name="parent_name"
          class="border border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:border-blue-400" required>
      </div>
      <div class="mb-4">
        <label for="student_name" class="block text-gray-700 font-medium mb-2">Tên học sinh</label>
        <input type="text" id="student_name" name="student_name"
          class="border border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:border-blue-400" required>
      </div>
      <div class="mb-4">
        <label for="gender" class="block text-gray-700 font-medium mb-2">Giới tính</label>
        <select id="gender" name="gender"
          class="border border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:border-blue-400" required>
          <option value="">Chọn</option>
          <option value="male">Nam</option>
          <option value="female">Nữ</option>
        </select>
      </div>
      <div class="mb-4">
        <label for="grade" class="block text-gray-700 font-medium mb-2">Khối</label>
        <select id="grade" name="grade"
          class="border border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:border-blue-400" required>
          <option value="">Chọn khối</option>
          <option data-type="1" value="1">Lớp 1</option>
          <option data-type="1" value="2">Lớp 2</option>
          <option data-type="1" value="3">Lớp 3</option>
          <option data-type="1" value="4">Lớp 4</option>
          <option data-type="1" value="5">Lớp 5</option>
          <option data-type="2" value="6">Lớp 6</option>
          <option data-type="2" value="7">Lớp 7</option>
          <option data-type="2" value="8">Lớp 8</option>
          <option data-type="2" value="9">Lớp 9</option>
          <option data-type="3" value="10">Lớp 10</option>
          <option data-type="3" value="11">Lớp 11</option>
          <option data-type="3" value="12">Lớp 12</option>
        </select>
      </div>
      <div class="mb-4">
        <label for="class" class="block text-gray-700 font-medium mb-2">Lớp</label>
        <select id="class" name="class"
          class="border border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:border-blue-400">
          <option value="">Chọn lớp</option>
        </select>
      </div>

      <div id="customClassWrapper" class="mb-4 hidden">
        <label for="customClass" class="block text-gray-700 font-medium mb-2">Tên lớp là ?</label>
        <input type="text" id="customClass" name="customClass"
          class="border border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:border-blue-400"
          placeholder="VD: 1F, 10Z">
      </div>

      <div class="mb-4">
        <label for="height" class="block text-gray-700 font-medium mb-2">Chiều cao (cm)</label>
        <input type="number" id="height" name="height" min="50"
          class="border border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:border-blue-400" required>
      </div>
      <div class="mb-4">
        <label for="weight" class="block text-gray-700 font-medium mb-2">Cân nặng (kg)</label>
        <input type="number" id="weight" name="weight" min="15"
          class="border border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:border-blue-400" required>
      </div>


      <div class="mb-4">
        <label class="block text-gray-700 font-medium mb-2">Loại áo đăng ký ?</label>
        <div class="flex flex-wrap -mx-2">
          <!-- Áo cộc tay -->
          <div class="px-2 w-1/3">
            <label class="block text-gray-700 font-medium mb-2">
              <input type="checkbox" name="types[]" value="coctay" class="mr-2 type-checkbox">Áo cộc tay
            </label>
            <input type="number" name="qty_coctay" id="qty-coctay" class="border p-2 w-full mb-2 rounded-lg hidden"
              placeholder="Số lượng áo cộc tay">
          </div>

          <!-- Áo dài tay -->
          <div class="px-2 w-1/3">
            <label class="block text-gray-700 font-medium mb-2">
              <input type="checkbox" name="types[]" value="daitay" class="mr-2 type-checkbox">Áo dài tay
            </label>
            <input type="number" name="qty_daitay" id="qty-daitay" class="border p-2 w-full mb-2 rounded-lg hidden"
              placeholder="Số lượng áo dài tay">
          </div>

          <!-- Áo khoác -->
          <div class="px-2 w-1/3">
            <label class="block text-gray-700 font-medium mb-2">
              <input type="checkbox" name="types[]" value="khoac" class="mr-2 type-checkbox">Áo khoác
            </label>
            <input type="number" name="qty_khoac" id="qty-khoac" class="border p-2 w-full mb-2 rounded-lg hidden"
              placeholder="Số lượng áo khoác">
          </div>

          <!-- Áo cờ đỏ -->
          <div class="px-2 w-1/3">
            <label class="block text-gray-700 font-medium mb-2">
              <input type="checkbox" name="types[]" value="codo" class="mr-2 type-checkbox">Áo cờ đỏ sao vàng
            </label>
            <input type="number" name="qty_codo" id="qty-codo" class="border p-2 w-full mb-2 rounded-lg hidden"
              placeholder="Số lượng áo cờ đỏ">
          </div>

          <!-- Không đăng ký -->
          <div class="px-2 w-fit">
            <label class="block text-red-600 font-medium mb-2">
              <input type="checkbox" id="none-type" name="types[]" value="none" class="mr-2">Không đăng ký loại nào
            </label>
          </div>
        </div>
      </div>

      <div class="mb-4">
        <label for="style" class="block text-gray-700 font-medium mb-2">Mong muốn tùy chỉnh</label>
        <select id="style" name="style"
          class="border border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:border-blue-400" required>
          <option value="bth">Tôi muốn áo vừa vặn</option>
          <option value="ngan">Tôi muốn áo ngắn hơn chút, bó hơn chút</option>
          <option value="dai">Tôi muốn áo dài hơn chút để năm sau vẫn có thể mặc</option>
        </select>
      </div>
      <div class="mb-4">
        <label for="message" class="block text-gray-700 font-medium mb-2">Lời nhắn đến nhà sản xuất áo</label>
        <textarea id="message" name="message"
          class="border border-gray-400 p-2 w-full rounded-lg focus:outline-none focus:border-blue-400"
          rows="5"></textarea>
      </div>
      <div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Submit</button>
      </div>

    </form>
  </div>
</body>
<script>
  function getQueryParam(param) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
  }

  function base64EncodeUnicode(str) {
    return btoa(unescape(encodeURIComponent(str)));
  }

  function base64DecodeUnicode(str) {
    return decodeURIComponent(escape(atob(str)));
  }

  document.addEventListener("DOMContentLoaded", () => {
    const schoolEncoded = getQueryParam("school");
    const type = getQueryParam("type");

    const schoolInput = document.getElementById("school_name");
    const schoolLabel = document.querySelector("label[for='school_name']");
    const gradeSelect = document.getElementById("grade");

    // Lưu danh sách option gốc
    const allOptions = Array.from(gradeSelect.options);

    if (schoolEncoded && type) {
      // Decode tên trường
      const schoolName = base64DecodeUnicode(schoolEncoded);
      schoolInput.value = schoolName;
      schoolInput.readOnly = true;

      // Lọc các lớp theo type (iPhone Safari không hỗ trợ hidden)
      gradeSelect.innerHTML = ""; // xóa hết
      allOptions.forEach(opt => {
        if (opt.value === "" || opt.dataset.type === type) {
          gradeSelect.appendChild(opt);
        }
      });

    } else {
      // Không có param → nhập số điện thoại
      schoolLabel.textContent = "Số điện thoại";
      schoolInput.placeholder = "Nhập số điện thoại";
      schoolInput.readOnly = false;
      schoolInput.value = "";

      // Reset select: append lại tất cả option
      gradeSelect.innerHTML = "";
      allOptions.forEach(opt => gradeSelect.appendChild(opt));
    }
  });
</script>
<script>
  const gradeSelect = document.getElementById("grade");
  const classSelect = document.getElementById("class");
  const customClassWrapper = document.getElementById("customClassWrapper");

  gradeSelect.addEventListener("change", function() {
    const grade = this.value;
    classSelect.innerHTML = '<option value="">Chọn lớp chi tiết</option>';

    if (grade) {
      // Tạo lớp mặc định từ A đến E
      ["A", "B", "C", "D", "E"].forEach(letter => {
        const opt = document.createElement("option");
        opt.value = grade + letter;
        opt.textContent = grade + letter;
        classSelect.appendChild(opt);
      });

      // Thêm option "Khác"
      const otherOpt = document.createElement("option");
      otherOpt.value = "other";
      otherOpt.textContent = "Khác...";
      classSelect.appendChild(otherOpt);
    }

    // Reset input custom
    customClassWrapper.classList.add("hidden");
    document.getElementById("customClass").value = "";
  });

  classSelect.addEventListener("change", function() {
    if (this.value === "other") {
      customClassWrapper.classList.remove("hidden");
    } else {
      customClassWrapper.classList.add("hidden");
      document.getElementById("customClass").value = "";
    }
  });
</script>
<script>
  const typeCheckboxes = document.querySelectorAll('.type-checkbox');
  const noneCheckbox = document.getElementById('none-type');

  // Ẩn/hiện input số lượng theo từng checkbox
  typeCheckboxes.forEach(cb => {
    cb.addEventListener("change", function() {
      const qtyInput = document.getElementById("qty-" + this.value);
      if (this.checked) {
        qtyInput.classList.remove("hidden");
        qtyInput.required = true;
      } else {
        qtyInput.classList.add("hidden");
        qtyInput.value = "";
        qtyInput.required = false;
      }
    });
  });

  // Xử lý khi chọn "Không đăng ký loại nào"
  noneCheckbox.addEventListener("change", function() {
    if (this.checked) {
      typeCheckboxes.forEach(cb => {
        cb.checked = false;
        cb.disabled = true;
        const qtyInput = document.getElementById("qty-" + cb.value);
        if (qtyInput) {
          qtyInput.classList.add("hidden");
          qtyInput.value = "";
          qtyInput.required = false;
        }
      });
    } else {
      typeCheckboxes.forEach(cb => cb.disabled = false);
    }
  });
</script>
<script>
  // Bảng cân nặng → size tham khảo (28–44)
  const weightSizeMap = [
    // Lớp 1–5 (tiểu học)
    {
      max: 17,
      size: 29
    },
    {
      max: 20,
      size: 30
    },
    {
      max: 23,
      size: 31
    },
    {
      max: 27,
      size: 32
    },
    {
      max: 31,
      size: 33
    },
    {
      max: 35,
      size: 34
    },
    {
      max: 39,
      size: 35
    },
    {
      max: 43,
      size: 36
    },
    {
      max: 47,
      size: 37
    },
    {
      max: 50,
      size: 38
    },

    // Lớp 6–9 (THCS)
    {
      max: 55,
      size: 39
    },
    {
      max: 60,
      size: 40
    },
    {
      max: 65,
      size: 41
    },
    {
      max: 70,
      size: 42
    },
    {
      max: 75,
      size: 43
    },
    {
      max: 80,
      size: 44
    },

    // Lớp 10–12 (THPT)
    {
      max: Infinity,
      size: 44
    } // nặng hơn vẫn size 44
  ];

  // Hàm tính BMI
  function calculateBMI(heightCm, weightKg) {
    if (!heightCm || !weightKg) return null;
    const heightM = heightCm / 100;
    return weightKg / (heightM * heightM);
  }

  // Lấy size cơ bản theo cân nặng
  function getBaseSize(weightKg) {
    for (const item of weightSizeMap) {
      if (weightKg <= item.max) return item.size;
    }
    return 44; // fallback
  }

  // Tính size cuối cùng với điều chỉnh BMI ±1
  function getAdjustedSize(heightCm, weightKg) {
    const baseSize = getBaseSize(weightKg);
    const bmi = calculateBMI(heightCm, weightKg);
    if (!bmi) return baseSize;

    let adjust = 0;
    if (bmi < 18.5) adjust = -1; // gầy → giảm 1 size
    else if (bmi > 25) adjust = 1; // thừa cân → +1 size

    let finalSize = baseSize + adjust;

    // Giới hạn size 28–44
    if (finalSize < 28) finalSize = 28;
    if (finalSize > 44) finalSize = 44;

    return finalSize;
  }
  $("#orderForm").submit(function(e) {
    e.preventDefault();

    // Lấy dữ liệu form
    const formData = {};
    $(this).serializeArray().forEach(item => {
      formData[item.name] = item.value;
    });

    const height = parseFloat(formData['height']);
    const weight = parseFloat(formData['weight']);
    const bmi = calculateBMI(height, weight);
    formData['size'] = getAdjustedSize(bmi);
    // Thêm items (số lượng áo)
    ["coctay", "daitay", "khoac", "codo"].forEach(type => {
      const qty = $("#qty-" + type).val();
      if (qty && parseInt(qty) > 0) {
        formData["qty_" + type] = parseInt(qty);
      }
    });

    // Gửi JSON
    fetch("/api/submit_order.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify(formData)
      })
      .then(res => res.json())
      .then(res => {
        if (res.status === 'success') {
          alert("Đơn hàng đã được ghi nhận, ID: " + res.order_id);
          // location.reload();
        } else {
          alert("Lỗi: " + res.message);
        }
      })
      .catch(err => {
        console.error(err);
        alert("Có lỗi xảy ra");
      });
  });
</script>

</html>