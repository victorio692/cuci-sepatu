<?php
/**
 * Custom Pagination Template for SYH Cleaning
 */
$pager->setSurroundCount(2);

// Get pagination info safely
$currentPage = 1;
$total = 0;

try {
    $currentPage = (int) $pager->getCurrent();
    $total = (int) $pager->getTotal();
} catch (Exception $e) {
    // Fallback values
}

$perPage = 10; // Sesuai dengan controller

// Calculate display range
if ($total > 0) {
    $firstItem = (($currentPage - 1) * $perPage) + 1;
    $lastItem = min($currentPage * $perPage, $total);
} else {
    $firstItem = 0;
    $lastItem = 0;
}
?>

<nav aria-label="Navigasi halaman" class="flex items-center justify-between">
    <!-- Info Text -->
    <div class="text-sm text-gray-600">
        Total: <span class="font-semibold text-gray-800"><?= $total ?></span> pesanan | 
        Menampilkan <span class="font-semibold text-gray-800"><?= $firstItem ?> - <?= $lastItem ?></span>
    </div>
    
    <!-- Pagination Links -->
    <ul class="flex items-center space-x-1">
        <?php if ($pager->hasPrevious()) : ?>
            <li>
                <a href="<?= $pager->getFirst() ?>" aria-label="<?= lang('Pager.first') ?>" 
                   class="flex items-center justify-center w-10 h-10 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-blue-50 hover:text-blue-600 hover:border-blue-400 transition-all duration-200">
                    <i class="fas fa-angle-double-left text-sm"></i>
                </a>
            </li>
            <li>
                <a href="<?= $pager->getPrevious() ?>" aria-label="<?= lang('Pager.previous') ?>" 
                   class="flex items-center justify-center w-10 h-10 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-blue-50 hover:text-blue-600 hover:border-blue-400 transition-all duration-200">
                    <i class="fas fa-chevron-left text-sm"></i>
                </a>
            </li>
        <?php endif ?>

        <?php foreach ($pager->links() as $link) : ?>
            <li>
                <?php if ($link['active']) : ?>
                    <a href="<?= $link['uri'] ?>" aria-current="page" 
                       class="flex items-center justify-center w-10 h-10 text-white bg-gradient-to-r from-blue-500 to-blue-600 border border-blue-600 rounded-lg font-semibold shadow-md">
                        <?= $link['title'] ?>
                    </a>
                <?php else : ?>
                    <a href="<?= $link['uri'] ?>" 
                       class="flex items-center justify-center w-10 h-10 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-blue-50 hover:text-blue-600 hover:border-blue-400 transition-all duration-200 font-medium">
                        <?= $link['title'] ?>
                    </a>
                <?php endif ?>
            </li>
        <?php endforeach ?>

        <?php if ($pager->hasNext()) : ?>
            <li>
                <a href="<?= $pager->getNext() ?>" aria-label="<?= lang('Pager.next') ?>" 
                   class="flex items-center justify-center w-10 h-10 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-blue-50 hover:text-blue-600 hover:border-blue-400 transition-all duration-200">
                    <i class="fas fa-chevron-right text-sm"></i>
                </a>
            </li>
            <li>
                <a href="<?= $pager->getLast() ?>" aria-label="<?= lang('Pager.last') ?>" 
                   class="flex items-center justify-center w-10 h-10 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-blue-50 hover:text-blue-600 hover:border-blue-400 transition-all duration-200">
                    <i class="fas fa-angle-double-right text-sm"></i>
                </a>
            </li>
        <?php endif ?>
    </ul>
</nav>
