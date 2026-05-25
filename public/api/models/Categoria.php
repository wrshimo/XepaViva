<?php
// public/api/models/Categoria.php

class Categoria {

    /**
     * Retorna a lista de categorias de produtos permitidas no sistema.
     * Esta lista é fixa e serve como a fonte da verdade para validações
     * e para popular elementos de UI, como selects.
     *
     * @return array A lista de categorias.
     */
    public function getTodasCategorias() {
        return [
            'Frutas',
            'Legumes',
            'Verduras',
            'Raízes e Tubérculos',
            'Ervas e Temperos',
            'Outros'
        ];
    }
}
?>