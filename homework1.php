<?php
$products = [
    [1, 'Молоток', 500, ['инструмент', 'ручной']],
    [2, 'Отвертка', 300, ['инструмент', 'ручной']],
    [3, 'Дрель ударная', 3500, ['инструмент', 'электро']],
    [4, 'Перфоратор', 5500, ['инструмент', 'электро']],
    [5, 'Гвозди 100мм', 200, ['крепеж', 'метизы']],
    [6, 'Саморезы 50мм', 250, ['крепеж', 'метизы']],
    [7, 'Краска акриловая', 800, ['отделка', 'краска']],
    [8, 'Шпатлевка финишная', 400, ['отделка', 'шпатлевка']],
    [9, 'Кирпич красный', 60, ['стеновые', 'кирпич']],
    [10, 'Цемент М500', 350, ['сухие смеси', 'цемент']],
    [11, 'Плитка керамическая', 1200, ['отделка', 'плитка']],
    [12, 'Ламинат 32 класс', 850, ['напольные', 'ламинат']]
];

function e(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
$search = trim($_GET['q'] ?? '');
$minPrice = $_GET['min'] ?? '';
$maxPrice = $_GET['max'] ?? '';
$sort = $_GET['sort'] ?? 'name';
$dir = $_GET['dir'] ?? 'asc';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = isset($_GET['perPage']) ? (int)$_GET['perPage'] : 5;

if ($page < 1) $page = 1;
if ($perPage < 1) $perPage = 5;

$newProducts = [];
foreach ($products as $p) {
    $newProducts[] = [
        'id' => $p[0],
        'name' => $p[1],
        'price' => $p[2],
        'tags' => $p[3]
    ];
}


if (is_numeric($minPrice) && $minPrice > 0) {
    $filtered = [];
    foreach ($newProducts as $p) {
        if ($p['price'] >= $minPrice) {
            $filtered[] = $p;
        }
    }
    $newProducts = $filtered;
}

if (is_numeric($maxPrice) && $maxPrice > 0) {
    $filtered = [];
    foreach ($newProducts as $p) {
        if ($p['price'] <= $maxPrice) {
            $filtered[] = $p;
        }
    }
    $newProducts = $filtered;
}

usort($newProducts, function($a, $b) use ($sort, $dir) {
    if ($sort == 'price') {
        if ($dir == 'asc') {
            return $a['price'] - $b['price'];
        } else {
            return $b['price'] - $a['price'];
        }
    } else {
        if ($dir == 'asc') {
            return strcmp($a['name'], $b['name']);
        } else {
            return strcmp($b['name'], $a['name']);
        }
    }
});

$total = count($newProducts);
$totalPages = ceil($total / $perPage);
if ($page > $totalPages && $totalPages > 0) $page = $totalPages;

$start = ($page - 1) * $perPage;
$productsForPage = array_slice($newProducts, $start, $perPage);

function url($params) {
    $url = '?';
    foreach ($params as $key => $value) {
        if ($value !== '') {
            $url .= "$key=$value&";
        }
    }
    return rtrim($url, '&');
}
?>

<h1>Каталог товаров</h1>

<form method="GET">
    <p>
        Цена от: <input type="number" name="min" value="<?php echo e($minPrice); ?>">
        до: <input type="number" name="max" value="<?php echo e($maxPrice); ?>">
        
        Сортировать по:
        <select name="sort">
            <option value="name" <?php if ($sort == 'name') echo 'selected'; ?>>Названию</option>
            <option value="price" <?php if ($sort == 'price') echo 'selected'; ?>>Цене</option>
        </select>
        
        <select name="dir">
            <option value="asc" <?php if ($dir == 'asc') echo 'selected'; ?>>Возрастание</option>
            <option value="desc" <?php if ($dir == 'desc') echo 'selected'; ?>>Убывание</option>
        </select>
        
        <select name="perPage">
            <option value="5" <?php if ($perPage == 5) echo 'selected'; ?>>5 на страницу</option>
            <option value="10" <?php if ($perPage == 10) echo 'selected'; ?>>10 на страницу</option>
            <option value="20" <?php if ($perPage == 20) echo 'selected'; ?>>20 на страницу</option>
        </select>
        
        <button type="submit">Применить</button>
    </p>
</form>

<p>Всего найдено: <?php echo $total; ?></p>

<?php if (empty($productsForPage)): ?>
    <p>Товары не найдены</p>
<?php else: ?>
    <?php foreach ($productsForPage as $p): ?>
        <div>
            <h3><?php echo e($p['name']); ?></h3>
            <p>Цена: <?php echo $p['price']; ?> руб.</p>
            <p>Теги: <?php echo implode(', ', $p['tags']); ?></p>
            <hr>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php if ($totalPages > 1): ?>
    <p>
        Страницы:
        
        <?php if ($page > 1): ?>
            <a href="<?php echo url(['page' => 1, 'q' => $search, 'min' => $minPrice, 'max' => $maxPrice, 'sort' => $sort, 'dir' => $dir, 'perPage' => $perPage]); ?>">Первая</a>
            <a href="<?php echo url(['page' => $page - 1, 'q' => $search, 'min' => $minPrice, 'max' => $maxPrice, 'sort' => $sort, 'dir' => $dir, 'perPage' => $perPage]); ?>">Предыдущая</a>
        <?php else: ?>
            <span>Первая</span>
            <span>Предыдущая</span>
        <?php endif; ?>
        
        <span>Страница <?php echo $page; ?> из <?php echo $totalPages; ?></span>
        
        <?php if ($page < $totalPages): ?>
            <a href="<?php echo url(['page' => $page + 1, 'q' => $search, 'min' => $minPrice, 'max' => $maxPrice, 'sort' => $sort, 'dir' => $dir, 'perPage' => $perPage]); ?>">Следующая</a>
            <a href="<?php echo url(['page' => $totalPages, 'q' => $search, 'min' => $minPrice, 'max' => $maxPrice, 'sort' => $sort, 'dir' => $dir, 'perPage' => $perPage]); ?>">Последняя</a>
        <?php else: ?>
            <span>Следующая</span>
            <span>Последняя</span>
        <?php endif; ?>
    </p>
<?php endif; ?>