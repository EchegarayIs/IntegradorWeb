<?php
// modelo/CartModel.php

class CartModel {
    private const CART_KEY = 'carrito';

    // 1. Inicializa el carrito y la sesión
    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION[self::CART_KEY] = $_SESSION[self::CART_KEY] ?? [];
    }

    // 2. Obtiene todos los ítems
    public function getItems() {
        // Asegura que todos los ítems tengan el subtotal actualizado antes de devolverlos
        $this->getTotalSubtotal(); 
        return $_SESSION[self::CART_KEY];
    }

    // 3. Genera un ID único (Hash) basado en el producto y sus mods
    private function generateItemHash($producto_id, $modificadores) {
        $modificadores = $modificadores ?? []; // Asegura que es un array
        $mod_string = '';
        if (!empty($modificadores)) {
            $mod_names = array_column($modificadores, 'nombre');
            sort($mod_names);
            $mod_string = implode('|', $mod_names);
        }
        return md5($producto_id . ':' . $mod_string);
    }

    // 4. Calcula el costo extra de todos los modificadores en un ítem
    private function calculateModsCost($modificadores) {
        $costo = 0.00;
        $modificadores = $modificadores ?? []; // Asegura que es un array
        foreach ($modificadores as $mod) {
            $costo += (float)($mod['precio_extra'] ?? 0.00);
        }
        return $costo;
    }

    // 5. Método para añadir o incrementar un producto (USADO POR TU MENÚ)
    public function addItem($producto_id, $nombre, $precio_base, $cantidad, $modificadores = []) {
        $item_hash = $this->generateItemHash($producto_id, $modificadores);

        if (isset($_SESSION[self::CART_KEY][$item_hash])) {
            $_SESSION[self::CART_KEY][$item_hash]['cantidad'] += $cantidad;
        } else {
            $_SESSION[self::CART_KEY][$item_hash] = [
                'producto_id' => $producto_id,
                'nombre' => $nombre,
                'precio' => (float)$precio_base,
                'cantidad' => (int)$cantidad,
                'modificadores' => $modificadores,
                'subtotal' => 0.00
            ];
        }
        $this->getTotalSubtotal(); 
        return true;
    }

    // 6. Actualiza la cantidad de un ítem (USADO POR TU CARRITO)
    public function updateQuantity($item_hash, $cantidad) {
        $cantidad = (int)$cantidad;
        if (isset($_SESSION[self::CART_KEY][$item_hash])) {
            if ($cantidad <= 0) {
                return $this->removeItem($item_hash);
            }
            $_SESSION[self::CART_KEY][$item_hash]['cantidad'] = $cantidad;
            $this->getTotalSubtotal();
            return true;
        }
        return false;
    }

    // 7. Elimina un ítem (USADO POR TU CARRITO)
    public function removeItem($item_hash) {
        if (isset($_SESSION[self::CART_KEY][$item_hash])) {
            unset($_SESSION[self::CART_KEY][$item_hash]);
            $this->getTotalSubtotal();
            return true;
        }
        return false;
    }

    // 8. Calcula el subtotal total del carrito
    public function getTotalSubtotal() {
        $total_subtotal = 0.00;
        foreach ($_SESSION[self::CART_KEY] as $item_hash => &$item) {
            
            $base_cost = (float)$item['precio'] * (int)$item['cantidad'];
            
            // Verifica y usa modificadores
            $item_modificadores = $item['modificadores'] ?? [];
            $mods_cost_unit = $this->calculateModsCost($item_modificadores); 
            $mods_cost_total = $mods_cost_unit * (int)$item['cantidad'];
            
            $item['subtotal'] = $base_cost + $mods_cost_total;
            $total_subtotal += $item['subtotal'];
        }
        return $total_subtotal;
    }

    public function isEmpty() {
        return empty($_SESSION[self::CART_KEY]);
    }
}
?>