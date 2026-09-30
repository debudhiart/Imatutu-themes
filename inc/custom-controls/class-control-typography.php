<?php
/**
 * Typography Selector Customizer Control
 *
 * @package Imatutu
 */

if (!defined('ABSPATH')) {
    exit;
}

if (class_exists('WP_Customize_Control') && !class_exists('Imatutu_Typography_Control')) {
    class Imatutu_Typography_Control extends WP_Customize_Control {
        public $type = 'imatutu_typography';

        public function render_content() {
            $fonts = array(
                'Plus Jakarta Sans' => 'Plus Jakarta Sans (Corporate Modern)',
                'Inter'             => 'Inter (Clean & Tech)',
                'Roboto'            => 'Roboto (Standard Enterprise)',
                'Poppins'           => 'Poppins (Geometric & Friendly)',
                'Outfit'            => 'Outfit (Modern Minimalist)',
                'System'            => 'System Sans-Serif (Native Fast)',
            );
            ?>
            <div class="imatutu-typography-control">
                <?php if (!empty($this->label)) : ?>
                    <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <?php endif; ?>
                <?php if (!empty($this->description)) : ?>
                    <span class="description customize-control-description"><?php echo esc_html($this->description); ?></span>
                <?php endif; ?>

                <select <?php $this->link(); ?> style="width: 100%; margin-top: 6px;">
                    <?php foreach ($fonts as $font_key => $font_name) : ?>
                        <option value="<?php echo esc_attr($font_key); ?>" <?php selected($this->value(), $font_key); ?>>
                            <?php echo esc_html($font_name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php
        }
    }
}
