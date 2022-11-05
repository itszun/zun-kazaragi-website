<?php

namespace App\Contracts;

/**
 * Action Button on Datatable
 *
 * Define Action Button array inside actionButtonOptions()
 *
 */

interface ActionButton {
    /**
     * Array of button settings to appear in action button list
     *
     * @return array
     */
    public function actionButtonOptions(): array;

    /**
     * Custom Eloquent Attribute to retrieve by model properties "action_button"
     *
     * @return void
     */
    public function getActionButtonAttribute();

    /**
     * Renderer of Action Button by Using Blade View Component6
     *
     * @param [type] $id
     * @param array $option
     * @return string
     */
    public function actionButton($id, $option = []);
}
