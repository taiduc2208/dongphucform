<?php
require_once "auth.php";
require_once "cfg_dongphuc.php";

// --- Lấy danh sách trường ---
$stmt = $conn->query("SELECT DISTINCT school_name FROM orders ORDER BY school_name DESC");
$schools = $stmt->fetchAll(PDO::FETCH_COLUMN);

// --- Lấy tham số filter ---
$selected_school = $_GET['school'] ?? '';
$months = $_GET['months'] ?? 2;
if ($months !== 'custom') {
  $months = intval($months);
  $from_date = date('Y-m-d 00:00:00', strtotime("-$months month"));
  $to_date = date('Y-m-d 23:59:59');
} else if (isset($_GET['from_date'], $_GET['to_date'])) {
  $from_date = $_GET['from_date'] . ' 00:00:00';
  $to_date = $_GET['to_date'] . ' 23:59:59';
} else {
  // fallback nếu custom nhưng ko điền ngày
  $from_date = date('Y-m-d 00:00:00', strtotime("-2 month"));
  $to_date = date('Y-m-d 23:59:59');
}

// --- Build WHERE ---
$where = [];
$params = [];
if ($selected_school) {
  $where[] = "o.school_name = :school";
  $params[':school'] = $selected_school;
}
$where[] = "o.created_at BETWEEN :from_date AND :to_date";
$params[':from_date'] = $from_date;
$params[':to_date'] = $to_date;

$where_sql = $where ? "WHERE " . implode(' AND ', $where) : "";

// --- Query thống kê ---
$sql = "
    SELECT o.gender, o.class, oi.type, o.size, SUM(oi.quantity) as qty
    FROM orders o
    JOIN order_items oi ON o.id = oi.order_id
    $where_sql
    GROUP BY o.gender, o.class, oi.type, o.size
    ORDER BY o.gender, o.class, oi.type, o.size
";
$stmt = $conn->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// --- Gom dữ liệu ---
$data = [];
$sizes = [];
foreach ($rows as $row) {
  $gender = $row['gender'];
  $class = $row['class'];
  $type = $row['type'];
  $size = $row['size'];
  $qty = $row['qty'];

  $data[$gender][$type][$class][$size] = $qty;
  $sizes[$size] = true;
}
ksort($sizes);
?>
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <title>Thống kê đồng phục</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 p-6">
  <div class="max-w-7xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Thống kê đồng phục</h1>

    <?php
    $type_vn = [
      'coctay' => 'Áo cộc tay',
      'khoac'  => 'Áo khoác',
      'daitay' => 'Áo dài tay',
      'codo'   => 'Áo cờ đỏ sao vàng',
    ];
    ?>

    <!-- Form filter -->
    <form method="GET" class="mb-6 flex space-x-4 items-end">
      <!-- Chọn trường -->
      <div>
        <label class="block mb-2 font-semibold">Chọn trường:</label>
        <select name="school" class="border rounded p-2 w-64" onchange="this.form.submit()">
          <option value="">-- Tất cả trường --</option>
          <?php foreach ($schools as $school): ?>
            <option value="<?= htmlspecialchars($school) ?>" <?= $school == $selected_school ? 'selected' : '' ?>>
              <?= htmlspecialchars($school) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Chọn khoảng thời gian -->
      <div>
        <label class="block mb-2 font-semibold">Khoảng thời gian:</label>
        <select name="months" class="border rounded p-2" onchange="this.form.submit()">
          <?php for ($m = 1; $m <= 12; $m++): ?>
            <option value="<?= $m ?>" <?= $m == $months ? 'selected' : '' ?>><?= $m ?> tháng gần đây</option>
          <?php endfor; ?>
          <option value="custom" <?= $months == 'custom' ? 'selected' : '' ?>>Tùy chọn</option>
        </select>
      </div>
      <div id="custom-dates" style="display: <?= $months == 'custom' ? 'flex' : 'none' ?>;" class="flex gap-4 mt-2 space-x-2">
        <label class="block">
          Từ ngày:
          <input type="date" name="from_date" value="<?= htmlspecialchars($_GET['from_date'] ?? '') ?>" class="border rounded px-2 py-1">
        </label>
        <label class="block">
          Đến ngày:
          <input type="date" name="to_date" value="<?= htmlspecialchars($_GET['to_date'] ?? '') ?>" class="border rounded px-2 py-1">
        </label>
      </div>
      <script>
        function toggleCustom(val) {
          document.getElementById('custom-dates').style.display = val === 'custom' ? 'flex' : 'none';
        }
        toggleCustom('<?= $months ?>');
      </script>
      <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Áp dụng</button>
    </form>

    <?php if ($selected_school): ?>
      <?php foreach (['male' => 'Nam', 'female' => 'Nữ'] as $genderKey => $genderLabel): ?>
        <?php if (!isset($data[$genderKey])) continue; ?>

        <h2 class="text-xl font-bold mt-8 mb-4"><?= $genderLabel ?></h2>

        <?php foreach ($data[$genderKey] as $type => $classes): ?>
          <?php $display_type = $type_vn[$type] ?? $type; ?>
          <h3 class="text-lg font-semibold mt-4 mb-2">Loại áo: <?= htmlspecialchars($display_type) ?></h3>
          <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow rounded mb-6">
              <thead>
                <tr class="bg-gray-200">
                  <th class="px-4 py-2 text-left">Lớp</th>
                  <?php foreach (array_keys($sizes) as $size): ?>
                    <th class="px-4 py-2 text-center">Size <?= $size ?></th>
                  <?php endforeach; ?>
                  <th class="px-4 py-2 text-center">Tổng</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $totalsBySize = array_fill_keys(array_keys($sizes), 0);
                $grandTotal = 0;
                foreach ($classes as $class => $sizesData):
                  $rowTotal = 0;
                ?>
                  <tr class="border-b">
                    <td class="px-4 py-2 font-medium"><?= htmlspecialchars($class) ?></td>
                    <?php foreach (array_keys($sizes) as $size):
                      $qty = $sizesData[$size] ?? 0;
                      $rowTotal += $qty;
                      $totalsBySize[$size] += $qty;
                    ?>
                      <td class="px-4 py-2 text-center"><?= $qty ?></td>
                    <?php endforeach; ?>
                    <td class="px-4 py-2 text-center font-semibold text-blue-600"><?= $rowTotal ?></td>
                  </tr>
                  <?php $grandTotal += $rowTotal; ?>
                <?php endforeach; ?>

                <!-- Tổng các lớp -->
                <tr class="bg-gray-100 font-bold">
                  <td class="px-4 py-2">Tổng</td>
                  <?php foreach ($totalsBySize as $qty): ?>
                    <td class="px-4 py-2 text-center text-blue-600"><?= $qty ?></td>
                  <?php endforeach; ?>
                  <td class="px-4 py-2 text-center text-red-600 text-lg"><?= $grandTotal ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        <?php endforeach; ?>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-gray-600">Vui lòng chọn trường để xem thống kê.</p>
    <?php endif; ?>
  </div>
</body>

</html>