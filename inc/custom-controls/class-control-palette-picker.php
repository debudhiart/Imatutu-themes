<?php
/**
 * Visual Palette Picker Customizer Control
 *
 * @package Imatutu
 */

if (!defined('ABSPATH')) {
    exit;
}

if (class_exists('WP_Customize_Control') && !class_exists('Imatutu_Palette_Picker_Control')) {
    class Imatutu_Palette_Picker_Control extends WP_Customize_Control {
        public $type = 'imatutu_palette_picker';
        public $palettes = array();

        public function render_content() {
            if (empty($this->palettes)) {
                return;
            }
            ?>
            <div class="imatutu-palette-picker-control">
                <?php if (!empty($this->label)) : ?>
                    <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <?php endif; ?>
                <?php if (!empty($this->description)) : ?>
                    <span class="description customize-control-description"><?php echo esc_html($this->description); ?></span>
                <?php endif; ?>

                <div class="palette-swatches-grid">
                    <?php foreach ($this->palettes as $id => $palette) : 
                        $is_checked = ($this->value() === $id);
                    ?>
                        <label class="palette-option <?php echo $is_checked ? 'is-active' : ''; ?>">
                            <div class="palette-option-label">
                                <input type="radio" 
                                       name="<?php echo esc_attr($this->id); ?>" 
                                       value="<?php echo esc_attr($id); ?>" 
                                       <?php $this->link(); ?> 
                                       <?php checked($this->value(), $id); ?> />
                                <span class="palette-name"><?php echo esc_html($palette['name']); ?></span>
                            </div>
                            <div class="swatch-strip">
                                <?php foreach ($palette['colors'] as $color) : ?>
                                    <span class="swatch-dot" style="background-color: <?php echo esc_attr($color); ?>;"></span>
                                <?php endforeach; ?>
                            </div>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php
        }
    }
}
