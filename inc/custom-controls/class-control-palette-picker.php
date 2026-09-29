<?php
/**
 * Visual Palette Picker Customizer Control
 *
 * @package Imatutu
 */

if (!defined('ABSPATH')) {
    exit;
}

if (class_exists('WP_Customize_Control')) {
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

                <div class="palette-swatches-grid" style="display: flex; flex-direction: column; gap: 8px; margin-top: 8px;">
                    <?php foreach ($this->palettes as $id => $palette) : 
                        $is_checked = ($this->value() === $id);
                    ?>
                        <label class="palette-option" style="display: flex; align-items: center; justify-content: space-between; padding: 8px 12px; background: #ffffff; border: 2px solid <?php echo $is_checked ? '#1559ed' : '#e2e8f0'; ?>; border-radius: 8px; cursor: pointer; transition: all 0.2s;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <input type="radio" 
                                       name="<?php echo esc_attr($this->id); ?>" 
                                       value="<?php echo esc_attr($id); ?>" 
                                       <?php $this->link(); ?> 
                                       <?php checked($this->value(), $id); ?> 
                                       style="margin: 0;" />
                                <span style="font-weight: 600; font-size: 13px; color: #1e293b;"><?php echo esc_html($palette['name']); ?></span>
                            </div>
                            <div class="swatch-strip" style="display: flex; gap: 4px;">
                                <?php foreach ($palette['colors'] as $color) : ?>
                                    <span style="display: inline-block; width: 18px; height: 18px; border-radius: 4px; background-color: <?php echo esc_attr($color); ?>; border: 1px solid rgba(0,0,0,0.1);"></span>
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
