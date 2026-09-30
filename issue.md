# SPESIFIKASI DAN PANDUAN PENGEMBANGAN: ADVANCED WORDPRESS CUSTOMIZER & MODULAR LAYOUT BUILDER (IMATUTU THEME V2)

**Target Repositori**: `debudhiart/Imatutu-themes`  
**Branch Pengembangan**: `feature/advanced-customizer` (atau `development`)  
**Lokasi Akses Fitur**: Dashboard WordPress Admin > **Appearance (Tampilan)** > **Customize (Sesuaikan)** (`WP_Customize_Manager`)  
**Target Pengguna Akhir**: Staf Non-Teknis / Content Administrator (Mudah digunakan secara visual tanpa coding)  
**Target Pelaksana**: Junior Web Programmer atau Model AI (Instruksi disusun sangat detail, prosedural, terstruktur rapi, dan *code-ready*)

---

## DAFTAR ISI
1. [Ringkasan & Tujuan Proyek](#1-ringkasan--tujuan-proyek)
2. [Cakupan Fitur Utama (Requirements Matrix)](#2-cakupan-fitur-utama-requirements-matrix)
3. [Arsitektur Direktori & File Baru](#3-arsitektur-direktori--file-baru)
4. [Spesifikasi Custom Controls (`inc/custom-controls/`)](#4-spesifikasi-custom-controls-inccustom-controls)
5. [Skema Data Struktur & Pengaturan Customizer](#5-skema-data-struktur--pengaturan-customizer)
   - 5.1 [Sistem Tipografi (Typography Engine)](#51-sistem-tipografi-typography-engine)
   - 5.2 [Sistem Color Palette & Theme Presets](#52-sistem-color-palette--theme-presets)
   - 5.3 [Layout Engine: Grid, Row & Column Controller](#53-layout-engine-grid-row--column-controller)
   - 5.4 [Modular Components Library (Image, Video, Heading, WPForms, dll)](#54-modular-components-library-image-video-heading-wpforms-dll)
6. [Spesifikasi Teknis Template Renderer (`template-parts/builder/`)](#6-spesifikasi-teknis-template-renderer-template-partsbuilder)
7. [Desain Styling & CSS Layout Engine (`assets/css/builder.css`)](#7-desain-styling--css-layout-engine-assetscssbuildercss)
8. [Live Preview Realtime Script (`assets/js/builder-preview.js`)](#8-live-preview-realtime-script-assetsjsbuilder-previewjs)
9. [Tahapan Implementasi Step-by-Step (Work Breakdown Structure)](#9-tahapan-implementasi-step-by-step-work-breakdown-structure)
10. [Checklist Pengujian & Validasi Kualitas](#10-checklist-pengujian--validasi-kualitas)

---

## 1. RINGKASAN & TUJUAN PROYEK

Pada versi sebelumnya (V1), tema Imatutu telah memiliki struktur korporat modern dengan section statis yang dapat diedit teks dan warnanya melalui Customizer standar.

Pada versi ini (V2), tujuan pengembangannya adalah **meningkatkan kapabilitas Customizer menjadi sebuah Visual Layout & Component Engine yang fleksibel**, di mana staf biasa dapat:
1. Mengubah teks dan tulisan di setiap elemen dengan seketika.
2. Mengubah gaya tulisan (*Typography*: pilihan Google Fonts, ukuran H1–H6 & body, bobot teks, jarak baris, letter spacing).
3. Mengganti palet warna (*Color Palette*) secara menyeluruh dengan bantuan preset siap pakai (1-klik) maupun pemilihan warna manual dengan CSS variables terintegrasi.
4. Memanipulasi tata letak (*layout grid, row, column*) dengan leluasa: menambah/mengurangi jumlah kolom (1 hingga 6 kolom), menentukan rasio pembagian kolom, serta mengatur spasi (*gap*) dan perataan (*alignment*).
5. Memasukkan berbagai jenis komponen ke dalam kolom: gambar, video, tombol/link, heading, paragraf teks, form interaktif (WPForms/Contact Form 7), counter statistik, maupun icon box.
6. Tetap mempertahankan kecepatan website tinggi tanpa ketergantungan pada plugin page builder berat pihak ketiga (seperti Elementor/WPBakery) dan tetap berjalan 100% menggunakan native **WordPress Customizer API**.

---

## 2. CAKUPAN FITUR UTAMA (REQUIREMENTS MATRIX)

| Modul Fitur | Kebutuhan Spesifik | Kontrol UI di Customizer | Sanitasi / Keamanan |
|---|---|---|---|
| **Content Editor** | Mengubah seluruh tulisan judul, subjudul, label tombol, paragraf | Text input, Textarea, TinyMCE / WP Editor control | `sanitize_text_field`, `wp_kses_post` |
| **Typography Engine** | Pilihan Font Family (Inter, Plus Jakarta Sans, Roboto, Poppins, Outfit, System), Font Size (px/rem), Weight (300-800), Line Height, Text Transform | Select dropdown, Range Slider, Toggle button | `sanitize_text_field`, `absint`, in-array validator |
| **Color Palette System** | Presets 1-klik (Corporate Blue, Modern Navy, Emerald Business, Warm Crimson, Minimal Slate) + Penyesuaian Custom per elemen (Primary, Secondary, Accent, Background, Surface, Text, Border) | Palette Swatches Radio + Color Pickers dengan Alpha opacity | `sanitize_hex_color`, in-array validator |
| **Layout Grid & Column** | Pilihan jumlah kolom per baris (1, 2, 3, 4, 6 kolom, rasio asimetris 1:2, 2:1, 1:3:1), pengaturan Gap (0, 16px, 24px, 32px, 48px), pengaturan Vertical & Horizontal Alignment | Select / Radio Image button, Slider gap, Alignment selector | `sanitize_key`, `absint`, in-array validator |
| **Media: Image & Gallery** | Upload gambar dari WP Media Library, pilihan aspect ratio (16:9, 4:3, 1:1, auto), border radius, alt text, lightbox modal toggle, tautan klik | `WP_Customize_Image_Control`, Select, Checkbox | `esc_url_raw`, `sanitize_text_field`, `wp_validate_boolean` |
| **Media: Video** | Embed YouTube, Vimeo, atau Self-Hosted MP4/WebM, aspect ratio responsif 16:9, opsi autoplay, loop, dan muted | URL Input, Select provider, Checkbox options | `esc_url_raw`, `wp_oembed_get`, `wp_validate_boolean` |
| **Heading & Typography** | Tag H1 s/d H6, font size override, text alignment (kiri, tengah, kanan), accent bar dekoratif toggle | Text input, Select tag (H1-H6), Select align, Checkbox | `sanitize_text_field`, in-array validator |
| **Button / Action Link** | Label tombol, URL tujuan, varian gaya (Primary Solid, Secondary, Outline, Ghost/Text Link), Icon panah toggle, Target `_blank` toggle | Text input, URL input, Select variant, Checkbox | `sanitize_text_field`, `esc_url_raw`, `wp_validate_boolean` |
| **Form Integration** | Pemilihan form dari plugin WPForms / Contact Form 7 via ID atau Shortcode, render otomatis dengan style modern terintegrasi | Select dropdown (otomatis membaca form yang aktif di database) / Text shortcode | `sanitize_text_field`, `do_shortcode` |
| **Interactive Components** | Counter Statistik (angka + label), Accordion/FAQ, Testimonial Card, Icon Feature Box | Repeater / Sub-setting fields | Sanitasi bertingkat sesuai tipe field |
| **Staff Experience (UX)** | Toggle Hide/Show section, live preview tanpa reload halaman (*postMessage*), penamaan section yang jelas dalam bahasa yang mudah dipahami | Toggle switch, Section reordering, Live Preview JS | Nonce token, selective refresh partials |

---

## 3. ARSITEKTUR DIREKTORI & FILE BARU

Pengembangan V2 akan mengorganisir kode ke dalam struktur modular berikut di dalam tema:

```
imatutu-theme/
├── assets/
│   ├── css/
│   │   ├── main.css                   # Stylesheet tema dasar
│   │   ├── builder.css                # [BARU] Styling layout grid, kolom, & komponen modular
│   │   └── customizer-controls.css    # [BARU] Styling custom UI controls di admin Customizer
│   ├── js/
│   │   ├── main.js                    # Script interaktif frontend dasar
│   │   ├── builder-frontend.js        # [BARU] Script lightbox, video modal, accordion interaktif
│   │   ├── builder-preview.js         # [BARU] Script live preview postMessage untuk Customizer
│   │   └── customizer-controls.js     # [BARU] Script interaksi repeater & UI di admin Customizer
│   └── images/
│       ├── icons/                     # [BARU] Kumpulan icon SVG untuk builder
│       └── palettes/                  # [BARU] Preview swatch warna preset
├── inc/
│   ├── customizer.php                 # Registrasi utama panel, section, dan settings
│   ├── customizer-typography.php      # [BARU] Logika Google Fonts loader & dynamic CSS generator
│   ├── customizer-palettes.php        # [BARU] Logika preset warna & variabel CSS tema
│   ├── customizer-layout-engine.php   # [BARU] Logika render section dinamis & grid builder
│   └── custom-controls/               # [BARU] Kumpulan Custom WP_Customize_Control classes
│       ├── class-control-typography.php   # Kontrol pemilihan font & ukuran
│       ├── class-control-palette-picker.php# Kontrol visual pemilihan palet warna
│       ├── class-control-range-slider.php # Kontrol slider angka (px, rem, gap)
│       └── class-control-repeater.php     # Kontrol repeater komponen per baris
├── template-parts/
│   ├── home/                          # Komponen home bawaan V1 (tetap ada sebagai fallback)
│   └── builder/                       # [BARU] Renderer komponen dinamis
│       ├── section-wrapper.php        # Pembungkus section dinamis (container, bg, spacing)
│       ├── row-column.php             # Grid & Flex column renderer
│       ├── component-heading.php      # Renderer heading H1-H6
│       ├── component-paragraph.php    # Renderer paragraf & rich text
│       ├── component-image.php        # Renderer gambar responsif & lightbox
│       ├── component-video.php        # Renderer video responsif (YouTube, Vimeo, MP4)
│       ├── component-button.php       # Renderer tombol aksi & CTA
│       ├── component-form.php         # Renderer WPForms / shortcode form
│       ├── component-iconbox.php      # Renderer kartu fitur ber-ikon
│       ├── component-counter.php      # Renderer statistik metrik
│       └── component-accordion.php    # Renderer accordion / FAQ
├── functions.php                      # Enqueue builder scripts & register hooks
└── style.css                          # Metadata tema
```

---

## 4. SPESIFIKASI CUSTOM CONTROLS (`inc/custom-controls/`)

Untuk membuat antarmuka Customizer mudah dipahami staf biasa, bangun 4 custom control turunan dari `WP_Customize_Control`:

### 4.1 Slider Ukuran / Range Control (`class-control-range-slider.php`)
- **Tujuan**: Mengatur gap kolom (0–64px), padding section (20–120px), dan ukuran font tanpa mengetik manual.
- **Implementasi**: Menampilkan slider `<input type="range">` dengan nilai visual live badge di sebelahnya (misal: `24px`).
- **Data output**: Angka numerik murni (`absint`).

### 4.2 Visual Palette Picker (`class-control-palette-picker.php`)
- **Tujuan**: Menampilkan kotak swatch visual warna (5 warna berjejer dalam satu kartu klik) untuk memilih preset palet perusahaan dalam 1-klik.
- **Preset Default**:
  1. *Pertamina Corporate Blue*: Primary `#1559ED`, Secondary `#0B192C`, Accent `#E21F23`, Background `#F8FAFC`.
  2. *Executive Midnight Navy*: Primary `#2563EB`, Secondary `#030712`, Accent `#F59E0B`, Background `#0F172A`.
  3. *Emerald Eco Enterprise*: Primary `#059669`, Secondary `#064E3B`, Accent `#10B981`, Background `#F0FDF4`.
  4. *Modern Minimalist Slate*: Primary `#0F172A`, Secondary `#334155`, Accent `#64748B`, Background `#FFFFFF`.
- **Implementasi**: Input radio tersembunyi dengan label berupa swatch warna yang memiliki border highlight saat aktif.

### 4.3 Typography Control (`class-control-typography.php`)
- **Tujuan**: Pengaturan font yang ringkas dalam satu kotak panel.
- **Sub-field**:
  - `font_family`: Dropdown berisi pilihan: *Plus Jakarta Sans (Default), Inter, Roboto, Poppins, Outfit, System Sans-Serif*.
  - `font_size`: Slider ukuran (12px – 64px).
  - `font_weight`: Dropdown pilihan *300 (Light), 400 (Regular), 500 (Medium), 600 (Semi-Bold), 700 (Bold), 800 (Extra-Bold)*.
  - `text_transform`: Dropdown *none, uppercase, capitalize, lowercase*.
- **Data output**: Disimpan dalam format JSON string terstruktur.

### 4.4 Modular Repeater Control (`class-control-repeater.php`)
- **Tujuan**: Memungkinkan staf menambah baris (*row*), memilih tipe komponen di dalam kolom, mengubah urutan (*drag/reorder*), dan menghapus komponen secara visual.
- **Data output**: Disimpan dalam `json_encode()` aman.

---

## 5. SKEMA DATA STRUKTUR & PENGATURAN CUSTOMIZER

Seluruh setting didaftarkan pada hook `customize_register` di bawah panel utama: **"Imatutu Theme Settings"** (`panel_imatutu`), ditambah panel baru: **"Imatutu Layout & Page Builder"** (`panel_imatutu_builder`).

### 5.1 Sistem Tipografi (Typography Engine)
Daftarkan section: `sec_imatutu_typography`

| Setting Key | Label di UI | Default | Tipe Control |
|---|---|---|---|
| `typo_primary_font` | Primary Body Font | `Plus Jakarta Sans` | Select Font Family |
| `typo_heading_font` | Heading Titles Font | `Plus Jakarta Sans` | Select Font Family |
| `typo_h1_size` | Ukuran Heading 1 (Desktop) | `48` (px) | Range Slider (32-72) |
| `typo_h2_size` | Ukuran Heading 2 (Desktop) | `36` (px) | Range Slider (24-54) |
| `typo_h3_size` | Ukuran Heading 3 (Desktop) | `24` (px) | Range Slider (18-36) |
| `typo_body_size` | Ukuran Teks Utama (Body) | `16` (px) | Range Slider (14-20) |
| `typo_body_line_height` | Jarak Antar Baris (Line Height) | `1.6` | Range Slider (1.2-2.2) |

### 5.2 Sistem Color Palette & Theme Presets
Daftarkan section: `sec_imatutu_colors`

| Setting Key | Label di UI | Default | Keterangan |
|---|---|---|---|
| `color_preset_active` | Pilihan Tema Palet Warna | `pertamina_blue` | Visual Palette Picker (1-klik) |
| `color_primary` | Warna Primer (Brand / Tombol Utama) | `#1559ED` | Color Picker (Hex) |
| `color_primary_hover`| Warna Primer saat Hover | `#0D45C2` | Color Picker (Hex) |
| `color_secondary` | Warna Sekunder (Heading / Dark Navy) | `#0B192C` | Color Picker (Hex) |
| `color_accent` | Warna Aksen (Badge / Garis Dekoratif) | `#E21F23` | Color Picker (Hex) |
| `color_bg_main` | Warna Latar Belakang Website | `#FFFFFF` | Color Picker (Hex) |
| `color_bg_surface` | Warna Latar Kartu / Container | `#F8FAFC` | Color Picker (Hex) |
| `color_text_main` | Warna Teks Utama (Paragraf) | `#1E293B` | Color Picker (Hex) |
| `color_text_muted` | Warna Teks Sekunder / Subjudul | `#64748B` | Color Picker (Hex) |
| `color_border` | Warna Garis Tepi (Border) | `#E2E8F0` | Color Picker (Hex) |

### 5.3 Layout Engine: Grid, Row & Column Controller
Daftarkan section untuk mengelola section dinamis beranda: `sec_imatutu_builder_sections`

Staf dapat membuat hingga **5 Modular Sections** dinamis di halaman depan (selain template bawaan). Setiap section memiliki pengaturan layout:

| Setting Key Pattern | Label di UI | Pilihan / Opsi |
|---|---|---|
| `builder_sec_{N}_enable` | Aktifkan Section Ini | Checkbox Toggle (Default: On untuk sec 1-3, Off untuk 4-5) |
| `builder_sec_{N}_bg_type` | Warna Latar Section | `default_white`, `soft_slate`, `navy_dark`, `custom_color` |
| `builder_sec_{N}_padding` | Padding Atas & Bawah Section | `small` (40px), `medium` (80px), `large` (120px) |
| `builder_sec_{N}_layout` | Tata Letak Kolom (Grid) | `col-1` (1 Kolom Penuh)<br>`col-2` (2 Kolom Sama 50:50)<br>`col-3` (3 Kolom Sama 33:33:33)<br>`col-4` (4 Kolom Sama 25:25:25:25)<br>`col-1-2` (Asimetris Kiri 33% : Kanan 66%)<br>`col-2-1` (Asimetris Kiri 66% : Kanan 33%) |
| `builder_sec_{N}_gap` | Spasi Antar Kolom (Grid Gap) | `0px`, `16px`, `24px`, `32px`, `48px` |
| `builder_sec_{N}_valign` | Perataan Vertikal Kolom | `top` (Atas), `center` (Tengah), `stretch` (Sama Tinggi) |

### 5.4 Modular Components Library
Di dalam setiap kolom pada section di atas (misal Kolom 1, Kolom 2, Kolom 3), staf dapat memilih **tipe komponen** yang ingin ditampilkan:

Setting Key: `builder_sec_{N}_col_{M}_type`  
Pilihan tipe:
1. `none` (Kosong)
2. `heading` (Judul / Heading)
3. `paragraph` (Teks Paragraf / WYSIWYG)
4. `image` (Gambar Visual)
5. `video` (Pemutar Video)
6. `button` (Tombol Aksi / CTA)
7. `form` (Formulir Kontak / WPForms)
8. `iconbox` (Kartu Fitur Ber-ikon)
9. `counter` (Angka Statistik)
10. `accordion` (FAQ / Teks Lipat)

Setiap tipe komponen memiliki sub-settings otomatis:

#### A. Komponen: Heading
- `heading_text`: Teks judul (Default: `"Taylor Made Solutions"`)
- `heading_tag`: Pilihan tag semantik `h1`, `h2`, `h3`, `h4` (Default: `h2`)
- `heading_align`: `left`, `center`, `right`
- `heading_accent`: Toggle garis aksen bawah (`true`/`false`)

#### B. Komponen: Paragraph
- `paragraph_content`: Textarea / editor isi teks
- `paragraph_size`: `small` (14px), `regular` (16px), `lead` (18px)
- `paragraph_align`: `left`, `center`, `right`, `justify`

#### C. Komponen: Image
- `image_url`: Media upload control
- `image_alt`: Teks deskripsi gambar untuk SEO & Aksesibilitas
- `image_ratio`: `auto`, `16-9`, `4-3`, `1-1`
- `image_radius`: `none`, `rounded-md` (8px), `rounded-xl` (16px), `rounded-full`
- `image_link`: URL opsional saat gambar diklik
- `image_lightbox`: Buka gambar ukuran besar di modal pop-up (`true`/`false`)

#### D. Komponen: Video
- `video_url`: URL YouTube / Vimeo / file `.mp4`
- `video_aspect`: `16-9` (Default standar), `4-3`, `21-9`
- `video_autoplay`: `true`/`false` (otomatis menambahkan parameter `mute=1`)

#### E. Komponen: Button / CTA
- `btn_text`: Label teks tombol (Default: `"Hubungi Kami"`)
- `btn_url`: Tautan URL tujuan
- `btn_style`: `primary` (Solid biru), `secondary` (Dark navy), `outline` (Garis tepi), `ghost` (Teks link dengan panah)
- `btn_size`: `sm`, `md`, `lg`
- `btn_target`: Buka tab baru `_blank` (`true`/`false`)

#### F. Komponen: Form (Integrasi WPForms / Shortcode)
- `form_type`: Pilihan `wpforms_picker` atau `custom_shortcode`
- `form_id`: Dropdown otomatis membaca form yang ada di database (dari post type `wpforms`)
- `form_shortcode`: Input teks manual jika menggunakan plugin form lain (misal: `[contact-form-7 id="123"]`)
- `form_card_style`: Tampilan berbingkai kartu dengan shadow (`true`/`false`)

#### G. Komponen: Icon Box (Feature Card)
- `icon_svg`: Pilihan preset icon (Phone, Monitor, Shield, Chart, Map, Clock, User, File)
- `icon_title`: Judul kartu layanan
- `icon_desc`: Uraian ringkas layanan
- `icon_link`: URL tujuan saat kartu diklik

#### H. Komponen: Counter Statistic
- `counter_number`: Nilai angka (misal: `150+`, `99.9%`, `24/7`)
- `counter_label`: Label metrik (misal: `Klien Aktif`, `Uptime Server`)
- `counter_subtext`: Keterangan kecil pelengkap

#### I. Komponen: Accordion / FAQ
- `accordion_item_1_q` s/d `item_3_q`: Pertanyaan
- `accordion_item_1_a` s/d `item_3_a`: Jawaban

---

## 6. SPESIFIKASI TEKNIS TEMPLATE RENDERER (`template-parts/builder/`)

Renderer dibuat modular agar mudah dipelihara dan tidak terjadi duplikasi kode (*clean architecture*).

### 6.1 `row-column.php` (Logika Pembagian Grid)
Mengonversi opsi `builder_sec_{N}_layout` menjadi CSS Grid / Flexbox yang presisi:
- Opsi `col-1` -> Menghasilkan class CSS: `grid-col-1`
- Opsi `col-2` -> Menghasilkan class CSS: `grid-col-2` (`grid-template-columns: repeat(2, 1fr)`)
- Opsi `col-3` -> Menghasilkan class CSS: `grid-col-3` (`grid-template-columns: repeat(3, 1fr)`)
- Opsi `col-4` -> Menghasilkan class CSS: `grid-col-4` (`grid-template-columns: repeat(4, 1fr)`)
- Opsi `col-1-2` -> Menghasilkan class CSS: `grid-col-1-2` (`grid-template-columns: 1fr 2fr`)
- Opsi `col-2-1` -> Menghasilkan class CSS: `grid-col-2-1` (`grid-template-columns: 2fr 1fr`)

### 6.2 `component-form.php` (Logika Sanitasi & Render Form)
Memastikan rendering shortcode aman dari injection:
```php
<?php
// Contoh arsitektur aman di component-form.php
if (!defined('ABSPATH')) exit;

$form_shortcode = get_theme_mod($prefix . '_shortcode', '');
$form_card      = get_theme_mod($prefix . '_card_style', true);

if (!empty($form_shortcode)) {
    $card_class = $form_card ? 'builder-form-card' : 'builder-form-raw';
    echo '<div class="' . esc_attr($card_class) . '">';
    // Menggunakan do_shortcode dengan sanitasi tag
    echo do_shortcode(wp_kses_post($form_shortcode));
    echo '</div>';
}
?>
```

### 6.3 `component-video.php` (Logika OEmbed Responsif)
Mendukung URL YouTube/Vimeo dengan wrapping `embed-responsive`:
```php
<?php
if (!defined('ABSPATH')) exit;

$video_url = get_theme_mod($prefix . '_video_url', '');
if (!empty($video_url)) {
    echo '<div class="builder-video-wrap ratio-16-9">';
    if (wp_oembed_get($video_url)) {
        echo wp_oembed_get($video_url); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    } else {
        // Fallback untuk file direct .mp4
        echo '<video controls playsinline><source src="' . esc_url($video_url) . '" type="video/mp4"></video>';
    }
    echo '</div>';
}
?>
```

---

## 7. DESAIN STYLING & CSS LAYOUT ENGINE (`assets/css/builder.css`)

File CSS ini memuat sistem styling modern tanpa dependensi framework eksternal:

1. **CSS Variables Synchronization**:
   Menghubungkan nilai dari Customizer langsung ke root style:
   ```css
   :root {
       --font-heading: var(--custom-heading-font, 'Plus Jakarta Sans', sans-serif);
       --font-body: var(--custom-body-font, 'Plus Jakarta Sans', sans-serif);
       --h1-size: 3rem;
       --h2-size: 2.25rem;
       --h3-size: 1.5rem;
       --body-size: 1rem;
   }
   ```

2. **Grid Layout Engine**:
   ```css
   .builder-grid {
       display: grid;
       width: 100%;
       align-items: var(--builder-valign, stretch);
       gap: var(--builder-gap, 24px);
   }
   .grid-col-1 { grid-template-columns: 1fr; }
   .grid-col-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
   .grid-col-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
   .grid-col-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
   .grid-col-1-2 { grid-template-columns: 1fr 2fr; }
   .grid-col-2-1 { grid-template-columns: 2fr 1fr; }

   /* Responsif Otomatis */
   @media (max-width: 900px) {
       .grid-col-3, .grid-col-4, .grid-col-1-2, .grid-col-2-1 {
           grid-template-columns: repeat(2, minmax(0, 1fr));
       }
   }
   @media (max-width: 640px) {
       .builder-grid {
           grid-template-columns: 1fr !important;
       }
   }
   ```

3. **Styling Form WPForms Terintegrasi**:
   Memberikan form input styling enterprise yang konsisten dengan tema:
   ```css
   .builder-form-card {
       background: #FFFFFF;
       padding: 2.5rem;
       border-radius: 16px;
       border: 1px solid var(--color-border);
       box-shadow: 0 10px 25px -5px rgba(11, 25, 44, 0.06);
   }
   .builder-form-card .wpforms-field input,
   .builder-form-card .wpforms-field textarea,
   .builder-form-card input[type="text"],
   .builder-form-card input[type="email"],
   .builder-form-card textarea {
       width: 100%;
       padding: 0.85rem 1.15rem;
       border: 1px solid #CBD5E1;
       border-radius: 8px;
       font-family: inherit;
       font-size: 0.95rem;
       transition: border-color 0.2s, box-shadow 0.2s;
   }
   .builder-form-card input:focus,
   .builder-form-card textarea:focus {
       outline: none;
       border-color: var(--color-primary);
       box-shadow: 0 0 0 3px rgba(21, 89, 237, 0.15);
   }
   .builder-form-card .wpforms-submit,
   .builder-form-card button[type="submit"] {
       background: var(--color-primary);
       color: #FFFFFF;
       border: none;
       border-radius: 9999px;
       padding: 0.85rem 2rem;
       font-weight: 700;
       cursor: pointer;
       transition: background 0.2s, transform 0.2s;
   }
   .builder-form-card .wpforms-submit:hover {
       background: var(--color-primary-dark);
       transform: translateY(-2px);
   }
   ```

---

## 8. LIVE PREVIEW REALTIME SCRIPT (`assets/js/builder-preview.js`)

Agar staf admin dapat melihat perubahan seketika tanpa jeda reload halaman:
1. Menangkap event `wp.customize('setting_key', function(value) { ... })`.
2. Untuk warna: langsung menginjeksi variabel CSS `:root { --color-primary: newval; }`.
3. Untuk tipografi: memperbarui style sheet `head` secara real-time.
4. Untuk layout grid: mengganti class nama kolom (`.removeClass('grid-col-1 grid-col-2 ...').addClass(newval)`).
5. Untuk heading dan teks: memperbarui teks DOM langsung via jQuery.

---

## 9. TAHAPAN IMPLEMENTASI STEP-BY-STEP (WORK BREAKDOWN STRUCTURE)

Bagi pelaksana (junior programmer atau AI model), ikuti urutan kerja berikut secara presisi:

### Tahap 1: Mempersiapkan Struktur Berkas & Folder
1. Buat folder `inc/custom-controls/`.
2. Buat folder `template-parts/builder/`.
3. Buat file CSS baru: `assets/css/builder.css` dan `assets/css/customizer-controls.css`.
4. Buat file JS baru: `assets/js/builder-frontend.js`, `assets/js/builder-preview.js`, dan `assets/js/customizer-controls.js`.

### Tahap 2: Membangun Modul Custom Controls
1. Buat file `inc/custom-controls/class-control-range-slider.php`.
2. Buat file `inc/custom-controls/class-control-palette-picker.php`.
3. Buat file `inc/custom-controls/class-control-typography.php`.
4. Pastikan file-file ini di-require di awal `inc/customizer.php` hanya saat `is_customize_preview()` atau di dalam hook `customize_register`.

### Tahap 3: Implementasi Modul Tipografi & Palet Warna
1. Buat file `inc/customizer-typography.php`:
   - Buat fungsi pembantu `imatutu_enqueue_google_fonts()` untuk menyusun URL Google Fonts dinamis sesuai font yang dipilih user di Customizer.
   - Buat generator CSS inline untuk output `font-family`, `font-size`, `font-weight`, dan `line-height`.
2. Buat file `inc/customizer-palettes.php`:
   - Definisikan 4 preset warna tema.
   - Jika preset dipilih, perbarui default color controls atau suntikkan palette CSS variables.

### Tahap 4: Implementasi Layout Engine (Grid, Column, Row Controller)
1. Daftarkan panel `panel_imatutu_builder` di `inc/customizer.php`.
2. Daftarkan section untuk 3–5 Modular Section dinamis.
3. Di dalam setiap section, daftarkan setting:
   - Status aktif/non-aktif section (`_enable`).
   - Tipe background section (`_bg_type`).
   - Tata letak kolom (`_layout`: col-1 s/d col-4, col-1-2, col-2-1).
   - Jarak antar kolom (`_gap`).
   - Tipe komponen untuk masing-masing kolom (`_col_{1..4}_type`).

### Tahap 5: Membangun Template Renderer Komponen
1. Tulis template dasar pembungkus: `template-parts/builder/section-wrapper.php`.
2. Tulis template layout grid: `template-parts/builder/row-column.php`.
3. Tulis masing-masing template komponen spesifik:
   - `component-heading.php`
   - `component-paragraph.php`
   - `component-image.php`
   - `component-video.php`
   - `component-button.php`
   - `component-form.php` (dengan filter `do_shortcode` & form detection)
   - `component-iconbox.php`
   - `component-counter.php`
   - `component-accordion.php`

### Tahap 6: Integrasi ke Template Beranda (`front-page.php`)
1. Buka `front-page.php`.
2. Di antara section hero dan footer (atau setelah section clients), tambahkan pemanggil section dinamis:
   ```php
   // Render dynamic modular sections from customizer
   for ($i = 1; $i <= 5; $i++) {
       if (get_theme_mod("builder_sec_{$i}_enable", ($i <= 2))) {
           set_query_var('section_index', $i);
           get_template_part('template-parts/builder/section', 'wrapper');
       }
   }
   ```

### Tahap 7: Menyusun Styling Terpadu & Interaktivitas
1. Lengkapi `assets/css/builder.css` dengan aturan CSS grid, media queries responsif ponsel, form inputs styling, dan accordion transitions.
2. Lengkapi `assets/js/builder-frontend.js` untuk interaksi klik accordion toggle dan video responsive iframe.
3. Lengkapi `assets/js/builder-preview.js` untuk live preview di Customizer.
4. Enqueue `assets/css/builder.css` dan `assets/js/builder-frontend.js` di `functions.php`.

### Tahap 8: Pengujian & Validasi
1. Jalankan `php -l` pada setiap file `.php` baru untuk memastikan 0 syntax error.
2. Uji seluruh customizer controls di WordPress admin untuk memastikan tidak ada pesan error PHP *Warning* / *Notice*.
3. Jalankan `php build-zip.php` untuk memperbarui berkas `imatutu-theme.zip`.

---

## 10. CHECKLIST PENGUJIAN & VALIDASI KUALITAS

Sebelum pull request dinyatakan siap di-merge, lakukan verifikasi terhadap checklist berikut:

- [ ] **Kontrol Teks**: Teks judul, paragraf, dan tombol dapat diubah dari Customizer dan langsung berganti di layar.
- [ ] **Kontrol Tipografi**: Mengganti font family (misal ke *Inter* atau *Outfit*) memuat font yang benar dari Google Fonts dan memperbarui seluruh elemen heading/body.
- [ ] **Kontrol Warna**: Mengubah warna primer di Customizer langsung mengubah warna tombol, link, dan aksen secara real-time.
- [ ] **Preset Warna 1-Klik**: Memilih salah satu preset warna berhasil mengubah skema warna website secara harmonis.
- [ ] **Manipulasi Grid & Kolom**:
  - Mengubah layout dari 3 kolom ke 2 kolom langsung mengubah tata letak secara rapi.
  - Opsi asimetris (1:2 dan 2:1) bekerja presisi pada desktop dan menjadi 1 kolom vertikal saat dibuka di smartphone (< 640px).
  - Slider gap (jarak kolom) berfungsi dari 0px hingga 48px.
- [ ] **Komponen Gambar**: Gambar yang diunggah memiliki atribut `alt` yang sesuai dan opsi border-radius berfungsi.
- [ ] **Komponen Video**: Memasukkan link YouTube atau Vimeo menghasilkan player responsif 16:9 tanpa terpotong (*no black bars*).
- [ ] **Komponen Form**: Form WPForms atau Contact Form 7 berhasil dirender dengan desain input yang modern dan elegan, serta tombol submit berfungsi normal.
- [ ] **Komponen Accordion & Counter**: Fitur expand/collapse accordion berfungsi halus dan counter angka terbaca jelas.
- [ ] **Keamanan & Sanitasi**: Tidak ada celah XSS pada input teks (seluruh output di-*escape* dengan `esc_html`, `esc_attr`, `esc_url`, atau `wp_kses_post`).
- [ ] **Bebas Error PHP**: Tidak ada pesan peringatan *Deprecated*, *Notice*, atau *Warning* saat `WP_DEBUG` aktif.
- [ ] **Packaging Valid**: Menjalankan `php build-zip.php` menghasilkan file zip valid dengan forward-slash (`/`) standar POSIX.
