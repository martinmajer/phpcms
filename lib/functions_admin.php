<?php

$_menu = array();

/** Zaregistruje položku do hlavního menu. */
function registerMenuItem($title, $link, $position, $submenu = null) {
    global $_menu;
    $_menu[] = createMenuItem($title, $link, $position, $submenu);
}

function & findSubMenu(&$menu, $link) {
    foreach ($menu as & $item) {
        if ($item['link'] == $link) return $item['submenu'];
        else if ($item['submenu']) {
            $inSubmenu = & findMenuItem($item['submenu'], $link);
            if ($inSubmenu) return $inSubmenu;
        }
    }
    return null;
}

/** Vytvoří položku pro hlavní menu. */
function createMenuItem($title, $link, $position, $submenu = null) {
    return array(
        'title' => $title,
        'link' => $link,
        'position' => $position,
        'submenu' => $submenu
    );
}

/** Vrátí strukturu hlavního menu. */
function & getMenuStruct() {
    global $_menu;
    return $_menu;
}

/** Vypíše menu. */
function writeMenu($menu, $depth = 0) {
    usort($menu, function($itemA, $itemB) { return $itemA['position'] - $itemB['position'];});
    
    echo "<ul class=\"" . ($depth == 0 ? "nav" : "dropdown-menu") . "\">", PHP_EOL;
    foreach ($menu as $item) {
        if ($item['submenu']) {
            echo "<li class=\"dropdown\">", PHP_EOL;
            echo "<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">" . $item['title'] . " <b class=\"caret\"></b></a>", PHP_EOL;
            writeMenu($item['submenu'], $depth + 1);
            echo "</li>";
        }
        else {
            echo "<li><a href=\"" . $item['link'] . "\">" . $item['title'] . "</a></li>", PHP_EOL;
        }
    }
    echo "</ul>";
}

/**
 * Vykreslí tabulku.
 * @param Model[] $data
 * @param array $columns
 * @param array $options
 */
function renderTable($data, $columns, $options = array()) {
    $showId = isset($options['showId']) ? $options['showId'] : true;
    if ($showId) {
        array_unshift($columns, createTableColumn("#", "id"));
    }
    
    echo "<table class=\"table table-hover\">", PHP_EOL;
    echo "<thead>", PHP_EOL;
    echo "<tr>";
    foreach ($columns as $column) {
        $style = "";
        if (isset($column['options']['align'])) {
            $style .= "text-align: {$column['options']['align']};";
        }
        echo "<th style=\"$style\">{$column['title']}</th>";
    }
    echo "</tr>";
    echo "</thead>", PHP_EOL;
    echo "<tbody>", PHP_EOL;
    foreach ($data as $item) {
        echo "<tr>";
        foreach ($columns as $column) {
            $property = $column['property'];
            $filterCallback = $column['filterCallback'];
            $value = $property ? $item->$property : null;
            if ($filterCallback) {
                $value = call_user_func($filterCallback, $item, $value);
            }
            
            $style = "";
            if (!empty($column['options']['align'])) {
                $style .= "text-align: {$column['options']['align']};";
            }
            if (!empty($column['options']['nowrap'])) {
                $style .= "white-space: nowrap;";
            }
            echo "<td style=\"$style\">$value</td>";
        }
        echo "</tr>";
    }
    /*if (!$data) {
        echo "<tr><td colspan=\"".count($columns)."\" style=\"text-align: center;\">(evidence je prázdná)</td></tr>", PHP_EOL;
    }*/
    echo "</tbody>", PHP_EOL;
    echo "</table>", PHP_EOL;
    
    $paginator = isset($options['paginator']) ? $options['paginator'] : null; /* @var $paginator Paginator */
    if ($paginator && $paginator->getTotalPages() > 1) {
        echo "<div class=\"pagination\"><ul>";
        echo "<li" . ($paginator->getCurrentPage() == 1 ? " class=\"disabled\"" : "") . "><a href=\"" . ($paginator->getCurrentPage() == 1 ? "#" : ("?".Paginator::PAGINATOR_KEY."=".($paginator->getCurrentPage()-1))) . "\">&laquo;</a></li>";
        for ($i = 1; $i <= $paginator->getTotalPages(); $i++) {
            echo "<li" . ($paginator->getCurrentPage() == $i ? " class=\"active\"" : "") . "><a href=\"?".Paginator::PAGINATOR_KEY."=".$i."\">".$i."</a></li>";
        }
        echo "<li" . ($paginator->getCurrentPage() == $paginator->getTotalPages() ? " class=\"disabled\"" : "") . "><a href=\"" . ($paginator->getCurrentPage() == $paginator->getTotalPages() ? "#" : ("?".Paginator::PAGINATOR_KEY."=".($paginator->getCurrentPage()+1))) . "\">&raquo;</a></li>";
        echo "</ul></div>", PHP_EOL;
    }
}

function createTableColumn($title, $property, $filterCallback = null, $options = array()) {
    return array(
        'title' => $title,
        'property' => $property,
        'filterCallback' => $filterCallback,
        'options' => $options
    );
}

function createTableAction($icon, $title, $url, $btnClass = "", $jsConfirm = "") {
    return "<a class=\"btn btn-mini $btnClass\" href=\"$url\" title=\"$title\"" . ($jsConfirm ? " onclick=\"return confirm('" . htmlspecialchars($jsConfirm) . "');\"" : "") . "><i class=\"$icon\"></i></a> ";
}

function adminHeader() {
    include ADMIN_DIR . "/header.php";
}

function adminFooter() {
    include ADMIN_DIR . "/footer.php";
}


