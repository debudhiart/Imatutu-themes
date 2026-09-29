<?php
/**
 * Range Slider Customizer Control
 *
 * @package Imatutu
 */

if (!defined('ABSPATH')) {
    exit;
}

if (class_exists('WP_Customize_Control')) {
    class Imatutu_Range_Slider_Control extends WP_Customize_Control {
        public $type = 'imatutu_range_slider';
        public $min  = 0;
        public $max  = 100;
        public $step = 1;
        public $unit = 'px';

        public function render_content() {
            ?>
            <div class="imatutu-range-slider-control">
                <?php if (!empty($this->label)) : ?>
                    <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <?php endif; ?>
                <?php if (!empty($this->description)) : ?>
                    <span class="description customize-control-description"><?php echo esc_html($this->description); ?></span>
                <?php endif; ?>

                <div class="range-slider-wrap" style="display: flex; align-items: center; gap: 12px; margin-top: 6px;">
                    <input type="range"
                           value="<?php echo esc_attr($this->value()); ?>"
                           min="<?php echo esc_attr($this->min); ?>"
                           max="<?php echo esc_attr($this->max); ?>"
                           step="<?php echo esc_attr($this->step); ?>"
                           <?php $this->link(); ?>
                           style="flex: 1;"
                           oninput="this.nextElementSibling.querySelector('.slider-value').innerText = this.value" />
                    <span class="range-value-badge" style="display: inline-block; min-width: 50px; text-align: center; padding: 4px 8px; background: #e2e8f0; border-radius: 4px; font-weight: 600; font-size: 12px; color: #1e293b;">
                        <span class="slider-value"><?php echo esc_html($this->value()); ?></span><?php echo esc_html($this->unit); ?>
                    </span>
                </div>
            </div>
            <?php
        }
    }
}
